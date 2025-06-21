@extends('layouts.app')

@section('title', 'Find Your Perfect Space')

@section('content')
    
    <section class="bg-lightgray py-20 relative overflow-hidden w-screen left-1/2 right-1/2 -translate-x-1/2">
    <div class="px-4 md:px-8 text-center relative z-10">
        <h1 class="text-5xl font-bold mb-4">Temukan Ruang Sempurna Anda bersama <br>UrbaNest</h1>
        <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
            Solusi lengkap untuk penjualan properti, konstruksi, renovasi, dan layanan desain.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="{{ url('/cariproperti') }}" class="bg-primary text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">Browse Properties</a>
            <a href="{{ url('/services') }}" class="bg-gray-400 text-white px-6 py-3 rounded-md hover:bg-gray-500 transition">Explore Services</a>
        </div>
    </div>
    <div class="absolute inset-0 bg-[url('/placeholder.svg?height=600&width=1200')] opacity-10"></div>
</section>

    <section class="py-16 bg-gray-50 px-4 md:px-8">
        <div class="px-4 md:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold">Properti Unggulan</h2>
                <a href="{{ url('/cariproperti') }}" class="text-primary flex items-center">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($featuredProperties as $property)
                <a href="/detailproperti/{{ $property->id }}" class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-200">
                    <div class="relative">
                        <img src="{{ $property->image_path ? asset('storage/' . $property->image_path) : '/placeholder.svg' }}" alt="{{ $property->title }}" class="h-48 w-full object-cover">
                        <span class="absolute top-2 left-2 bg-primary text-white text-xs px-2 py-1 rounded">Sale</span>
                        
                        <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                            </svg>
                            <span class="text-gray-600 text-sm">{{ $property->users_count }}</span>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg">{{ $property->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $property->location }}</p>
                        <p class="text-primary font-bold text-xl mb-3">Rp{{ number_format($property->price, 0, ',', '.') }}</p>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>{{ $property->bedrooms }} Kamar Tidur</span>
                            <span>{{ $property->bathrooms }} Kamar Mandi</span>
                            <span>{{ $property->area }} Meter persegi</span>
                        </div>
                    </div>
                </a>
            @endforeach
            </div>
        </div>
    </section>

     
    <section class="py-16 bg-white px-4 md:px-8">
        <div class="px-4 md:px-8">
            <h2 class="text-2xl font-bold mb-12 text-center">Layanan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-building text-primary text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center">Konstruksi</h3>
                    <p class="text-gray-600 text-center mb-4">Bangun rumah impian Anda dari nol dengan layanan konstruksi profesional kami.</p>
                    <div class="flex justify-center">
                        <a href="#" class="text-primary border border-primary px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-tools text-primary text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center">Renovasi</h3>
                    <p class="text-gray-600 text-center mb-4">Ubah ruang Anda dengan layanan renovasi profesional kami.</p>
                    <div class="flex justify-center">
                        <a href="#" class="text-primary border border-primary px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-paint-brush text-primary text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center">Desain</h3>
                    <p class="text-gray-600 text-center mb-4">Ciptakan ruang indah dan fungsional dengan layanan desain interior dan eksterior kami.</p>
                    <div class="flex justify-center">
                        <a href="#" class="text-primary border border-primary px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @guest
    <section class="bg-blue-600 text-white py-16 px-6 text-center">
        <h2 class="text-3xl font-bold mb-4">Siap Menemukan Properti Impian Anda?</h2>
        <p class="text-lg mb-6">Bergabunglah dengan UrbaNest sekarang dan temukan properti yang tepat untuk Anda.</p>
        <a href="{{ route('signup') }}" class="inline-block bg-white text-blue-700 font-bold py-3 px-6 rounded hover:bg-gray-100 transition">
            Mulai Sekarang
        </a>
    </section>
    @endguest
@include('partials.footer')

@endsection
