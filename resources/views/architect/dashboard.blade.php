@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Dashboard Architect</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Layanan</th>
                <th class="px-4 py-2 border">No. HP client</th> 
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($serviceOrders as $order)
            <tr class="text-center">
                <td class="px-4 py-2 border">{{ $order->id }}</td>
                <td class="px-4 py-2 border">{{ $order->service_type }}</td>
                <td class="px-4 py-2 border">{{ $order->user->phone ?? '-' }}</td>
                <td class="px-4 py-2 border capitalize">{{ str_replace('_', ' ', $order->status) }}</td>
                <td class="px-4 py-2 border">
                    <form method="POST" action="{{ route('architect.service_orders.updateStatus', $order->id) }}"
                        onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                        @csrf
                        @method('PUT')
                        <select name="status" class="border rounded px-2 py-1">
                            @foreach([
                                'pending' => 'Pending',
                                'consultation' => 'Consultation',
                                'site_survey' => 'Site Survey',
                                'designing' => 'Designing',
                                'in_progress' => 'In Progress',
                                'review' => 'Review',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ] as $value => $label)
                                <option value="{{ $value }}" {{ $order->status == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="ml-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Update
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
