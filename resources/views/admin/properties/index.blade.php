@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Admin Properties</h1>

    <a href="{{ route('admin.properties.create') }}" class="btn btn-primary mb-3">Add New Property</a>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Address</th>
                <th>Size</th>
                <th>Bedrooms</th>
                <th>Bathrooms</th>
                <th>Developer</th>
                <th>Architect</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($properties as $property)
            <tr>
                <td>{{ $property->title }}</td>
                <td>{{ $property->price }}</td>
                <td>{{ $property->address }}</td>
                <td>{{ $property->size }}</td>
                <td>{{ $property->number_of_bedrooms }}</td>
                <td>{{ $property->number_of_bathrooms }}</td>
                <td>{{ $property->developer->name ?? '-' }}</td>
          
                <td>
                    {{-- Add action buttons here (e.g., Edit, Delete) --}}
                    {{-- <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
