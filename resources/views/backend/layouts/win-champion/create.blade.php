
@extends('backend.app')

@section('title', 'Add Win Champion')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New Win Champion</h1>
</div>

<div class="card">
    <div class="card-header">
        <h2>Win Champion Form</h2>
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

        <!-- Add New Win Champion Form -->
        <form action="{{ route('winchampion.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="champion_title" class="form-label">Champion Title</label>
                <input type="text" class="form-control" id="champion_title" name="champion_title" required>
            </div>

            <div class="mb-3">
                <label for="champion_date" class="form-label">Champion Date</label>
                <input type="date" class="form-control" id="champion_date" name="champion_date" required>
            </div>

            <div class="mb-3">
                <label for="champion_image" class="form-label">Champion Image</label>
                <input type="file" class="form-control" id="champion_image" name="champion_image">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save Champion</button>
            </div>
        </form>
    </div>
</div>

@endsection
