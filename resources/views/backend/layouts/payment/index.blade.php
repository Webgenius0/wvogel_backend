@extends('backend.app')

@section('title', 'Payment History')

@section('content')
<div class="page-header">
    <h1 class="page-title">Payment History</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between;">
        <h2>Payment Details</h2>
        {{-- <div class="">
        <a href="{{ route('race.create') }}" class="btn btn-primary float-right">Add New Race</a>
    </div> --}}
    </div>

    <div class="card-body">
        @if($payments->isNotEmpty())

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>OwnerShipe Name</th>
                    <th>Horse Name</th>
                    <th>OwnerShip Share</th>
                    <th>Total Price</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <!-- Display ownership name (user's name) -->
                    <td>{{ $payment->user->name ?? 'N/A' }}</td>

                    <!-- Display horse name -->
                    <td>{{ $payment->horse->name ?? 'N/A' }}</td>

                    <!-- Display ownership share -->
                    <td>{{ $payment->ownership_share ?? 'N/A' }}</td>

                    <!-- Display total price -->
                    <td>{{ $payment->total_price ?? 'N/A' }}</td>

                    <!-- Display payment status -->
                    <td>{{ $payment->status ?? 'N/A' }}</td>

                    <!-- Actions (you can add buttons or links for actions like edit or delete) -->
                    <td>
                        <!-- Example actions -->
                        {{-- <a href="{{ route('payment.show', $payment->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-warning">Edit</a> --}}
                        <form action="{{ route('payment.destroy', $payment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No payments found.</p>
        @endif
    </div>
    </div>
</div>
@endsection

