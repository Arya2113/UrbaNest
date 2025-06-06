@extends('layouts.app')

@section('title', 'UrbaNest - Find Your Perfect Space')

@section('content')

<div class="bg-slate-50 font-sans text-gray-900">
  <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    
    <div class="mb-16">
        {{-- Section Header --}}
        <div class="mb-6 flex items-baseline justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Favorite Properties</h2>
            <a href="#" class="hidden items-center text-sm font-semibold text-blue-600 hover:text-blue-500 sm:flex">
                <span>View All</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="ml-1.5 h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
            @if (isset($favoriteProperties) && $favoriteProperties->count() > 0)
                @foreach ($favoriteProperties as $property)
                    <div class="group relative overflow-hidden rounded-lg bg-white shadow-md transition-shadow duration-300 hover:shadow-xl">
                        <div class="relative">
                            @if ($property->image_path)
                                <img src="{{ asset('storage/' . $property->image_path) }}" class="w-full h-48 object-cover" alt="{{ $property->name }}">
                            @else
                                {{-- Placeholder if no image --}}
                                <div class="aspect-w-16 aspect-h-9 flex items-center justify-center bg-gray-200 h-48">
                                    <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="h-80 rounded-lg border shadow p-5 flex flex-col justify-between">
    <!-- Bagian atas (judul, lokasi, harga, dll.) -->
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $property->title }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $property->location ?? 'Location not specified' }}</p>
                                <p class="mt-4 text-2xl font-bold text-gray-800">Rp{{ number_format($property->price ?? 0, 0, ',', '.') }}</p>
                                
                            </div>

                            <!-- Tombol tetap di bawah -->
                            <div>
                                <hr class="my-4" />
                                <div class="flex items-center space-x-6 text-sm text-gray-600">
                                    <span>{{ $property->bedrooms ?? '-' }} Beds</span>
                                    <span class="text-gray-300">|</span>
                                    <span>{{ $property->bathrooms ?? '-' }} Baths</span>
                                    <span class="text-gray-300">|</span>
                                    <span>{{ $property->area ?? '-' }} m²</span>
                                </div>
                                <a href="{{ route('property.show', $property->id) }}" class="mt-4 block text-center rounded-md bg-blue-600 px-8 py-2 text-base font-medium text-white hover:bg-blue-700">
                                    View Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="col-span-full text-center text-gray-500">You have no favorite properties yet.</p>
            @endif
        </div>
    </div>
    
   
    
  </main>
</div>

@endsection