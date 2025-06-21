@extends('layouts.admin')

@section('title', 'Admin - Properties')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Properties</h1>

    <div class="flex justify-end mb-4">
            <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-300">
                Add New Property
            </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
         
        <div class="overflow-x-auto">
             
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Address</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Size (m²)</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Bedrooms</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Bathrooms</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Developer</th>
                        <th scope="col" class="px-6 py-3 text-center tracking-wider">Actions</th>  
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($properties as $property)
                    <tr>
                        <!-- Form Update -->
                        <form method="POST" action="{{ route('admin.properties.update', $property->id) }}">
                            @csrf
                            @method('PUT')
                            <td class="min-w-[300px] px-6 py-4 whitespace-nowrap">
                                <input type="text" name="title" value="{{ $property->title }}" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                            </td>
                            <td class="min-w-[300px] px-6 py-4 whitespace-nowrap">
                                <input type="number" name="price" value="{{ $property->price }}" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                            </td>
                            <td class="min-w-[300px] px-6 py-4 whitespace-nowrap">
                                <input type="text" name="address" value="{{ $property->address }}" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                            </td>
                            <td class="min-w-[200px] px-6 py-4 whitespace-nowrap">
                                <input type="number" name="area" value="{{ $property->area }}" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                            </td>
                            <td class="min-w-[100px] px-6 py-4 whitespace-nowrap">
                                <input type="number" name="bedrooms" value="{{ $property->bedrooms }}" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                            </td>
                            <td class="min-w-[100px] px-6 py-4 whitespace-nowrap">
                                <input type="number" name="bathrooms" value="{{ $property->bathrooms }}" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                            </td>
                            <td class="min-w-[300px] px-6 py-4 whitespace-nowrap">
                                <input type="text" name="developer" value="{{ $property->developer->name ?? 'N/A' }}" disabled class="w-full border border-gray-100 bg-gray-50 text-gray-500 rounded px-2 py-1 text-sm">
                            </td>
                            <td class="min-w-[100px] px-6 py-4 whitespace-nowrap text-center">
                                <button type="submit" class="text-blue-600 hover:underline text-sm">Save</button>
                            </td>
                        </form>

                        <!-- Form Delete -->
                        <td class="min-w-[100px] px-6 py-4 whitespace-nowrap text-center">
                            <form method="POST" action="{{ route('admin.properties.destroy', $property->id) }}" onsubmit="return confirm('Are you sure you want to delete this property?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>
    </div>

     
  
</div>
@endsection

