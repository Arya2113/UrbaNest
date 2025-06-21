@extends('layouts.app')

@section('title', 'UrbaNest - Riwayat Transaksi')

@section('content')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Riwayat Transaksi Anda</h1>

    <div class="mb-12">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Menunggu Verifikasi</h2>
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <p class="text-sm font-medium text-gray-600">Transaksi yang memerlukan konfirmasi admin.</p>
            </div>
            
            @if (isset($processVerificationTransactions) && $processVerificationTransactions->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($processVerificationTransactions as $transaction)
                        <li class="p-6 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                                <div class="flex-1 mb-4 sm:mb-0">
                                    <div class="flex items-center mb-2">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">
                                            ID: {{ $transaction->id }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                                            @if ($transaction->status_transaksi === 'uploaded') 
                                                bg-yellow-100 text-yellow-800 
                                            @else 
                                                bg-gray-100 text-gray-800 
                                            @endif">
                                            @if ($transaction->status_transaksi === 'uploaded')
                                                Menunggu Konfirmasi
                                            @else
                                                {{ ucfirst($transaction->status_transaksi) }}
                                            @endif
                                        </span>
                                    </div>
                                     
                                    @if ($transaction->property)
                                        <p class="text-lg font-bold text-gray-900">{{ $transaction->property->title }}</p>
                                        <div class="flex items-center text-gray-500 text-sm mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                                              <path fill-rule="evenodd" d="m9.69 18.933.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.1.4-.223.654-.369.625-.362 1.544-.924 2.667-1.735C15.835 14.61 17 12.63 17 10a7 7 0 1 0-14 0c0 2.63 1.165 4.61 2.803 5.998 1.123.811 2.042 1.373 2.667 1.735a11.742 11.742 0 0 0 .935.51ZM10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ $transaction->property->location }}</span>
                                        </div>
                                    @endif

                                    <div class="mt-3 text-sm text-gray-700">
                                        <p><strong>Jumlah:</strong> Rp{{ number_format($transaction->total_transfer ?? 0, 0, ',', '.') }}</p>
                                        <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d F Y, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex-shrink-0">
                                    <a href="{{ route('payment.confirmation', $transaction->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Lihat Detail
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0L13.5 19.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="px-6 py-10 text-center">
                    <p class="text-gray-500">Tidak ada transaksi yang menunggu verifikasi.</p>
                </div>
            @endif
        </div>
    </div>
    
    <div class="mb-12">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Pesanan Layanan</h2>
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <p class="text-sm font-medium text-gray-600">Riwayat pesanan layanan jasa.</p>
            </div>
            @if (isset($serviceOrders) && $serviceOrders->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($serviceOrders as $order)
                        <li class="p-6 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                                <div class="flex-1 mb-4 sm:mb-0">
                                    <div class="flex items-center mb-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                                            Status: {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <p class="text-lg font-bold text-gray-900">Layanan {{ ucfirst($order->service_type) }}</p>
                                    <div class="flex items-center text-gray-500 text-sm mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                                          <path fill-rule="evenodd" d="m9.69 18.933.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.1.4-.223.654-.369.625-.362 1.544-.924 2.667-1.735C15.835 14.61 17 12.63 17 10a7 7 0 1 0-14 0c0 2.63 1.165 4.61 2.803 5.998 1.123.811 2.042 1.373 2.667 1.735a11.742 11.742 0 0 0 .935.51ZM10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $order->project_location }}</span>
                                    </div>
                                    <div class="mt-3 text-sm text-gray-700 space-y-1">
                                        <p><strong>Anggaran:</strong> {{ $order->estimated_budget ? 'Rp' . number_format($order->estimated_budget, 0, ',', '.') : '-' }}</p>
                                        <p><strong>Tanggal Pesan:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('order.status.show', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Lihat Detail
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0L13.5 19.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="px-6 py-10 text-center">
                    <p class="text-gray-500">Belum ada riwayat layanan yang dipesan.</p>
                </div>
            @endif
        </div>
    </div>
     
    <div class="mb-12">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Transaksi Berhasil</h2>
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <p class="text-sm font-medium text-gray-600">Properti yang telah berhasil Anda beli.</p>
            </div>
            @if (isset($purchasedTransactions) && $purchasedTransactions->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($purchasedTransactions as $transaction)
                        <li class="p-6 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                                <div class="flex-1 mb-4 sm:mb-0">
                                    <div class="flex items-center mb-2">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">
                                            ID: {{ $transaction->id }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            {{ ucfirst($transaction->status_transaksi) }}
                                        </span>
                                    </div>
                                    @if ($transaction->property)
                                        <p class="text-lg font-bold text-gray-900">{{ $transaction->property->title }}</p>
                                        <div class="flex items-center text-gray-500 text-sm mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                                              <path fill-rule="evenodd" d="m9.69 18.933.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.1.4-.223.654-.369.625-.362 1.544-.924 2.667-1.735C15.835 14.61 17 12.63 17 10a7 7 0 1 0-14 0c0 2.63 1.165 4.61 2.803 5.998 1.123.811 2.042 1.373 2.667 1.735a11.742 11.742 0 0 0 .935.51ZM10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ $transaction->property->location }}</span>
                                        </div>
                                    @endif
                                    <div class="mt-3 text-sm text-gray-700">
                                        <p><strong>Harga:</strong> Rp{{ number_format($transaction->total_transfer ?? 0, 0, ',', '.') }}</p>
                                        <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d F Y, H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('payment.confirmation', $transaction->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Lihat Detail
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0L13.5 19.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="px-6 py-10 text-center">
                    <p class="text-gray-500">Belum ada transaksi pembelian.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection