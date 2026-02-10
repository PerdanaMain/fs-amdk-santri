@extends('layouts.dashboard.index')

@section('title')
    Dashboard
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="row statistics-details d-flex align-items-center justify-content-between">
                    <div class="col-md-3 col-sm-12">
                        <div class="card mb-3 pt-2 pb-2 ps-4">
                            <p class="statistics-title">Employees</p>
                            <h3 class="rate-percentage">{{ $users }}</h3>
                            <p class="text-primary d-flex"><span> Persons</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 ">
                        <div class="card mb-3 pt-2 pb-2 ps-4">
                            <p class="statistics-title">Customers</p>
                            <h3 class="rate-percentage">{{ $customers }}</h3>
                            <p class="text-primary d-flex"><span> Persons</span>
                            </p>
                        </div>

                    </div>
                    <div class="col-md-3 col-sm-12 ">
                        <div class="card mb-3 pt-2 pb-2 ps-4">
                            <p class="statistics-title">Pembelian</p>
                            <h3 class="rate-percentage">{{ $purchases }}</h3>
                            <p class="text-primary d-flex"><span> Transactions</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 ">
                        <div class="card mb-3 pt-2 pb-2 ps-4">
                            <p class="statistics-title">Penjualan</p>
                            <h3 class="rate-percentage">{{ $sales }}</h3>
                            <p class="text-primary d-flex"><span> Transactions</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="card-title card-title-dash">
                                            Statistik Penjualan dan Pembelian</h4>
                                        <h5 class="card-subtitle card-subtitle-dash">
                                            Statistik Pembelian dan Penjualan Air Minum Santri Berdasarkan Periode Bulan
                                        </h5>
                                    </div>
                                </div>
                                <div class="chartjs-wrapper mt-5">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 col-lg-4 col-lg-12 grid-margin strecth-card">
                        <div class="card card-rounded">
                            <div class="card-body card-rounded">
                                <h4 class="card-title  card-title-dash">Penjualan Terbaru
                                </h4>
                                @foreach ($recentSales as $recentSale)
                                    <div class="list align-items-center border-bottom py-2">
                                        <div class="wrapper w-100">
                                            <p class="mb-2 font-weight-medium">
                                                {{ $recentSale->stock->stock_name . ' * ' . $recentSale->sale_quantity . ' ' . $recentSale->stock->stock_satuan }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="mdi mdi-calendar text-muted me-1"></i>
                                                    <p class="mb-0 text-small text-muted">
                                                        {{ $recentSale->created_at->format('d-m-Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('dashboard.script')
    <script>
        var ctx = document.getElementById('barChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Penjualan',
                    data: @json($chartData['sales']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Pembelian',
                    data: @json($chartData['purchases']),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
