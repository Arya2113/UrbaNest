@extends('layouts.app')

@section('title', 'UrbaNest - Find Your Perfect Space')

@section('content')
    {{-- SCENARIO 2: Sections are full-width WITHIN the layout's padding. --}}
    {{-- Hero section's direct child div loses container/mx-auto/px-6 --}}
    <section class="bg-lightgray py-20 relative overflow-hidden w-screen left-1/2 right-1/2 -translate-x-1/2">
    <div class="px-4 md:px-8 text-center relative z-10">
        <h1 class="text-5xl font-bold mb-4">Find Your Perfect Space with <br>UrbaNest</h1>
        <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
            Your one-stop solution for property sales, construction, renovation, and design services.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="{{ url('/cariproperti') }}" class="bg-primary text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">Browse Properties</a>
            <a href="{{ url('/services') }}" class="bg-gray-400 text-white px-6 py-3 rounded-md hover:bg-gray-500 transition">Explore Services</a>
        </div>
    </div>
    <div class="absolute inset-0 bg-[url('/placeholder.svg?height=600&width=1200')] opacity-10"></div>
</section>

    {{-- Section itself loses container/mx-auto/px-6. Apply negative margins to make its background full. --}}
    <section class="py-16 bg-gray-50 px-4 md:px-8">
                {{-- Add padding back for the content INSIDE this section to align with global padding --}}
        <div class="px-4 md:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold">Featured Properties</h2>
                <a href="{{ url('/cariproperti') }}" class="text-primary flex items-center">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <div class="bg-[url('/placeholder.svg?height=200&width=300')] h-48 w-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                        </div>
                        <span class="absolute top-2 left-2 bg-primary text-white text-xs px-2 py-1 rounded">Sale</span>
                        <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg">Modern Apartment with Ocean View</h3>
                        <p class="text-gray-600 text-sm mb-2">Downtown, Ocean City</p>
                        <p class="text-primary font-bold text-xl mb-3">$450,000</p>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>2 Beds</span>
                            <span>2 Baths</span>
                            <span>1200 sqft</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <div class="bg-[url('/placeholder.svg?height=200&width=300')] h-48 w-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                        </div>
                        <span class="absolute top-2 left-2 bg-primary text-white text-xs px-2 py-1 rounded">Sale</span>
                        <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg">Luxury Villa with Pool</h3>
                        <p class="text-gray-600 text-sm mb-2">Beverly Hills, Los Angeles</p>
                        <p class="text-primary font-bold text-xl mb-3">$1,200,000</p>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>4 Beds</span>
                            <span>3 Baths</span>
                            <span>3500 sqft</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <div class="bg-[url('/placeholder.svg?height=200&width=300')] h-48 w-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                        </div>
                        <span class="absolute top-2 left-2 bg-primary text-white text-xs px-2 py-1 rounded">Sale</span>
                        <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg">Cozy Studio in City Center</h3>
                        <p class="text-gray-600 text-sm mb-2">Midtown, New York</p>
                        <p class="text-primary font-bold text-xl mb-3">$320,000</p>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>1 Beds</span>
                            <span>1 Baths</span>
                            <span>650 sqft</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services Section - same principle --}}
    <section class="py-16 bg-white px-4 md:px-8">
        <div class="px-4 md:px-8">
            <h2 class="text-2xl font-bold mb-12 text-center">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-building text-primary text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center">Construction</h3>
                    <p class="text-gray-600 text-center mb-4">Build your dream home from the ground up with our expert construction services.</p>
                    <div class="flex justify-center">
                        <a href="#" class="text-primary border border-primary px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Learn More</a>
                    </div>
                </div>
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-tools text-primary text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center">Renovation</h3>
                    <p class="text-gray-600 text-center mb-4">Transform your existing space with our professional renovation services.</p>
                    <div class="flex justify-center">
                        <a href="#" class="text-primary border border-primary px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Learn More</a>
                    </div>
                </div>
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-paint-brush text-primary text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center">Design</h3>
                    <p class="text-gray-600 text-center mb-4">Create beautiful, functional spaces with our interior and exterior design services.</p>
                    <div class="flex justify-center">
                        <a href="#" class="text-primary border border-primary px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-blue-600 text-white py-16 px-6 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Find Your Dream Property?</h2>
        <p class="text-lg mb-6">Join UrbaNest today and discover the perfect property for your needs.</p>
        <a href="{{ route('signup') }}" class="inline-block bg-white text-blue-700 font-bold py-3 px-6 rounded hover:bg-gray-100 transition">Get Started</a>
    </section>
@include('partials.footer')

@endsection

