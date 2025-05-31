@extends('layouts.app')

@section('title', 'Status Verifikasi Pembayaran')

@section('content')
<div class="bg-slate-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
  <div class="w-full max-w-6xl mx-auto">
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

      {{-- Main Content: Awaiting Verification --}}
      <div class="lg:w-2/3 bg-white shadow-lg rounded-xl p-8 sm:p-12 flex flex-col items-center justify-center text-center">
        {{-- Placeholder for Clock Icon --}}
        <div class="w-20 h-20 mb-4 rounded-full bg-yellow-100 flex items-center justify-center">
          <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <span class="inline-block bg-yellow-200 text-yellow-700 text-sm font-semibold px-3 py-1 rounded-full mb-4">Pending</span>
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">Awaiting Verification</h1>
        <p class="text-gray-600 text-lg">
          We have received your proof of payment. Our admin is reviewing it.
        </p>
      </div>

      {{-- Sidebar: Details & Timeline --}}
      <div class="lg:w-1/3 space-y-6 lg:space-y-8">
        {{-- Transaction Details Card --}}
        <div class="bg-white shadow-lg rounded-xl p-6">
          <h2 class="text-xl font-semibold text-gray-800 mb-6">Transaction Details</h2>
          <div class="space-y-4">
            <div>
              <p class="text-sm text-gray-500">Property Reference</p>
              <p class="text-md font-medium text-gray-700">PRO-2024-0123</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Amount</p>
              <p class="text-md font-medium text-gray-700">$250,000.00</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Payment Method</p>
              <p class="text-md font-medium text-gray-700">Bank Transfer</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Upload Date</p>
              <p class="text-md font-medium text-gray-700">16 May 2025, 14:32</p>
            </div>
          </div>
        </div>

        {{-- Status Timeline Card --}}
        <div class="bg-white shadow-lg rounded-xl p-6">
          <h2 class="text-xl font-semibold text-gray-800 mb-6">Status Timeline</h2>
          <div class="space-y-6">
            {{-- Item 1: Proof Uploaded --}}
            <div class="flex items-start">
              <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4 flex-shrink-0">
                {{-- Placeholder for Cloud Icon --}}
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
              </div>
              <div>
                <p class="font-medium text-gray-700">Proof Uploaded</p>
                <p class="text-sm text-gray-500">16 May 2025, 14:32</p>
              </div>
            </div>

            {{-- Item 2: Under Review --}}
            <div class="flex items-start">
              <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mr-4 flex-shrink-0">
                {{-- Placeholder for Clock Icon --}}
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
              <div>
                <p class="font-medium text-gray-700">Under Review</p>
                <p class="text-sm text-gray-500">Estimated: 24 hours</p>
              </div>
            </div>

            {{-- Item 3: Verification Complete (Pending) --}}
            <div class="flex items-start opacity-60"> {{-- Opacity to show it's pending/disabled --}}
              <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mr-4 flex-shrink-0">
                {{-- Placeholder for Checkmark Icon (Grayed out) --}}
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
              </div>
              <div>
                <p class="font-medium text-gray-700">Verification Complete</p>
                <p class="text-sm text-gray-500">Pending verification</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection