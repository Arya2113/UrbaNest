@extends('layouts.admin')

@section('title', 'Admin - Properties')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Properties</h1>

    <div class="flex justify-end mb-4">
            <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Add New Property
            </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        {{-- Tambahkan class overflow-x-auto di sini --}}
        <div class="overflow-x-auto">
            {{-- Tambahkan class min-w-full di sini --}}
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Address</th>
                        <th scope="col" class
="px-6 py-3 text-left tracking-wider">Size (m²)</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Bedrooms</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Bathrooms</th>
                        <th scope="col" class="px-6 py-3 text-left tracking-wider">Developer</th>
                        <th scope="col" class="px-6 py-3 text-center tracking-wider">Actions</th> {{-- Sesuaikan teks dan alignment --}}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($properties as $property)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $property->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($property->price, 0, ',', '.') }}</td> {{-- Contoh format harga --}}
                            <td class="px-6 py-4 whitespace-nowrap">{{ $property->alamat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $property->area }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $property->bedrooms }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $property->bathrooms }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $property->developer->name ?? "N/A" }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                           
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center">No properties found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tambahkan pagination jika Anda memiliki banyak data --}}
    {{-- <div class="mt-4">
        {{ $properties->links() }}
    </div> --}}
</div>
@endsection
