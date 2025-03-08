@extends('backend.app')

@section('title', 'Race Data')

@section('content')
<div class="page-header">
    <h1 class="page-title">Race Data</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between;">
        <h2>Race Details</h2>
        <div class="">
        <a href="{{ route('race.create') }}" class="btn btn-primary float-right">Add New Race</a>
    </div>
    </div>

    <div class="card-body">
        @if($races->isNotEmpty())

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>date</th>
                    <th>Video</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($races as $race)
                <tr>
                    <td>{{ $race->race_name ?? 'N/A' }}</td>
                    <td>{{ $race->location ?? 'N/A' }}</td>

                    <td>{{ $race->price ?? 'N/A' }}</td>
                    <td>{{ $race->date ?? 'N/A' }}</td>

                    <td>
                        @if(!empty($race->video))
                            <video style="width: 200px; height: auto;"  src="{{ asset('storage/' . $race->video) }}" controls></video>
                        @else
                            No Video
                        @endif
                    </td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('race.edit', $race->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('race.destroy', $race->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this race?')">
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
