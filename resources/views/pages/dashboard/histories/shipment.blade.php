@extends('layouts.dashboard.index')

@section('title')
    Riwayat Pengiriman
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Riwayat Pengiriman Barang</h4>
                        <div class="d-block my-4">
                            @if (in_array(session()->get('user')->role_id, [1, 2, 4, 5, 6]))
                                <button type="button" class="btn btn-success me-2 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">Export Riwayat</button>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-shipment">
                                <thead>
                                    <tr>
                                        <th>Nama Customer</th>
                                        <th>Alamat Customer</th>
                                        <th>Peta</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shipments as $ship)
                                        <tr>
                                            <td>{{ $ship->sale->customer->customer_name }}</td>
                                            <td>{{ $ship->sale->customer->customer_address }}</td>
                                            <td>
                                                <a href="https://www.google.com/maps/search/{{ $ship->sale->customer->customer_coordinate }}"
                                                    target="_blank">
                                                    <i class="mdi mdi-map-marker-circle"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <label class="badge badge-success">{{ $ship->shipment_status }}</label>
                                            </td>
                                            <td>
                                                <a class="nav-link" id="StockDropdown" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                                    aria-labelledby="StockDropdown">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#infoModal-{{ $ship->shipment_id }}"><i
                                                            class="dropdown-item-icon mdi mdi-information-outline me-2"></i>
                                                        Info </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- info modal --}}
                                        <div class="modal fade" id="infoModal-{{ $ship->shipment_id }}" tabindex="-1"
                                            aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="infoModalLabel">Info Delivery</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p>Nama Customer
                                                                    : {{ $ship->sale->customer->customer_name }}</p>
                                                                </p>
                                                                <p>Nama Barang
                                                                    : {{ $ship->sale->stock->stock_name }}</p>
                                                                </p>
                                                                <p>Jumlah
                                                                    :
                                                                    {{ $ship->sale->sale_quantity . ' ' . $ship->sale->stock->stock_satuan }}
                                                                </p>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p>Harga Barang
                                                                    : Rp
                                                                    {{ number_format($ship->sale->sale_price, 0, ',', '.') }}
                                                                </p>
                                                                </p>
                                                                <p>Total Harga
                                                                    :
                                                                    Rp
                                                                    {{ number_format($ship->sale->sale_total, 0, ',', '.') }}
                                                                </p>
                                                                </p>
                                                                <p>Metode Pembayaran
                                                                    : {{ $ship->sale->payment->payment_name }}</p>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Export modal --}}
                        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exportModalLabel">Export Riwayat Pengiriman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <form class="forms-sample" method="POST"
                                                action="{{ route('deliveryHistory.export') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12" id="tenggat-awal">
                                                        <div class="form-group">
                                                            <label for="start_date">Tanggal Mulai </label>
                                                            <input type="date" class="form-control" name="start_date">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12" id="tenggat-waktu">
                                                        <div class="form-group">
                                                            <label for="end_date">Tanggal Akhir </label>
                                                            <input type="date" class="form-control" name="end_date">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="finance_name">Format <span style="color: red">
                                                                    *</span></label>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-12">
                                                                    <input type="radio" name="format" id="format"
                                                                        value="1" checked>
                                                                    Excel
                                                                </div>
                                                                <div class="col-md-6 col-sm-12">
                                                                    <input type="radio" name="format" id="format"
                                                                        value="2"> PDF
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="d-block">
                                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                                    <button class="btn btn-light" type="button"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
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
        $(document).ready(function() {
            $('#table-shipment').DataTable();
        });
    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ $error }}',
                })
            </script>
        @endforeach
    @endif
    @if (session('shipment.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('shipment.success') }}',
            })
        </script>
    @endif
    @if (session('shipment.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: @json(session('shipment.error')),
            })
        </script>
    @endif
@endpush
