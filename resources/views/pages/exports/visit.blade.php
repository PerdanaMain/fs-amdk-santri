<!-- resources/views/users/pdf.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Kunjungan</title>

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
    <h1>Data Kunjungan - AMDK Santri</h1>
    <table>
        <thead>
            <tr>
                <th>PIC Customer</th>
                <th>Nama Customer</th>
                <th>Deskripsi</th>
                <th>Bukti Kunjungan</th>
                <th>Tanggal Kunjungan</th>
            </tr>


        </thead>
        <tbody>
            @foreach ($visits as $index => $visit)
                <tr>
                    <td>{{ $visit->user->user_name }}</td>
                    <td>{{ $visit->customer->customer_name }}</td>
                    <td>{{ $visit->visit_description }}</td>
                    <td class="photo">
                        <img src="{{ public_path('storage/visits/' . $visit->visit_photo) }}" alt="Bukti Kunjungan">
                    </td>
                    <td>{{ $visit->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
