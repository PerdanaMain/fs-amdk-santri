@extends('layouts.dashboard.index')

@section('title')
    Employees
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Employee</h4>
                        <div class="d-block my-4">
                            <button type="button" class="btn btn-primary me-2 mb-3" data-bs-toggle="modal"
                                data-bs-target="#addModal">Add Employee</button>

                            <button type="button" class="btn btn-success me-2 mb-3" data-bs-toggle="modal"
                                data-bs-target="#exportModal">Export Employee</button>

                            {{-- Add modal --}}
                            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Add New Employee</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('employee.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="user_photo">Foto Employee</label>
                                                        <input type="file" class="form-control" name="user_photo">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="user_nik">NIK <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text" name="user_nik"
                                                                    id="user_nik" placeholder="Masukkan NIK">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="user_nip">NIP </label>
                                                                <input class="form-control" type="text" name="user_nip"
                                                                    id="user_nip" placeholder="Masukkan NIP">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="user_name">Nama Employee <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text" name="user_name"
                                                                    id="user_name" placeholder="Masukkan Nama Lengkap">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="user_nickname">Nama Panggilan <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="user_nickname" id="user_nickname"
                                                                    placeholder="Masukkan Nama Panggilan">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="user_phone">No Telp <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text" name="user_phone"
                                                                    id="user_phone">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="user_description">Deskripsi Employee </label>
                                                                <textarea name="user_description" class="form-control" cols="30" rows="10"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="user_address">Alamat <span
                                                                        style="color:red">*</span></label>
                                                                <textarea name="user_address" id="user_address" cols="30" rows="10" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="user_branch">Cabang <span
                                                                        style="color:red">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="user_branch" id="user_branch">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="role_id">Hak Akses <span
                                                                        style="color:red">*</span></label>
                                                                <select name="role_id" id="role_id"
                                                                    class="form-select">
                                                                    <option selected hidden>=== Pilih Hak Akses ===</option>
                                                                    @foreach ($roles as $role)
                                                                        <option value="{{ $role->role_id }}">
                                                                            {{ $role->role_description }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="status">Status <span
                                                                        style="color:red">*</span></label>
                                                                <select name="status" id="status"
                                                                    class="form-select">
                                                                    <option selected hidden>=== Pilih Status ===</option>
                                                                    <option value="active">Active</option>
                                                                    <option value="magang">Magang</option>
                                                                    <option value="resign">Resign</option>
                                                                    <option value="dipecat">Dipecat</option>
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

                            {{-- Export modal --}}
                            <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Export Employees</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('employee.export') }}" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="row">
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
                            <table class="table table-striped" id="table-employee">
                                <thead>
                                    <tr>
                                        <th>Foto Employee</th>
                                        <th>Hak Akses</th>
                                        <th>Nama Employee</th>
                                        <th>No Telp</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Cabang</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $user)
                                        <tr>
                                            <td>
                                                @if ($user->user_photo != null)
                                                    <img src="{{ asset('storage/profiles/' . $user->user_photo) }}"
                                                        alt="image" class="img-fluid"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('dashboards/images/faces/face1.jpg') }}"
                                                        alt="image" class="img-fluid"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                            </td>
                                            <td>{{ $user->user_name }}</td>
                                            <td>{{ $user->role->role_description }}</td>
                                            <td>{{ $user->user_phone }}</td>
                                            <td>{{ Str::limit($user->user_address, 10) }}</td>
                                            <td>
                                                @if ($user->status == 'active')
                                                @endif
                                                @switch($user->status)
                                                    @case('active')
                                                        <label class="badge badge-success">Active</label>
                                                    @break

                                                    @case('magang')
                                                        <label class="badge badge-warning">Magang</label>
                                                    @break

                                                    @case('resign')
                                                        <label class="badge badge-danger">Resign</label>
                                                    @break

                                                    @case('dipecat')
                                                        <label class="badge badge-danger">Dipecat</label>
                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                            <td>{{ $user->user_branch }}</td>
                                            <td>
                                                <a class="nav-link" id="StockDropdown" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                                    aria-labelledby="StockDropdown">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#infoModal-{{ $user->user_id }}"><i
                                                            class="dropdown-item-icon mdi mdi-information-outline me-2"></i>
                                                        Info </button>
                                                    @if (session()->get('user')->role_id == 2)
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#updateModal-{{ $user->user_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                            Update </button>
                                                        <button class="dropdown-item" data-id={{ $user->user_id }}
                                                            id="delete_user"><i
                                                                class="dropdown-item-icon mdi mdi-close me-2"></i>
                                                            Delete </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Info modal --}}
                                        <div class="modal fade" id="infoModal-{{ $user->user_id }}" tabindex="-1"
                                            aria-labelledby="infoModal-{{ $user->user_id }}Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="infoModal-{{ $user->user_id }}Label">
                                                            Info Employee
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-12">
                                                                <p>
                                                                    <b>Nama: </b>
                                                                    {{ $user->user_name }}
                                                                </p>
                                                                <p>
                                                                    <b>NIK: </b>
                                                                    {{ $user->user_nik }}
                                                                </p>
                                                                <p>
                                                                    <b>NIP: </b>
                                                                    {{ $user->user_nip }}
                                                                </p>

                                                                <p>
                                                                    <b>No Telp: </b>
                                                                    {{ $user->user_phone }}
                                                                </p>
                                                                <p>
                                                                    <b>Alamat: </b>
                                                                    {{ $user->user_address }}
                                                                </p>
                                                                <p>
                                                                    <b>Deskripsi: </b>
                                                                    {{ $user->user_description ?? 'Belum ada deskripsi' }}
                                                                </p>

                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p>
                                                                    <b>Email: </b>
                                                                    {{ $user->email }}
                                                                </p>
                                                                <p>
                                                                    <b>Jumlah Pic (Customer):</b>
                                                                    {{ $user->customers->count() }}
                                                                </p>
                                                                <p>
                                                                    <b>Jumlah Transaksi: </b>
                                                                    {{ $user->sales->count() }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="d-block">
                                                            <button class="btn btn-light" type="button"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Update modal --}}
                                        <div class="modal fade" id="updateModal-{{ $user->user_id }}" tabindex="-1"
                                            aria-labelledby="updateModal-{{ $user->user_id }}Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="updateModal-{{ $user->user_id }}Label">Update Employee
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <form class="forms-sample" method="POST"
                                                                action="{{ route('employee.update', ['id' => $user->user_id]) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="user_photo">Foto Employee</label>
                                                                    <input type="file" class="form-control"
                                                                        name="user_photo">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="user_nik">NIK </label>
                                                                            <input class="form-control" type="text"
                                                                                name="user_nik" id="user_nik"
                                                                                placeholder="Masukkan NIK"
                                                                                value="{{ $user->user_nik }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="user_nip">NIP </label>
                                                                            <input class="form-control" type="text"
                                                                                name="user_nip" id="user_nip"
                                                                                placeholder="Masukkan NIP"
                                                                                value="{{ $user->user_nip }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="user_name">Nama Employee <span
                                                                                    style="color:red">*</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="user_name" id="user_name"
                                                                                placeholder="Masukkan Nama Lengkap"
                                                                                value="{{ $user->user_name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="user_phone">No Telp <span
                                                                                    style="color:red">*</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="user_phone" id="user_phone"
                                                                                value="{{ $user->user_phone }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="user_description">Deskripsi
                                                                                Employee </label>
                                                                            <textarea name="user_description" class="form-control" cols="30" rows="10">
                                                                              {{ $user->user_description }}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="user_address">Alamat <span
                                                                                    style="color:red">*</span></label>
                                                                            <textarea name="user_address" id="user_address" cols="30" rows="10" class="form-control">
                                                                              {{ $user->user_address }}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="user_branch">Cabang <span
                                                                                    style="color:red">*</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="user_branch" id="user_branch"
                                                                                value="{{ $user->user_branch }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="role_id">Hak Akses <span
                                                                                    style="color:red">*</span></label>
                                                                            <select name="role_id" id="role_id"
                                                                                class="form-select">
                                                                                <option selected hidden
                                                                                    value="{{ $user->role_id }}">
                                                                                    {{ $user->role->role_description }}
                                                                                </option>
                                                                                @foreach ($roles as $role)
                                                                                    <option value="{{ $role->role_id }}">
                                                                                        {{ $role->role_description }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="status">Status <span
                                                                                    style="color:red">*</span></label>
                                                                            <select name="status" id="status"
                                                                                class="form-select">
                                                                                <option selected hidden>=== Pilih Status ===
                                                                                </option>
                                                                                <option value="active">Active</option>
                                                                                <option value="magang">Magang</option>
                                                                                <option value="resign">Resign</option>
                                                                                <option value="dipecat">Dipecat</option>
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
            $('#table-employee').DataTable();
        });


        $(document).on("click", "#delete_user", function() {
            var user_id = $(this).data('id');
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
                        url: "/employees/" + user_id,
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
    @if (session('employee.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('employee.success') }}',
            })
        </script>
    @endif
    @if (session('employee.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('employee.error') }}',
            })
        </script>
    @endif
@endpush
