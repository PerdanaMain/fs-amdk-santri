@extends('layouts.dashboard.index')

@section('title')
    Sales
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
                        <h4 class="card-title">Data Penjualan</h4>
                        <div class="d-block my-4">
                            @if (!in_array(session()->get('user')->role_id, [4, 5, 6]))
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    <i class="mdi mdi-plus"></i> Tambah Penjualan
                                </button>
                            @endif

                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#exportModal">
                                <i class="mdi mdi-file-export"></i> Export Data
                            </button>

                            {{-- Export modal --}}
                            <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exportModalLabel">Export Data Penjualan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('sales.export') }}" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="col-md-12 col-sm12">
                                                        <div class="form-group mb-3">
                                                            <label for="format">Format Export</label>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-12">
                                                                    <input type="radio" name="format" id="format_excel"
                                                                        value="1" checked> Excel
                                                                </div>
                                                                <div class="col-md-6 col-sm-12">
                                                                    <input type="radio" name="format" id="format_pdf"
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
                                            <h5 class="modal-title" id="addModalLabel">Add Penjualan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('sales.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="customer_id">Nama Customer <span
                                                                        style="color:red">*</span></label>
                                                                <select id="customer_id" class="form-select"
                                                                    name="customer_id">
                                                                    <option></option>
                                                                    @foreach ($customers as $customer)
                                                                        <option value="{{ $customer->customer_id }}"
                                                                            data-phone="{{ $customer->customer_phone }}"
                                                                            data-address="{{ $customer->customer_address }}">
                                                                            {{ $customer->customer_name }} -
                                                                            {{ $customer->customer_owner }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="stock_id">Nama Barang <span
                                                                        style="color:red">*</span></label>
                                                                <select id="stock_id" class="form-select" name="stock_id">
                                                                    <option selected hidden>=== Pilih Barang === </option>
                                                                    @foreach ($stocks as $stock)
                                                                        <option value="{{ $stock->stock_id }}"
                                                                            data-satuan="{{ $stock->stock_satuan }}">
                                                                            {{ $stock->stock_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="sale_quantity">Jumlah Barang <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="sale_quantity" id="sale_quantity">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="sale_price">Harga Barang / <span
                                                                        id="satuan_barang"></span> <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="sale_price" id="sale_price">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="sale_total">Total Harga <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="sale_total" id="sale_total" hidden>
                                                                <input class="form-control" type="text"
                                                                    id="sale_total_show" readonly>
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
                                                        <div class="col-md-6 col-sm-12" id="tenggat-waktu">
                                                            <div class="form-group">
                                                                <label for="sale_date">Tenggat waktu pembayaran <span
                                                                        style="color:red">*</span></label>
                                                                <div id="datepicker-popup"
                                                                    class="input-group date datepicker navbar-date-picker">
                                                                    <span
                                                                        class="input-group-addon input-group-prepend border-right">
                                                                        <span
                                                                            class="icon-calendar input-group-text calendar-icon"></span>
                                                                    </span>
                                                                    <input type="text" class="form-control"
                                                                        name="sale_date">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="sale_description">Deskripsi
                                                                    Penjualan</label>
                                                                <textarea name="sale_description" class="form-control" cols="30" rows="10"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="sale_description">Bukti Pembayaran</label>
                                                                <input type="file" class="form-control"
                                                                    name="sale_invoice">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="stock_id">Simpan sebagai <span
                                                                        style="color:red">*</span></label>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <input type="radio" name="sale_status"
                                                                            id="sale_status" value="6"> Sebagai
                                                                        draft
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <input type="radio" name="sale_status"
                                                                            id="sale_status" value="1"> Ajukan
                                                                        Penjualan
                                                                    </div>
                                                                </div>
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
                            <table class="table table-striped" id="table-sales">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Nama Customer</th>
                                        <th>Jumlah Barang</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Tgl Transaksi</th>
                                        <th>Status</th>
                                        <th>Status Pembayaran</th>
                                        <th>PIC</th>
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
                                                <label
                                                    class="badge {{ $sale->payment_status == 'Lunas' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $sale->payment_status }}
                                                </label>
                                            </td>
                                            <td>{{ $sale->user->user_name }}</td>

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
                                                    @if ($sale->payment_status == 'Belum Lunas')
                                                        <button class="dropdown-item" id="pay_sales"
                                                            data-id="{{ $sale->sale_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-cash-multiple me-2"></i>
                                                            Bayar</button>
                                                    @endif

                                                    @if ($sale->status->status_id == 6)
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#updateModal-{{ $sale->sale_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                            Update</button>
                                                        <button class="dropdown-item" data-id="{{ $sale->sale_id }}"
                                                            id="submit_sales"><i
                                                                class="dropdown-item-icon mdi mdi-send me-2"></i>
                                                            Ajukan</button>
                                                        <button class="dropdown-item" id="delete_sales"
                                                            data-id="{{ $sale->sale_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-delete-outline me-2"></i>
                                                            Delete</button>
                                                    @else
                                                        @if (in_array(session()->get('user')->role_id, [1, 2]))
                                                            @if ($sale->status->status_id == 1)
                                                                <button class="dropdown-item"
                                                                    data-id="{{ $sale->sale_id }}" id="approve_sales"><i
                                                                        class="dropdown-item-icon mdi mdi-check me-2"></i>
                                                                    Approve</button>

                                                                <button class="dropdown-item"
                                                                    data-id="{{ $sale->sale_id }}" id="reject_sales"><i
                                                                        class="dropdown-item-icon mdi mdi-close me-2"></i>
                                                                    Reject</button>
                                                            @else
                                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#updateModal-{{ $sale->sale_id }}"><i
                                                                        class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                                    Update</button>
                                                                <button class="dropdown-item" id="delete_sales"
                                                                    data-id="{{ $sale->sale_id }}"><i
                                                                        class="dropdown-item-icon mdi mdi-delete-outline me-2"></i>
                                                                    Delete</button>
                                                                <button class="dropdown-item"
                                                                    data-msg="{{ $sale->sale_reject_message }}"
                                                                    id="reject_message"><i
                                                                        class="dropdown-item-icon mdi mdi-email me-2"></i>
                                                                    Message</button>
                                                            @endif
                                                        @else
                                                            @if ($sale->status->status_id != 1 || $sale->status->status_id != 2)
                                                                @if ($sale->status->status_id == 6)
                                                                    <button class="dropdown-item"
                                                                        data-id="{{ $sale->sale_id }}"
                                                                        id="submit_purchase"><i
                                                                            class="dropdown-item-icon mdi mdi-send me-2"></i>
                                                                        Ajukan</button>
                                                                @endif

                                                                @if ($sale->status->status_id == 5)
                                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#updateModal-{{ $sale->sale_id }}"><i
                                                                            class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                                        Update</button>
                                                                    <button class="dropdown-item" id="delete_sales"
                                                                        data-id="{{ $sale->sale_id }}"><i
                                                                            class="dropdown-item-icon mdi mdi-delete-outline me-2"></i>
                                                                        Delete</button>
                                                                    <button class="dropdown-item"
                                                                        data-msg="{{ $sale->sale_reject_message }}"
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

                                        {{-- Update modal --}}
                                        <div class="modal fade" id="updateModal-{{ $sale->sale_id }}" tabindex="-1"
                                            aria-labelledby="updateModal-{{ $sale->sale_id }}Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="updateModal-{{ $sale->sale_id }}Label">Update Penjualan
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <form class="forms-sample" method="POST"
                                                                action="{{ route('sales.update', ['id' => $sale->sale_id]) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="customer_id">Nama Customer <span
                                                                                    style="color:red">*</span></label>
                                                                            <select id="customer_id" class="form-select"
                                                                                name="customer_id">
                                                                                <option selected hidden
                                                                                    value="{{ $sale->customer_id }}">
                                                                                    {{ $sale->customer->customer_name }}
                                                                                </option>
                                                                                @foreach ($customers as $customer)
                                                                                    <option
                                                                                        value="{{ $customer->customer_id }}">
                                                                                        {{ $customer->customer_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="stock_id">Nama Barang <span
                                                                                    style="color:red">*</span></label>
                                                                            <select id="stock_id" class="form-select"
                                                                                name="stock_id">
                                                                                <option selected hidden
                                                                                    value="{{ $sale->stock_id }}">
                                                                                    {{ $sale->stock->stock_name }}
                                                                                </option>
                                                                                @foreach ($stocks as $stock)
                                                                                    <option
                                                                                        value="{{ $stock->stock_id }}">
                                                                                        {{ $stock->stock_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="sale_quantity">Jumlah Barang <span
                                                                                    style="color:red">*</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="sale_quantity" id="sale_quantity"
                                                                                value="{{ $sale->sale_quantity }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="sale_price">Harga Barang <span
                                                                                    style="color:red">*</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="sale_price" id="sale_price"
                                                                                value="{{ $sale->sale_price }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="payment_id">Pembayaran <span
                                                                                    style="color:red">*</span></label>
                                                                            <select id="payment_id" class="form-select"
                                                                                name="payment_id">
                                                                                <option selected hidden
                                                                                    value="{{ $sale->payment_id }}">
                                                                                    {{ $sale->payment->payment_name }}
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
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="sale_date">Tenggat waktu pembayaran
                                                                                <span style="color:red">*</span></label>
                                                                            <div id="datepicker-popup"
                                                                                class="input-group date datepicker navbar-date-picker">
                                                                                <span
                                                                                    class="input-group-addon input-group-prepend border-right">
                                                                                    <span
                                                                                        class="icon-calendar input-group-text calendar-icon"></span>
                                                                                </span>
                                                                                <input type="date" class="form-control"
                                                                                    name="sale_date"value="{{ date('Y-m-d', strtotime($sale->sale_date)) }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="sale_description">Deskripsi
                                                                                Penjualan</label>
                                                                            <textarea name="sale_description" class="form-control" cols="30" rows="10">
                                                                              {{ $sale->sale_description }}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="sale_description">Bukti
                                                                                Pembayaran</label>
                                                                            <input type="file" class="form-control"
                                                                                name="sale_invoice">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="stock_id">Simpan sebagai <span
                                                                                    style="color:red">*</span></label>
                                                                            <div class="row">
                                                                                <div class="col-md-6 col-sm-12">
                                                                                    <input type="radio"
                                                                                        name="sale_status"
                                                                                        id="sale_status" value="6"
                                                                                        {{ $sale->status_id == 6 ? 'checked' : '' }}>
                                                                                    Sebagai
                                                                                    draft
                                                                                </div>
                                                                                <div class="col-md-6 col-sm-12">
                                                                                    <input type="radio"
                                                                                        name="sale_status"
                                                                                        id="sale_status" value="1"
                                                                                        {{ $sale->status_id == 1 ? 'checked' : '' }}>
                                                                                    Ajukan
                                                                                    Penjualan
                                                                                </div>
                                                                            </div>
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
            $('#table-sales').DataTable();

            $('#addModal #customer_id').select2({
                dropdownParent: $('#addModal'),
                placeholder: '=== Pilih Customer ===',
                width: '100%',
                templateResult: function(data) {
                    if (!data.id) {
                        return data.text;
                    }
                    var phone = $(data.element).data('phone');
                    var address = $(data.element).data('address');

                    var $result = $(
                        '<div style="padding: 4px;">' +
                        '<div style="font-weight: bold; font-size: 1.1em;">' + data.text +
                        '</div>' +
                        '<div style="font-size: 0.9em; color: #555; margin-top: 4px;">' +
                        '<i class="mdi mdi-phone" style="margin-right: 5px;"></i>' + (phone ?
                            phone : '-') +
                        '</div>' +
                        '<div style="font-size: 0.9em; color: #555;">' +
                        '<i class="mdi mdi-map-marker" style="margin-right: 5px;"></i>' + (address ?
                            address :
                            '-') +
                        '</div>' +
                        '</div>'
                    );
                    return $result;
                },
                matcher: function(params, data) {
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    if (typeof data.text === 'undefined') {
                        return null;
                    }

                    var term = params.term.toLowerCase();
                    var text = data.text.toLowerCase();
                    var phone = $(data.element).data('phone') ? String($(data.element).data('phone'))
                        .toLowerCase() : '';
                    var address = $(data.element).data('address') ? String($(data.element).data(
                        'address')).toLowerCase() : '';

                    if (text.indexOf(term) > -1 || phone.indexOf(term) > -1 || address.indexOf(term) > -
                        1) {
                        return data;
                    }

                    return null;
                }
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
                let sQty = parseInt($('#sale_quantity').val());
                let sPrc = parseInt($('#sale_price').val());

                let total = sPrc * sQty;
                let formattedTotal = formatCurrency(total);
                $('#sale_total').val(total);
                $('#sale_total_show').val(formattedTotal);
            }
            $('#sale_quantity, #sale_price').on('input', updateTotal);

            $('input[id="sale_status"]').on("change", function() {
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

            $("#payment_id").on("change", function() {
                let payment = $(this).val();
                if (payment == 1) {
                    $("#tenggat-waktu").hide();
                } else {
                    $("#tenggat-waktu").show();
                }
            });

            $('#stock_id').on('change', function() {
                let satuan = $(this).find(':selected').data('satuan');
                $('#satuan_barang').text(satuan);
            });
        });


        $(document).on("click", "#delete_sales", function() {
            var sale_id = $(this).data('id');
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
                        url: "/sales/" + sale_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire(
                                    'Deleted!',
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
                            console.log(response);
                            Swal.fire(
                                'Failed!',
                                response.responseJSON.message,
                                'error'
                            )
                        }
                    });
                }
            })
        });

        $(document).on("click", "#submit_sales", function() {
            var sale_id = $(this).data('id');

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
                        url: "/sales/" + sale_id,
                        type: 'PATCH',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status == true) {
                                Swal.fire(
                                    'Submitted!',
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
                            console.log(response);
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

        $(document).on("click", "#approve_sales", function() {
            let sale_id = $(this).data('id');
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
                        url: "/sales/approve/" + sale_id,
                        type: 'PUT',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status) {
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

        $(document).on("click", "#reject_sales", function() {
            let sale_id = $(this).data('id');
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
                        url: "/sales/reject/" + sale_id,
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
                                    response.message,
                                    'error'
                                )
                            }
                        },
                        error: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Failed!',
                                response.responseJSON.message,
                                'error'
                            )
                        }
                    });
                }
            });
        })

        $(document).on("click", "#reject_message", function() {
            let msg = $(this).data('msg');
            Swal.fire({
                title: "Alasan penolakan",
                text: msg,
                icon: "warning"
            });
        })

        $(document).on("click", "#pay_sales", function() {
            var sale_id = $(this).data('id');

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
                        url: "/sales/pay/" + sale_id,
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
                                'Failed!',
                                response.responseJSON.message,
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
    @if (session('sales.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('sales.success') }}',
            })
        </script>
    @endif
    @if (session('sales.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('sales.error') }}',
            })
        </script>
    @endif
@endpush
