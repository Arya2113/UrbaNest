@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="bg-slate-50 min-h-screen">
    
    {{-- Hero Section --}}
    <div class="relative pt-20 pb-16 overflow-hidden">
        <div class="absolute inset-0"></div>
        <div class="relative max-w-4xl mx-auto text-center px-4">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                Profil <span class="text-blue-700">Saya</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Kelola informasi pribadi Anda dengan mudah dan aman.
            </p>
        </div>
    </div>

    {{-- Profile Section --}}
    <div class="max-w-3xl mx-auto px-6 pb-20">
        <div class="bg-white border border-gray-200 rounded-xl shadow-lg p-8">
            <div class="flex justify-center mb-8">
                <img alt="Foto Profil" class="rounded-full" height="96" src="{{ $user->avatar ?? 'https://storage.googleapis.com/a1aa/image/default-avatar.jpg' }}" width="96"/>
            </div>
            
            <form class="space-y-6">
                <!-- Nama Lengkap -->
                <label class="block">
                    <span class="text-sm font-medium text-gray-600 mb-1"><i class="far fa-user mr-2"></i> Nama Lengkap</span>
                    <div class="w-full rounded-md border border-gray-200 bg-gray-100 px-4 py-3 text-gray-900 text-sm">
                        {{ $user->name }}
                    </div>
                </label>

                <!-- Email -->
                <label class="block">
                    <span class="text-sm font-medium text-gray-600 mb-1"><i class="far fa-envelope mr-2"></i> Email</span>
                    <div class="w-full rounded-md border border-gray-200 bg-gray-100 px-4 py-3 text-gray-900 text-sm">
                        {{ $user->email }}
                    </div>
                </label>

                <!-- Nomor Telepon -->
                <label class="block">
                    <span class="text-sm font-medium text-gray-600 mb-1"><i class="fas fa-phone-alt mr-2"></i> Nomor Telepon</span>
                    <div class="w-full rounded-md border border-gray-200 bg-gray-100 px-4 py-3 text-gray-900 text-sm">
                        {{ $user->phone ?? '-' }}
                    </div>
                </label>

                <!-- Alamat -->
                <label class="block">
                    <span class="text-sm font-medium text-gray-600 mb-1"><i class="fas fa-map-marker-alt mr-2"></i> Alamat</span>
                    <div class="w-full rounded-md border border-gray-200 bg-gray-100 px-4 py-3 text-gray-900 text-sm">
                        {{ $user->address ?? '-' }}
                    </div>
                </label>

                <!-- Edit Profil Button -->
                <button class="w-full bg-blue-600 text-white py-2 rounded-md text-sm font-semibold hover:bg-blue-700 transition" type="button" onclick="window.location.href='{{ route('profile.edit') }}'">
                    Edit Profil
                </button>

                <!-- Change Password Button -->
                <button class="w-full border border-blue-600 text-blue-600 py-2 rounded-md text-sm font-semibold flex items-center justify-center space-x-2 hover:bg-blue-50 transition" type="button" onclick="window.location.href='{{ route('profile.password') }}'">
                    <i class="fas fa-lock text-xs"></i><span>Ubah Password</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Properti Favorit --}}
    <section class="max-w-3xl mx-auto mb-12">
        <h2 class="font-bold text-gray-900 text-lg mb-4">Properti Favorit</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Example Property Card -->
            <a class="block border border-gray-200 rounded-md overflow-hidden hover:shadow-md transition bg-white" href="#">
                <img alt="Foto eksterior apartemen" class="w-full h-40 object-cover" height="160" src="https://storage.googleapis.com/a1aa/image/37bdf841-1ecf-4d1a-dccb-987eed3bbe20.jpg" width="240"/>
                <div class="p-3 text-xs text-gray-700">
                    <p class="font-semibold mb-1">Apartemen Modern 1</p>
                    <p class="text-blue-600 font-semibold text-xs">Rp499.000.000</p>
                </div>
            </a>
            <!-- Add more properties as needed -->
        </div>
        <div class="mt-3 text-xs">
            <a class="text-blue-600 hover:underline flex items-center space-x-1 w-max" href="#">Lihat Semua Favorit <i class="fas fa-chevron-right text-[10px]"></i></a>
        </div>
    </section>

    {{-- Riwayat Transaksi --}}
    <section class="max-w-3xl mx-auto mb-16">
        <h2 class="font-bold text-gray-900 text-lg mb-4">Riwayat Transaksi</h2>
        <div class="overflow-x-auto bg-white border border-gray-200 rounded-md shadow-md">
            <table class="w-full text-xs text-left">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="py-2 px-3 border-b border-gray-200 font-semibold">ID Transaksi</th>
                        <th class="py-2 px-3 border-b border-gray-200 font-semibold">Tanggal</th>
                        <th class="py-2 px-3 border-b border-gray-200 font-semibold">Properti</th>
                        <th class="py-2 px-3 border-b border-gray-200 font-semibold">Status</th>
                        <th class="py-2 px-3 border-b border-gray-200 font-semibold">Total</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr class="border-b border-gray-200">
                        <td class="py-2 px-3">TRX-001</td>
                        <td class="py-2 px-3">20 Jan 2024</td>
                        <td class="py-2 px-3">Apartemen Modern 1</td>
                        <td class="py-2 px-3"><span class="inline-block bg-green-100 text-green-700 text-[10px] font-semibold px-2 py-0.5 rounded-full">Selesai</span></td>
                        <td class="py-2 px-3 font-semibold">Rp499.000.000</td>
                    </tr>
                    <!-- Add more transaction rows as needed -->
                </tbody>
            </table>
        </div>
        <div class="mt-3 text-xs">
            <a class="text-blue-600 hover:underline flex items-center space-x-1 w-max" href="#">Lihat Semua Transaksi <i class="fas fa-chevron-right text-[10px]"></i></a>
        </div>
    </section>
</main>
@include('partials.footer')
</div>
@endsection
