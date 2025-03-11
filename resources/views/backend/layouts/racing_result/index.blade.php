@extends('backend.app')

@section('title', 'Racing Results')

@section('content')
<div class="page-header">
    <h1 class="page-title">Racing Results</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between;">
        <h2>Racing Results</h2>
        <div class="">
            <a href="{{ route('racing_result.create') }}" class="btn btn-primary float-right">Add New Result</a>
        </div>
    </div>

    <div class="card-body">
        @if($racingResults->isNotEmpty())

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Start</th>
                    <th>Win</th>
                    <th>Place</th>
                    <th>Show</th>
                    <th>Win %</th>
                    <th>WPS %</th>
                    <th>Purses </th>
                    <th>Earning </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($racingResults as $result)
                <tr>
                    <td>{{ $result->racing_result_start }}</td>
                    <td>{{ $result->racing_result_win }}</td>
                    <td>{{ $result->racing_result_place }}</td>
                    <td>{{ $result->racing_result_show }}</td>
                    <td>{{ number_format($result->racing_result_win_percentage, 2) }}%</td>
                    <td>{{ number_format($result->racing_result_wps_percentage, 2) }}%</td>
                    <td>${{ number_format($result->racing_result_purses_percentage, 2) }}</td>
                    <td>${{ number_format($result->racing_result_earning_percentage, 2) }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('racing_result.edit', $result->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('racing_result.destroy', $result->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this result?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No racing results available.</p>
        @endif
    </div>
</div>
@endsection
