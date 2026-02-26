@extends('layouts.dashboard.index')

@section('title')
    Finances
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            {{-- Finance Detail --}}
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <h4 class="card-title">Total Debit</h4>
                                <h2 class="text-success">Rp {{ number_format($totalDebet, 0, ',', '.') }}</h2>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <h4 class="card-title">Total Kredit</h4>
                                <h2 class="text-danger">Rp {{ number_format($totalCredit, 0, ',', '.') }}</h2>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <h4 class="card-title">Total Saldo</h4>
                                <h2 class="text-primary">Rp {{ number_format($totalDebet - $totalCredit, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Keuangan</h4>
                        <div class="d-block my-4">
                            @if (!in_array(session()->get('user')->role_id, [3, 4, 5, 6]))
                                <button type="button" class="btn btn-primary me-2 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#addModal">Add Keuangan</button>
                            @endif

                            <button type="button" class="btn btn-success me-2 mb-3" data-bs-toggle="modal"
                                data-bs-target="#exportModal">Export Keuangan</button>

                            {{-- Add modal --}}
                            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Add Transaction</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('finance.store') }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="finance_name">Nama Transaksi <span
                                                                        style="color: red"> *</span></label>
                                                                <input type="text" class="form-control" id="finance_name"
                                                                    name="finance_name"
                                                                    placeholder="Masukkan nama transaksi">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="finance_credit">Jumlah Kredit <span
                                                                        style="color: red"> *</span></label>
                                                                <input type="text" class="form-control"
                                                                    id="finance_credit" name="finance_credit"
                                                                    placeholder="Masukkan jumlah kredit">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-">
                                                            <div class="form-group">
                                                                <label for="finance_description">Deskripsi <span
                                                                        style="color: red"> *</span></label>
                                                                <textarea name="finance_description" id="finance_description" cols="30" rows="10" class="form-control"></textarea>
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
                                            <h5 class="modal-title" id="exportModalLabel">Export Transaction</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('finance.export') }}">
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
                                                                <input type="date" class="form-control"
                                                                    name="end_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="finance_name">Format <span style="color: red">
                                                                        *</span></label>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <input type="radio" name="format"
                                                                            id="format" value="1" checked>
                                                                        Excel
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <input type="radio" name="format"
                                                                            id="format" value="2"> PDF
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
                            <table class="table table-striped" id="table-finance">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Transaksi</th>
                                        <th>Customer</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Dreskripsi</th>
                                        <th>Tgl Transaksi</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($finances as $finance)
                                        <tr>
                                            <td>{{ $finance->finance_code }}</td>
                                            <td>{{ $finance->finance_name }}</td>
                                            <td>{{ $finance->sale->customer->customer_name ?? '-' }}</td>
                                            <td>Rp {{ number_format($finance->finance_debet, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($finance->finance_credit, 0, ',', '.') }}</td>
                                            <td>{{ $finance->finance_description }}</td>
                                            <td>{{ $finance->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}</td>
                                            <td>
                                                <a class="nav-link" id="StockDropdown" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                                    aria-labelledby="StockDropdown">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#infoModal-{{ $finance->finance_id }}"><i
                                                            class="dropdown-item-icon mdi mdi-information-outline me-2"></i>
                                                        Info </button>

                                                    @if (substr($finance->finance_code, 0, 1) == 'O')
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#updateModal-{{ $finance->finance_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                            Update</button>
                                                        @if (in_array(session()->get('user')->role_id, [2]))
                                                            <button class="dropdown-item" id="delete_finance"
                                                                data-id="{{ $finance->finance_id }}"><i
                                                                    class="dropdown-item-icon mdi mdi-delete-outline me-2"></i>
                                                                Delete</button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Info modal --}}
                                        <div class="modal fade" id="infoModal-{{ $finance->finance_id }}" tabindex="-1"
                                            aria-labelledby="infoModal-{{ $finance->finance_id }}Label"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="infoModal-{{ $finance->finance_id }}Label">Info
                                                            Transaction
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-12">
                                                                <p>
                                                                    <b>Type transaksi: </b>
                                                                    @if (substr($finance->finance_code, 0, 1) == 'O')
                                                                        <label class="badge badge-primary">
                                                                            Operasional
                                                                        </label>
                                                                    @else
                                                                        @if (substr($finance->finance_code, 0, 1) == 'S')
                                                                            <label class="badge badge-warning">
                                                                                Penjualan
                                                                            </label>
                                                                        @else
                                                                            <label class="badge badge-success">
                                                                                Pembelian
                                                                            </label>
                                                                        @endif
                                                                    @endif

                                                                </p>
                                                                <p>
                                                                    <b>Kode transaksi: </b>
                                                                    {{ $finance->finance_code }}
                                                                </p>
                                                                <p>
                                                                    <b>Debet: </b>
                                                                    Rp
                                                                    {{ number_format($finance->finance_debet, 0, ',', '.') }}
                                                                </p>

                                                                <p>
                                                                    <b>Kredit: </b>
                                                                    Rp
                                                                    {{ number_format($finance->finance_credit, 0, ',', '.') }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <p>
                                                                    <b>Transaksi: </b>
                                                                    {{ $finance->finance_name }}
                                                                </p>
                                                                <p>
                                                                    <b>Deskripsi: </b>
                                                                    {{ $finance->finance_description }}
                                                                </p>
                                                                <p>
                                                                    <b>Tanggal: </b>
                                                                    {{ date_format(date_create($finance->created_at), 'd-m-Y') }}
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
                                        <div class="modal fade" id="updateModal-{{ $finance->finance_id }}"
                                            tabindex="-1" aria-labelledby="updateModal-{{ $finance->finance_id }}Label"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="updateModal-{{ $finance->finance_id }}Label">Update
                                                            Transaction</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <form class="forms-sample" method="POST"
                                                                action="{{ route('finance.update', ['id' => $finance->finance_id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="finance_name">Nama Transaksi <span
                                                                                    style="color: red"> *</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="finance_name" name="finance_name"
                                                                                placeholder="Masukkan nama transaksi"
                                                                                value="{{ $finance->finance_name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="finance_credit">Jumlah Kredit <span
                                                                                    style="color: red"> *</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="finance_credit" name="finance_credit"
                                                                                placeholder="Masukkan jumlah kredit"
                                                                                value="{{ $finance->finance_credit }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-">
                                                                        <div class="form-group">
                                                                            <label for="finance_description">Deskripsi
                                                                                <span style="color: red"> *</span></label>
                                                                            <textarea name="finance_description" id="finance_description" cols="30" rows="10" class="form-control">
                                                                                {{ $finance->finance_description }}
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
            $('#table-finance').DataTable();
        });

        $(document).on("click", "#delete_finance", function() {
            var finance_id = $(this).data('id');
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
                        type: "DELETE",
                        url: "/finance/" + finance_id,
                        data: {
                            "id": finance_id,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Oops...',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(err) {
                            Swal.fire(
                                'Oops...',
                                err.responseJSON.message,
                                'error'
                            );
                        }
                    });
                }
            });
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
    @if (session('finance.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('finance.success') }}',
            })
        </script>
    @endif
    @if (session('finance.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('finance.error') }}',
            })
        </script>
    @endif
@endpush
