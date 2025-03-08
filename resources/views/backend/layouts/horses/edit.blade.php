@extends('backend.app')

@section('title', 'Edit Horse')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Horse</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

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
        <h2>Horse Information</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('horse.update', $horse->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $horse->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Horse Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $horse->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="about_horse">About Horse</label>
                        <textarea name="about_horse" class="form-control" rows="3">{{ $horse->about_horse }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="racing_start">Racing Start</label>
                        <input type="number" name="racing_start" class="form-control" value="{{ $horse->racing_start }}">
                    </div>

                    <div class="form-group">
                        <label for="racing_win">Racing Win</label>
                        <input type="number" name="racing_win" class="form-control" value="{{ $horse->racing_win }}">
                    </div>

                    <div class="form-group">
                        <label for="racing_place">Racing Place</label>
                        <input type="number" name="racing_place" class="form-control" value="{{ $horse->racing_place }}">
                    </div>

                    <div class="form-group">
                        <label for="racing_show">Racing Show</label>
                        <input type="number" name="racing_show" class="form-control" value="{{ $horse->racing_show }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="breed">Breed</label>
                        <input type="text" name="breed" class="form-control" value="{{ $horse->breed }}">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="Male" {{ $horse->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $horse->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" name="age" class="form-control" value="{{ $horse->age }}">
                    </div>

                    <div class="form-group">
                        <label for="trainer">Trainer</label>
                        <input type="text" name="trainer" class="form-control" value="{{ $horse->trainer }}">
                    </div>

                    <div class="form-group">
                        <label for="owner">Owner</label>
                        <input type="text" name="owner" class="form-control" value="{{ $horse->owner }}">
                    </div>

                    <div class="form-group">
                        <label for="horse_image">Horse Image</label>
                        <input type="file" name="horse_image" class="form-control">
                        @if($horse->horse_image)
                            <img src="{{ asset('storage/' . $horse->horse_image) }}" alt="Horse Image" style="width: 100px; height: auto; margin-top: 10px;">
                        @endif
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Horse</button>
        </form>
    </div>
</div>
@endsection
