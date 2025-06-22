@extends('layouts.app')

@section('title', 'Properties')

@section('content')
<div class="container mx-auto p-4 lg:p-8">
    <form method="GET" action="{{ route('cariproperti.index') }}" id="filterForm">
        <div class="flex flex-col lg:flex-row gap-8">
            <aside class="w-full lg:w-1/4 bg-white p-6 rounded-lg shadow-lg h-fit">
                <h2 class="text-xl font-semibold mb-6">Lokasi</h2>
                <select name="location" class="w-full border border-gray-300 rounded-md p-2 mb-6 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Lokasi</option>
                    @if(isset($locations) && $locations->count() > 0)
                        @foreach ($locations as $loc)
                            <option value="{{ $loc->location }}" {{ request('location') == $loc->location ? 'selected' : '' }}>
                                {{ $loc->location }}
                            </option>
                        @endforeach
                    @else
                    @endif
                </select>

                <div class="mb-6 w-full max-w-md">
                    <h2 class="text-xl font-semibold mb-4">Luas Area (m²)</h2>
                    <div class="relative h-2 bg-gray-200 rounded-full">
                        <div id="range-bar" class="absolute h-2 bg-blue-600 rounded-full"></div>
                    </div>
                    <div class="relative mt-0.5">
                        <input id="minRange" type="range" min="1" max="1000" value="{{ request('min_surface_area', 0) }}"
                            class="absolute w-full appearance-none bg-transparent pointer-events-none
                            [&::-webkit-slider-thumb]:appearance-none
                            [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:w-4
                            [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-blue-600
                            [&::-webkit-slider-thumb]:pointer-events-auto
                            [&::-webkit-slider-thumb]:-mt-3
                            [&::-moz-range-thumb]:bg-blue-600 [&::-moz-range-thumb]:h-4 [&::-moz-range-thumb]:w-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:transform [&::-moz-range-thumb]:-translate-y-2">

                        <input id="maxRange" type="range" min="1" max="1000" value="{{ request('max_surface_area', 1000) }}"
                            class="absolute w-full appearance-none bg-transparent pointer-events-none
                            [&::-webkit-slider-thumb]:appearance-none
                            [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:w-4
                            [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-blue-600
                            [&::-webkit-slider-thumb]:pointer-events-auto
                            [&::-webkit-slider-thumb]:-mt-3
                            [&::-moz-range-thumb]:bg-blue-600 [&::-moz-range-thumb]:h-4 [&::-moz-range-thumb]:w-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:transform [&::-moz-range-thumb]:-translate-y-2">
                    </div>
                    <input type="hidden" name="min_surface_area" id="hidden_min_surface_area" value="{{ request('min_surface_area', 100) }}">
                    <input type="hidden" name="max_surface_area" id="hidden_max_surface_area" value="{{ request('max_surface_area', 800) }}">
                    <div class="flex justify-between text-sm text-gray-600 mt-2">
                        <span><span id="minVal">100</span> m²</span>
                        <span><span id="maxVal">800</span> m²</span>
                    </div>
                </div>

                <script>
                    const minRange = document.getElementById('minRange');
                    const maxRange = document.getElementById('maxRange');
                    const minVal = document.getElementById('minVal');
                    const maxVal = document.getElementById('maxVal');
                    const rangeBar = document.getElementById('range-bar');
                    const hiddenMinSurfaceArea = document.getElementById('hidden_min_surface_area');
                    const hiddenMaxSurfaceArea = document.getElementById('hidden_max_surface_area');

                    function clampSurfaceValues() {
                        let min = parseInt(minRange.value);
                        let max = parseInt(maxRange.value);
                        const minGap = 10; 

                        if (min > max - minGap) {
                            min = max - minGap;
                            if (min < parseInt(minRange.min)) min = parseInt(minRange.min);
                            minRange.value = min;
                        }

                        if (max < min + minGap) {
                            max = min + minGap;
                            if (max > parseInt(maxRange.max)) max = parseInt(maxRange.max);
                            maxRange.value = max;
                        }

                        minVal.textContent = min;
                        maxVal.textContent = max;
                        hiddenMinSurfaceArea.value = min; 
                        hiddenMaxSurfaceArea.value = max; 

                        const rangeMaxVal = parseInt(minRange.max); 
                        const percentMin = (min / rangeMaxVal) * 100;
                        const percentMax = (max / rangeMaxVal) * 100;
                        rangeBar.style.left = percentMin + '%';
                        rangeBar.style.width = (percentMax - percentMin) + '%';
                    }

                    minRange.addEventListener('input', clampSurfaceValues);
                    maxRange.addEventListener('input', clampSurfaceValues);
                    clampSurfaceValues(); 
                </script>

                <div class="mb-6 w-full max-w-md">
                    <h2 class="text-xl font-semibold mb-4">Rentang Harga (Rp)</h2>
                    <div class="relative h-2 bg-gray-200 rounded-full">
                        <div id="price-range-bar" class="absolute h-2 bg-blue-600 rounded-full"></div>
                    </div>
                    <div class="relative mt-0.5">
                        <input id="minPrice" type="range" min="10000000" max="15000000000" step="1000000" value="{{ request('min_price', 10000000) }}"
                        class="absolute w-full appearance-none bg-transparent pointer-events-none
                        [&::-webkit-slider-thumb]:appearance-none
                        [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:w-4
                        [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-blue-600
                        [&::-webkit-slider-thumb]:pointer-events-auto
                        [&::-webkit-slider-thumb]:-mt-3
                        [&::-moz-range-thumb]:bg-blue-600 [&::-moz-range-thumb]:h-4 [&::-moz-range-thumb]:w-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:transform [&::-moz-range-thumb]:-translate-y-2">

                        <input id="maxPrice" type="range" min="10000000" max="15000000000" step="1000000" value="{{ request('max_price', 15000000000) }}"
                        class="absolute w-full appearance-none bg-transparent pointer-events-none
                        [&::-webkit-slider-thumb]:appearance-none
                        [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:w-4
                        [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-blue-600
                        [&::-webkit-slider-thumb]:pointer-events-auto
                        [&::-webkit-slider-thumb]:-mt-3
                        [&::-moz-range-thumb]:bg-blue-600 [&::-moz-range-thumb]:h-4 [&::-moz-range-thumb]:w-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:transform [&::-moz-range-thumb]:-translate-y-2">
                    </div>
                    <input type="hidden" name="min_price" id="hidden_min_price" value="{{ request('min_price', 10000000) }}">
                    <input type="hidden" name="max_price" id="hidden_max_price" value="{{ request('max_price', 15000000000) }}">
                    <div class="flex justify-between text-sm text-gray-600 mt-2">
                        <span><span id="minPriceVal">Rp 10.000.000</span></span>
                        <span><span id="maxPriceVal">Rp 15.000.000.000</span></span>
                    </div>
                </div>

                <script>
                    const minPrice = document.getElementById('minPrice');
                    const maxPrice = document.getElementById('maxPrice');
                    const minPriceVal = document.getElementById('minPriceVal');
                    const maxPriceVal = document.getElementById('maxPriceVal');
                    const priceRangeBar = document.getElementById('price-range-bar');
                    const hiddenMinPrice = document.getElementById('hidden_min_price');
                    const hiddenMaxPrice = document.getElementById('hidden_max_price');

                    const formatRupiah = (value) =>
                        'Rp ' + Number(value).toLocaleString('id-ID'); 

                    function clampPriceValues() {
                        let min = parseInt(minPrice.value);
                        let max = parseInt(maxPrice.value);
                        const minGap = parseInt(minPrice.step) || 1000000; 

                        if (min > max - minGap) {
                            min = max - minGap;
                            if (min < parseInt(minPrice.min)) min = parseInt(minPrice.min);
                            minPrice.value = min;
                        }

                        if (max < min + minGap) {
                            max = min + minGap;
                            if (max > parseInt(maxPrice.max)) max = parseInt(maxPrice.max);
                            maxPrice.value = max;
                        }

                        minPriceVal.textContent = formatRupiah(min);
                        maxPriceVal.textContent = formatRupiah(max);
                        hiddenMinPrice.value = min; 
                        hiddenMaxPrice.value = max; 

                        const rangeMin = parseInt(minPrice.min);
                        const rangeMax = parseInt(maxPrice.max);
                        const percentMin = ((min - rangeMin) / (rangeMax - rangeMin)) * 100;
                        const percentMax = ((max - rangeMin) / (rangeMax - rangeMin)) * 100;

                        priceRangeBar.style.left = percentMin + '%';
                        priceRangeBar.style.width = (percentMax - percentMin) + '%';
                    }

                    minPrice.addEventListener('input', clampPriceValues);
                    maxPrice.addEventListener('input', clampPriceValues);
                    clampPriceValues(); 
                </script>

                <h2 class="text-xl font-semibold mb-4">Kamar Tidur</h2>
                <div id="bedroom-options" class="flex flex-wrap gap-2 mb-6">
                    @php
                        $selectedBedrooms = request('bedrooms', []);
                    @endphp
                    @foreach(['1', '2', '3', '4+'] as $br)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="bedrooms[]" value="{{ $br }}" class="hidden peer"
                                {{ in_array($br, $selectedBedrooms) ? 'checked' : '' }}>
                        <span class="peer-checked:bg-blue-500 peer-checked:text-white border border-gray-300 peer-checked:border-blue-500 rounded px-4 py-2 cursor-pointer hover:bg-blue-100 ">
                            {{ $br }} BR
                        </span>
                    </label>
                    @endforeach
                </div>

                <h2 class="text-xl font-semibold mb-4">Fasilitas</h2>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    @php
                        $amenitiesList = ['Pool', 'Garage', 'Garden', 'Gym', 'Security', 'Parking']; 
                        $selectedAmenities = request('amenities', []);
                    @endphp
                    @foreach ($amenitiesList as $amenity)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="amenities[]" value="{{ $amenity }}" class="form-checkbox h-4 w-4 text-blue-600"
                                {{ in_array($amenity, $selectedAmenities) ? 'checked' : '' }}>
                        <span>{{ $amenity }}</span>
                    </label>
                    @endforeach
                </div>

                <h2 class="text-xl font-semibold mb-4">Urut berdasarkan</h2>
                <select name="sort_by" class="w-full border border-gray-300 rounded-md p-2 mb-6 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Terbaru dulu</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                </select>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold mb-3 hover:bg-blue-700 transition duration-200">Apply Filters</button>
                <a href="{{ route('cariproperti.index') }}" class="block w-full text-center bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-300 transition duration-200">Reset Filters</a>
            </aside>

            <main class="w-full lg:w-3/4">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($properties as $property)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                            @if ($property->image_path)
                                <img src="{{  asset('storage/'.$property->image_path) }}" alt="{{ $property->title }}" class="w-full h-48 object-cover">

                            @else
                                <img src="" alt="No Image Available" class="w-full h-48 object-cover">
                            @endif
                            <div class="min-h-[20rem] rounded-lg border shadow flex flex-col p-4">
                            <div>
                            <div class="mb-3 min-h-[4rem]">
                                <h3 class="text-lg font-semibold">{{ $property->title }}</h3>
                                <p class="text-sm text-gray-500 flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1 text-gray-400 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 9s7-4.5 7-10a7 7 0 10-14 0c0 5.5 7 10 7 10z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $property->location }}</span>
                                </p>
                            </div>
                                <p class="text-xl font-bold text-blue-600 mb-3">Rp {{ number_format($property->price, 0, ',', '.') }}</p>
                                <div class="flex justify-between text-sm text-gray-600 border-t pt-3 mb-4">
                                @if ($property->bedrooms)
                                <span><i class="fas fa-bed mr-1"></i> {{ $property->bedrooms }} Kamar Tidur</span>
                                @endif
                                @if ($property->bathrooms)
                                <span><i class="fas fa-bath mr-1"></i> {{ $property->bathrooms }} Kamar Mandi</span>
                                @endif
                                @if ($property->area)
                                <span><i class="fas fa-ruler-combined mr-1"></i> {{ $property->area }} m²</span>
                                @endif
                                </div>

                                @if ($property->amenities->count() > 0)
                                <div class="mb-3 mt-2 text-sm text-gray-600">
                                    <strong>Fasilitas:</strong>
                                    <ul class="grid grid-cols-3 gap-2 list-disc list-inside">
                                        @foreach ($property->amenities as $amenity)
                                        <li>{{ $amenity->name }}</li>
                                        @endforeach
                                    </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <a href="/detailproperti/{{ $property->id }}" class="block text-center w-full border border-blue-600 text-blue-600 py-2 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition duration-200">
                                Tampilkan Detail
                                </a>
                            </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 xl:col-span-3 text-center text-gray-600 py-10">
                            <p class="text-xl mb-2">Tidak ada property yang sesui dengan filter.</p>
                            <p>coba sesuaikan filter anda atau <a href="/cariproperti" class="text-blue-600 hover:underline">reset all filters</a>.</p>
                        </div>
                    @endforelse
                </div>

                {{ $properties->links() }}
            </main>
        </div>
    </form> 
</div>

@include('partials.footer')

@endsection