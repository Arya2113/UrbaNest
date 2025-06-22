@extends('layouts.app')
@section('title', 'UrbanNest - ' . $service['title'])
@section('content')
<div class="bg-slate-50 font-sans text-gray-900 min-h-screen">
    <main class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row items-start gap-8 mb-12">
            <div class="flex-1">
                <h1 class="text-3xl font-bold mb-2">{{ $service['title'] }}</h1>
                <p class="text-lg text-gray-600 mb-4">{{ $service['subtitle'] }}</p>
            </div>
            <img src="{{ asset($service['image']) }}" alt="{{ $service['title'] }}" class="w-full md:w-[440px] h-56 object-cover rounded-xl shadow" />
        </div>

        {{-- Section Layanan --}}
        @if(isset($service['sections']))
            @foreach ($service['sections'] as $sectionTitle => $items)
            <div class="mb-12">
                <h2 class="text-xl font-bold text-center mb-8">{{ $sectionTitle }}</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($items as $section)
                        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-start">
                            <img src="{{ asset($section['icon']) }}" alt="{{ $section['title'] }}" class="w-10 h-10 mb-4" />
                            <div>
                                <h3 class="font-semibold mb-1">{{ $section['title'] }}</h3>
                                <p class="text-gray-500 text-sm">{{ $section['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif

        {{-- Workflow --}}
        @if(isset($service['workflow']))
        <div class="bg-[#f8fbff] rounded-lg px-6 py-10 mb-12">
            <h2 class="text-xl font-bold text-center mb-8">{{ $service['workflow_title'] }}</h2>
            <div class="flex flex-col md:flex-row justify-center gap-6">
                @foreach ($service['workflow'] as $step)
                    <div class="flex flex-col items-center md:items-start">
                        <div class="text-blue-600 text-2xl font-bold mb-2">{{ $step['step'] }}</div>
                        <div class="font-semibold">{{ $step['title'] }}</div>
                        <div class="text-gray-500 text-sm">{{ $step['desc'] }}</div>
                    </div>
                    @if (!$loop->last)
                        <div class="hidden md:flex items-center mx-4 text-gray-300 text-2xl">→</div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- CTA --}}
        <div class="text-center mt-10">
            <h2 class="text-xl font-bold mb-2">{{ $service['cta_title'] }}</h2>
            <p class="text-gray-600 mb-6">{{ $service['cta_subtitle'] }}</p>
            <a href="{{ route('service.request', ['slug' => $slug]) }}" class="inline-block rounded bg-blue-600 px-6 py-2 text-white font-semibold hover:bg-blue-700">
                {{ $service['main_cta'] }}
            </a>
        </div>
    </main>
</div>

@include('partials.footer')
@endsection
