@extends('layouts.dashboard.index')

@section('title')
    Customer
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Customer</h4>
                        <div class="d-block my-4">
                            @if (in_array(session()->get('user')->role_id, [1, 2, 4, 5, 6]))
                                <button type="button" class="btn btn-primary me-2 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#addModal">Add Customer</button>
                                <button type="button" class="btn btn-warning me-2 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#importModal">Import Customer</button>
                            @endif

                            @if (in_array(session()->get('user')->role_id, [2, 5, 6]))
                                <button type="button" class="btn btn-success me-2 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">Export Customer</button>
                            @endif

                            {{-- Add modal --}}
                            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Add New Customer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('customer.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="stock_id">Foto Customer</label>
                                                        <input type="file" class="form-control" name="customer_photo">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="customer_name">Nama Customer <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="customer_name" id="customer_name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="customer_owner">Nama Pemilik <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="customer_owner" id="customer_owner">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="customer_phone">No Telpon <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="customer_phone" id="customer_phone">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="customer_coordinate">Koordinat (latitude,
                                                                    longitude) </label>
                                                                <input class="form-control" type="text"
                                                                    name="customer_coordinate" id="customer_coordinate">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="customer_address">Alamat Lengkap<span
                                                                        style="color:red">*</span></label>
                                                                <textarea name="customer_address" class="form-control" cols="30" rows="10"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="customer_description">Deskripsi Customer</label>
                                                                <textarea name="customer_description" class="form-control" cols="30" rows="10"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="user_id">Petugas <span
                                                                        style="color:red">*</span></label>
                                                                <select id="user_id" class="form-select" name="user_id">
                                                                    <option selected hidden>=== Pilih Petugas === </option>
                                                                    @foreach ($ptg as $p)
                                                                        <option value={{ $p->user_id }}>
                                                                            {{ $p->user_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
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

                            {{-- Import modal --}}
                            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Mass Insert Customer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('customer.import') }}" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="customer_file">Upload File (excel)</label>
                                                                <input type="file" class="form-control"
                                                                    name="customer_file">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="d-block">
                                                                <a href="{{ route('customer.template') }}"
                                                                    class="btn btn-warning">Download Template</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-block mt-3">
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

                            {{-- Export modal --}}
                            <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Export Customer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('customer.export') }}" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="col-md-12 col-sm12">
                                                            <div class="form-group mb-3">
                                                                <label for="start_date">Petugas</label>
                                                                <select name="user_id" id="user_id"
                                                                    class="form-select">
                                                                    <option selected hidden>=== Pilih Petugas ===</option>
                                                                    <option value="0">Semua Petugas</option>
                                                                    @foreach ($ptg as $p)
                                                                        <option value="{{ $p->user_id }}">
                                                                            {{ $p->user_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm12">
                                                            <div class="form-group mb-3">
                                                                <label for="start_date">Format Export</label>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <input type="radio" name="format"
                                                                            id="format" value="1" checked> Excel
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <input type="radio" name="format"
                                                                            id="format" value="2"> Pdf
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-block mt-3">
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
                            <table class="table table-striped" id="table-customer">
                                <thead>
                                    <tr>
                                        <th>Foto Customer</th>
                                        <th>Nama Customer</th>
                                        <th>Nama Pemilik</th>
                                        <th>Alamat</th>
                                        <th>Transaksi</th>
                                        <th>Lokasi</th>
                                        <th>Petugas</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $c)
                                        <tr>
                                            <td>
                                                @if ($c->customer_photo == null)
                                                    <img src="{{ url('dashboards/images/faces/face1.jpg') }}"
                                                        alt="image" />
                                                @else
                                                    <img src="{{ url('storage/customers/' . $c->customer_photo) }}"
                                                        alt="image" style="width: 70px; height:70px;" />
                                                @endif
                                            </td>
                                            <td>{{ $c->customer_name }}</td>
                                            <td>{{ $c->customer_owner }}</td>
                                            <td class="text-truncate" style="max-width: 250px;">
                                                {{ $c->customer_address }}
                                            </td>
                                            <td>
                                                @if (count($c->sales) > 0)
                                                    <button type="button" class="btn btn-danger me-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#transModal-{{ $c->customer_id }}">Transaksi</button>
                                                @else
                                                    <span>Tidak ada</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href='https://www.google.com/maps?q={{ $c->customer_coordinate }}'
                                                    class="btn btn-success" target="_blank"><i
                                                        class="mdi mdi-map me-2"></i>
                                                    Map</a>
                                            </td>
                                            <td>
                                                {{ $c->user->user_name }}
                                            </td>
                                            <td>
                                                <a class="nav-link" id="StockDropdown" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                                    aria-labelledby="StockDropdown">
                                                    <a class="dropdown-item"
                                                        href="{{ route('customer.show', $c->customer_id) }}">
                                                        <i class="dropdown-item-icon mdi mdi-information-outline me-2"></i>
                                                        Info
                                                    </a>
                                                    @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#updateModal-{{ $c->customer_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                            Update </button>
                                                        @if (in_array(session()->get('user')->role_id, [2, 5, 6]))
                                                            <button class="dropdown-item" data-id="{{ $c->customer_id }}"
                                                                id="delete_customer"><i
                                                                    class="dropdown-item-icon mdi mdi-close me-2"></i>
                                                                Delete</button>
                                                        @endif
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>

                                        {{-- info modal --}}
                                        <div class="modal fade" id="infoModal-{{ $c->customer_id }}" tabindex="-1"
                                            aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="infoModalLabel">Info Customer</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 mb-2">
                                                                @if ($c->customer_photo == null)
                                                                    <img src="{{ url('dashboards/images/faces/face1.jpg') }}"
                                                                        alt="image" />
                                                                @else
                                                                    <img src="{{ url('storage/customers/' . $c->customer_photo) }}"
                                                                        alt="image"
                                                                        style="width: 150px; height:150px;" />
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p><b>Nama Customer:</b>
                                                                    {{ $c->customer_name }}
                                                                </p>
                                                                <p><b>Nama Pemilik:</b>
                                                                    {{ $c->customer_owner }}
                                                                </p>
                                                                <p><b>No Telp:</b>
                                                                    {{ $c->customer_phone }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p><b>Deskripsi:</b>
                                                                    {{ $c->customer_description }}
                                                                </p>
                                                                <p><b>Alamat:</b>
                                                                    {{ $c->customer_address }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p><b>PIC:</b>
                                                                    {{ $c->user->user_name }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Transaction modal --}}
                                        <div class="modal fade" id="transModal-{{ $c->customer_id }}" tabindex="-1"
                                            aria-labelledby="transModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="transModalLabel">Info Transaksi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-12">
                                                                <p>
                                                                    <b>Nama Customer: </b>
                                                                    {{ $c->customer_name }} - {{ $c->customer_owner }}
                                                                </p>
                                                                <p>
                                                                    <b>Nama Petugas: </b>
                                                                    {{ $c->user->user_name }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p>
                                                                    <b>Total Transaksi: </b>
                                                                    {{ count($c->sales) }}
                                                                </p>
                                                                <p>
                                                                    <b>Total Barang Terjual: </b>
                                                                    {{ $c->sales->sum('sale_quantity') }}
                                                                </p>
                                                                <p>
                                                                    <b>Total Pendapatan: </b>
                                                                    Rp. {{ number_format($c->sales->sum('sale_total')) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Update modal --}}
                                        <div class="modal fade" id="updateModal-{{ $c->customer_id }}" tabindex="-1"
                                            aria-labelledby="updateModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateModalLabel">Update Customer
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <form class="forms-sample" method="POST"
                                                                action="{{ route('customer.update', ['id' => $c->customer_id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="stock_id">Foto Customer</label>
                                                                    <input type="file" class="form-control"
                                                                        name="customer_photo">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="customer_name">Nama
                                                                                Customer</label>
                                                                            <input class="form-control" type="text"
                                                                                name="customer_name" id="customer_name"
                                                                                value="{{ $c->customer_name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="customer_owner">Nama
                                                                                Pemilik</label>
                                                                            <input class="form-control" type="text"
                                                                                name="customer_owner" id="customer_owner"
                                                                                value="{{ $c->customer_owner }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="customer_phone">No
                                                                                Telpon</label>
                                                                            <input class="form-control" type="text"
                                                                                name="customer_phone" id="customer_phone"
                                                                                value="{{ $c->customer_phone }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="customer_coordinate">Koordinat
                                                                                (latitude,
                                                                                longitude)
                                                                            </label>
                                                                            <input class="form-control" type="text"
                                                                                name="customer_coordinate"
                                                                                id="customer_coordinate"
                                                                                value="{{ $c->customer_coordinate }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="customer_address">Alamat</label>
                                                                            <textarea name="customer_address" class="form-control" cols="30" rows="10">
                                                                          {{ $c->customer_address }}
                                                                        </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="customer_description">Deskripsi
                                                                                Customer</label>
                                                                            <textarea name="customer_description" class="form-control" cols="30" rows="10">
                                                                          {{ $c->customer_description }}
                                                                        </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="user_id">Petugas</label>
                                                                            <select id="user_id" class="form-select"
                                                                                name="user_id">
                                                                                <option selected hidden
                                                                                    value={{ $c->user->user_id }}>
                                                                                    {{ $c->user->user_name }}</option>
                                                                                @foreach ($ptg as $p)
                                                                                    <option value={{ $p->user_id }}>
                                                                                        {{ $p->user_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
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
            $('#table-customer').DataTable();
            $('#table-trx').DataTable();
        });


        $(document).on("click", "#delete_customer", function() {
            var customer_id = $(this).data('id');
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
                        url: "/customers/" + customer_id,
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
                        }
                    });
                }
            })
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
    @if (session('customer.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('customer.success') }}',
            })
        </script>
    @endif
    @if (session('customer.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('customer.error') }}',
            })
        </script>
    @endif
@endpush
