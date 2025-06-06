<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyCheckoutTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PropertyCheckoutController extends Controller
{
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
            ->whereIn('status_transaksi', ['uploaded', 'confirmed', 'processing', 'completed', 'rejected']) // Also check rejected
            ->latest()
            ->first();

        if ($existingTransaction) {
             // If rejected, redirect to the rejected page
             if ($existingTransaction->status_transaksi === 'rejected') {
                 return redirect()->route('payment.rejected', ['transactionId' => $existingTransaction->id]);
             }
            // For other statuses, redirect to confirmation
            return redirect()->route('payment.confirmation', ['transaction' => $existingTransaction->id]);
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
                    ->whereIn('status_transaksi', ['uploaded', 'rejected'])
                    ->first();

                if ($existingTransaction) {
                     // If rejected, redirect to the rejected page
                     if ($existingTransaction->status_transaksi === 'rejected') {
                         return ['success' => false, 'redirect_route' => 'payment.rejected', 'transaction_id' => $existingTransaction->id];
                     }
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
                    Log::error("File storage failed for user {$user->id}, property {$freshProperty->id}.");
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
                 if (isset($transactionResult['transaction_id'])) {
                      return redirect()->route(
                          $transactionResult['redirect_route'],
                          ['transaction' => $transactionResult['transaction_id']]
                      );
                 } else {
                       return redirect()->route(
                           $transactionResult['redirect_route']
                       );
                 }
            } else {
                $redirectRoute = $transactionResult['redirect_route'] ?? 'property.checkout';
                $routeParameters = isset($transactionResult['property_id']) ? $transactionResult['property_id'] : $property->id;

                // Handle redirect for rejected status specifically
                if ($redirectRoute === 'payment.rejected' && isset($transactionResult['transaction_id'])) {
                    return redirect()->route($redirectRoute, ['transactionId' => $transactionResult['transaction_id']]);
                }

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
            Log::error('Error uploading proof and creating transaction: UserID ' . ($user->id ?? 'guest') . ' PropertyID ' . $property->id . ' - ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Gagal mengunggah bukti transfer karena kesalahan sistem. Silakan coba lagi nanti.'], 500);
            }
            // Redirect back to the payment page, or a general error page
            return redirect()->route('property.checkout', $property->id)->withInput()->withErrors(['upload_error' => 'Terjadi kesalahan tidak terduga saat mengunggah bukti transfer. Tim kami telah diberitahu. Silakan coba lagi nanti atau hubungi dukungan.']);
        }
    }

    public function paymentConfirmation(Request $request, $transactionId)
    {
        $transaction = PropertyCheckoutTransaction::find($transactionId);

        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Check if the transaction is rejected
        if ($transaction->status_transaksi === 'rejected') {
            return redirect()->route('payment.rejected', ['transactionId' => $transaction->id]);
        }

        // If status is verified, redirect to the final confirmation page
        if ($transaction->status_transaksi === 'verified') {
            return redirect()->route('payment.confirmed', ['transactionId' => $transaction->id]);
        }

        // Otherwise, show the confirmation page (assuming status is 'uploaded' or 'processing')
        return view('paymentconfirmation', compact('transaction'));
    }

    public function confirmedPage($transactionId)
    {
        $transaction = PropertyCheckoutTransaction::find($transactionId);

        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        }

         // If status is rejected, redirect to the rejected page
        if ($transaction->status_transaksi === 'rejected') {
            return redirect()->route('payment.rejected', ['transactionId' => $transaction->id]);
        }

        // Only show confirmed page if status is verified or completed
        if (!in_array($transaction->status_transaksi, ['verified', 'completed'])) {
             // Redirect to confirmation or home if not in a final confirmed state
             return redirect()->route('payment.confirmation', ['transaction' => $transaction->id])->with('error', 'Transaksi belum dikonfirmasi.');
        }

        return view('paymentconfirmed', compact('transaction'));
    }

     public function paymentRejected($transactionId)
    {
        $transaction = PropertyCheckoutTransaction::find($transactionId);

        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Only show rejected page if status is rejected
        if ($transaction->status_transaksi !== 'rejected') {
             // Redirect to confirmation or home if not rejected
             return redirect()->route('payment.confirmation', ['transaction' => $transaction->id])->with('error', 'Transaksi ini tidak berstatus ditolak.');
        }

        return view('paymentrejected', compact('transaction'));
    }
}
