@extends('backend.app')

@section('title', 'Onboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Onboard</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between;">
        <h2>Onboard Details</h2>
    </div>

    <div class="card-body">
        @if($onboards->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Most Shared Race Horse</th>
                    <th>ROI</th>
                    <th>Risk Ownership</th>
                    <th>Investment Opportunities</th>
                    <th>Investment Venture</th>
                    <th>Venture Book</th>
                    <th>Potential Profit</th>
                    <th>Passive Investment</th>
                    <th>Younger Experience</th>
                    <th>Race Entry Fees</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach($onboards as $onboard)
                <tr>
                    <td>{{ $onboard->user->name ?? 'N/A' }}</td>
                    <td>{{ $onboard->most_share_race_horse ?? 'N/A' }}</td>
                    <td>{{ $onboard->roi ?? 'N/A' }}</td>
                    <td>{{ $onboard->horse_racing_risk_ownership ?? 'N/A' }}</td>
                    <td>{{ $onboard->investment_opportunities ?? 'N/A' }}</td>
                    <td>{{ $onboard->investment_venture ?? 'N/A' }}</td>
                    <td>{{ $onboard->investment_venture_book ?? 'N/A' }}</td>
                    <td>{{ $onboard->racing_potiential_profit ?? 'N/A' }}</td>
                    <td>{{ $onboard->passive_investment ?? 'N/A' }}</td>
                    <td>{{ $onboard->younger_experience ?? 'N/A' }}</td>
                    <td>{{ $onboard->race_entery_fees ?? 'N/A' }}</td>
                    <td>

                        <!-- Delete Form -->
                        <form action="{{ route('onboard.destroy', $onboard->id) }}" method="POST" style="display:inline-block;">
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
        <p>No onboard data available.</p>
        @endif
    </div>
</div>
@endsection
