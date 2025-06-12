@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Choose Your Architect</h1>

    <div class="mb-4">
        <a href="?style=all" class="btn btn-primary btn-sm">All Styles</a>
        @foreach(['Modern', 'Minimalist', 'Industrial', 'Classic', 'Contemporary'] as $style)
            <a href="?style={{ $style }}" class="btn btn-outline-secondary btn-sm">{{ $style }}</a>
        @endforeach
    </div>

    <div class="row">
        @foreach($architects as $architect)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($architect->photo)
                        <img src="{{ asset('storage/' . $architect->photo) }}" class="card-img-top" alt="{{ $architect->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $architect->name }}</h5>
                        <p class="text-muted">{{ $architect->title }}</p>
                        <p>
                            ⭐ {{ $architect->rating }} ({{ $architect->reviews_count }} reviews)<br>
                            🏆 {{ $architect->experience_years }} years experience<br>
                            📍 {{ $architect->location }}
                        </p>
                        <div>
                            @foreach($architect->styles as $style)
                                <span class="badge bg-secondary">{{ $style }}</span>
                            @endforeach
                        </div>
                        <a href="#" class="btn btn-primary mt-3 w-100">Select Architect</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
