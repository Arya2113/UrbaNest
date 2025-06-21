@extends('layouts.app')

@section('title', 'Request ' . $service_label . ' Service')

@section('content')
<div class="bg-slate-100 min-h-screen pt-16 pb-20">
    <div class="w-full max-w-2xl mx-auto">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2 text-center">
            Request {{ $service_label }} Service
        </h1>
        <p class="text-gray-600 text-center mb-8 max-w-lg mx-auto">
            Fill out the form below to start your {{ strtolower($service_label) }} project. Our team will review your request and get in touch with you soon.
        </p>

        @if(session('success'))
            <div class="mb-6 text-green-600 bg-green-100 rounded p-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 rounded text-red-700">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('service.request.submit') }}" method="POST" class="bg-white rounded-xl shadow p-6 sm:p-10 space-y-8">
            @csrf

            
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Personal Details</h2>
                <div class="grid gap-5">
                    <div>
                        <input type="text" name="full_name" placeholder="Enter your full name" class="w-full border border-gray-300 rounded-lg p-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Enter your email" class="w-full border border-gray-300 rounded-lg p-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <input type="text" name="phone_number" placeholder="Enter your phone number" class="w-full border border-gray-300 rounded-lg p-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Project Information</h2>
                <div class="grid gap-5">
                    <div>
                        <input type="text" name="project_location" placeholder="Enter project location" class="w-full border border-gray-300 rounded-lg p-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                     
                    <div>
                        <input type="hidden" name="service_type" value="{{ $slug }}">
                        <input type="text" value="{{ $service_label }}" 
                            class="w-full border border-gray-300 rounded-lg p-3 text-base bg-gray-100 cursor-not-allowed" 
                            disabled>
                    </div>

                    <div>
                        <input type="number" name="estimated_budget" placeholder="Enter estimated budget" class="w-full border border-gray-300 rounded-lg p-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <input type="date" name="project_date" class="w-full border border-gray-300 rounded-lg p-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="yyyy/mm/dd">
                    </div>
                    <div>
                        <textarea name="project_description" rows="3" placeholder="Describe your {{ strtolower($service_label) }} project in detail..." class="w-full border border-gray-300 rounded-lg p-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="terms" name="terms" required class="mr-2">
                <label for="terms" class="text-gray-600 text-sm">I agree to the Terms and Conditions and Privacy Policy</label>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-150 ease-in-out text-base">
                Submit Service Request
            </button>
        </form>
    </div>
</div>
@endsection
