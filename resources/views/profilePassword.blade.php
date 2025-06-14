@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="bg-slate-50 min-h-screen">
    <div class="relative pt-20 pb-16 overflow-hidden">
        <div class="relative max-w-4xl mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                Change <span class="text-blue-700">Password</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                For your account security, we recommend using a strong password.
            </p>
        </div>
    </div>

    <div class="max-w-xl mx-auto px-4 pb-20">
        <div class="bg-white border border-gray-200 rounded-xl shadow-lg p-8">

            @if(session('success'))
                <div class="mb-4 text-green-600 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf

                {{-- Current Password --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Current Password</label>
                    <input type="password" name="current_password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">New Password</label>
                    <input type="password" name="new_password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('new_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm New Password --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Submit --}}
                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition shadow">
                        Update Password
                    </button>
                    <a href="{{ route('profile.show') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
