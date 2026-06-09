<!-- resources/views/users/pdf.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Keuangan</title>

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
    <h1>Data Keuangan - AMDK Santri</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Transaksi</th>
                <th>Jenis Transaksi</th>
                <th>Nama Transaksi</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Deskripsi</th>
                <th>Tanggal Transaksi</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($finances as $index => $finance)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $finance->finance_code }}</td>
                    <td>
                        @switch(substr($finance->finance_code, 0, 1))
                            @case('O')
                                Operasional
                            @break

                            @case('P')
                                Purchasing
                            @break

                            @case('S')
                                Sales
                            @break

                            @default
                        @endswitch
                    </td>
                    <td>{{ $finance->finance_name }}</td>
                    <td>{{ number_format($finance->finance_debet, 0, ',', '.') }}</td>
                    <td>{{ number_format($finance->finance_credit, 0, ',', '.') }}</td>
                    <td>{{ $finance->finance_description }}</td>
                    <td>{{ $finance->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Total</td>
                <td style="font-weight: bold;">{{ $purchase->sum('purchase_quantity') }}</td>
                <td></td>
                <td style="font-weight: bold;">{{ number_format($purchase->sum('purchase_total'), 0, ',', '.') }}</td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
