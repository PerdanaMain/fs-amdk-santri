@extends('layouts.dashboard.index')

@section('title')
    Supplier
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Supplier</h4>
                        <div class="d-block my-4">
                            @if (!in_array(session()->get('user')->role_id, [4]))
                                <button type="button" class="btn btn-primary me-2 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#addModal">Add Supplier</button>
                            @endif

                            @if (in_array(session()->get('user')->role_id, [2]))
                                <div class="btn-group mb-3">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Export Data
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('supplier.export.excel') }}">Excel</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('supplier.export.pdf') }}">PDF</a></li>
                                    </ul>
                                </div>
                            @endif

                            {{-- Add modal --}}
                            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Add New Supplier</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('supplier.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="supplier_photo">Foto Supplier</label>
                                                        <input type="file" class="form-control" name="supplier_photo">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="supplier_name">Nama Supplier <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="supplier_name" id="supplier_name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="supplier_owner">Nama Pemilik <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="supplier_owner" id="supplier_owner">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="supplier_phone">No Telpon <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="supplier_phone" id="supplier_phone">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="supplier_coordinate">Koordinat (latitude,
                                                                    longitude) </label>
                                                                <input class="form-control" type="text"
                                                                    name="supplier_coordinate" id="supplier_coordinate">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="supplier_address">Alamat Lengkap<span
                                                                        style="color:red">*</span></label>
                                                                <textarea name="supplier_address" class="form-control" cols="30" rows="10"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="supplier_description">Deskripsi Supplier</label>
                                                                <textarea name="supplier_description" class="form-control" cols="30" rows="10"></textarea>
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

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-supplier">
                                <thead>
                                    <tr>
                                        <th>Foto Supplier</th>
                                        <th>Nama Supplier</th>
                                        <th>Nama Pemilik</th>
                                        <th>Alamat</th>
                                        <th>Lokasi</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $s)
                                        <tr>
                                            <td>
                                                @if ($s->supplier_photo == null)
                                                    <img src="{{ url('dashboards/images/faces/face1.jpg') }}"
                                                        alt="image" />
                                                @else
                                                    <img src="{{ url('storage/suppliers/' . $s->supplier_photo) }}"
                                                        alt="image" style="width: 70px; height:70px;" />
                                                @endif
                                            </td>
                                            <td>{{ $s->supplier_name }}</td>
                                            <td>{{ $s->supplier_owner }}</td>
                                            <td class="text-truncate" style="max-width: 250px;">
                                                {{ $s->supplier_address }}
                                            </td>
                                            <td>
                                                @if ($s->supplier_coordinate)
                                                    <a href='https://www.google.com/maps?q={{ $s->supplier_coordinate }}'
                                                        class="btn btn-success" target="_blank"><i
                                                            class="mdi mdi-map me-2"></i>
                                                        Map</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <a class="nav-link" id="StockDropdown" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                                    aria-labelledby="StockDropdown">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#infoModal-{{ $s->supplier_id }}">
                                                        <i class="dropdown-item-icon mdi mdi-information-outline me-2"></i>
                                                        Info
                                                    </a>
                                                    @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#updateModal-{{ $s->supplier_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                            Update </button>
                                                        @if (in_array(session()->get('user')->role_id, [2]))
                                                            <button class="dropdown-item" data-id="{{ $s->supplier_id }}"
                                                                id="delete_supplier"><i
                                                                    class="dropdown-item-icon mdi mdi-close me-2"></i>
                                                                Delete</button>
                                                        @endif
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>

                                        {{-- info modal --}}
                                        <div class="modal fade" id="infoModal-{{ $s->supplier_id }}" tabindex="-1"
                                            aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="infoModalLabel">Info Supplier</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 mb-2">
                                                                @if ($s->supplier_photo == null)
                                                                    <img src="{{ url('dashboards/images/faces/face1.jpg') }}"
                                                                        alt="image" />
                                                                @else
                                                                    <img src="{{ url('storage/suppliers/' . $s->supplier_photo) }}"
                                                                        alt="image"
                                                                        style="width: 150px; height:150px;" />
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p><b>Nama Supplier:</b>
                                                                    {{ $s->supplier_name }}
                                                                </p>
                                                                <p><b>Nama Pemilik:</b>
                                                                    {{ $s->supplier_owner }}
                                                                </p>
                                                                <p><b>No Telp:</b>
                                                                    {{ $s->supplier_phone }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p><b>Deskripsi:</b>
                                                                    {{ $s->supplier_description }}
                                                                </p>
                                                                <p><b>Alamat:</b>
                                                                    {{ $s->supplier_address }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Update modal --}}
                                        <div class="modal fade" id="updateModal-{{ $s->supplier_id }}" tabindex="-1"
                                            aria-labelledby="updateModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateModalLabel">Update Supplier
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <form class="forms-sample" method="POST"
                                                                action="{{ route('supplier.update', ['id' => $s->supplier_id]) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="supplier_photo">Foto Supplier</label>
                                                                    <input type="file" class="form-control"
                                                                        name="supplier_photo">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="supplier_name">Nama
                                                                                Supplier</label>
                                                                            <input class="form-control" type="text"
                                                                                name="supplier_name" id="supplier_name"
                                                                                value="{{ $s->supplier_name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="supplier_owner">Nama
                                                                                Pemilik</label>
                                                                            <input class="form-control" type="text"
                                                                                name="supplier_owner" id="supplier_owner"
                                                                                value="{{ $s->supplier_owner }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="supplier_phone">No
                                                                                Telpon</label>
                                                                            <input class="form-control" type="text"
                                                                                name="supplier_phone" id="supplier_phone"
                                                                                value="{{ $s->supplier_phone }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="supplier_coordinate">Koordinat
                                                                                (latitude,
                                                                                longitude)
                                                                            </label>
                                                                            <input class="form-control" type="text"
                                                                                name="supplier_coordinate"
                                                                                id="supplier_coordinate"
                                                                                value="{{ $s->supplier_coordinate }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="supplier_address">Alamat</label>
                                                                            <textarea name="supplier_address" class="form-control" cols="30" rows="10">
                                                                          {{ $s->supplier_address }}
                                                                        </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="supplier_description">Deskripsi
                                                                                Supplier</label>
                                                                            <textarea name="supplier_description" class="form-control" cols="30" rows="10">
                                                                          {{ $s->supplier_description }}
                                                                        </textarea>
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
            $('#table-supplier').DataTable();
        });


        $(document).on("click", "#delete_supplier", function() {
            var supplier_id = $(this).data('id');
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
                        url: "/suppliers/" + supplier_id,
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
    @if (session('supplier.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('supplier.success') }}',
            })
        </script>
    @endif
    @if (session('supplier.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('supplier.error') }}',
            })
        </script>
    @endif
@endpush
