@extends('layouts.dashboard.index')

@section('title')
    Stocks
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Air Mineral Stocks</h4>
                        <div class="d-block my-4">
                            @if (in_array(session()->get('user')->role_id, [1, 2]))
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#addModal">Add Stock</button>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-export"></i> Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('stocks.export') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="format" value="1">
                                                <button type="submit" class="dropdown-item">Excel</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('stocks.export') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="format" value="2">
                                                <button type="submit" class="dropdown-item">PDF</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif

                            {{-- Add modal --}}
                            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Add stock</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('stocks.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="stock_photo">Photo</label>
                                                        <input type="file" class="form-control" name="stock_photo">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="supplier_id">Supplier</label>
                                                        <select class="form-select" name="supplier_id" id="supplier_id">
                                                            <option selected disabled>Pilih Supplier</option>
                                                            @foreach ($suppliers as $supplier)
                                                                <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="stock_name">Name</label>
                                                        <input type="text" class="form-control" placeholder="Name"
                                                            name="stock_name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="stock_quantity">Jumlah stock</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Jumlah stock" name="stock_quantity">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="stock_satuan">Satuan</label>
                                                        <select id="stock_select" class="form-select" name="stock_satuan">
                                                            <option value="Dus" selected>Dus</option>
                                                            <option value="Galon">Galon</option>
                                                        </select>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="stock_description">Deskripsi</label>
                                                        <textarea name="stock_description" class="form-control" cols="30" rows="10"></textarea>
                                                    </div>
                                                    <div class="d-block">
                                                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                                                        <button class="btn btn-light">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-stocks">
                                <thead>
                                    <tr>
                                        <th>
                                            Photo
                                        </th>
                                        <th>
                                            Supplier
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Quantity
                                        </th>
                                        <th>
                                            Description
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                        <tr>
                                            <td class="py-1">
                                                <img src="{{ url('storage/stocks/' . $stock->stock_photo) }}" alt="image"
                                                    style="width: 90px; height:90px;" />
                                            </td>
                                            <td>
                                                <p class="mb-1">{{ $stock->supplier ? $stock->supplier->supplier_name : '-' }}</p>
                                                <small class="text-muted d-block">{{ $stock->supplier ? $stock->supplier->supplier_owner : '' }}</small>
                                                <small class="text-muted">{{ $stock->supplier ? $stock->supplier->supplier_phone : '' }}</small>
                                            </td>
                                            <td>
                                                {{ $stock->stock_name }}
                                            </td>
                                            <td>
                                                {{ $stock->stock_quantity }} {{ $stock->stock_satuan }}

                                            </td>
                                            <td>
                                                {{ Str::limit($stock->stock_description, 50, '...') }}
                                            </td>
                                            <td>
                                                <a class="nav-link" id="StockDropdown" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i> </a>

                                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                                    aria-labelledby="StockDropdown">

                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#infoModal-{{ $stock->stock_id }}"><i
                                                            class="dropdown-item-icon mdi mdi-information-outline me-2"></i>
                                                        Info </button>
                                                    @if (in_array(session()->get('user')->role_id, [1, 2]))
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#updateModal-{{ $stock->stock_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                            Update </button>
                                                        <button class="dropdown-item" id="delete_stock"
                                                            data-id="{{ $stock->stock_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-delete-outline me-2"></i>
                                                            Delete</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- info modal --}}
                                        <div class="modal fade" id="infoModal-{{ $stock->stock_id }}" tabindex="-1"
                                            aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="infoModalLabel">Info stock</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <img src="{{ url('storage/stocks/' . $stock->stock_photo) }}"
                                                                    alt="image" style="width:100px;" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h4>{{ $stock->stock_name }}</h4>
                                                                <p class="mb-1"><strong>Supplier:</strong> {{ $stock->supplier ? $stock->supplier->supplier_name : '-' }}</p>
                                                                <p class="mb-1"><strong>Owner:</strong> {{ $stock->supplier ? $stock->supplier->supplier_owner : '-' }}</p>
                                                                <p class="mb-1"><strong>Phone:</strong> {{ $stock->supplier ? $stock->supplier->supplier_phone : '-' }}</p>
                                                                <p class="mb-3"><strong>Address:</strong> {{ $stock->supplier ? $stock->supplier->supplier_address : '-' }}</p>
                                                                <p class="mb-1"><strong>Description:</strong> {{ $stock->stock_description }}</p>
                                                                <p>Stock: {{ $stock->stock_quantity }}
                                                                    {{ $stock->stock_satuan }}</p>
                                                                <p>
                                                                    {{ $stock->stock_description }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        {{-- Update modal --}}
                                        <div class="modal fade" id="updateModal-{{ $stock->stock_id }}" tabindex="-1"
                                            aria-labelledby="updateModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateModalLabel">Update stock</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <form class="forms-sample" method="POST"
                                                                action="{{ route('stocks.update', ['id' => $stock->stock_id]) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="stock_photo">Photo</label>
                                                                    <input type="file" class="form-control"
                                                                        name="stock_photo">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="supplier_id">Supplier</label>
                                                                    <select class="form-select" name="supplier_id" id="supplier_id">
                                                                        <option selected disabled>Pilih Supplier</option>
                                                                        @foreach ($suppliers as $supplier)
                                                                            <option value="{{ $supplier->supplier_id }}" {{ $stock->supplier_id == $supplier->supplier_id ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="stock_name">Name</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Name" name="stock_name"
                                                                        value="{{ $stock->stock_name }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="stock_quantity">Jumlah stock</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jumlah stock" name="stock_quantity"
                                                                        value="{{ $stock->stock_quantity }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="stock_satuan">Satuan</label>
                                                                    <select id="stock_select" class="form-select"
                                                                        name="stock_satuan"
                                                                        value="{{ $stock->stock_satuan }}">
                                                                        <option value="Dus" selected>Dus</option>
                                                                        <option value="Galon">Galon</option>
                                                                    </select>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="stock_description">Deskripsi</label>
                                                                    <textarea name="stock_description" class="form-control" cols="30" rows="10">{{ $stock->stock_description }}</textarea>
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
            $('#table-stocks').DataTable();
        });

        $(document).on("click", "#delete_stock", function() {
            var stock_id = $(this).data('id');
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
                        url: "/stocks/" + stock_id,
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
    @if (session('stock.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('stock.success') }}',
            })
        </script>
    @endif
    @if (session('stock.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('auth.error') }}',
            })
        </script>
    @endif
@endpush
