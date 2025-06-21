@extends('layouts.app')

@section('content')
<div class="w-full flex justify-center">
    <div class="max-w-7xl m-12 rounded-2xl bg-white p-12 shadow-2xl flex flex-col gap-6">
        <h1 class="text-4xl font-bold">
            Kontak Kami
        </h1>
        <p class="font-semibold text-gray-500 text-justify">
            Ada pertanyaan, saran, atau ingin bekerja sama? Tim Urbanest Solo siap membantu Anda. Kami terbuka untuk diskusi mengenai properti, layanan konstruksi, hingga potensi kolaborasi lokal. Jangan ragu untuk menghubungi kami kapan pun dibutuhkan.
        </p>

        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Informasi Kontak</h2>
            <ul class="text-gray-600 font-medium space-y-2">
                <li><strong>Email:</strong> support@urbanest.id</li>
                <li><strong>Telepon:</strong> +62 821-9876-5432</li>
                <li><strong>Alamat:</strong> Jl. Slamet Riyadi No. 45, Laweyan, Kota Surakarta (Solo), Jawa Tengah</li>
                <li><strong>Instagram:</strong> <a href="#" class="text-blue-500 hover:underline">@urbanest.solo</a></li>
            </ul>
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Jam Operasional</h2>
            <p class="text-gray-600 font-medium">
                Senin - Jumat: 08.00 - 16.00 WIB <br>
                Sabtu - Minggu: Tutup (melayani via email)
            </p>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection