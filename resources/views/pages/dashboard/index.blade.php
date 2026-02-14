@extends('layouts.dashboard.index')

@section('title')
    Dashboard
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        {{-- Stat Cards Zone --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab"
                                    aria-controls="overview" aria-selected="true">Overview</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content tab-content-basic">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                            
                            {{-- Row 1: Stat Cards (2x2 Grid) --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="statistics-details d-flex align-items-center justify-content-between">
                                        <div class="row w-100">
                                            <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                                                <div class="card card-rounded">
                                                    <div class="card-body">
                                                        <p class="statistics-title">Employees</p>
                                                        <h3 class="rate-percentage">{{ $users }}</h3>
                                                        <p class="text-primary d-flex"><span>Persons</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                                                <div class="card card-rounded">
                                                    <div class="card-body">
                                                        <p class="statistics-title">Customers</p>
                                                        <h3 class="rate-percentage">{{ $customers }}</h3>
                                                        <p class="text-primary d-flex"><span>Persons</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                                                <div class="card card-rounded">
                                                    <div class="card-body">
                                                        <p class="statistics-title">Pembelian</p>
                                                        <h3 class="rate-percentage">{{ $purchases }}</h3>
                                                        <p class="text-primary d-flex"><span>Transactions</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                                                <div class="card card-rounded">
                                                    <div class="card-body">
                                                        <p class="statistics-title">Penjualan</p>
                                                        <h3 class="rate-percentage">{{ $sales }}</h3>
                                                        <p class="text-primary d-flex"><span>Transactions</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Row 2: Chart Component --}}
                            <div class="row">
                                <div class="col-lg-6 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="d-sm-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h4 class="card-title card-title-dash">Statistik Bulanan</h4>
                                                            <h5 class="card-subtitle card-subtitle-dash">Periode Tahun Ini</h5>
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
                                <div class="col-lg-6 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="d-sm-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h4 class="card-title card-title-dash">Statistik Tahunan</h4>
                                                            <h5 class="card-subtitle card-subtitle-dash">5 Tahun Terakhir</h5>
                                                        </div>
                                                    </div>
                                                    <div class="chartjs-wrapper mt-5">
                                                        <canvas id="yearlyChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Row 3: Recent Activity --}}
                            <div class="row">
                                <div class="col-lg-12 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <h4 class="card-title card-title-dash">Penjualan Terbaru</h4>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Barang</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Tanggal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($recentSales as $recentSale)
                                                                    <tr>
                                                                        <td>{{ $recentSale->stock->stock_name }}</td>
                                                                        <td>{{ $recentSale->sale_quantity }} {{ $recentSale->stock->stock_satuan }}</td>
                                                                        <td>{{ $recentSale->created_at->format('d-m-Y') }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Row 4: Summary Panel --}}
                            <div class="row">
                                <div class="col-lg-12 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <h4 class="card-title card-title-dash">Summary Panel</h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <canvas id="doughnutChart"></canvas>
                                                        </div>
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <ul class="list-unstyled">
                                                                <li class="mb-3"><i class="mdi mdi-circle text-primary me-2"></i> Total Penjualan: <b>{{ $sales }}</b></li>
                                                                <li class="mb-3"><i class="mdi mdi-circle text-warning me-2"></i> Total Pembelian: <b>{{ $purchases }}</b></li>
                                                                <li class="mb-3"><i class="mdi mdi-circle text-danger me-2"></i> Total Hutang: <b>Rp {{ number_format($totalPayable, 0, ',', '.') }}</b></li>
                                                                <li class="mb-3"><i class="mdi mdi-circle text-success me-2"></i> Total Piutang: <b>Rp {{ number_format($totalReceivable, 0, ',', '.') }}</b></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        // Bar Chart
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
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Yearly Chart
        var yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
        var yearlyChart = new Chart(yearlyCtx, {
            type: 'bar',
            data: {
                labels: @json($yearlyChartData['labels']),
                datasets: [{
                    label: 'Penjualan',
                    data: @json($yearlyChartData['sales']),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Pembelian',
                    data: @json($yearlyChartData['purchases']),
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Doughnut Chart (Summary Panel)
        var doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
        var doughnutChart = new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: @json($summaryData['labels']),
                datasets: [{
                    data: @json($summaryData['data']),
                    backgroundColor: @json($summaryData['colors']),
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
@endpush
