@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="bg-slate-100 p-4 sm:p-6 lg:p-8 pt-16">
  <div class="w-full max-w-5xl mx-auto">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Payment Detail</h1>
    <div class="mb-6 sm:mb-8">
        <p class="text-lg text-gray-700"><span class="font-semibold">Nama Properti:</span> {{ $property->title }}</p>
        <p class="text-md text-gray-600"><span class="font-semibold">Lokasi:</span> {{ $property->address }}</p>
    </div>

    <div id="countdown" class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative mb-6" role="alert">
        Pembayaran harus diselesaikan dalam waktu: <span id="timer" class="font-semibold"></span>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
      
      <div class="lg:w-1/2 space-y-6">
        <div class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Transfer Manual</h2>
          <div class="space-y-3">
            <div>
              <p class="text-sm text-gray-500">Bank Tujuan</p>
              <p class="text-lg font-medium text-gray-800">Bank UrbaNest</p>
            </div>
          </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Rekening</h2>
          <div class="space-y-3">
            <div>
              <p class="text-sm text-gray-500">Nama Rekening</p>
              <p class="text-lg font-medium text-gray-800">Urbanest</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">No Rekening</p>
              <p class="text-lg font-medium text-gray-800">000987654321</p>
            </div>
          </div>
        </div>
      </div>

      <div class="lg:w-1/2 bg-white p-8 rounded-lg shadow h-fit">
        <h2 class="text-xl sm:text-2xl font-semibold text-gray-700 mb-8">Ringkasan Pembelian</h2>
        <div class="space-y-4 mb-8">
          <div class="flex justify-between items-center">
            <p class="text-base text-gray-600">Harga Properti</p>
            <p class="text-base font-medium text-gray-800">Rp {{ number_format($hargaProperti, 0, ',', '.') }}</p>
          </div>
          <div class="flex justify-between items-center">
            <p class="text-base text-gray-600">Biaya Layanan (5%)</p>
            <p class="text-base font-medium text-gray-800">Rp {{ number_format($biayaLayanan, 0, ',', '.') }}</p>
          </div>
          <div class="flex justify-between items-center">
            <p class="text-base text-gray-600">Kode Unik Transfer</p>
            <p class="text-base font-medium text-gray-800">Rp {{ number_format($kodeUnik, 0, ',', '.') }}</p>
          </div>
        </div>
        <hr class="my-6 border-gray-200">
        <div class="flex justify-between items-center mb-4">
          <p class="text-lg sm:text-xl font-semibold text-gray-800">Total Tagihan</p>
          <p class="text-lg sm:text-xl font-bold text-blue-600">Rp {{ number_format($jumlahTotal, 0, ',', '.') }}</p>
        </div>
        <p class="text-sm text-red-500 mb-8">*pastikan transfer sesuai dengan total tagihan dan file uploud maks 5 Mb</p>
        <form action="{{ route('payment.upload', ['property' => $property->id]) }}" method="POST" enctype="multipart/form-data">
          @csrf
            <input type="hidden" name="property_id" value="{{ $property->id }}">
            <input type="file" name="proof" accept=".jpeg,.jpg,.png,application/pdf" class="mb-4">
            @error('proof')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-150 ease-in-out text-base">
              Upload bukti bayar
            </button>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lockedUntilTimestamp = {{ $property->locked_until->timestamp }};
        const countdownElement = document.getElementById('timer');

        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const timeLeft = lockedUntilTimestamp - now;

            if (timeLeft <= 0) {
                countdownElement.textContent = 'Waktu pembayaran habis!';
                window.location.href = '/detailproperti/{{ $property->id }}'; 
                clearInterval(timerInterval);
                return;
            }

            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            countdownElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }

        updateCountdown();
        const timerInterval = setInterval(updateCountdown, 1000); 
    });
</script>
@endsection

