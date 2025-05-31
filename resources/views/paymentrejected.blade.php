@extends('layouts.app')

@section('title', 'Pembayaran Ditolak')

@section('content')
<div class="bg-slate-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
  <div class="w-full max-w-3xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl p-8 sm:p-12 text-center">
      {{-- Error Icon --}}
      <div class="mx-auto w-24 h-24 rounded-full bg-red-100 flex items-center justify-center mb-6">
        <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
      </div>
      <h1 class="text-3xl font-bold text-gray-800 mb-4">Payment Rejected</h1>
      <p class="text-lg text-gray-600 mb-8">Your payment was not successful. Please check the details and try again or contact support.</p>

      {{-- Transaction Details (tetap ditampilkan) --}}
      <div class="bg-gray-50 rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4 text-left">Transaction Details</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <p class="text-sm text-gray-500">Property Name</p>
            <p class="text-md font-medium text-gray-700">Sunset Villa</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Transaction ID</p>
            <p class="text-md font-medium text-gray-700">TRX-2023112501</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Property Address</p>
            <p class="text-md font-medium text-gray-700">123 Oceanview Drive</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Purchase Date</p>
            <p class="text-md font-medium text-gray-700">November 25, 2023</p>
          </div>
          {{-- Mungkin bisa ditambahin alasan penolakan di sini kalau ada --}}
          <div class="col-span-2">
            <p class="text-sm text-red-500 font-semibold">Reason for Rejection: [Alasan Penolakan Jika Ada]</p>
          </div>
        </div>
      </div>

      {{-- Opsi untuk Coba Lagi atau Kontak Support --}}
      <div class="mb-8 text-center space-y-2">

        <p class="text-sm text-gray-600">If the problem persists, please contact our support team.</p>
      </div>

      {{-- Need Help? (tetap ditampilkan) --}}
      <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Need Help?</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.224 0L21 8m0 0l-3-3m3 3l-3 3M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <div>
              <p class="font-semibold text-gray-700">Email Support</p>
              <p class="text-sm text-gray-600">support@propertyco.com</p>
            </div>
          </div>
          <div class="flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10c0 3.9-3.1 7-7 7H7c-3.9 0-7-3.1-7-7s3.1-7 7-7h4c3.9 0 7 3.1 7 7zM7 9a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1zm6 0a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <div>
              <p class="font-semibold text-gray-700">WhatsApp</p>
              <p class="text-sm text-gray-600">+1 234 567 8900</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Back to Dashboard (atau link lain yang relevan) --}}
      <div class="text-center">
        <button class="inline-flex items-center bg-white hover:bg-gray-100 border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md transition duration-150 ease-in-out">
          Back to Dashboard
          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m4 4h14m4-4l-4-4m0 0l4 4"></path></svg>
        </button>
      </div>

    </div>
  </div>
</div>
@endsection