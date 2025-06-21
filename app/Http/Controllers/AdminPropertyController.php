<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Developer;
use App\Models\Architect;
use App\Models\Amenity;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminPropertyController extends Controller
{
    /**
     * Show the form for creating a new property.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $properties = Property::with(['developer', 'amenities'])->get();
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $developers = Developer::all();
        $amenities = Amenity::all();

        return view('admin.properties.create', compact('developers',  'amenities'));
    }

    /**
     * Store a newly created property in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'developer_id' => 'nullable|exists:developers,id',
            'location' => 'required|string|max:255',  
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'additional_images' => 'required|array|size:2',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $validatedData = $validator->validated();

         
        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('properties', 'public');
        }

         
        $property = Property::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'address' => $validatedData['address'],
            'area' => $validatedData['area'],
            'bedrooms' => $validatedData['bedrooms'] ?? 0,
            'bathrooms' => $validatedData['bathrooms'] ?? 0,
            'developer_id' => $validatedData['developer_id'] ?? null,
            'location' => $validatedData['location'],  
            'image_path' => $mainImagePath,
        ]);

         
        if (isset($validatedData['amenities'])) {
            $property->amenities()->sync($validatedData['amenities']);
        }

         
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $imagefile) {
                $imagePath = $imagefile->store('properties', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => $imagePath,
                ]);
            }
        }

        return redirect()->route('admin.properties.index')->with('success', 'Property added successfully!');
    }

     
     
     
     
     
     
}
