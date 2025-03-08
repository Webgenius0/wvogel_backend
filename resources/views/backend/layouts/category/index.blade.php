@extends('backend.app')

@section('title', 'Category Data')

@section('content')
<div class="page-header">
    <h1 class="page-title">Category Data</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between;">
        <h2>Category Details</h2>
        <div class="">
        <a href="{{ route('category.create') }}" class="btn btn-primary float-right">Add New Category</a>
    </div>
    </div>

    <div class="card-body">
        @if($categorys->isNotEmpty())

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorys as $category)
                <tr>
                    <td>{{ $category->category_name ?? 'N/A' }}</td>
                    <td>{{ $category->category_description ?? 'N/A' }}</td>
                    </td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No category data available.</p>
        @endif
    </div>
</div>
@endsection
