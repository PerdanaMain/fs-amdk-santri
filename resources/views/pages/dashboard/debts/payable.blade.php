@extends('layouts.dashboard.index')

@section('title')
    Hutang (Account Payable)
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="card-title card-title-dash">Total Hutang</h4>
                                <h2 class="text-primary">Rp
                                    {{ number_format($purchases->sum('purchase_total'), 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title">Data Hutang (Pembelian Belum Lunas)</h4>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#exportModal">
                                <i class="mdi mdi-file-export"></i> Export Data
                            </button>
                        </div>

                        {{-- Export modal --}}
                        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exportModalLabel">Export Data Hutang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <form class="forms-sample" method="POST"
                                                action="{{ route('debts.payable.export') }}">
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

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-payable">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Pembelian</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Hutang</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Tgl Transaksi</th>
                                        <th>Status Pembayaran</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $p)
                                        <tr>
                                            <td>{{ $p->stock->stock_name }}</td>
                                            <td>{{ $p->purchase_quantity }} {{ $p->stock->stock_satuan }}</td>
                                            <td>Rp {{ number_format($p->purchase_price, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($p->purchase_total, 0, ',', '.') }}</td>
                                            <td>-</td> {{-- Purchase table doesn't have due date yet, unlike Sales --}}
                                            <td>{{ $p->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}
                                            </td>
                                            <td>
                                                <label
                                                    class="badge {{ $p->payment_status == 'Lunas' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $p->payment_status }}
                                                </label>
                                            </td>
                                            <td>
                                                @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
                                                    <button class="btn btn-success btn-sm" id="pay_purchase"
                                                        data-id="{{ $p->purchase_id }}">
                                                        <i class="mdi mdi-cash-multiple me-1"></i> Bayar
                                                    </button>
                                                @else
                                                    <button class="btn btn-secondary btn-sm" disabled>
                                                        -
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
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
            $('#table-payable').DataTable();
        });

        $(document).on("click", "#pay_purchase", function() {
            var purchase_id = $(this).data('id');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin melunasi hutang ini?",
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
                        }
                    });
                }
            })
        })
    </script>
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
