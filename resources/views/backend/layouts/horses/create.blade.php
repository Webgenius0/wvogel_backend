@extends('backend.app')

@section('title', 'Add Horse')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New Horse</h1>
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
        <form action="{{ route('horse.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <!-- Category Dropdown -->
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Horse Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="about_horse">About Horse</label>
                        <textarea name="about_horse" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="racing_start">Racing Start</label>
                        <input type="number" name="racing_start" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="racing_win">Racing Win</label>
                        <input type="number" name="racing_win" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="racing_place">Racing Place</label>
                        <input type="number" name="racing_place" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="racing_show">Racing Show</label>
                        <input type="number" name="racing_show" class="form-control">
                    </div>


                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="breed">Breed</label>
                        <input type="text" name="breed" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" name="age" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="trainer">Trainer</label>
                        <input type="text" name="trainer" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="owner">Owner</label>
                        <input type="text" name="owner" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="horse_image">Horse Image</label>
                        <input type="file" name="horse_image" class="form-control">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Add Horse</button>
        </form>
    </div>
</div>
@endsection
