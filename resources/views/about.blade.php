@extends('layouts.app')

@section('content')
<div class="w-full flex justify-center">
    <div class="max-w-7xl m-12 rounded-2xl bg-white p-12 shadow-2xl flex flex-col gap-6 min-h-96">
        <h1 class="text-4xl font-bold">
            Tentang Kami
        </h1>
        <p class="font-semibold text-gray-500 text-justify">
            Kami adalah platform digital yang memudahkan siapa pun untuk mencari dan menemukan properti seperti rumah, tanah, atau bangunan lain dengan cepat dan efisien. Fokus utama kami adalah membantu pengguna menelusuri properti berdasarkan lokasi dan kategori secara praktis melalui sistem filter yang sederhana. <br><br>
            Selain itu, kami juga menyediakan informasi tentang layanan konstruksi dan renovasi dari berbagai penyedia jasa terpercaya. Dengan antarmuka yang ringan dan informasi yang jelas, kami hadir sebagai solusi bagi Anda yang ingin mencari properti atau jasa terkait tanpa perlu repot.
        </p>
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">
                Fitur Unggulan
            </h2>
            <ul class="list-disc list-inside text-gray-600 font-medium space-y-2">
                <ul class="list-disc list-inside text-gray-600 font-medium space-y-2">
                    <li>Filter properti berdasarkan lokasi, harga, dan kategori (rumah, tanah, dll).</li>
                    <li>Direktori jasa konstruksi, renovasi, dan desain interior yang bisa dihubungi langsung.</li>
                    <li>Antarmuka sederhana yang memudahkan pencarian properti tanpa ribet.</li>
                    <li>Informasi properti yang jelas dan terstruktur, tanpa embel-embel menyesatkan.</li>
                    <li>Dukungan komunikasi langsung antara pembeli dan pemilik/jasa terkait.</li>
                </ul>
            </ul>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection