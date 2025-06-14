@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="bg-slate-50 min-h-screen">
    <div class="relative pt-20 pb-16 overflow-hidden">
        <div class="relative max-w-4xl mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                Your <span class="text-blue-700">Profile</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Manage your account information below. You can edit your profile or update your password anytime.
            </p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 pb-20">
        <div class="bg-white border border-gray-200 rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Profile Details</h2>

            <div class="space-y-4">
                <div>
                    <label class="text-gray-600 font-medium">Name</label>
                    <p class="text-lg text-gray-900">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="text-gray-600 font-medium">Email</label>
                    <p class="text-lg text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="text-gray-600 font-medium">Phone</label>
                    <p class="text-lg text-gray-900">{{ $user->phone ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-10 flex gap-4">
                <a href="{{ route('profile.edit') }}" class="bg-blue-600 hover:bg-blue-800 text-white px-6 py-3 rounded-lg transition-all shadow">
                    Edit Profile
                </a>
                <a href="{{ route('profile.password') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg border transition-all">
                    Change Password
                </a>
            </div>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
