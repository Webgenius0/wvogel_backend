@extends('backend.app')

@section('title', 'Edit Event')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Event</h1>
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

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="event_title" class="form-label">Event Title</label>
                <input type="text" class="form-control" id="event_title" name="event_title" value="{{ $event->event_title }}" required>
            </div>

            <div class="mb-3">
                <label for="event_description" class="form-label">Event Description (optional)</label>
                <textarea class="form-control" id="event_description" name="event_description" rows="4" required>{{ $event->event_description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="event_date" class="form-label">Event Date</label>
                <input type="date" class="form-control" id="event_date" name="event_date" value="{{ $event->event_date }}" required>
            </div>

            <div class="mb-3">
                <label for="event_location" class="form-label">Event Location</label>
                <input type="text" class="form-control" id="event_location" name="event_location" value="{{ $event->event_location }}" required>
            </div>

            <div class="mb-3">
                <label for="event_image" class="form-label">Event Image (optional)</label>
                <input type="file" class="form-control" id="event_image" name="event_image" accept="image/*">
                @if(!empty($event->event_image))
                    <img src="{{ asset('storage/' . $event->event_image) }}" alt="event image" style="width: 100px; height: auto; margin-top: 10px;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Event</button>
        </form>
    </div>
</div>
@endsection
