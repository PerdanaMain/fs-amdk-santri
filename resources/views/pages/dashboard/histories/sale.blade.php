@extends('layouts.dashboard.index')

@section('title')
    History of Sales
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Riwayat Data Penjualan</h4>
                        <div class="d-block my-4">
                            @if (in_array($user->role_id, [1, 2, 5, 6]))
                                <button type="button" class="btn btn-success me-2 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">Export Penjualan</button>
                            @endif

                            {{-- Export modal --}}
                            <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Export Penjualan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('salesHistory.export') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12" id="tenggat-awal">
                                                            <div class="form-group">
                                                                <label for="start_date">Tanggal Mulai </label>
                                                                <input type="date" class="form-control"
                                                                    name="start_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12" id="tenggat-waktu">
                                                            <div class="form-group">
                                                                <label for="end_date">Tanggal Akhir </label>
                                                                <input type="date" class="form-control" name="end_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm12">
                                                            <div class="form-group mb-3">
                                                                <label for="start_date">Format Export</label>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <input type="radio" name="format" id="format"
                                                                            value="1" checked> Excel
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <input type="radio" name="format" id="format"
                                                                            value="2"> Pdf
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-block mt-3">
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

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-purchase">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Nama Customer</th>
                                        <th>Jumlah Barang</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Tgl Transaksi</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>{{ $sale->stock->stock_name }}</td>
                                            <td>{{ $sale->customer->customer_name }}</td>
                                            <td>{{ $sale->sale_quantity }}</td>
                                            <td>Rp {{ number_format($sale->sale_price, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($sale->sale_total, 0, ',', '.') }}</td>
                                            <td>{{ $sale->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}
                                            </td>
                                            <td><label
                                                    class="badge 
                                      {{ $sale->status->status_id == 1 || $sale->status->status_id == 3
                                          ? 'badge-warning'
                                          : ($sale->status->status_id == 2 || $sale->status->status_id == 4
                                              ? 'badge-success'
                                              : ($sale->status->status_id == 5
                                                  ? 'badge-danger'
                                                  : 'badge-primary')) }}
                                      ">
                                                    {{ $sale->status->status_description }}
                                                </label></td>
                                            <td>
                                                <a class="nav-link" id="StockDropdown" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                                    aria-labelledby="StockDropdown">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#infoModal-{{ $sale->sale_id }}"><i
                                                            class="dropdown-item-icon mdi mdi-information-outline me-2"></i>
                                                        Info </button>

                                                </div>
                                            </td>
                                        </tr>

                                        {{-- info modal --}}
                                        <div class="modal fade" id="infoModal-{{ $sale->sale_id }}" tabindex="-1"
                                            aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="infoModalLabel">Info Pembelian</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 mb-2">
                                                                <img src="{{ url('storage/stocks/' . $sale->stock->stock_photo) }}"
                                                                    alt="image" style="width:100px;" />
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p><b>Nama Barang:</b>
                                                                    {{ $sale->stock->stock_name }}</p>
                                                                <p><b>Jumlah Penjualan:</b> {{ $sale->sale_quantity }}
                                                                    {{ $sale->stock->stock_satuan }}</p>
                                                                <p><b>Harga Satuan:</b> Rp
                                                                    {{ number_format($sale->sale_price, 0, ',', '.') }}
                                                                </p>
                                                                <p><b>Total Harga:</b> Rp
                                                                    {{ number_format($sale->sale_total, 0, ',', '.') }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p><b>Nama customer:</b>
                                                                    {{ $sale->customer->customer_name }} -
                                                                    {{ $sale->customer->customer_owner }}
                                                                </p>
                                                                <p><b>Alamat customer:</b>
                                                                    {{ $sale->customer->customer_address }}
                                                                </p>
                                                                <p><b>Tanggal pengajuan:</b>
                                                                    {{ date_format($sale->created_at, 'Y/m/d') }}
                                                                </p>
                                                                <p><b>Tanggal Tempo Pembayaran:</b>
                                                                    {{ date_format(date_create($sale->sale_date), 'Y/m/d') }}
                                                                </p>

                                                                @if ($sale->sale_invoice != null)
                                                                    <p><b>Nota pembayaran:</b>
                                                                        <button class="btn btn-primary btn-sm"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#invoiceModal-{{ $sale->sale_id }}"
                                                                            data-bs-dismiss="modal">
                                                                            Nota
                                                                        </button>
                                                                    </p>
                                                                @endif

                                                                <p><b>Deskripsi penjualan:</b>
                                                                    {{ $sale->sale_description }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12">
                                                                <p><b>Metode pembayaran:</b>
                                                                    <label
                                                                        class="badge 
                                                        {{ $sale->payment->payment_id == 1
                                                            ? 'badge-warning'
                                                            : ($sale->payment->payment_id == 2
                                                                ? 'badge-success'
                                                                : ($sale->payment->payment_id == 3
                                                                    ? 'badge-danger'
                                                                    : 'badge-info')) }}
                                                        ">
                                                                        {{ $sale->payment->payment_name }}
                                                                    </label>
                                                                </p>
                                                                <p class="mb-2"><b>Status:</b>
                                                                    <label
                                                                        class="badge 
                                                                  {{ $sale->status->status_id == 1 || $sale->status->status_id == 3
                                                                      ? 'badge-warning'
                                                                      : ($sale->status->status_id == 2 || $sale->status->status_id == 4
                                                                          ? 'badge-success'
                                                                          : ($sale->status->status_id == 5
                                                                              ? 'badge-danger'
                                                                              : 'badge-info')) }}
                                                                  ">
                                                                        {{ $sale->status->status_description }}
                                                                    </label>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        {{-- Invoice modal --}}
                                        <div class="modal fade" id="invoiceModal-{{ $sale->sale_id }}" tabindex="-1"
                                            aria-labelledby="invoiceModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="invoiceModalLabel">Nota Pembayaran
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12">
                                                                <img src="{{ url('storage/invoices/' . $sale->sale_invoice) }}"
                                                                    alt="image" style="width:100%;" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="d-block">
                                                            <button class="btn btn-light" type="button"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
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
            $('#table-purchase').DataTable();
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
    @if (session('sale.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('sale.success') }}',
            })
        </script>
    @endif
    @if (session('sale.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('sale.error') }}',
            })
        </script>
    @endif
@endpush
