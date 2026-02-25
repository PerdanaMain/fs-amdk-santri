<!DOCTYPE html>
<html>

<head>
    <title>Laporan Stok</title>

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
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <h1>Data Stok - AMDK Santri</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Stok</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $stock->stock_name }}</td>
                    <td>{{ $stock->stock_quantity }}</td>
                    <td>{{ $stock->stock_satuan }}</td>
                    <td>{{ $stock->stock_description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
