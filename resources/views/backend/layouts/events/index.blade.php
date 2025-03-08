@extends('backend.app')

@section('title', 'Event Data')

@section('content')
<div class="page-header">
    <h1 class="page-title">Event Data</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between;">
        <h2>Event Details</h2>
        <div class="">
        <a href="{{ route('event.create') }}" class="btn btn-primary float-right">Add New Event</a>
    </div>
    </div>

    <div class="card-body">
        @if($events->isNotEmpty())

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Event Description</th>
                    <th>Event Date</th>
                    <th>Event Location</th>
                    <th>Event Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->event_title ?? 'N/A' }}</td>
                    <td>{{ $event->event_description ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d H:i') ?? 'N/A' }}</td>
                    <td>{{ $event->event_location ?? 'N/A' }}</td>

                    <td>
                        @if(!empty($event->event_image))
                            <img src="{{ asset('storage/' . $event->event_image) }}" alt="event image" style="width: 100px; height: auto;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('event.destroy', $event->id) }}" method="POST" style="display:inline-block;">
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
        <p>No event data available.</p>
        @endif
    </div>
</div>
@endsection
