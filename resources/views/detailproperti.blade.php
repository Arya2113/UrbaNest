@extends('layouts.app')

@section('title', 'UrbaNest - Find Your Perfect Space')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto p-4 lg:p-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">
            <div class="lg:col-span-2 rounded-lg overflow-hidden shadow-lg">
                {{-- Main image from properties table --}}
                <img src="{{ asset($property->image_path) }}" alt="Property Image" class="w-full h-full object-cover">
            </div>
            <div class="grid grid-rows-2 gap-4">
                 {{-- Smaller images from property_images table --}}
                 @forelse ($property->images->take(2) as $image)
                    <div class="rounded-lg overflow-hidden shadow-lg">
                         <img src="{{ asset('storage/' . $image->image_url) }}" alt="Property Image" class="w-full h-full object-cover">
                    </div>
                 @empty
                     {{-- Optional: Add placeholder images or a message if no additional images are available --}}
                     <div class="rounded-lg overflow-hidden shadow-lg flex items-center justify-center bg-gray-200 text-gray-500">
                         No additional images
                     </div>
                      <div class="rounded-lg overflow-hidden shadow-lg flex items-center justify-center bg-gray-200 text-gray-500">
                         No additional images
                     </div>
                 @endforelse
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
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M3 10v10M21 10v10M3 16h18M7 10V7a2 2 0 012-2h6a2 2 0 012 2v3"/>
                            </svg>
                            <p class="font-medium">Kamar Tidur</p>
                            <p class="text-gray-600">{{ $property->bedrooms }}</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mx-auto mb-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18v4a4 4 0 01-4 4H7a4 4 0 01-4-4v-4zM7 14v6M17 14v6" />
                            </svg>
                            <p class="font-medium">Kamar Mandi</p>
                            <p class="text-gray-600">{{ $property->bathrooms }}</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mx-auto mb-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3 3h18v18H3V3zm6 0v18m6-18v18M3 9h18M3 15h18" />
                            </svg>
                            <p class="font-medium">Luas</p>
                            <p class="text-gray-600">{{ $property->area }} m²</p>
                        </div>
                    </div>
                </div>

                <h2 class="text-xl font-semibold mb-4 text-gray-800">Fasilitas Lingkungan</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse ($property->amenities as $amenity)
                        <div class="bg-gray-50 p-4 rounded-lg text-center border border-gray-100 hover:shadow-sm transition">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 2l1.5 4.5H18l-3.75 3 1.5 4.5L12 12l-3.75 2.5 1.5-4.5L6 6.5h4.5z"/>
                            </svg>
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

                    {{-- Property Visit Section --}}
                    <h3 class="text-lg font-semibold mb-2 text-gray-800">Jadwalkan Kunjungan Properti</h3>
                    <input type="date" id="visit_date" class="w-full p-2 border rounded-lg mb-4">
                    <button id="schedule_visit_button" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                        Jadwalkan Kunjungan
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Confirmation Modal Structure --}}
<div id="confirmation_modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Jadwal Kunjungan</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="scheduled_date_text"></p>
                <p class="text-sm text-gray-500">Anda yakin ingin menjadwalkan kunjungan pada tanggal ini?</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirm_schedule_button" class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Konfirmasi
                </button>
                <button id="cancel_schedule_button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Checkout form logic (keep existing)
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

        // Favorite button logic (keep existing)
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

        // Property Visit Scheduling Logic
        const visitDateInput = document.getElementById('visit_date');
        const scheduleVisitButton = document.getElementById('schedule_visit_button');
        const confirmationModal = document.getElementById('confirmation_modal');
        const scheduledDateText = document.getElementById('scheduled_date_text');
        const confirmScheduleButton = document.getElementById('confirm_schedule_button');
        const cancelScheduleButton = document.getElementById('cancel_schedule_button');

        // You will need to integrate a date picker library here (e.g., Flatpickr)
        // For example, using Flatpickr:
        // flatpickr("#visit_date", { minDate: "today" });

        scheduleVisitButton.addEventListener('click', function() {
            const selectedDate = visitDateInput.value;

            if (!selectedDate) {
                alert('Please select a date for the visit.');
                return;
            }

            // Display the selected date in the modal
            scheduledDateText.innerText = 'Tanggal terpilih: ' + selectedDate;

            // Show the confirmation modal
            confirmationModal.classList.remove('hidden');
        });

        cancelScheduleButton.addEventListener('click', function() {
            // Hide the confirmation modal
            confirmationModal.classList.add('hidden');
        });

        confirmScheduleButton.addEventListener('click', function() {
            const selectedDate = visitDateInput.value;
            const propertyId = {{ $property->id }};
            const url = `/property/${propertyId}/visit`;
            const token = '{{ csrf_token() }}';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ scheduled_at: selectedDate })
            })
            .then(response => {
                if (!response.ok) {
                     return response.json().then(data => {
                        throw new Error(data.message || 'Failed to schedule visit.');
                    });
                }
                return response.json();
            })
            .then(data => {
                alert(data.message || 'Visit scheduled successfully!');
                confirmationModal.classList.add('hidden');
                visitDateInput.value = ''; // Clear the date input after successful scheduling
            })
            .catch(error => {
                 alert('Error scheduling visit: ' + error.message);
                 console.error('Error:', error);
                 confirmationModal.classList.add('hidden');
            });
        });


    });
</script>
@endsection
