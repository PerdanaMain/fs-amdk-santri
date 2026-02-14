@extends('layouts.dashboard.index')

@section('title')
    Detail Customer
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Customer</h4>
                        <div class="row">
                            <div class="col-md-4">
                                @if ($customer->customer_photo == null)
                                    <img src="{{ url('dashboards/images/faces/face1.jpg') }}" alt="image"
                                        class="img-fluid rounded" style="width: 100%; max-width: 300px;" />
                                @else
                                    <img src="{{ url('storage/customers/' . $customer->customer_photo) }}" alt="image"
                                        class="img-fluid rounded" style="width: 100%; max-width: 300px;" />
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Nama Customer:</strong> {{ $customer->customer_name }}</p>
                                        <p><strong>Nama Pemilik:</strong> {{ $customer->customer_owner }}</p>
                                        <p><strong>No Telepon:</strong> {{ $customer->customer_phone }}</p>
                                        <p><strong>Alamat:</strong> {{ $customer->customer_address }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Koordinat:</strong>
                                            @if ($customer->customer_coordinate)
                                                <a href="https://www.google.com/maps?q={{ $customer->customer_coordinate }}"
                                                    target="_blank">{{ $customer->customer_coordinate }}</a>
                                            @else
                                                -
                                            @endif
                                        </p>
                                        <p><strong>Petugas:</strong> {{ $customer->user->user_name ?? '-' }}</p>
                                        <p><strong>Deskripsi:</strong> {{ $customer->customer_description ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Riwayat Transaksi</h4>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-transaction">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Petugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer->sales as $index => $sale)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d-m-Y H:i') }}</td>
                                            <td>{{ $sale->stock->stock_name }}</td>
                                            <td>{{ $sale->sale_quantity }} {{ $sale->stock->stock_satuan }}</td>
                                            <td>Rp {{ number_format($sale->sale_total, 0, ',', '.') }}</td>
                                            <td>
                                                <label class="badge 
                                                    {{ $sale->status->status_id == 1 || $sale->status->status_id == 3 ? 'badge-warning' : 
                                                      ($sale->status->status_id == 2 || $sale->status->status_id == 4 ? 'badge-success' : 
                                                      ($sale->status->status_id == 5 ? 'badge-danger' : 'badge-primary')) }}">
                                                    {{ $sale->status->status_description }}
                                                </label>
                                            </td>
                                            <td>{{ $sale->user->user_name }}</td>
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
            $('#table-transaction').DataTable({
                "order": [] // Disable initial sort, let blade loop order prevail (which is by created_at desc)
            });
        });
    </script>
@endpush
