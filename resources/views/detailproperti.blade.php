@extends('layouts.app')

@section('title', 'UrbaNest - Find Your Perfect Space')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto p-4 lg:p-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">
            <div class="lg:col-span-2 rounded-lg overflow-hidden shadow-lg">
                {{-- Reverted to static image source as requested --}}
                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80" alt="Property Image" class="w-full h-full object-cover">
            </div>
            <div class="grid grid-rows-2 gap-4">
                 {{-- Add more images here if available in the property model, or use placeholders --}}
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Apartment Interior 1" class="w-full h-full object-cover">
                </div>
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Apartment Interior 2" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <div class="w-full lg:w-2/3 bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-start mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $property->title }}</h1>
                    <form id="favorite-form" data-property-id="{{ $property->id }}">
                        @csrf
                        <button type="button" id="favorite-button" class="{{ $isFavorited ? 'text-red-500' : 'text-gray-400' }} hover:text-red-700 focus:outline-none">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </form>
                </div>

                <div id="message-area" class="mt-4 mb-4 p-3 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800 hidden" role="alert">
                    <span class="font-medium"></span>
                </div>

                <p class="text-2xl font-semibold text-blue-600 mb-4">Rp {{ number_format($property->price, 0, ',', '.') }}</p>

                <p class="text-gray-700 mb-6"><i class="fas fa-map-marker-alt mr-2 text-gray-600"></i>{{ $property->alamat }}</p>

                <h2 class="text-xl font-semibold mb-4 text-gray-800">Deskripsi</h2>
                <p class="text-gray-700 mb-8">{{ $property->description }}</p>

                <h2 class="text-xl font-semibold mb-4 text-gray-800">Spesifikasi</h2>
                <div class="bg-gray-50 p-6 rounded-lg mb-8 border border-gray-100">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18M3 12h18M3 19h18"></path></svg> <p class="font-medium">Kamar Tidur</p>
                            <p class="text-gray-600">{{ $property->bedrooms }}</p>
                        </div>
                        <div>
                             <svg class="w-8 h-8 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v2"></path></svg> <p class="font-medium">Kamar Mandi</p>
                            <p class="text-gray-600">{{ $property->bathrooms }}</p>
                        </div>
                        <div>
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v4m0 0h-4m4 0l-5-5"></path></svg> <p class="font-medium">Luas</p>
                            <p class="text-gray-600">{{ $property->area }} m²</p>
                        </div>
                    </div>
                </div>

                <h2 class="text-xl font-semibold mb-4 text-gray-800">Fasilitas Lingkungan</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse ($property->amenities as $amenity)
                        <div class="bg-gray-50 p-4 rounded-lg text-center border border-gray-100 hover:shadow-sm transition">
                           {{-- You might need to add icons dynamically based on amenity name or have a mapping --}}
                           {{-- For now, using a generic check icon --}}
                           <svg class="w-8 h-8 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.49l-1.955 5.378a2 2 0 01-3.655.26l-3.13-6.261a2 2 0 00-3.655-.26L4.382 7.51a2 2 0 00.26 3.655l5.378 1.955a2 2 0 01.26 3.655l-6.261 3.13a2 2 0 00-.26 3.655l7.51 4.382a2 2 0 003.655-.26l1.955-5.378a2 2 0 013.655-.26l3.13 6.261a2 2 0 003.655.26l4.382-7.51a2 2 0 00-.26-3.655l-5.378-1.955a2 2 0 01-.26-3.655l6.261-3.13a2 2 0 00.26-3.655L16.49 4.382a2 2 0 00-3.655.26z"></path></svg>
                            <p class="text-sm">{{ $amenity->name }}</p>
                        </div>
                    @empty
                        <p>Tidak ada fasilitas yang terdaftar.</p>
                    @endforelse
                </div>

            </div>

            <div class="w-full lg:w-1/3">
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                
                @if($lockedByOtherUser)
                    <div class="text-red-500 mb-4">
                        Properti ini sedang diproses oleh pengguna lain. Silakan coba lagi dalam beberapa detik.
                    </div>
                @endif

                <form id="checkout-form" method="POST" action="{{ route('property.attemptLockAndCheckout', $property, false) }}">
                    @csrf
                    <button type="submit" id="checkout-button" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200"
                        @if($isLocked && !$lockedByCurrentUser) disabled @endif>
                        Lanjutkan Pembayaran
                    </button>
                </form>

                {{-- Konten lain jika ada --}}
            </div>

                <div class="bg-white p-6 rounded-lg shadow-lg sticky top-16">
                    <div class="flex items-center mb-6">
                        <img src="https://via.placeholder.com/60" alt="Developer Avatar" class="w-16 h-16 rounded-full mr-4 border-2 border-gray-200">
                        <div>
                            @isset($property->developer)
                                <p class="font-bold text-lg text-gray-900">{{ $property->developer->name }}</p>
                                <p class="text-sm text-gray-600">Pengembang</p>
                            @else
                                <p class="font-bold text-lg text-gray-900">Informasi Pengembang Tidak Tersedia</p>
                            @endisset
                        </div>
                    </div>
                    @isset($property->developer)
                    @php
                        $nomorHp = $property->developer->phone;
                        $nomorWA = preg_replace('/[^0-9]/', '', $nomorHp);
                    @endphp

                    <a href="https://wa.me/{{ $nomorWA }}" target="_blank"
                    class="w-full bg-green-500 text-white py-3 rounded-lg font-semibold mb-4 hover:bg-green-600 transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 16.5V3a1 1 0 00.894-.447z">
                            </path>
                        </svg>
                        WhatsApp
                    </a>
                    @endisset
                    {{-- Kunjungan Properti button remains --}}
                    <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                        Kunjungan Properti
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var timeLeft = {{ $timeLeftInSeconds }};
        var lockedByOtherUser = {{ $lockedByOtherUser ? 'true' : 'false' }};
        var countdownElement = document.getElementById('countdown');
        var checkoutButton = document.getElementById('checkout-button');

        function updateCountdown() {
            if (lockedByOtherUser && timeLeft > 0) {
                timeLeft--;
            } else {
                checkoutButton.disabled = false;
            }
        }

        if (lockedByOtherUser) {
            checkoutButton.disabled = true;
            updateCountdown(); 
            setInterval(updateCountdown, 1000); 
        }

        document.getElementById('checkout-form').addEventListener('submit', function(event){
            event.preventDefault();
            
            const form = document.getElementById('checkout-form');
            const url = form.action
            const button = document.getElementById('checkout-button')

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            }).then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Something went wrong');
                }
            }).then(data => {
                window.location.href = data.redirect
            }).catch((error) => {
                console.error('Error:', error);
            });
        });
    });
    document.getElementById('favorite-button').addEventListener('click', function() {
        const form = document.getElementById('favorite-form');
        const propertyId = form.getAttribute('data-property-id');
        const url = `/property/${propertyId}/favorite`;
        const token = form.querySelector('input[name="_token"]').value;
        const messageArea = document.getElementById('message-area');
        const favoriteButton = document.getElementById('favorite-button');

        messageArea.classList.add('hidden');
        messageArea.querySelector('span').innerText = '';

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'An error occurred');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.isFavorited) {
                favoriteButton.classList.add('text-red-500');
                favoriteButton.classList.remove('text-gray-400');
            } else {
                favoriteButton.classList.remove('text-red-500');
                favoriteButton.classList.add('text-gray-400');
            }
        })
        .catch(error => {
            messageArea.classList.remove('hidden');
            messageArea.querySelector('span').innerText = error.message;
        });
    });
</script>
@endsection