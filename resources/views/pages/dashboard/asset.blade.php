@extends('layouts.dashboard.index')

@section('title')
    Manajemen Aset
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Aset</h4>
                        <div class="d-block my-4">
                            @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    <i class="mdi mdi-plus"></i> Tambah Aset
                                </button>
                                
                                {{-- Export Buttons --}}
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-export"></i> Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('assets.export') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="format" value="1">
                                                <button type="submit" class="dropdown-item">Excel</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('assets.export') }}" method="POST">
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
                                            <h5 class="modal-title" id="addModalLabel">Tambah Aset Baru</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="forms-sample" method="POST" action="{{ route('assets.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="asset_name">Nama Aset <span
                                                            style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="asset_name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="purchase_date">Tanggal Pembelian <span
                                                            style="color:red">*</span></label>
                                                    <input type="date" class="form-control" name="purchase_date" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="purchase_price">Harga Beli <span
                                                            style="color:red">*</span></label>
                                                    <input type="number" class="form-control" name="purchase_price"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="asset_photo">Foto Aset</label>
                                                    <input type="file" class="form-control" name="asset_photo">
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
                            <table class="table table-striped" id="table-assets">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Aset</th>
                                        <th>Tgl Beli</th>
                                        <th>Harga Beli</th>
                                        <th>Life Time</th>
                                        <th>Deviasi / Bulan</th>
                                        <th>Nilai Aset Saat Ini</th>
                                        <th>Foto</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assets as $asset)
                                        <tr>
                                            <td>{{ $asset->asset_code }}</td>
                                            <td>{{ $asset->asset_name }}</td>
                                            <td>{{ date('d-m-Y', strtotime($asset->purchase_date)) }}</td>
                                            <td>Rp {{ number_format($asset->purchase_price, 0, ',', '.') }}</td>
                                            <td>{{ $asset->lifetime_years }} Tahun</td>
                                            <td>Rp {{ number_format($asset->depreciation_per_month, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge badge-success">
                                                    Rp {{ number_format($asset->current_value, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($asset->asset_photo)
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#photoModal-{{ $asset->asset_id }}">
                                                        Lihat Foto
                                                    </button>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#updateModal-{{ $asset->asset_id }}">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" id="delete_asset"
                                                    data-id="{{ $asset->asset_id }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- Photo Modal --}}
                                        @if ($asset->asset_photo)
                                            <div class="modal fade" id="photoModal-{{ $asset->asset_id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Foto Aset: {{ $asset->asset_name }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ url('storage/assets/' . $asset->asset_photo) }}"
                                                                alt="Foto Aset" class="img-fluid" style="max-height: 400px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Update Modal --}}
                                        <div class="modal fade" id="updateModal-{{ $asset->asset_id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Aset</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="forms-sample" method="POST"
                                                            action="{{ route('assets.update', $asset->asset_id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label>Kode Aset <span style="color:red">*</span></label>
                                                                <input type="text" class="form-control" name="asset_code"
                                                                    value="{{ $asset->asset_code }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nama Aset <span style="color:red">*</span></label>
                                                                <input type="text" class="form-control" name="asset_name"
                                                                    value="{{ $asset->asset_name }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tanggal Pembelian <span
                                                                        style="color:red">*</span></label>
                                                                <input type="date" class="form-control"
                                                                    name="purchase_date"
                                                                    value="{{ $asset->purchase_date }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Harga Beli <span style="color:red">*</span></label>
                                                                <input type="number" class="form-control"
                                                                    name="purchase_price"
                                                                    value="{{ $asset->purchase_price }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Ganti Foto (Opsional)</label>
                                                                <input type="file" class="form-control"
                                                                    name="asset_photo">
                                                            </div>
                                                            <div class="d-block">
                                                                <button type="submit"
                                                                    class="btn btn-primary me-2">Update</button>
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
            $('#table-assets').DataTable();
        });

        $(document).on("click", "#delete_asset", function() {
            var asset_id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/assets/" + asset_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire(
                                    'Terhapus!',
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
                        }
                    });
                }
            })
        })
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            })
        </script>
    @endif
@endpush
