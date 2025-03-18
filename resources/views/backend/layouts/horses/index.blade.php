@extends('backend.app')

@section('title', 'Horse Data')

@section('content')
<div class="page-header">
    <h1 class="page-title">Horse Data</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between;">
        <h2>Horse Details</h2>
        <div class="">
        <a href="{{ route('horse.create') }}" class="btn btn-primary float-right">Add New Horse</a>
    </div>
    </div>

    <div class="card-body">
        @if($horses->isNotEmpty())

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Name</th>
                    <th>About Horse</th>
                    <th>Horse Price</th>
                    <th>Racing Start</th>
                    <th>Racing Win</th>
                    <th>Racing Place</th>
                    <th>Racing Show</th>
                    <th>Breed</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Trainer</th>
                    <th>Owner</th>
                    <th>Horse Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach($horses as $horse)
                <tr>
                    <td>{{ $horse->category->category_name ?? 'N/A' }}</td>
                    <td>{{ $horse->name ?? 'N/A' }}</td>
                    <td>{{ $horse->about_horse ?? 'N/A' }}</td>
                    <td>{{ $horse->price ?? 'N/A' }}</td>
                    <td>{{ $horse->racing_start ?? '0' }}</td>
                    <td>{{ $horse->racing_win ?? '0' }}</td>
                    <td>{{ $horse->racing_place ?? '0' }}</td>
                    <td>{{ $horse->racing_show ?? '0' }}</td>
                    <td>{{ $horse->breed ?? 'N/A' }}</td>
                    <td>{{ $horse->gender ?? 'N/A' }}</td>
                    <td>{{ $horse->age ?? 'N/A' }}</td>
                    <td>{{ $horse->trainer ?? 'N/A' }}</td>
                    <td>{{ $horse->owner ?? 'N/A' }}</td>
                    <td>
                        @if(!empty($horse->horse_image))
                            <img src="{{ asset('storage/' . $horse->horse_image) }}" alt="Horse Image" style="width: 100px; height: auto;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('horse.edit', $horse->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('horse.destroy', $horse->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this horse?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No horse data available.</p>
        @endif
    </div>
</div>
@endsection
