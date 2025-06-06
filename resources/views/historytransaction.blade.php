@extends('layouts.app')

@section('title', 'UrbaNest - Transaction History')

@section('content')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">Transaction History</h1>

    <div class="mb-12">
        <h2 class="text-xl font-semibold mb-4">Process Verification Transactions</h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @if (isset($processVerificationTransactions) && $processVerificationTransactions->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($processVerificationTransactions as $transaction)
                        <li class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">Transaction ID: {{ $transaction->id }}</div>
                                    {{-- Assuming transaction has a relationship to Property model --}}
                                    @if ($transaction->property)
                                        <div class="text-sm text-gray-600">Property: {{ $transaction->property->title }}</div>
                                        <div class="text-sm text-gray-600">Location: {{ $transaction->property->location }}</div>
                                    @endif
                                    <div class="text-sm text-gray-600">Amount: Rp{{ number_format($transaction->total_transfer ?? 0, 0, ',', '.') }}</div>
                                    <div class="text-sm text-gray-600">Date: {{ $transaction->created_at->format('Y-m-d H:i') }}</div>
                                </div>
                                <div class="text-sm font-semibold text-yellow-600 text-right">
                                    Status: 
                                    @if ($transaction->status_transaksi === 'uploaded')
                                        Waiting Confirmation
                                    @else
                                        {{ $transaction->status_transaksi }}
                                    @endif
                                    <br>
                                    <a href="{{ route('payment.confirmation', $transaction->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">View Details</a>
                                </div>
                            </div>


                        </li>
                    @endforeach
                </ul>
            @else
                <p class="px-6 py-4 text-gray-500">No pending verification transactions.</p>
            @endif
        </div>
    </div>

    {{-- Section 3: Purchased Properties --}}
    <div class="mb-12">
        <h2 class="text-xl font-semibold mb-4">Purchased Transactions</h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @if (isset($purchasedTransactions) && $purchasedTransactions->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($purchasedTransactions as $transaction)
                        <li class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">Transaction ID: {{ $transaction->id }}</div>
                                     {{-- Assuming transaction has a relationship to Property model --}}
                                    @if ($transaction->property)
                                        <div class="text-sm text-gray-600">Property: {{ $transaction->property->title }}</div>
                                        <div class="text-sm text-gray-600">Location: {{ $transaction->property->location }}</div>
                                    @endif
                                    <div class="text-sm text-gray-600">Amount: Rp{{ number_format($transaction->total_transfer ?? 0, 0, ',', '.') }}</div>
                                    <div class="text-sm text-gray-600">Date: {{ $transaction->created_at->format('Y-m-d H:i') }}</div>
                                </div>
                                <div class="text-sm font-semibold text-green-600 text-right">
                                    Status: {{ $transaction->status_transaksi }}
                                    <br>
                                    <a href="{{ route('payment.confirmation', $transaction->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">View Details</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="px-6 py-4 text-gray-500">No purchased transactions yet.</p>
            @endif
        </div>
    </div>

</div>
@endsection