<!-- resources/views/users/pdf.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Customer</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .photo img {
            max-width: 50px;
            max-height: 50px;
        }
    </style>
</head>

<body>
    <h1>Data Customer - AMDK Santri</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Petugas</th>
                <th>Jumlah Transaksi</th>
                <th>Jumlah Barang Terjual</th>
                <th>Jumlah Total Penjualan</th>
                <th>Customer Name</th>
                <th>Customer Owner</th>
                <th>Customer Phone</th>
                <th>Customer Address</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $c)
                <tr>
                    <td>{{ $c->customer_id }}</td>
                    <td>{{ $c->user->user_name }}</td>
                    <td>{{ $c->sales->count() }}</td>
                    <td>{{ $c->sales->sum('sale_quantity') }}</td>
                    <td>{{ 'Rp. ' . number_format($c->sales->sum('sale_total')) }}</td>
                    <td>{{ $c->customer_name }}</td>
                    <td>{{ $c->customer_owner }}</td>
                    <td>{{ $c->customer_phone }}</td>
                    <td>{{ $c->customer_address }}</td>
                    <td>{{ $c->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
