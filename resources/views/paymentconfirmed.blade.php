@extends('layouts.app')

@section('title', 'Pembayaran Dikonfirmasi')

@section('content')

{{-- html2canvas --}}
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<style>
  .download-hide {
    display: block;
  }

  body.downloading .download-hide {
    display: none !important;
  }
</style>

<div class="bg-slate-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
  <div class="w-full max-w-3xl mx-auto">
    <div id="confirmed-section" class="bg-white shadow-lg rounded-xl p-8 sm:p-12 text-center">

      {{-- ✅ Success Section --}}
      <div class="mx-auto w-24 h-24 rounded-full bg-green-100 flex items-center justify-center mb-6">
        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
      </div>
      <h1 class="text-3xl font-bold text-gray-800 mb-4">Payment Confirmed</h1>
      <p class="text-lg text-gray-600 mb-8">Thank you for your payment. Your property purchase is now complete.</p>

      {{-- ✅ Transaction Details --}}
      <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Transaction Details</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <p class="text-sm text-gray-500">Property Name</p>
            <p class="text-md font-medium text-gray-700">{{ $transaction->property->title}}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Transaction ID</p>
            <p class="text-md font-medium text-gray-700">{{ $transaction->id }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Property Address</p>
            <p class="text-md font-medium text-gray-700">{{ $transaction->property->alamat }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Purchase Date</p>
            <p class="text-md font-medium text-gray-700">{{ $transaction->created_at->format('F d, Y') }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Price</p>
            <p class="text-md font-medium text-gray-700">Rp {{ number_format($transaction->total_transfer, 0, ',', '.') }}</p>
          </div>
        </div>
      </div>

      <div class="download-hide flex items-center justify-between bg-white rounded-lg p-4 mb-8 border border-gray-200">
        <div class="flex items-center">
          <svg class="w-6 h-6 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
          <div>
            <p class="text-sm font-semibold text-gray-700">Invoice #{{ $transaction->id}}</p>
            <p class="text-xs text-gray-500">PNG</p>
          </div>
        </div>
        <button id="downloadInvoiceBtn" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md transition duration-150 ease-in-out">
          <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L9 8m4-4v12"></path></svg>
          Download Invoice
        </button>
      </div>
      <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Need Help?</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.224 0L21 8m0 0l-3-3m3 3l-3 3M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <div>
              <p class="font-semibold text-gray-700">Email Support</p>
              <p class="text-sm text-gray-600">support@UrbaNest.com</p>
            </div>
          </div>
          <div class="flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10c0 3.9-3.1 7-7 7H7c-3.9 0-7-3.1-7-7s3.1-7 7-7h4c3.9 0 7 3.1 7 7zM7 9a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1zm6 0a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <div>
              <p class="font-semibold text-gray-700">WhatsApp</p>
              <p class="text-sm text-gray-600">+6289538509494</p>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center">
        <a href="/transactions" 
          class="inline-flex items-center bg-white hover:bg-gray-100 border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md transition duration-150 ease-in-out">
            Go to Transactions
        </a>
      </div>

    </div>
  </div>
</div>

<script>
  document.getElementById('downloadInvoiceBtn').addEventListener('click', function() {
    const target = document.getElementById('confirmed-section');
    document.body.classList.add('downloading'); 

    html2canvas(target).then(canvas => {
      const link = document.createElement('a');
      link.download = 'invoice-confirmed.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
      document.body.classList.remove('downloading'); 
    });
  });
</script>

@endsection