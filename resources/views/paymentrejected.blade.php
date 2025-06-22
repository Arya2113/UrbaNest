@extends('layouts.app')

@section('title', 'Pembayaran Ditolak')

@section('content')
<div class="bg-slate-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
  <div class="w-full max-w-3xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl p-8 sm:p-12 text-center">
       
      <div class="mx-auto w-24 h-24 rounded-full bg-red-100 flex items-center justify-center mb-6">
        <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
      </div>
      <h1 class="text-3xl font-bold text-gray-800 mb-4">Pembayaran Ditolak</h1>
      <p class="text-lg text-gray-600 mb-8">Pembayaran Anda tidak berhasil diproses. Mohon periksa kembali detailnya dan coba lagi atau hubungi dukungan.</p>

       
      <div class="bg-gray-50 rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4 text-left">Detail Transaksi</h2>
        @if($transaction)
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left">
          <div>
            <p class="text-sm text-gray-500">Nama Properti</p>
            <p class="text-md font-medium text-gray-700">{{ $transaction->property->title ?? 'N/A' }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">ID Transaksi</p>
            <p class="text-md font-medium text-gray-700">{{ $transaction->id ?? 'N/A' }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Lokasi Properti</p>
            <p class="text-md font-medium text-gray-700">{{ $transaction->property->location ?? 'N/A' }}</p>
          </div>
           <div>
            <p class="text-sm text-gray-500">Tanggal Transaksi</p>
            <p class="text-md font-medium text-gray-700">{{ $transaction->created_at ? $transaction->created_at->format('d F Y H:i:s') : 'N/A' }}</p>
          </div>
           
          @if(isset($transaction->reason_for_rejection))
          <div class="col-span-2">
            <p class="text-sm text-red-500 font-semibold">Alasan Penolakan: {{ $transaction->reason_for_rejection }}</p>
          </div>
          @endif
           <div class="col-span-2">
                <p class="text-sm text-gray-500">Total Transfer</p>
                <p class="text-lg font-bold text-gray-800">Rp {{ number_format($transaction->total_transfer ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
        @else
         <p class="text-md text-gray-600">Detail transaksi tidak tersedia.</p>
        @endif
      </div>

       
      <div class="mb-8 text-center space-y-2">

        <p class="text-sm text-gray-600">Jika masalah berlanjut, silakan hubungi tim dukungan kami.</p>
      </div>

       
      <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Butuh Bantuan?</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.224 0L21 8m0 0l-3-3m3 3l-3 3M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <div>
              <p class="font-semibold text-gray-700">Dukungan Email</p>
              <p class="text-sm text-gray-600">support@urbanest.id</p>
            </div>
          </div>
          <div class="flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10c0 3.9-3.1 7-7 7H7c-3.9 0-7-3.1-7-7s3.1-7 7-7h4c3.9 0 7 3.1 7 7zM7 9a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1zm6 0a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <div>
              <p class="font-semibold text-gray-700">WhatsApp</p>
              <p class="text-sm text-gray-600">+62 821-9876-5432</p>
            </div>
          </div>
        </div>
      </div>

       
      <div class="text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center bg-white hover:bg-gray-100 border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md transition duration-150 ease-in-out">
          Kembali ke Beranda
          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m4 4h14m4-4l-4-4m0 0l4 4"></path></svg>
        </a>
      </div>

    </div>
  </div>
</div>
@endsection
