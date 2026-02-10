<!-- resources/views/users/pdf.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Pembelian</title>

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
    <h1>Data Pembelian - AMDK Santri</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Jumlah Barang</th>
                <th>Harga Barang</th>
                <th>Total Harga</th>
                <th>Diajukan Kepada</th>
                <th>Tanggal Pengajuan</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($purchase as $p)
                <tr>
                    <td>{{ $p->purchase_id }}</td>
                    <td>{{ $p->stock->stock_name }}</td>
                    <td>{{ $p->purchase_quantity }}</td>
                    <td>{{ number_format($p->purchase_price, 0, ',', '.') }}</td>
                    <td>{{ number_format($p->purchase_total, 0, ',', '.') }}</td>
                    <td>{{ $p->user->user_name }}</td>
                    <td>{{ $p->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
