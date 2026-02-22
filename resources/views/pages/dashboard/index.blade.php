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
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview"
                                    role="tab" aria-controls="overview" aria-selected="true">Overview</a>
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
                                                        <p class="statistics-title">Purchasing Products</p>
                                                        <div class="d-flex">
                                                            <div class="col-md-6">
                                                                <h3 class="rate-percentage">{{ $purchases }}</h3>
                                                                <p class="text-primary d-flex"><span>Data
                                                                        Transactions</span>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h3 class="rate-percentage">
                                                                    Rp {{ number_format($totalPurchase, 0, ',', '.') }}</h3>
                                                                <p class="text-primary d-flex"><span>Total
                                                                        Purchasing</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                                                <div class="card card-rounded">
                                                    <div class="card-body">
                                                        <p class="statistics-title">Selling Products</p>
                                                        <div class="d-flex">
                                                            <div class="col-md-6">
                                                                <h3 class="rate-percentage">{{ $sales }}</h3>
                                                                <p class="text-primary d-flex"><span>Data
                                                                        Transactions</span>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h3 class="rate-percentage">
                                                                    Rp {{ number_format($totalSale, 0, ',', '.') }}</h3>
                                                                <p class="text-primary d-flex"><span>Total
                                                                        Selling</span>
                                                                </p>
                                                            </div>
                                                        </div>
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
                                                            <h4 class="card-title card-title-dash">Monthly Purchasing
                                                                Statistics</h4>
                                                            <h5 class="card-subtitle card-subtitle-dash">In Period:
                                                                {{ date('Y') }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="chartjs-wrapper mt-5">
                                                        <canvas id="purchasesBarChart"></canvas>
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
                                                        <div class="d-sm-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h4 class="card-title card-title-dash">Monthly Selling
                                                                    Statistics</h4>
                                                                <h5 class="card-subtitle card-subtitle-dash">In Period:
                                                                    {{ date('Y') }}</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="chartjs-wrapper mt-5">
                                                        <canvas id="salesBarChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="d-sm-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h4 class="card-title card-title-dash">Yearly Statistics</h4>
                                                            <h5 class="card-subtitle card-subtitle-dash">Last 5 Years
                                                            </h5>
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

                            {{-- Row 3: Product Statistics --}}
                            <div class="row">
                                <div class="col-lg-12 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <h4 class="card-title card-title-dash">Product Statistics</h4>
                                                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Product Name</th>
                                                                    <th>Total Data Transaction</th>
                                                                    <th>Total Sold</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($products as $recentSale)
                                                                    <tr>
                                                                        <td>{{ $recentSale->stock_name }}</td>
                                                                        <td>{{ $recentSale->total_sale_data }}</td>
                                                                        <td>Rp{{ number_format($recentSale->total_sale_transactions, 2, ',', '.') }}
                                                                        </td>
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
                                                            <div id="doughnutChart"></div>
                                                        </div>
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <ul class="list-unstyled">
                                                                <li class="mb-3"><i
                                                                        class="mdi mdi-circle me-2"
                                                                        style="color: #4B49AC;"></i> Total
                                                                    Penjualan: <b>Rp
                                                                        {{ number_format($totalSale, 0, ',', '.') }}</b></li>
                                                                <li class="mb-3"><i
                                                                        class="mdi mdi-circle me-2"
                                                                        style="color: #FFC100;"></i> Total
                                                                    Pembelian: <b>Rp
                                                                        {{ number_format($totalPurchase, 0, ',', '.') }}</b>
                                                                </li>
                                                                <li class="mb-3"><i
                                                                        class="mdi mdi-circle me-2"
                                                                        style="color: #FF4747;"></i> Total
                                                                    Hutang: <b>Rp
                                                                        {{ number_format($totalPayable, 0, ',', '.') }}</b>
                                                                </li>
                                                                <li class="mb-3"><i
                                                                        class="mdi mdi-circle me-2"
                                                                        style="color: #57B657;"></i> Total
                                                                    Piutang: <b>Rp
                                                                        {{ number_format($totalReceivable, 0, ',', '.') }}</b>
                                                                </li>
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Bar Chart
        var purchasesCtx = document.getElementById('purchasesBarChart').getContext('2d');
        var salesCtx = document.getElementById('salesBarChart').getContext('2d');

        var purchasesChart = new Chart(purchasesCtx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Purchases data',
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

        var salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Sales data',
                    data: @json($chartData['sales']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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

        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                series: @json($summaryData['data']),
                chart: {
                    type: 'donut',
                    height: 200
                },
                labels: @json($summaryData['labels']),
                colors: @json($summaryData['colors']),
                dataLabels: {
                    enabled: false
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%'
                        }
                    }
                },
                legend: {
                    show: false
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(value);
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#doughnutChart"), options);
            chart.render();
        });
    </script>
@endpush
