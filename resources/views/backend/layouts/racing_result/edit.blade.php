@extends('backend.app')

@section('title', 'Edit Racing Result')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Racing Result</h1>
</div>

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
    <div class="card-body">
        <form action="{{ route('racing_result.update', $racingResult->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <label>Start</label>
                    <input type="number" name="racing_result_start" class="form-control" value="{{ $racingResult->racing_result_start }}" required>
                </div>
                <div class="col-md-6">
                    <label>Win</label>
                    <input type="number" name="racing_result_win" class="form-control" value="{{ $racingResult->racing_result_win }}" required>
                </div>
                <div class="col-md-6">
                    <label>Place</label>
                    <input type="number" name="racing_result_place" class="form-control" value="{{ $racingResult->racing_result_place }}" required>
                </div>
                <div class="col-md-6">
                    <label>Show</label>
                    <input type="number" name="racing_result_show" class="form-control" value="{{ $racingResult->racing_result_show }}" required>
                </div>
                <div class="col-md-6">
                    <label>Win %</label>
                    <input type="text" name="racing_result_win_percentage" class="form-control" value="{{ $racingResult->racing_result_win_percentage }}" required>
                </div>
                <div class="col-md-6">
                    <label>WPS %</label>
                    <input type="text" name="racing_result_wps_percentage" class="form-control" value="{{ $racingResult->racing_result_wps_percentage }}" required>
                </div>
                <div class="col-md-6">
                    <label>Purses </label>
                    <input type="text" name="racing_result_purses_percentage" class="form-control" value="{{ $racingResult->racing_result_purses_percentage }}" required>
                </div>
                <div class="col-md-6">
                    <label>Earning </label>
                    <input type="text" name="racing_result_earning_percentage" class="form-control" value="{{ $racingResult->racing_result_earning_percentage }}" required>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('racing_result.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
