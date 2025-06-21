@extends('layouts.app')

@section('title', 'Login - UrbaNest')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-900">Login</h2>

        <form class="mt-8 space-y-6" action="{{ route('login.post') }}" method="POST">
            @csrf  

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">There were some problems with your input.</span>
                    <ul class="mt-3 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                <input id="email" name="email" type="email" autocomplete="email" required
                       class="relative block w-full px-3 py-2 mt-1 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-500 @enderror"
                       placeholder="Email address" value="{{ old('email') }}">
                 @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                       class="relative block w-full px-3 py-2 mt-1 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-500 @enderror"
                       placeholder="Password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

             
            {{-- <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="remember-me" class="block ml-2 text-sm text-gray-900">Remember me</label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Forgot your password?</a>
                </div>
            </div> --}}

            <div>
                <button type="submit"
                        class="relative flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md group hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Sign in
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-gray-600">
            Don't have an account? <a href="{{ route('signup') }}" class="font-medium text-blue-600 hover:text-blue-500">Sign up</a>
        </div>
    </div>
</div>
@endsection
