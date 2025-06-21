@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="bg-slate-50 min-h-screen">
    
     
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

     
    <div class="max-w-3xl mx-auto px-6 pb-20">
        <div class="bg-white border border-gray-200 rounded-xl shadow-lg p-8">
            
            <form class="space-y-6">
                
                <label class="block">
                    <span class="text-sm font-medium text-gray-600 mb-1"><i class="far fa-user mr-2"></i> Nama Lengkap</span>
                    <div class="w-full rounded-md border border-gray-200 bg-gray-100 px-4 py-3 text-gray-900 text-sm">
                        {{ $user->name }}
                    </div>
                </label>

                
                <label class="block">
                    <span class="text-sm font-medium text-gray-600 mb-1"><i class="far fa-envelope mr-2"></i> Email</span>
                    <div class="w-full rounded-md border border-gray-200 bg-gray-100 px-4 py-3 text-gray-900 text-sm">
                        {{ $user->email }}
                    </div>
                </label>

                
                <label class="block">
                    <span class="text-sm font-medium text-gray-600 mb-1"><i class="fas fa-phone-alt mr-2"></i> Nomor Telepon</span>
                    <div class="w-full rounded-md border border-gray-200 bg-gray-100 px-4 py-3 text-gray-900 text-sm">
                        {{ $user->phone ?? '-' }}
                    </div>
                </label>

                
                <label class="block">
                    <span class="text-sm font-medium text-gray-600 mb-1"><i class="fas fa-map-marker-alt mr-2"></i> address</span>
                    <div class="w-full rounded-md border border-gray-200 bg-gray-100 px-4 py-3 text-gray-900 text-sm">
                        {{ $user->address ?? '-' }}
                    </div>
                </label>

                
                <button class="w-full bg-blue-600 text-white py-2 rounded-md text-sm font-semibold hover:bg-blue-700 transition" type="button" onclick="window.location.href='{{ route('profile.edit') }}'">
                    Edit Profil
                </button>

                
                <button class="w-full border border-blue-600 text-blue-600 py-2 rounded-md text-sm font-semibold flex items-center justify-center space-x-2 hover:bg-blue-50 transition" type="button" onclick="window.location.href='{{ route('profile.password') }}'">
                    <i class="fas fa-lock text-xs"></i><span>Ubah Password</span>
                </button>
            </form>
        </div>
    </div>

</main>
@include('partials.footer')
</div>
@endsection
