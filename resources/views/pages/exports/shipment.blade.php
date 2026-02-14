<!DOCTYPE html>
<html>

<head>
    <title>Data Pengiriman</title>
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
    </style>
</head>

<body>
    <h1>Data Pengiriman - AMDK Santri</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Pengiriman</th>
                <th>Nama Customer</th>
                <th>Alamat Customer</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shipments as $shipment)
                <tr>
                    <td>{{ $shipment->shipment_id }}</td>
                    <td>{{ $shipment->shipment_code ?? '-' }}</td>
                    <td>{{ $shipment->sale->customer->customer_name }}</td>
                    <td>{{ $shipment->sale->customer->customer_address }}</td>
                    <td>{{ $shipment->sale->stock->stock_name }}</td>
                    <td>{{ $shipment->sale->sale_quantity . ' ' . $shipment->sale->stock->stock_satuan }}</td>
                    <td>{{ $shipment->shipment_status }}</td>
                    <td>{{ $shipment->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
