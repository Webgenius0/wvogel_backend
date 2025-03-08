@extends('backend.app')

@section('title', 'Edit Category')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Category</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <h2>Category Details</h2>
    </div>

    <div class="card-body">
        <!-- Form to Edit Category -->
        <form action="{{ route('category.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" value="{{ old('category_name', $category->category_name) }}" required>
                @error('category_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_description">Category Description</label>
                <textarea class="form-control" id="category_description" name="category_description" rows="3">{{ old('category_description', $category->category_description) }}</textarea>
                @error('category_description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Category</button>
                <a href="{{ route('category.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
