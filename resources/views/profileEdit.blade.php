@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
<div class="bg-slate-50 font-sans text-gray-900 min-h-screen">
    <main class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        {{-- Header Edit Profil --}}
        <div class="flex flex-col items-center mb-12">
            <h1 class="text-3xl font-bold">Edit Profile</h1>
            <p class="text-gray-600 mb-4">Update your profile information below</p>
        </div>

        {{-- Form Edit Profil --}}
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <form method="POST" action="{{ route('profileUpdate') }}">
                @csrf
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="mt-1 block w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold">Email</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="mt-1 block w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div class="mb-4">
                        <label for="bio" class="block text-sm font-semibold">Bio</label>
                        <textarea name="bio" id="bio" class="mt-1 block w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">{{ $user->bio }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-semibold">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ $user->phone_number }}" class="mt-1 block w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div class="mb-4">
                        <label for="location" class="block text-sm font-semibold">Location</label>
                        <input type="text" name="location" id="location" value="{{ $user->location }}" class="mt-1 block w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <a href="{{ route('profileShow') }}" class="bg-gray-400 text-white p-3 rounded-lg hover:bg-gray-500">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700">Save Changes</button>
                </div>
            </form>
        </div>

    </main>
</div>

@include('partials.footer')
@endsection
