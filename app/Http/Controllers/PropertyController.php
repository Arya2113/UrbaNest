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

         
        $query->whereDoesntHave('propertyCheckoutTransactions', function ($q) {
            $q->whereIn('status_transaksi', ['verified', 'uploaded']);
        });

         
        if ($request->filled('location')) {
            $query->whereRaw('LOWER(location) = ?', [strtolower($request->input('location'))]);
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
                foreach ($selectedBedrooms as $br) {
                    if (is_numeric($br)) {
                        $numericBedrooms[] = (int)$br;
                    } elseif ($br === '4+') {
                        $q->orWhere('bedrooms', '>=', 4);
                    }
                }
                if (!empty($numericBedrooms)) {
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

         
        $sortBy = $request->input('sort_by');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

         
        $perPage = $request->input('per_page', 10);
        $properties = $query->paginate($perPage)->withQueryString();  

         
        $uniqueLocations = Property::select('location')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->whereDoesntHave('propertyCheckoutTransactions', function ($q) {
                $q->whereIn('status_transaksi', ['verified', 'uploaded']);
            })
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
         
        $hasActiveTransaction = PropertyCheckoutTransaction::where('property_id', $property->id)
            ->whereIn('status_transaksi', ['uploaded', 'verified'])
            ->exists();

        if ($hasActiveTransaction) {
            return redirect('/cariproperti')->with('error', 'Property sudah dalam proses transaksi.');
        }

         
        $property->load('amenities', 'developer', 'lockedByUser', 'images'); 

        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Auth::user()->properties()->where('property_id', $property->id)->exists();
        }

         
        $isLocked = $property->locked_until && $property->locked_until->isFuture();
        $lockedByCurrentUser = $isLocked && Auth::check() && $property->locked_by_user_id === Auth::id();
        $lockedByOtherUser = $isLocked && !$lockedByCurrentUser;

        $timeLeftInSeconds = 0;
        if ($lockedByOtherUser) {
            $timeLeftInSeconds = $property->locked_until->diffInSeconds(Carbon::now());
        }

        return view('detailproperti', compact(
            'property',
            'isFavorited',
            'isLocked',
            'lockedByCurrentUser',
            'lockedByOtherUser',
            'timeLeftInSeconds'
        ));
    }

    public function attemptLockAndCheckout(Property $property)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $lockDuration = 30;  
        $lockExpiresAt = Carbon::now()->addMinutes($lockDuration);

        try {
            $acquired = DB::transaction(function () use ($property, $user, $lockExpiresAt) {
                 
                $freshProperty = Property::where('id', $property->id)->lockForUpdate()->first();

                if (!$freshProperty) {
                    return false;  
                }

                $isCurrentlyLocked = $freshProperty->locked_until && $freshProperty->locked_until->isFuture();

                 
                 
                 
                if (!$isCurrentlyLocked || $freshProperty->locked_by_user_id === $user->id) {
                    $freshProperty->locked_by_user_id = $user->id;
                    $freshProperty->locked_until = $lockExpiresAt;
                    $freshProperty->save();
                    return true;  
                }
                 
                return false;
            });

            if ($acquired) {
                 
                session()->flash('lock_checkout_info', [
                    'property_id' => $property->id,
                    'user_id' => $user->id,
                    'locked_until_timestamp' => $lockExpiresAt->timestamp,
                ]);
                return response()->json(['success' => true, 'redirect' => route('property_checkout.checkout', $property->id)]);
            } else {
                 $property->refresh();  
                 $timeLeftInSeconds = 0;
                 if ($property->locked_until && $property->locked_until->isFuture()) {
                     $timeLeftInSeconds = max(0, $property->locked_until->diffInSeconds(Carbon::now()));
                 }
                 return response()->json([
                     'success' => false,
                     'message' => 'Properti sedang dalam proses checkout oleh pengguna lain. Silakan coba lagi' . ($timeLeftInSeconds > 0 ? ' dalam ' . $timeLeftInSeconds . ' detik.' : '.'),
                     'locked_until' => $property->locked_until ? $property->locked_until->timestamp : null
                 ], 409);  
            }

        } catch (\Exception $e) {
            \Log::error('Error attempting to lock property: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mencoba mengunci properti. Silakan coba lagi nanti.'], 500);
        }
    }

    /**
     * Get all properties for API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPropertiesApi()
    {
        $properties = Property::with(['amenities', 'developer', 'images'])->get();

        return response()->json($properties);
    }
}
