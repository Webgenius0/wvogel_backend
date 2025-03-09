@extends('backend.app')

@section('title', 'Dashboard')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-md-6 col-xl-3">
            <div class="card overflow-hidden bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold">1</h3>
                            <p class="text-white fs-13 mb-0">Total Agency</p>
                        </div>
                        <div class="col col-auto top-icn dash">
                            <div class="counter-icon bg-white dash ms-auto box-shadow-primary">
                                <i class="fas fa-building fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-md-6 col-xl-3">
            <div class="card overflow-hidden bg-gradient-success text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold">1</h3>
                            <p class="text-white fs-13 mb-0">Total Agent</p>
                        </div>
                        <div class="col col-auto top-icn dash">
                            <div class="counter-icon bg-white dash ms-auto box-shadow-secondary">
                                <i class="fas fa-user-tie fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-md-6 col-xl-3">
            <div class="card overflow-hidden bg-gradient-info text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold">1</h3>
                            <p class="text-white fs-13 mb-0">Total User</p>
                        </div>
                        <div class="col col-auto top-icn dash">
                            <div class="counter-icon bg-white dash ms-auto box-shadow-info">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-md-6 col-xl-3">
            <div class="card overflow-hidden bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold">1</h3>
                            <p class="text-white fs-13 mb-0">Total Property</p>
                        </div>
                        <div class="col col-auto top-icn dash">
                            <div class="counter-icon bg-white dash ms-auto box-shadow-warning">
                                <i class="fas fa-home fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Vite Bundle -->
    @vite(['resources/js/app.js'])

    <!-- Echo Script for Real-time chat events -->
    <script>
        $(document).ready(function() {
            let userId = @json(auth()->id()); // Safely pass the user ID as a JSON value

            Echo.private('chat.' + userId).listen('MessageSent', (e) => {
                console.log("New message received:", e);

                // Show Toastr notification with sender's name
                toastr.success(`${e.sender_name} sent you a message!`, 'New Message', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 5000, // Auto close in 5 seconds
                    positionClass: "toast-bottom-right"
                });
            });
        });
    </script>
@endpush
