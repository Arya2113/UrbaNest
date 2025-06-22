@extends('layouts.app')

@section('title', 'Layanan Kami')

@section('content')
<div class="bg-slate-50 min-h-screen">
    
    {{-- Hero Section --}}
    <div class="relative pt-20 pb-16 overflow-hidden">
        <div class="absolute inset-0"></div>
        <div class="relative max-w-4xl mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                <span class="text-blue-700">Layanan</span> Kami
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                UrbaNest menawarkan solusi properti terintegrasi — mulai dari menemukan hunian impian, membangun, hingga mendesain ruang sempurna Anda dengan keahlian terbaik.
            </p>
        </div>
    </div>

    {{-- Kartu Layanan --}}
    <div class="max-w-7xl mx-auto px-4 pb-16">
        <div class="grid md:grid-cols-3 gap-8 mb-20">
        
        {{-- Konstruksi --}}
        <div class="border border-gray-200 rounded-lg p-6 flex flex-col">
            <div class="flex justify-center mb-4">
                <div class="bg-blue-100 p-3 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="4" y="3" width="16" height="18" rx="2"></rect>
                        <path d="M9 21V9h6v12"></path>
                        <path d="M9 3V6"></path>
                        <path d="M15 3V6"></path>
                        <circle cx="12" cy="15" r="1" fill="currentColor"></circle>
                    </svg>
                </div>
            </div>
            <h3 class="text-xl font-bold mb-3 text-center">Konstruksi</h3>
            <p class="text-gray-600 text-center mb-4">Bangun rumah impian Anda dari nol dengan layanan konstruksi profesional kami.</p>
            <div class="flex justify-center mt-auto">
                <a href="{{ route('service.show', ['slug' => 'construction']) }}" class="text-blue-600 border border-blue-600 px-4 py-2 rounded-md hover:bg-blue-600 hover:text-white transition">
                    Selengkapnya
                </a>
            </div>
        </div>

        {{-- Renovasi --}}
        <div class="border border-gray-200 rounded-lg p-6 flex flex-col">
            <div class="flex justify-center mb-4">
                <div class="bg-blue-100 p-3 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20.25 4.317a2.366 2.366 0 00-3.346 0l-1.528 1.528 3.346 3.346 1.528-1.528a2.366 2.366 0 000-3.346z"></path>
                        <path d="M7.293 9.707l-4.5 4.5a1 1 0 00-.293.707V18a1 1 0 001 1h3.086a1 1 0 00.707-.293l4.5-4.5"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-xl font-bold mb-3 text-center">Renovasi</h3>
            <p class="text-gray-600 text-center mb-4">Ubah tampilan ruang lama menjadi baru dengan layanan renovasi terpercaya kami.</p>
            <div class="flex justify-center mt-auto">
                <a href="{{ route('service.show', ['slug' => 'renovation']) }}" class="text-blue-600 border border-blue-600 px-4 py-2 rounded-md hover:bg-blue-600 hover:text-white transition">
                    Selengkapnya
                </a>
            </div>
        </div>

        {{-- Desain --}}
        <div class="border border-gray-200 rounded-lg p-6 flex flex-col">
            <div class="flex justify-center mb-4">
                <div class="bg-blue-100 p-3 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19.5 4.5l-15 15"></path>
                        <path d="M4.5 19.5l7.5-7.5"></path>
                        <circle cx="19.5" cy="4.5" r="2.5" fill="currentColor"></circle>
                    </svg>
                </div>
            </div>
            <h3 class="text-xl font-bold mb-3 text-center">Desain</h3>
            <p class="text-gray-600 text-center mb-4">Ciptakan ruang indah dan fungsional dengan layanan desain interior & eksterior kami.</p>
            <div class="flex justify-center mt-auto">
                <a href="{{ route('service.show', ['slug' => 'design']) }}" class="text-blue-600 border border-blue-600 px-4 py-2 rounded-md hover:bg-blue-600 hover:text-white transition">
                    Selengkapnya
                </a>
            </div>
        </div>
        </div>

        {{-- Mengapa Memilih Kami --}}
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 border border-gray-100">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Mengapa Memilih Kami
                    </div>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 leading-tight">
                        Unggul dalam <span class="text-blue-700">Setiap Detail</span>
                    </h3>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-700 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Tim Ahli</h4>
                                <p class="text-gray-600 leading-relaxed">Kami terdiri dari arsitek, desainer, dan profesional konstruksi berpengalaman yang telah menangani berbagai proyek.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-700 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Material Berkualitas</h4>
                                <p class="text-gray-600 leading-relaxed">Kami hanya menggunakan material terbaik dari pemasok terpercaya untuk memastikan daya tahan dan kualitas.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-700 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Tepat Waktu</h4>
                                <p class="text-gray-600 leading-relaxed">Kami menyelesaikan proyek sesuai jadwal dan anggaran dengan komunikasi yang transparan.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Kepuasan Pelanggan</h4>
                                <p class="text-gray-600 leading-relaxed">Kami selalu mengutamakan kepuasan Anda dengan memberikan hasil terbaik di setiap proyek.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8"></div>
                </div>

                <div class="relative">
                    <div class="absolute inset-0 rounded-3xl transform rotate-3"></div>
                    <div class="relative bg-gray-100 rounded-3xl h-80 flex items-center justify-center shadow-xl">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">Gambar Tim Profesional</p>
                            <p class="text-gray-400 text-sm mt-1">Segera Hadir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@include('partials.footer')
@endsection
