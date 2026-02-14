<!-- resources/views/pages/exports/asset.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Aset</title>

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
    <h1>Data Aset - AMDK Santri</h1>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Tanggal Pembelian</th>
                <th>Harga Beli</th>
                <th>Life Time</th>
                <th>Deviasi / Bulan</th>
                <th>Nilai Saat Ini</th>
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
                    <td>Rp {{ number_format($asset->current_value, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
