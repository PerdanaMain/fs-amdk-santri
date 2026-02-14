@extends('layouts.dashboard.index')

@section('title')
    Piutang (Account Receivable)
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Piutang (Penjualan Belum Lunas)</h4>
                        
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-receivable">
                                <thead>
                                    <tr>
                                        <th>Nama Customer</th>
                                        <th>Nama Barang</th>
                                        <th>Total Piutang</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Status Pembayaran</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $s)
                                        <tr>
                                            <td>{{ $s->customer->customer_name }}</td>
                                            <td>{{ $s->stock->stock_name }}</td>
                                            <td>Rp {{ number_format($s->sale_total, 0, ',', '.') }}</td>
                                            <td>{{ $s->sale_date ? date('d-m-Y', strtotime($s->sale_date)) : '-' }}</td>
                                            <td>
                                                <label
                                                    class="badge {{ $s->payment_status == 'Lunas' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $s->payment_status }}
                                                </label>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm" id="pay_sales"
                                                    data-id="{{ $s->sale_id }}">
                                                    <i class="mdi mdi-cash-multiple me-1"></i> Terima Pembayaran
                                                </button>
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
            $('#table-receivable').DataTable();
        });

        $(document).on("click", "#pay_sales", function() {
            var sale_id = $(this).data('id');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin mengubah status pembayaran menjadi Lunas?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Terima!'
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
                        }
                    });
                }
            })
        })
    </script>
@endpush
