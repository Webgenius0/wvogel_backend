@extends('backend.app')

@section('title', 'Add New Race')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New Race</h1>
</div>

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
        <h2>Create Race</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('race.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="race_name">Race Name</label>
                <input type="text" name="race_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prize">Price</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="datetime-local" name="date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="video">Upload Video</label>
                <input type="file" name="video" class="form-control" >
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ route('race.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
