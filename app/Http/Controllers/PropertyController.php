<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Amenity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\PropertyCheckoutTransaction;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query()->with('amenities');

        if ($request->filled('location')) {
            $locationValue = $request->input('location');
            $query->whereRaw('LOWER(location) = ?', [strtolower($locationValue)]);
        }

        if ($request->filled('min_surface_area')) {
            $query->where('area', '>=', $request->input('min_surface_area'));
        }
        if ($request->filled('max_surface_area')) {
            $query->where('area', '<=', $request->input('max_surface_area'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        if ($request->filled('bedrooms')) {
            $selectedBedrooms = $request->input('bedrooms');
            $query->where(function ($q) use ($selectedBedrooms) {
                $numericBedrooms = [];
                $applyNumericFilter = false;
                foreach ($selectedBedrooms as $br) {
                    if (is_numeric($br)) {
                        $numericBedrooms[] = (int)$br;
                        $applyNumericFilter = true;
                    } elseif ($br === '4+') {
                        $q->orWhere('bedrooms', '>=', 4);
                    }
                }
                if ($applyNumericFilter) {
                    $q->orWhereIn('bedrooms', $numericBedrooms);
                }
            });
        }

        if ($request->filled('amenities')) {
            $selectedAmenities = $request->input('amenities');
            $query->whereHas('amenities', function ($q) use ($selectedAmenities) {
                $q->whereIn('name', $selectedAmenities);
            });
        }

        if ($request->filled('sort_by')) {
            $sortBy = $request->input('sort_by');
            if ($sortBy === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($sortBy === 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($sortBy === 'newest') {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        
        $properties = $query->get();


        $uniqueLocations = Property::select('location')
                                    ->whereNotNull('location')
                                    ->where('location', '!=', '')
                                    ->distinct()
                                    ->orderBy('location', 'asc')
                                    ->get();

        $amenitiesListForFilter = Amenity::orderBy('name')->get();


        return view('cariproperti', [
            'properties' => $properties,
            'locations' => $uniqueLocations,
            'amenities_list_for_filter' => $amenitiesListForFilter,
        ]);
    }

    
    public function show(Property $property)
    {
        $property->load('amenities', 'developer', 'lockedByUser'); // Load lockedByUser relationship

        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Auth::user()->properties()->where('property_id', $property->id)->exists();
        }

        // Determine lock status
        $isLocked = $property->locked_until && $property->locked_until->isFuture();
        $lockedByCurrentUser = $isLocked && Auth::check() && $property->locked_by_user_id === Auth::id();
        $lockedByOtherUser = $isLocked && (!$lockedByCurrentUser);

        // Calculate time left if locked by another user
        $timeLeftInSeconds = 0;
        if ($lockedByOtherUser) {
            $timeLeftInSeconds = $property->locked_until->diffInSeconds(Carbon::now());
        }

        return view('detailproperti', compact('property', 'isFavorited', 'isLocked', 'lockedByCurrentUser', 'lockedByOtherUser', 'timeLeftInSeconds'));
    }

    public function toggleFavorite(Property $property)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Silakan login untuk menambahkan ke favorit.'], 401);
        }

        $user = Auth::user();
        $isFavorited = $user->properties()->toggle($property->id);

        return response()->json(['isFavorited' => count($isFavorited['attached']) > 0]);
    }

    public function attemptLockAndCheckout(Property $property)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Silakan login untuk melanjutkan pembayaran.'], 401);
        }

        $user = Auth::user();
        $lockDuration = 30; // minutes
        $lockExpiresAt = Carbon::now()->addMinutes($lockDuration);

        try {
            $acquired = DB::transaction(function () use ($property, $user, $lockExpiresAt) {
                // Use lockForUpdate to prevent race conditions on the property record itself
                $freshProperty = Property::where('id', $property->id)->lockForUpdate()->first();

                if (!$freshProperty) {
                    return false; // Property somehow disappeared
                }

                $isCurrentlyLocked = $freshProperty->locked_until && $freshProperty->locked_until->isFuture();

                // Allow locking if:
                // 1. Not locked by anyone.
                // 2. Or, locked by the current user (can re-lock/extend).
                if (!$isCurrentlyLocked || $freshProperty->locked_by_user_id === $user->id) {
                    $freshProperty->locked_by_user_id = $user->id;
                    $freshProperty->locked_until = $lockExpiresAt;
                    $freshProperty->save();
                    return true; // Lock acquired or refreshed
                }
                // If locked by another user and their lock is active
                return false;
            });

            if ($acquired) {
                // Flash minimal necessary data. The checkout page will calculate amounts.
                session()->flash('lock_checkout_info', [
                    'property_id' => $property->id,
                    'user_id' => $user->id,
                    'locked_until_timestamp' => $lockExpiresAt->timestamp,
                ]);
                return response()->json(['success' => true, 'redirect' => route('property.checkout', $property->id)]);
            } else {
                 $property->refresh(); // Get the latest lock info if acquisition failed
                 $timeLeftInSeconds = 0;
                 if ($property->locked_until && $property->locked_until->isFuture()) {
                     $timeLeftInSeconds = max(0, $property->locked_until->diffInSeconds(Carbon::now()));
                 }
                 return response()->json([
                     'success' => false,
                     'message' => 'Properti sedang dalam proses checkout oleh pengguna lain. Silakan coba lagi' . ($timeLeftInSeconds > 0 ? ' dalam ' . $timeLeftInSeconds . ' detik.' : '.'),
                     'locked_until' => $property->locked_until ? $property->locked_until->timestamp : null
                 ], 409); // 409 Conflict
            }

        } catch (\Exception $e) {
            \Log::error('Error attempting to lock property: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mencoba mengunci properti. Silakan coba lagi nanti.'], 500);
        }
    }

    // MODIFIED: This method will now display the payment detail
    // It calculates details on the fly rather than from a pending transaction
    public function checkout(Request $request, Property $property)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melanjutkan.');
        }
        $user = Auth::user();

        $lockInfo = $request->session()->get('lock_checkout_info');
        $property->refresh(); // Get the absolute latest state from DB

        // Validate the lock:
        // 1. Was lock_checkout_info flashed for this specific property by this user?
        // 2. Is the property in the DB actually locked by this user?
        // 3. Is the lock still valid (not expired)?
        if (!$lockInfo ||
            $lockInfo['property_id'] !== $property->id ||
            $lockInfo['user_id'] !== $user->id || // Ensure the user in session is the one who locked
            $property->locked_by_user_id !== $user->id ||
            !$property->locked_until ||
            $property->locked_until->isPast()) {

            // If the lock is invalid, clear potentially stale session data and redirect.
            $request->session()->forget('lock_checkout_info');
            return redirect()->route('property.show', $property->id)->withErrors(['checkout_error' => 'Sesi checkout tidak valid atau telah kedaluwarsa. Silakan kunci ulang properti untuk melanjutkan.']);
        }

        // If a transaction with uploaded proof already exists for this property by this user,
        // they probably shouldn't be on this page. Redirect them.
        $existingTransaction = PropertyCheckoutTransaction::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->whereIn('status_transaksi', ['uploaded', 'confirmed', 'processing', 'completed']) // Check against terminal/advanced states
            ->latest()
            ->first();

        if ($existingTransaction) {
            // Perhaps redirect to a transaction status page or payment confirmation.
            // For now, redirecting to property show with a message.
            return redirect()->route('payment.confirmation')->with('info_message', 'Anda sudah memiliki transaksi yang sedang diproses atau selesai untuk properti ini.');
        }


        // Calculate payment details dynamically
        $hargaProperti = $property->price;
        $biayaLayanan = $hargaProperti * 0.05; // 5% service fee
        // Ensure kodeUnik is somewhat unique per attempt, or at least stable for this user/property combo for this session.
        // Using a combination that includes a part of the lock time might be an option if you need it more dynamic here.
        // For simplicity, using user_id + property_id + a constant, but consider your needs.
        $kodeUnik = $user->id + $property->id + 100; // Example: make it distinct per user/property.
        $jumlahTotal = $hargaProperti + $biayaLayanan + $kodeUnik;

        return view('paymentdetail', [
            'property' => $property,
            'hargaProperti' => $hargaProperti,
            'biayaLayanan' => $biayaLayanan,
            'kodeUnik' => $kodeUnik,
            'jumlahTotal' => $jumlahTotal,
            'locked_until_timestamp' => $property->locked_until->timestamp, // Pass the actual lock expiry from DB
        ]);
    }


   public function paymentConfirmation(Request $request)
    {
        // Assuming you have the transaction ID stored in the session or request
        // For example, after a successful uploadProof, you might redirect to this route with the transaction ID
        $transactionId = session('transaction_id') ?? $request->query('transaction_id');

        // Fetch the transaction from the database
        $transaction = PropertyCheckoutTransaction::find($transactionId);

        // If transaction not found, redirect back with an error message
        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Pass the transaction data to the view
        return view('paymentconfirmation', compact('transaction'));
    }


    // MODIFIED: This method will now create the transaction upon successful proof upload
    public function uploadProof(Request $request, Property $property)
    {
        if (!Auth::check()) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Silakan login untuk mengunggah bukti transfer.'], 401)
                : redirect()->route('login')->with('error', 'Silakan login untuk mengunggah bukti transfer.');
        }

        $user = Auth::user();

        $request->validate([
            'proof' => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
        ], [
            'proof.required' => 'File bukti bayar wajib diunggah.',
            'proof.file' => 'File tidak valid.',
            'proof.mimes' => 'Format file tidak didukung. Gunakan jpeg, jpg, png, atau pdf.',
            'proof.max' => 'Ukuran file maksimal 5MB. File kamu kegedean, tolong dikecilin.',
        ]);

        try {
            $transactionResult = DB::transaction(function () use ($request, $property, $user) {
                // Re-fetch and lock the property row for update to ensure data integrity.
                $freshProperty = Property::where('id', $property->id)->lockForUpdate()->first();

                if (!$freshProperty) {
                    return ['success' => false, 'message' => 'Properti tidak ditemukan.', 'status' => 404, 'redirect_route' => 'home']; // Or some other appropriate route
                }

                // Crucial Check: Is the property STILL locked by THIS user and is the lock valid?
                if (!$freshProperty->locked_until || $freshProperty->locked_until->isPast() || $freshProperty->locked_by_user_id !== $user->id) {
                    $request->session()->forget('lock_checkout_info'); // Clean up session if lock invalid
                    return ['success' => false, 'message' => 'Waktu checkout telah habis atau properti tidak lagi dikunci oleh Anda. Silakan coba kunci ulang.', 'status' => 409, 'redirect_route' => 'property.show', 'property_id' => $freshProperty->id];
                }

                // Prevent duplicate transaction creation if one already exists with proof.
                $existingTransaction = PropertyCheckoutTransaction::where('user_id', $user->id)
                    ->where('property_id', $freshProperty->id)
                    ->whereIn('status_transaksi', ['uploaded', 'confirmed', 'processing', 'completed'])
                    ->first();

                if ($existingTransaction) {
                    return ['success' => false, 'message' => 'Anda sudah pernah mengunggah bukti untuk properti ini.', 'status' => 409, 'redirect_route' => 'payment.confirmation']; // Or transaction status page
                }

                // All checks passed, proceed to create the transaction and upload proof.
                $hargaProperti = $freshProperty->price;
                $biayaLayanan = $hargaProperti * 0.05;
                // Re-calculate kodeUnik here to ensure it's based on current data at transaction creation time
                $kodeUnik = $user->id + $freshProperty->id + 100; // Keep consistent with checkout display logic
                $jumlahTotal = $hargaProperti + $biayaLayanan + $kodeUnik;

                $file = $request->file('proof');
                $fileName = 'Transfer_' . $user->id . '_' . $freshProperty->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_transfer', $fileName, 'public');

                if (!$path) {
                    // This should ideally not happen if storage is configured correctly.
                    \Log::error("File storage failed for user {$user->id}, property {$freshProperty->id}.");
                    throw new \Exception('Gagal menyimpan file bukti transfer. Penyimpanan file bermasalah.');
                }

                $newTransaction = PropertyCheckoutTransaction::create([
                    'user_id' => $user->id,
                    'property_id' => $freshProperty->id,
                    'harga_properti' => $hargaProperti,
                    'biaya_jasa' => $biayaLayanan,
                    'kode_unik' => $kodeUnik,
                    'total_transfer' => $jumlahTotal,
                    'status_transaksi' => 'uploaded', // Initial status after proof upload
                    'transaction_time' => Carbon::now(),
                    'bukti_transfer_url' => Storage::url($path),
                    // 'locked_until' => $freshProperty->locked_until, // Optionally store the lock time with the transaction
                ]);

                // Clear the session lock info as it has been consumed by a successful transaction creation.
                $request->session()->forget('lock_checkout_info');

                // After successful transaction, you might want to change property status or clear its lock
                // For example: $freshProperty->status = 'pending_confirmation'; $freshProperty->locked_by_user_id = null; $freshProperty->locked_until = null; $freshProperty->save();
                // This depends on your exact desired workflow after proof submission.

                return ['success' => true, 'transaction_id' => $newTransaction->id, 'redirect_route' => 'payment.confirmation'];
            });

            if ($transactionResult['success']) {
                return redirect()->route($transactionResult['redirect_route'])
                                 ->with('success_message', 'Bukti transfer berhasil diunggah! Transaksi Anda (ID: ' . $transactionResult['transaction_id'] . ') sedang diproses.');
            } else {
                $redirectRoute = $transactionResult['redirect_route'] ?? 'property.checkout';
                $routeParameters = isset($transactionResult['property_id']) ? $transactionResult['property_id'] : $property->id;

                if ($request->expectsJson()) {
                    return response()->json(['message' => $transactionResult['message']], $transactionResult['status']);
                }
                return redirect()->route($redirectRoute, $routeParameters)
                                 ->withInput()
                                 ->withErrors(['upload_error' => $transactionResult['message']]);
            }

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Data tidak valid.', 'errors' => $e->errors()], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error uploading proof and creating transaction: UserID ' . ($user->id ?? 'guest') . ' PropertyID ' . $property->id . ' - ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Gagal mengunggah bukti transfer karena kesalahan sistem. Silakan coba lagi nanti.'], 500);
            }
            // Redirect back to the payment page, or a general error page
            return redirect()->route('property.checkout', $property->id)->withInput()->withErrors(['upload_error' => 'Terjadi kesalahan tidak terduga saat mengunggah bukti transfer. Tim kami telah diberitahu. Silakan coba lagi nanti atau hubungi dukungan.']);
        }
    }
}