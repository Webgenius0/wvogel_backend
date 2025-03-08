@extends('backend.app')

@section('title', 'Win Champion')

@section('content')
<div class="page-header">
    <h1 class="page-title">Win Champion</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between;">
        <h2>Win Champion Details</h2>
        <div class="">
        <a href="{{ route('winchampion.create') }}" class="btn btn-primary float-right">Add New Win Champion</a>
    </div>
    </div>

    <div class="card-body">
        @if($winChampions->isNotEmpty())

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($winChampions as $winChampion)
                <tr>
                    <td>{{ $winChampion->champion_title ?? 'N/A' }}</td>
                    <td>{{ $winChampion->champion_date ?? 'N/A' }}</td>
                    <td>
                        @if(!empty($winChampion->champion_image))
                            <img src="{{ asset('storage/' . $winChampion->champion_image) }}" alt="Horse Image" style="width: 100px; height: auto;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('winchampion.edit', $winChampion->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('winchampion.destroy', $winChampion->id) }}" method="POST" style="display:inline-block;">
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
