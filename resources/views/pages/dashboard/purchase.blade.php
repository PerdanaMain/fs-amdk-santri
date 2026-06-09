@extends('layouts.dashboard.index')

@section('title')
    Pembelian
@endsection

@section('content.dashboard')
    <style>
        .select2-search--dropdown .select2-search__field {
            background-color: #e9ecef !important;
            color: #333 !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--bootstrap .select2-results__option--highlighted[aria-selected] {
            background-color: #f8f9fa !important;
            color: #333 !important;
        }
    </style>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data pembelian</h4>
                        <div class="d-block my-4">
                            @if (!in_array(session()->get('user')->role_id, [3, 4, 5, 6]))
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#addModal">Add Data</button>
                            @endif

                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal"
                                data-bs-target="#exportModal">Export Data</button>

                            {{-- Export modal --}}
                            <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Export Data Pembelian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('purchase.export') }}" enctype="multipart/form-data">
                                                    @csrf

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

                            {{-- Add modal --}}
                            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Add Purchase Item</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('purchase.store') }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="supplier_id">Supplier <span style="color: red">
                                                                *</span></label>
                                                        <select class="form-select" name="supplier_id" id="supplier_select">
                                                            <option selected hidden>=== Pilih Supplier ===</option>
                                                            @foreach ($suppliers as $supplier)
                                                                <option value="{{ $supplier->supplier_id }}">
                                                                    {{ $supplier->supplier_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="stock_id">Nama Barang <span style="color: red">
                                                                *</span></label>
                                                        <select id="stock_select" class="form-select" name="stock_id">
                                                            <option></option>
                                                            @foreach ($stocks as $stock)
                                                                <option value={{ $stock->stock_id }}
                                                                    data-satuan={{ $stock->stock_satuan }}>
                                                                    {{ $stock->stock_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="purchase_description">Deskripsi Pembelian </label>
                                                        <textarea name="purchase_description" class="form-control" cols="30" rows="10"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="stock_id">Jumlah Barang <span style="color: red">
                                                                *</span></label>
                                                        <input class="form-control" type="number" name="purchase_quantity"
                                                            id="purchase_quantity">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="stock_id">Harga Satuan / <span
                                                                        id="satuan_barang"></span> <span
                                                                        style="color: red">
                                                                        *</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="purchase_price" id="purchase_price">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="payment_id">Pembayaran <span
                                                                        style="color:red">*</span></label>
                                                                <select id="payment_id" class="form-select"
                                                                    name="payment_id">
                                                                    <option selected hidden>=== Pilih Pembayaran ===
                                                                    </option>
                                                                    @foreach ($payments as $payment)
                                                                        <option value="{{ $payment->payment_id }}">
                                                                            {{ $payment->payment_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="stock_id">Total Harga <span style="color: red">
                                                                    *</span></label>
                                                            <input class="form-control" type="text"
                                                                name="purchase_total" id="purchase_total_show" disabled
                                                                readonly>
                                                            <input class="form-control" type="text"
                                                                name="purchase_total" id="purchase_total" hidden>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="stock_id">Simpan sebagai <span style="color: red">
                                                                *</span></label>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-12">
                                                                <input type="radio" name="purchase_status"
                                                                    id="purchase_status" value="6"> Sebagai draft
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <input type="radio" name="purchase_status"
                                                                    id="purchase_status" value="3"> Ajukan pembelian
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-block">
                                                        <button type="submit"
                                                            class="btn btn-primary me-2">Submit</button>
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
                                            <td>{{ $p->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}
                                            </td>
                                            <td>
                                                <label
                                                    class="badge 
                                                {{ $p->status->status_id == 1 || $p->status->status_id == 3
                                                    ? 'badge-warning'
                                                    : ($p->status->status_id == 2 || $p->status->status_id == 4
                                                        ? 'badge-success'
                                                        : ($p->status->status_id == 5
                                                            ? 'badge-danger'
                                                            : 'badge-primary')) }}
                                                ">
                                                    {{ $p->status->status_description }}
                                                </label>
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

                                                    @if ($p->payment_status == 'Belum Lunas')
                                                        @if (in_array(auth()->user()->role_id, [1, 2, 5, 6]))
                                                            <button class="dropdown-item" id="pay_purchase"
                                                                data-id="{{ $p->purchase_id }}"><i
                                                                    class="dropdown-item-icon mdi mdi-cash-multiple me-2"></i>
                                                                Bayar</button>
                                                        @endif
                                                    @endif

                                                    @if ($p->status->status_id == 6)
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#updateModal-{{ $p->purchase_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                            Update</button>
                                                        <button class="dropdown-item" data-id="{{ $p->purchase_id }}"
                                                            id="submit_purchase"><i
                                                                class="dropdown-item-icon mdi mdi-send me-2"></i>
                                                            Ajukan</button>
                                                        <button class="dropdown-item" id="delete_purchase"
                                                            data-id="{{ $p->purchase_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-delete-outline me-2"></i>
                                                            Delete</button>
                                                    @else
                                                        @if (in_array(session()->get('user')->role_id, [2, 5, 6]))
                                                            @if ($p->status->status_id == 3)
                                                                <button class="dropdown-item"
                                                                    data-id="{{ $p->purchase_id }}"
                                                                    id="approve_purchase"><i
                                                                        class="dropdown-item-icon mdi mdi-check me-2"></i>
                                                                    Approve</button>

                                                                <button class="dropdown-item"
                                                                    data-id="{{ $p->purchase_id }}"
                                                                    id="reject_purchase"><i
                                                                        class="dropdown-item-icon mdi mdi-close me-2"></i>
                                                                    Reject</button>
                                                            @endif
                                                        @else
                                                            @if (!in_array($p->status->status_id, [3, 4]))
                                                                @if ($p->status->status_id == 6)
                                                                    <button class="dropdown-item"
                                                                        data-id="{{ $p->purchase_id }}"
                                                                        id="submit_purchase"><i
                                                                            class="dropdown-item-icon mdi mdi-send me-2"></i>
                                                                        Ajukan</button>
                                                                @endif

                                                                @if ($p->status->status_id == 5)
                                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#updateModal-{{ $p->purchase_id }}"><i
                                                                            class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                                        Update</button>
                                                                    <button class="dropdown-item" id="delete_purchase"
                                                                        data-id="{{ $p->purchase_id }}"><i
                                                                            class="dropdown-item-icon mdi mdi-delete-outline me-2"></i>
                                                                        Delete</button>
                                                                    <button class="dropdown-item"
                                                                        data-msg="{{ $p->purchase_reject_message }}"
                                                                        id="reject_message"><i
                                                                            class="dropdown-item-icon mdi mdi-email me-2"></i>
                                                                        Message</button>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
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
                                                                    {{ $p->supplier ? $p->supplier->supplier_name : '-' }}
                                                                </p>
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
                                                                <p><b>Metode Pembayaran:</b>
                                                                    {{ $p->payment ? $p->payment->payment_name : '-' }}
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

                                        {{-- Update modal --}}
                                        <div class="modal fade" id="updateModal-{{ $p->purchase_id }}" tabindex="-1"
                                            aria-labelledby="updateModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateModalLabel">Update Pembelian
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <form class="forms-sample" method="POST"
                                                                action="{{ route('purchase.update', ['id' => $p->purchase_id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="supplier_id">Supplier <span
                                                                            style="color: red"> *</span></label>
                                                                    <select class="form-select supplier-select-update"
                                                                        name="supplier_id">
                                                                        <option selected hidden
                                                                            value="{{ $p->supplier_id }}">
                                                                            {{ $p->supplier ? $p->supplier->supplier_name : '=== Pilih Supplier ===' }}
                                                                        </option>
                                                                        @foreach ($suppliers as $supplier)
                                                                            <option value="{{ $supplier->supplier_id }}">
                                                                                {{ $supplier->supplier_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="stock_id">Nama Barang <span
                                                                            style="color: red"> *</span></label>
                                                                    <select id="stock_select" class="form-select"
                                                                        name="stock_id">
                                                                        <option selected hidden
                                                                            value={{ $p->stock->stock_id }}
                                                                            data-satuan={{ $stock->stock_satuan }}>
                                                                            {{ $p->stock->stock_name }}
                                                                        </option>
                                                                        @foreach ($stocks as $stock)
                                                                            <option value={{ $stock->stock_id }}>
                                                                                {{ $stock->stock_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="purchase_description">Deskripsi
                                                                        Pembelian <span style="color: red">
                                                                            *</span></label>
                                                                    <textarea name="purchase_description" class="form-control" cols="30" rows="10">
                                                                        {{ $p->purchase_description }}
                                                                    </textarea>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="stock_id">Jumlah Barang <span
                                                                                    style="color: red"> *</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="purchase_quantity"
                                                                                id="purchase_quantity_update"
                                                                                value="{{ $p->purchase_quantity }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="stock_id">Harga Satuan / <span
                                                                                    id="satuan_barang"></span> <span
                                                                                    style="color: red"> *</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="purchase_price"
                                                                                id="purchase_price_update"
                                                                                value="{{ $p->purchase_price }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="payment_id">Pembayaran <span
                                                                                    style="color:red">*</span></label>
                                                                            <select id="payment_id" class="form-select"
                                                                                name="payment_id">
                                                                                <option selected hidden
                                                                                    value="{{ $p->payment_id }}">
                                                                                    {{ $p->payment ? $p->payment->payment_name : '=== Pilih Pembayaran ===' }}
                                                                                </option>
                                                                                @foreach ($payments as $payment)
                                                                                    <option
                                                                                        value="{{ $payment->payment_id }}">
                                                                                        {{ $payment->payment_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="stock_id">Simpan sebagai <span
                                                                            style="color: red"> *</span></label>
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-sm-12">
                                                                            <input type="radio" name="purchase_status"
                                                                                id="purchase_status" value="6"
                                                                                {{ $p->status_id == 6 ? 'checked' : '' }}>
                                                                            Sebagai draft
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-12">
                                                                            <input type="radio" name="purchase_status"
                                                                                id="purchase_status" value="3"
                                                                                {{ $p->status_id == 3 ? 'checked' : '' }}>
                                                                            Ajukan pembelian
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-block">
                                                                    <button type="submit"
                                                                        class="btn btn-primary me-2">Submit</button>
                                                                    <button class="btn btn-light" type="button"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close">Cancel</button>
                                                                </div>
                                                            </form>
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

            $('#addModal #stock_select').select2({
                dropdownParent: $('#addModal'),
                placeholder: '=== Pilih Barang ===',
                width: '100%',
                templateResult: function(data) {
                    if (!data.id) {
                        return data.text;
                    }
                    var satuan = $(data.element).data('satuan');

                    var $result = $(
                        '<div style="padding: 4px;">' +
                        '<div style="font-weight: bold; font-size: 1.1em;">' + data.text +
                        '</div>' +
                        '<div style="font-size: 0.9em; color: #555; margin-top: 4px;">' +
                        'Satuan: ' + (satuan ?
                            satuan : '-') +
                        '</div>' +
                        '</div>'
                    );
                    return $result;
                }
            });

            $('#addModal #supplier_select').select2({
                dropdownParent: $('#addModal'),
                placeholder: '=== Pilih Supplier ===',
                width: '100%'
            });

            $('.supplier-select-update').each(function() {
                $(this).select2({
                    dropdownParent: $(this).closest('.modal'),
                    placeholder: '=== Pilih Supplier ===',
                    width: '100%'
                });
            });
        });

        $(document).ready(function() {
            function formatCurrency(value) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(value);
            }

            function updateTotal() {
                let pQty = parseInt($('#purchase_quantity').val());
                let pPrc = parseInt($('#purchase_price').val());

                let total = pPrc * pQty;
                let formattedTotal = formatCurrency(total);
                $('#purchase_total').val(total);
                $('#purchase_total_show').val(formattedTotal);
            }
            $('#purchase_quantity, #purchase_price').on('input', updateTotal);

            $('input[id="purchase_status"]').on("change", function() {
                let status = parseInt($(this).val());
                if (status == 3) {
                    Swal.fire({
                        title: "Perhatian!",
                        text: "Data yang sudah diajukan tidak dapat diubah lagi.",
                        icon: "warning",
                        confirmButtonText: "Ya",
                    })
                }
            });

            $('#stock_select').on('change', function() {
                let satuan = $(this).find(':selected').data('satuan');
                $('#satuan_barang').text(satuan);
            });

        });

        $(document).on("click", "#submit_purchase", function() {
            var purchase_id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to submit this purchase?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/purchase/" + purchase_id,
                        type: 'PATCH',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status == true) {
                                Swal.fire(
                                    'Submitted!',
                                    'Your file has been submitted.',
                                    'success'
                                )
                                location.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Your file has not been submitted.',
                                    'error'
                                )
                            }
                        }
                    });
                }

            })
        })

        $(document).on("click", "#reject_message", function() {
            let msg = $(this).data('msg');
            Swal.fire({
                title: "Alasan penolakan",
                text: msg,
                icon: "warning"
            });
        })

        $(document).on("click", "#approve_purchase", function() {
            let purchase_id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to approve this purchase?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/purchase/approve/" + purchase_id,
                        type: 'PUT',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status == true) {
                                Swal.fire(
                                    'Approved!',
                                    response.message,
                                    'success'
                                )
                                location.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    response.message,
                                    'error'
                                )
                            }
                        },
                        error: function(response) {
                            Swal.fire(
                                'Failed!',
                                response.responseJSON.message,
                                'error'
                            )
                        }
                    });
                }
            })
        })

        $(document).on("click", "#reject_purchase", function() {
            let purchase_id = $(this).data('id');
            Swal.fire({
                title: "Masukkan alasan penolakan",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Submit",
                showLoaderOnConfirm: true,

            }).then((result) => {
                console.log(result);
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/purchase/reject/" + purchase_id,
                        type: 'PUT',
                        data: {
                            _token: $("input[name=_token]").val(),
                            purchase_reject_message: result.value
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire(
                                    'Rejected!',
                                    response.message,
                                    'success'
                                )
                                location.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    response.responseJSON.message,
                                    'error'
                                )
                            }
                        },
                        error: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Failed!',
                                response.message,
                                'error'
                            )
                        }
                    });
                }
            });
        })

        $(document).on("click", "#delete_purchase", function() {
            var purchase_id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/purchase/" + purchase_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                location.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Your file has not been deleted.',
                                    'error'
                                )
                            }
                        }
                    });
                }
            })
        });

        $(document).on("click", "#pay_purchase", function() {
            var purchase_id = $(this).data('id');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin mengubah status pembayaran menjadi Lunas?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Bayar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/purchase/pay/" + purchase_id,
                        type: 'PATCH',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire(
                                    'Berhasil!',
                                    response.message,
                                    'success'
                                )
                                location.reload();
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    response.message,
                                    'error'
                                )
                            }
                        },
                        error: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'error'
                            )
                        }
                    });
                }
            })
        })
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
