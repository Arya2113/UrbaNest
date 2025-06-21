@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-bold mb-6">Add New Property</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">There were some problems with your input.</span>
            <ul class="mt-3 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        @csrf

         
        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('title')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price:</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('price')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

         <div class="mb-4">
            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address (address):</label>
             
            <input type="text" name="address" id="address" value="{{ old('address') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('address')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Location:</label>
            <input type="text" name="location" id="location" value="{{ old('location') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('location')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

         <div class="mb-4">
            <label for="area" class="block text-gray-700 text-sm font-bold mb-2">Area (sqm):</label>
             
            <input type="number" name="area" id="area" value="{{ old('area') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('area')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="bedrooms" class="block text-gray-700 text-sm font-bold mb-2">Bedrooms:</label>
             
            <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('bedrooms')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="bathrooms" class="block text-gray-700 text-sm font-bold mb-2">Bathrooms:</label>
             
            <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('bathrooms')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

         
         <div class="mb-4">
            <label for="developer_id" class="block text-gray-700 text-sm font-bold mb-2">Developer:</label>
            <select name="developer_id" id="developer_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Developer</option>
                @foreach($developers as $developer)
                    <option value="{{ $developer->id }}" {{ old('developer_id') == $developer->id ? 'selected' : '' }}>{{ $developer->name }}</option>
                @endforeach
            </select>
            @error('developer_id')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>


         
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Amenities:</label>
            <div class="flex flex-wrap -mx-2">
                @foreach($amenities as $amenity)
                    <div class="px-2 w-1/2 md:w-1/3">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" class="form-checkbox"
                                {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">{{ $amenity->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
             @error('amenities')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

         
        <div class="mb-4">
            <label for="main_image" class="block text-gray-700 text-sm font-bold mb-2">Main Image (for Property model):</label>
            <input type="file" name="main_image" id="main_image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('main_image')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="additional_images" class="block text-gray-700 text-sm font-bold mb-2">Additional Images (Exactly 2 for PropertyImage model):</label>
            <input type="file" name="additional_images[]" id="additional_images" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
             <p class="text-gray-600 text-xs italic mt-1">Please select exactly 2 image files.</p>
             @error('additional_images')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
             @error('additional_images.*')  
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>


         
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Add Property
            </button>
        </div>
    </form>
</div>
@endsection