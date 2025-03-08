@extends('backend.app')

@section('title', 'Edit Race Data')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Race Data</h1>
</div>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Validation Errors -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h2>Edit Race Details</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('race.update', $race->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="race_name">Race Name</label>
                <input type="text" name="race_name" id="race_name" class="form-control" value="{{ old('race_name', $race->race_name) }}" required>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $race->location) }}" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $race->price) }}" required>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="datetime-local" name="date" id="date" class="form-control" value="{{ old('date', $race->date) }}" required>
            </div>

            <div class="form-group">
                <label for="video">Race Video (Optional)</label>
                <input type="file" name="video" id="video" class="form-control">
                @if($race->video)
                    <div class="mt-2">
                        <video style="width: 200px; height: auto;" src="{{ asset('storage/' . $race->video) }}" controls></video>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Update Race</button>
            </div>
        </form>
    </div>
</div>
@endsection
