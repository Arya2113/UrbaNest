<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Property Visits</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Admin Property Visits</h2>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kunjungan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($propertyVisits as $visit)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $visit->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $visit->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $visit->user->phone ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[300px]">{{ $visit->property->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($visit->scheduled_at)->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.property_visits.updateStatus', $visit) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="border border-gray-300 rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                                            <option value="pending" {{ $visit->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="contacted" {{ $visit->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                            <option value="visited" {{ $visit->status == 'visited' ? 'selected' : '' }}>Visited</option>
                                            <option value="cancelled" {{ $visit->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs px-2 inline-flex leading-5 font-semibold rounded-full
                                        @if ($visit->status == 'visited') bg-green-100 text-green-800
                                        @elseif ($visit->status == 'cancelled') bg-red-100 text-red-800
                                        @elseif ($visit->status == 'contacted') bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($visit->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
