@extends('layouts.dealer')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 fw-bold">Dashboard Dealer</h1>

    <div class="row g-4">
        {{-- Card Mobil --}}
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100 shadow rounded-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center">
                        <i class="fas fa-car me-2"></i> Mobil
                    </h5>
                    <p class="card-text small mt-2">Total mobil yang kamu jual:</p>
                    <p class="display-6 fw-bold">{{ $totalMobil }}</p>
                </div>
            </div>
        </div>

        {{-- Card Pesanan --}}
        <div class="col-md-4">
            <div class="card text-white bg-warning h-100 shadow rounded-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center">
                        <i class="fas fa-list me-2"></i> Pesanan
                    </h5>
                    <p class="card-text small mt-2">Total pesanan masuk:</p>
                    <p class="display-6 fw-bold">0</p> {{-- Nanti diganti dynamic --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection