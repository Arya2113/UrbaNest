@extends('layouts.app')
@section('title', 'User Profile')
@section('content')
<div class="bg-slate-50 font-sans text-gray-900 min-h-screen">
    <main class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        {{-- Header Profil --}}
        <div class="flex flex-col items-center mb-12">
            <div class="relative">
                <!-- Foto Profil -->
                <img src="{{ asset($user->profile_image) }}" alt="{{ $user->name }}" class="w-32 h-32 object-cover rounded-full shadow-xl" />
                <!-- Ikon Kamera -->
                <a href="#" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 shadow-lg">
                    <i class="fa fa-camera"></i>
                </a>
            </div>
            <h1 class="text-3xl font-bold mt-4">{{ $user->name }}</h1>
            <p class="text-gray-600 text-sm">{{ $user->email }}</p>
            <a href="{{ route('profileEdit') }}" class="mt-3 text-blue-600 hover:text-blue-700 text-sm">Edit Profile</a>
        </div>

        {{-- Personal Information --}}
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <h2 class="text-2xl font-semibold mb-6">Personal Information</h2>
            <div class="space-y-4">
                <div>
                    <strong class="text-gray-700">Full Name:</strong>
                    <p>{{ $user->name }}</p>
                </div>
                <div>
                    <strong class="text-gray-700">Email:</strong>
                    <p>{{ $user->email }}</p>
                </div>
                <div>
                    <strong class="text-gray-700">Bio:</strong>
                    <p>{{ $user->bio ?: 'No bio available' }}</p>
                </div>
                <div>
                    <strong class="text-gray-700">Phone:</strong>
                    <p>{{ $user->phone_number ?: 'Not available' }}</p>
                </div>
                <div>
                    <strong class="text-gray-700">Location:</strong>
                    <p>{{ $user->location ?: 'Not specified' }}</p>
                </div>
            </div>
        </div>

        {{-- Change Password Link --}}
        <div class="flex justify-center mb-12">
            <a href="{{ route('profilePassword') }}" class="text-blue-600 hover:text-blue-700 text-lg">
                Change Password
            </a>
        </div>

    </main>
</div>

@include('partials.footer')
@endsection
