@extends('layouts.app')
@section('title', 'Change Password')
@section('content')
<div class="bg-slate-50 font-sans text-gray-900 min-h-screen">
    <main class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        {{-- Header Ganti Password --}}
        <div class="flex flex-col items-center mb-12">
            <h1 class="text-2xl font-bold">Change Password</h1>
            <p class="text-gray-600 mb-4">Ensure your new password is strong and memorable.</p>
        </div>

        {{-- Form Ganti Password --}}
        <div class="bg-white rounded-lg shadow-lg p-6 mb-12">
            <form method="POST" action="{{ route('profileUpdatePassword') }}">
                @csrf
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold">New Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-semibold">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="flex justify-between mt-6">
                    <a href="{{ route('profileShow') }}" class="bg-gray-400 text-white p-3 rounded-lg hover:bg-gray-500">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700">Change Password</button>
                </div>
            </form>
        </div>

    </main>
</div>

@include('partials.footer')
@endsection
