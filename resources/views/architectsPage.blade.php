@extends('layouts.app')

@section('content')
<div class="container-lg py-5">
    <h1 class="mb-4 text-center">Choose Your Architect</h1>

    <div class="mb-4 d-flex justify-content-center flex-wrap gap-2">
        <a href="?style=all" class="btn btn-primary btn-sm">All Styles</a>
        @foreach(['Modern', 'Minimalist', 'Industrial', 'Classic', 'Contemporary'] as $style)
            <a href="?style={{ $style }}" class="btn btn-outline-secondary btn-sm">{{ $style }}</a>
        @endforeach
    </div>

    <div class="row justify-content-center g-4">
        @foreach($architects as $architect)
            <div class="col-12 col-md-4 d-flex align-items-stretch">
                <div class="card w-100 shadow rounded-4 border-0 h-100 d-flex flex-column">
                    @if($architect->photo)
                        <img src="{{ asset('storage/' . $architect->photo) }}" class="card-img-top" alt="{{ $architect->name }}" style="object-fit:cover; height:180px;">
                    @endif
                    <div class="card-body d-flex flex-column align-items-center">
                        <h5 class="card-title">{{ $architect->name }}</h5>
                        <div class="text-muted mb-2" style="font-size:1em;">{{ $architect->title }}</div>
                        <div class="mb-2 text-center">
                            <span>⭐ {{ $architect->rating }} ({{ $architect->reviews_count }} reviews)</span><br>
                            <span>🏆 {{ $architect->experience_years }} years experience</span><br>
                            <span>📍 {{ $architect->location }}</span>
                        </div>
                        <div class="mb-3">
                            @foreach($architect->styles as $style)
                                <span class="badge bg-light text-dark rounded-pill me-1 mb-1" style="font-size:0.85em;">
                                    {{ $style }}
                                </span>
                            @endforeach
                        </div>
                        <a href="#" class="btn btn-primary w-100 mt-auto" style="background:#2563eb; border:0;">Select Architect</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
