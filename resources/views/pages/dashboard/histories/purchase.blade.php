@extends('layouts.dashboard.index')

@section('title')
    History of Purchases
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Riwayat Data Pembelian</h4>
                        <div class="d-block my-4">
                            <button type="button" class="btn btn-success me-2 mb-3" data-bs-toggle="modal"
                                data-bs-target="#exportModal">Export Pembelian</button>

                            {{-- Export modal --}}
                            <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Export Pembelian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('purchaseHistory.export') }}"
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
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="status">Filter Status </label>
                                                                <select class="form-control" name="status">
                                                                    <option value="">Semua Status</option>
                                                                    <option value="4">Approved</option>
                                                                    <option value="0">Pending</option>
                                                                    <option value="5">Rejected</option>
                                                                </select>
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
                                        <th>Supplier</th>
                                        <th>Jumlah Pembelian</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Tgl Transaksi</th>
                                        <th>Status</th>
                                        <th>Status Pembayaran</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $p)
                                        <tr>
                                            <td>{{ $p->stock->stock_name }}</td>
                                            <td>{{ $p->supplier ? $p->supplier->supplier_name : '-' }}</td>
                                            <td>{{ $p->purchase_quantity }} {{ $p->stock->stock_satuan }}</td>
                                            <td>Rp {{ number_format($p->purchase_price, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($p->purchase_total, 0, ',', '.') }}</td>
                                            <td>{{ $p->created_at->format('d-m-Y H:i:s') }}</td>
                                            <td>
                                                @switch($p->status_id)
                                                    @case(1)
                                                        <label for="status" class="badge badge-warning">
                                                            {{ $p->status->status_description }}
                                                        </label>
                                                    @break

                                                    @case(2)
                                                        <label for="status" class="badge badge-success">
                                                            Approved
                                                        </label>
                                                    @break

                                                    @case(3)
                                                        <label for="status" class="badge badge-warning">
                                                            {{ $p->status->status_description }}
                                                        </label>
                                                    @break

                                                    @case(4)
                                                        <label for="status" class="badge badge-success">
                                                            Approved
                                                        </label>
                                                    @break

                                                    @case(5)
                                                        <label for="status" class="badge badge-danger">
                                                            {{ $p->status->status_description }}
                                                        </label>
                                                    @break

                                                    @default
                                                        <label for="status" class="badge badge-primary">
                                                            {{ $p->status->status_description }}
                                                        </label>
                                                @endswitch
                                            </td>
                                            <td>
                                                <label
                                                    class="badge {{ $p->payment_status == 'Lunas' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $p->payment_status }}
                                                </label>
                                            </td>
                                            <td>
                                                <a class="nav-link" id="StockDropdown" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                                    aria-labelledby="StockDropdown">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#infoModal-{{ $p->purchase_id }}"><i
                                                            class="dropdown-item-icon mdi mdi-information-outline me-2"></i>
                                                        Info </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- info modal --}}
                                        <div class="modal fade" id="infoModal-{{ $p->purchase_id }}" tabindex="-1"
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
                                                            <div class="col-md-6 col-sm-12 mb-2">
                                                                <img src="{{ url('storage/stocks/' . $p->stock->stock_photo) }}"
                                                                    alt="image" style="width:100px;" />
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p><b>Nama Barang:</b>
                                                                    {{ $p->stock->stock_name }}</p>
                                                                <p><b>Supplier:</b>
                                                                    {{ $p->supplier ? $p->supplier->supplier_name : '-' }}</p>
                                                                <p><b>Jumlah Pembelian:</b> {{ $p->purchase_quantity }}
                                                                    {{ $p->stock->stock_satuan }}</p>
                                                                <p><b>Harga Satuan:</b> Rp
                                                                    {{ number_format($p->purchase_price, 0, ',', '.') }}
                                                                </p>
                                                                <p><b>Total Harga:</b> Rp
                                                                    {{ number_format($p->purchase_total, 0, ',', '.') }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p><b>Deskripsi Pembelian:</b>
                                                                    {{ $p->purchase_description }}
                                                                </p>

                                                                <p><b>Diajukan Oleh:</b>
                                                                    {{ $p->user->user_name }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p><b>Tanggal pengajuan:</b>
                                                                    {{ date_format($p->created_at, 'Y/m/d') }}
                                                                </p>
                                                                @if ($p->status->status_id == 4)
                                                                    <p><b>Tanggal disetujui:</b>
                                                                        {{ date_format($p->updated_at, 'Y/m/d') }}
                                                                    </p>
                                                                @endif
                                                                @if ($p->status->status_id == 5)
                                                                    <p><b>Tanggal penolakan:</b>
                                                                        {{ date_format($p->updated_at, 'Y/m/d') }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-12 col-sm-12">
                                                                <p class="mb-2"><b>Metode Pembayaran:</b>
                                                                    {{ $p->payment ? $p->payment->payment_name : '-' }}
                                                                </p>
                                                                <p class="mb-2"><b>Status Pembayaran:</b>
                                                                    <label
                                                                        class="badge {{ $p->payment_status == 'Lunas' ? 'badge-success' : 'badge-danger' }}">
                                                                        {{ $p->payment_status }}
                                                                    </label>
                                                                </p>
                                                                <p class="mb-2"><b>Status:</b>
                                                                    <label
                                                                        class="badge 
                                                                        {{ $p->status->status_id == 1 || $p->status->status_id == 3
                                                                            ? 'badge-warning'
                                                                            : ($p->status->status_id == 2 || $p->status->status_id == 4
                                                                                ? 'badge-success'
                                                                                : ($p->status->status_id == 5
                                                                                    ? 'badge-danger'
                                                                                    : 'badge-info')) }}
                                                                        ">
                                                                        {{ $p->status->status_description }}
                                                                    </label>
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
    @if (session('purchase.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('purchase.success') }}',
            })
        </script>
    @endif
    @if (session('purchase.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('purchase.error') }}',
            })
        </script>
    @endif
@endpush
