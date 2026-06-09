<!-- resources/views/users/pdf.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Penjualan</title>

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
    <h1>Data Penjualan - AMDK Santri</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Customer</th>
                <th>Alamat Customer</th>
                <th>Pembayaran</th>
                <th>Nama Barang</th>
                <th>Jumlah Penjualan</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>PIC Customer</th>
                <th>Jatuh Tempo</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->sale_id }}</td>
                    <td>{{ $sale->customer->customer_name }}</td>
                    <td>{{ $sale->customer->customer_address }}</td>
                    <td>{{ $sale->payment->payment_name }}</td>
                    <td>{{ $sale->stock->stock_name }}</td>
                    <td>{{ $sale->sale_quantity . ' ' . $sale->stock->stock_satuan }}</td>
                    <td>{{ number_format($sale->sale_price, 0, ',', '.') }}</td>
                    <td>{{ number_format($sale->sale_total, 0, ',', '.') }}</td>
                    <td>{{ $sale->user->user_name }}</td>
                    <td>{{ $sale->sale_date }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold;">Total</td>
                <td style="font-weight: bold;">{{ $sales->sum('sale_quantity') }}</td>
                <td></td>
                <td style="font-weight: bold;">{{ number_format($sales->sum('sale_total'), 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
