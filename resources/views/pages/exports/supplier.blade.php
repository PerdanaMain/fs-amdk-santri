<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Laporan Data Supplier</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Nama Pemilik</th>
                <th>No Telpon</th>
                <th>Alamat</th>
                <th>Deskripsi</th>
                <th>Koordinat</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $s)
                <tr>
                    <td>{{ $s->supplier_id }}</td>
                    <td>{{ $s->supplier_name }}</td>
                    <td>{{ $s->supplier_owner }}</td>
                    <td>{{ $s->supplier_phone }}</td>
                    <td>{{ $s->supplier_address }}</td>
                    <td>{{ $s->supplier_description }}</td>
                    <td>{{ $s->supplier_coordinate ?? '-' }}</td>
                    <td>{{ $s->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
