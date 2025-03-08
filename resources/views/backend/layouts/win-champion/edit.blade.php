@extends('backend.app')

@section('title', 'Edit Win Champion')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Win Champion</h1>
</div>

<div class="card">
    <div class="card-header">
        <h2>Edit Win Champion Details</h2>
    </div>

    <div class="card-body">
        <!-- Display Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Win Champion Form -->
        <form action="{{ route('winchampion.update', $winChampion->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="champion_title" class="form-label">Champion Title</label>
                <input type="text" class="form-control" id="champion_title" name="champion_title" value="{{ old('champion_title', $winChampion->champion_title) }}" required>
            </div>

            <div class="mb-3">
                <label for="champion_date" class="form-label">Champion Date</label>
                <input type="date" class="form-control" id="champion_date" name="champion_date" value="{{ old('champion_date', $winChampion->champion_date) }}" required>
            </div>

            <div class="mb-3">
                <label for="champion_image" class="form-label">Champion Image</label>
                <input type="file" class="form-control" id="champion_image" name="champion_image">
            </div>

            <div class="mb-3">
                @if($winChampion->champion_image)
                    <div>
                        <img src="{{ asset('storage/' . $winChampion->champion_image) }}" alt="Champion Image" style="width: 100px; height: auto;">
                    </div>
                    <div class="mt-2">
                        <small>Current Image</small>
                    </div>
                @else
                    <div>No image available</div>
                @endif
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update Champion</button>
            </div>
        </form>
    </div>
</div>

@endsection
