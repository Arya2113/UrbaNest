@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    @php
        $label = [
            'construction' => 'Konstruksi',
            'renovation' => 'Renovasi',
            'design' => 'Desain',
        ];
    @endphp

    <div class="text-center mb-8">
        <h1 class="text-3xl font-semibold text-gray-800">{{ $judulProyek }}</h1>
        <p class="text-gray-500 text-sm mt-1">Layanan: <span class="font-medium">{{ $label[$order->service_type] ?? ucfirst($order->service_type) }}</span></p>
    </div>

    <div class="bg-white shadow-md rounded-2xl p-6 max-w-2xl mx-auto">
        <div class="space-y-2 mb-6">
            <p><span class="font-semibold text-gray-700">Alamat Lokasi:</span> {{ $order->project_location }}</p>
            <p><span class="font-semibold text-gray-700">Arsitek:</span> {{ $order->architect ? $order->architect->name : '-' }}</p>
            <p>
                <span class="font-semibold text-gray-700">Status Proyek:</span> 
                <span class="inline-block px-3 py-1 rounded-full text-white text-sm bg-blue-600">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>

        {{-- Progress Bar --}}
        <div class="mb-6">
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-green-500 h-4 rounded-full transition-all duration-500"
                     style="width: {{ $progressPercent }}%">
                </div>
            </div>
            <p class="text-right text-sm text-gray-600 mt-1">{{ $progressPercent }}% Selesai</p>
        </div>

        {{-- Timeline --}}
        <h5 class="text-lg font-semibold text-gray-800 mb-4">Timeline Proyek</h5>
        <ol class="relative border-l border-gray-300">
            @foreach ($timeline as $step)
            <li class="mb-6 ml-4">
                <div class="absolute w-3 h-3 bg-gray-300 rounded-full -left-1.5 border border-white
                    @if($step['done']) bg-green-500 @elseif($step['active']) bg-yellow-400 @endif">
                </div>
                <div class="p-3 bg-gray-100 rounded-xl shadow-sm">
                    <div class="font-semibold text-gray-800">{{ $step['title'] }}</div>
                </div>
            </li>
            @endforeach
        </ol>

        {{-- Tombol Back to Home --}}
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}"
               class="inline-block bg-blue-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-4 rounded-lg transition">
                ← Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
