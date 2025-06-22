@extends('layouts.app')

@section('content')
<div class="bg-white text-gray-800 px-4 md:px-8 lg:px-20 py-16">
    {{-- Hero Section --}}
    <div class="text-center py-16 px-6">
        <h1 class="text-4xl font-bold mb-4">Tentang UrbaNest</h1>
        <p class="text-lg text-gray-600">Solusi properti terpadu untuk menemukan, membangun, dan mendesain ruang impian Anda.</p>
    </div>

    {{-- Our Story --}}
    <div class="max-w-7xl mx-auto px-6 py-12 flex flex-col lg:flex-row gap-10 items-start">
        <div class="flex-1">
            <img src="{{ asset('images/ourstory/ourstory.png') }}" alt="Cerita UrbaNest" class="w-full rounded-xl shadow-md object-cover">
        </div>
        <div class="flex-1 space-y-4">
            <h2 class="text-2xl font-semibold">Cerita Kami</h2>
            <p class="text-gray-600">
                UrbaNest didirikan pada tahun 2015 dengan visi sederhana: membuat proses menemukan, membangun, dan mendesain properti menjadi lebih mudah dan terintegrasi. Kami menyadari bahwa banyak orang menghadapi kesulitan ketika harus berurusan dengan berbagai pihak untuk kebutuhan properti mereka.
            </p>
            <p class="text-gray-600">
                Dimulai dengan tim kecil yang terdiri dari arsitek, agen real estate, dan pengembang, UrbaNest tumbuh menjadi perusahaan properti terpadu yang menawarkan berbagai layanan mulai dari penjualan properti hingga konstruksi, renovasi, dan desain.
            </p>
            <p class="text-gray-600">
                Hari ini, UrbaNest telah membantu ribuan klien menemukan dan menciptakan ruang impian mereka. Kami terus berkomitmen untuk memberikan layanan berkualitas tinggi dengan pendekatan yang berpusat pada klien.
            </p>
        </div>
    </div>

    {{-- Misi & Visi --}}
    <div class="bg-blue-50 py-12 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-10">
            <div>
                <h3 class="text-xl font-semibold flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                    Misi Kami
                </h3>
                <p class="text-gray-600">
                    Menyediakan solusi properti terpadu yang memudahkan klien untuk menemukan, membangun, dan mendesain ruang yang sesuai dengan kebutuhan dan impian mereka. Kami berkomitmen untuk memberikan layanan berkualitas tinggi dengan integritas, transparansi, dan kepuasan klien sebagai prioritas utama.
                </p>
            </div>
            <div>
                <h3 class="text-xl font-semibold flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                    Visi Kami
                </h3>
                <p class="text-gray-600">
                    Menjadi perusahaan properti terpadu terkemuka yang dikenal karena inovasi, kualitas, dan layanan pelanggan yang luar biasa. Kami bertujuan untuk mengubah cara orang berpikir tentang properti dengan menyediakan solusi end-to-end yang memudahkan setiap langkah dalam perjalanan properti mereka.
                </p>
            </div>
        </div>
    </div>

    {{-- Nilai-Nilai --}}
    <div class="py-16 px-6 text-center">
        <h2 class="text-3xl font-bold mb-10">Nilai-Nilai Kami</h2>
        <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-6 text-left">
            <div class="bg-white shadow rounded-xl p-6">
                <div class="text-3xl mb-4">👥</div>
                <h3 class="font-semibold text-lg mb-2">Berpusat pada Klien</h3>
                <p class="text-gray-600">Kami menempatkan kebutuhan dan kepuasan klien sebagai prioritas utama dalam setiap keputusan dan tindakan yang kami ambil.</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <div class="text-3xl mb-4">🏆</div>
                <h3 class="font-semibold text-lg mb-2">Kualitas Tanpa Kompromi</h3>
                <p class="text-gray-600">Kami berkomitmen untuk memberikan kualitas tertinggi dalam setiap aspek layanan kami, dari properti yang kami jual hingga konstruksi dan desain yang kami tawarkan.</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <div class="text-3xl mb-4">⏰</div>
                <h3 class="font-semibold text-lg mb-2">Efisiensi & Ketepatan Waktu</h3>
                <p class="text-gray-600">Kami menghargai waktu klien kami dan berkomitmen untuk menyelesaikan proyek tepat waktu tanpa mengorbankan kualitas.</p>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="bg-blue-50 py-16 text-center">
        <h2 class="text-2xl font-bold mb-4">Siap Bekerja Sama dengan Kami?</h2>
        <p class="text-gray-600 mb-6">Hubungi kami untuk mendiskusikan kebutuhan properti Anda atau jelajahi layanan kami.</p>
        <div class="flex justify-center gap-4">
            <a href="/cariproperti" class="px-6 py-3 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-100">Jelajahi Properti</a>
            <a href="/services" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Lihat Layanan Kami</a>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection
