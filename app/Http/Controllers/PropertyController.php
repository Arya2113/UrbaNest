<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Amenity;
use Illuminate\Support\Facades\DB; // Pastikan ini di-import jika pakai DB::raw atau query log

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query()->with('amenities');

        if ($request->filled('location')) {
            $locationValue = $request->input('location');
            // Aktifkan ini untuk cek nilai yang dikirim:
            // dd('Filter lokasi aktif. Nilai:', $locationValue);
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
        // Aktifkan ini untuk cek isi dropdown:
        // dd('Lokasi unik untuk dropdown:', $uniqueLocations->pluck('location')->toArray());

        $amenitiesListForFilter = Amenity::orderBy('name')->get();


        return view('cariproperti', [
            'properties' => $properties,
            'locations' => $uniqueLocations,
            'amenities_list_for_filter' => $amenitiesListForFilter,
        ]);
    }

    

    public function show(Property $property)
    {
        $property->load('amenities');
        return view('detailproperti', compact('property'));
    }
}