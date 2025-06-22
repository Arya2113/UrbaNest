@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Admin Transactions</h2>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded overflow-x-auto">
                <table class="w-full min-w-[800px] divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Biaya Jasa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti Transfer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[300px]">{{ $transaction->property->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($transaction->harga_properti, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($transaction->biaya_jasa, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($transaction->total_transfer, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($transaction->bukti_transfer_url)
                                        @php
                                            $filePath = public_path(parse_url($transaction->bukti_transfer_url, PHP_URL_PATH));
                                            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];
                                        @endphp

                                        <a href="{{ asset($transaction->bukti_transfer_url) }}" target="_blank" class="flex items-center space-x-2 text-blue-600 hover:underline">
                                            @if (in_array($extension, $imageExtensions))
                                                <img src="{{ asset($transaction->bukti_transfer_url) }}" alt="Bukti Transfer" class="h-16 w-auto rounded">
                                            @elseif ($extension == 'pdf')
                                                <span class="flex items-center space-x-2">
                                                    <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                    </svg>
                                                    <span class="text-sm font-medium">Lihat PDF</span>
                                                </span>
                                            @else
                                                <span class="flex items-center space-x-2">
                                                    <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                    </svg>
                                                    <span class="text-sm font-medium">Unduh File</span>
                                                </span>
                                            @endif
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-500 italic">No Proof</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.transactions.updateStatus', $transaction) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status_transaksi" class="border border-gray-300 rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                                            <option value="pending" {{ $transaction->status_transaksi == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="verified" {{ $transaction->status_transaksi == 'verified' ? 'selected' : '' }}>Verified</option>
                                            <option value="rejected" {{ $transaction->status_transaksi == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs px-2 inline-flex leading-5 font-semibold rounded-full
                                        {{ $transaction->status_transaksi == 'verified' ? 'bg-green-100 text-green-800' : 
                                           ($transaction->status_transaksi == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($transaction->status_transaksi) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection