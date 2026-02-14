@extends('layouts.dashboard.index')

@section('title')
    Visits
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
                        <h4 class="card-title">Data Kunjungan Karyawan</h4>
                        <div class="d-block my-4">
                            <button type="button" class="btn btn-primary me-2 mb-3" data-bs-toggle="modal"
                                data-bs-target="#addModal">Tambah Kunjungan</button>

                            @if (in_array(session()->get('user')->role_id, [1, 2, 3, 5, 6]))
                                <button type="button" class="btn btn-success me-2 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">Export Kunjungan</button>
                            @endif
                        </div>

                        {{-- Add modal --}}
                        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addModalLabel">Add New Kunjungan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <form class="forms-sample" method="POST" action="{{ route('visit.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="visit_photo">Bukti Kunjungan <span
                                                            style="color:red">*</span></label>
                                                    <input type="file" class="form-control" name="visit_photo">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="customer_id">Customer <span
                                                                    style="color:red">*</span></label>
                                                            <select id="customer_id" class="form-select" name="customer_id">
                                                                <option></option>
                                                                @foreach ($customers as $c)
                                                                    <option value="{{ $c->customer_id }}"
                                                                        data-phone="{{ $c->customer_phone }}"
                                                                        data-address="{{ $c->customer_address }}">
                                                                        {{ $c->customer_name }} -
                                                                        {{ $c->user->user_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="visit_description">Deskripsi Kunjungan <span
                                                                    style="color:red">*</span></label>
                                                            <textarea name="visit_description" class="form-control" cols="30" rows="10"></textarea>
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

                        {{-- Export modal --}}
                        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exportModalLabel">Export Kunjungan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <form class="forms-sample" method="POST" action="{{ route('visit.export') }}">
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

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-purchase">
                                <thead>
                                    <tr>
                                        <th>Nama Employee</th>
                                        <th>Nama Customer</th>
                                        <th>Deskripsi</th>
                                        <th>Bukti Kunjungan</th>
                                        <th>Tanggal Kunjungan</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visits as $visit)
                                        <tr>
                                            <td>{{ $visit->user->user_name }}</td>
                                            <td>{{ $visit->customer->customer_name }}</td>
                                            <td>{{ $visit->visit_description }}</td>
                                            <td>
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#proofModal-{{ $visit->visit_id }}">
                                                    Bukti </button>
                                            </td>
                                            <td>{{ $visit->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <a class="nav-link" id="StockDropdown" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                                    aria-labelledby="StockDropdown">

                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#updateModal-{{ $visit->visit_id }}"><i
                                                            class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                        Update </button>
                                                    @if ($user->role->role_id == 1 || $user->role->role_id == 3)
                                                        @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
                                                            <button class="dropdown-item"
                                                                data-id="{{ $visit->visit_id }}" id="delete_visit"><i
                                                                    class="dropdown-item-icon mdi mdi-close me-2"></i>
                                                                Delete</button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- Proof modal --}}
                                            <div class="modal fade" id="proofModal-{{ $visit->visit_id }}"
                                                tabindex="-1" aria-labelledby="proofModal" aria-hidden="true">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="proofModal">Bukti Kunjungan
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('storage/visits/' . $visit->visit_photo) }}"
                                                                alt="{{ $visit->visit_photo }}"
                                                                style="width: 300px; height:300px">
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
                                            <div class="modal fade" id="updateModal-{{ $visit->visit_id }}"
                                                tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateModal">Update Kunjungan
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('visit.update', ['id' => $visit->visit_id]) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="visit_photo">Bukti Kunjungan
                                                                            </label>
                                                                            <input type="file" class="form-control"
                                                                                name="visit_photo">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="customer_id">Customer <span
                                                                                    style="color:red">*</span></label>
                                                                            <select id="customer_id" class="form-select"
                                                                                name="customer_id">
                                                                                <option selected hidden
                                                                                    value="{{ $visit->customer->customer_id }}">
                                                                                    {{ $visit->customer->customer_name }}
                                                                                </option>
                                                                                @foreach ($customers as $c)
                                                                                    <option value={{ $c->customer_id }}>
                                                                                        {{ $c->customer_name . ' - ' . $c->user->user_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="visit_description">Deskripsi
                                                                                Kunjungan
                                                                                <span style="color:red">*</span></label>
                                                                            <textarea name="visit_description" class="form-control" cols="30" rows="10">
                                                                                {{ $visit->visit_description }}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-block">
                                                                    <button class="btn btn-primary"
                                                                        type="submit">Submit</button>
                                                                    <button class="btn btn-light" type="button"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </form>
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

        $(document).on("click", "#delete_visit", function() {
            let visit_id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: '/visits/' + visit_id,
                        data: {
                            visit_id: visit_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.status == true) {
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    data.message,
                                    'error'
                                )
                            }
                        },
                        error: function(err) {
                            Swal.fire(
                                'Failed!',
                                err.responseJSON.message,
                                'error'
                            )
                        }
                    });
                }
            });
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
    @if (session('visit.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('visit.success') }}',
            })
        </script>
    @endif
    @if (session('visit.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('visit.error') }}',
            })
        </script>
    @endif
@endpush
