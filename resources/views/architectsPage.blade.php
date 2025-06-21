@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-center mb-8">Choose Your Architect</h1>

    <!-- Filter Buttons -->
    <div class="flex flex-wrap justify-center gap-2 mb-6">
        <a href="?style=all" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">All Styles</a>
        @foreach(['Modern', 'Minimalist', 'Industrial', 'Classic', 'Contemporary'] as $style)
            <a href="?style={{ $style }}" class="px-3 py-1 border border-gray-400 rounded text-sm text-gray-700 hover:bg-gray-100">
                {{ $style }}
            </a>
        @endforeach
    </div>

    <!-- Architect Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($architects as $architect)
        <div class="bg-white rounded-2xl shadow-md flex flex-col overflow-hidden">
            @if($architect->photo)
                <img src="{{ asset('storage/' . $architect->photo) }}" alt="{{ $architect->name }}"
                     class="w-full h-48 object-cover">
            @endif
            <div class="p-5 flex flex-col flex-1">
                <h2 class="text-lg font-semibold text-center">{{ $architect->name }}</h2>
                <p class="text-sm text-gray-500 text-center mb-2">{{ $architect->title }}</p>

                <div class="text-sm text-gray-600 text-center mb-3">
                    ⭐ {{ $architect->rating }} ({{ $architect->reviews_count }} reviews) <br>
                    🏆 {{ $architect->experience_years }} years experience <br>
                    📍 {{ $architect->location }}
                </div>

                <div class="flex flex-wrap justify-center gap-1 mb-4">
                    @foreach($architect->styles as $style)
                        <span class="text-xs bg-gray-200 text-gray-800 px-2 py-1 rounded-full">{{ $style }}</span>
                    @endforeach
                </div>

                <form action="{{ route('architect.select') }}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="architect_id" value="{{ $architect->id }}">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md text-sm font-medium">
                        Select Architect
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
