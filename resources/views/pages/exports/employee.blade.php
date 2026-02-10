<!-- resources/views/users/pdf.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Pegawai</title>

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
    <h1>Data Pegawai - AMDK Santri</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Hak Akses</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Email</th>
                <th>No Telp</th>
                <th>Jumlah Customer</th>
                <th>Jumlah Transaksi</th>
                <th>Address</th>
                <th>Branch</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $u)
                <tr>
                    <td>{{ $u->user_id }}</td>
                    <td>{{ $u->role->role_description }}</td>
                    <td>{{ $u->user_name }}</td>
                    <td>{{ $u->status }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->user_phone }}</td>
                    <td>{{ $u->customers->count() }}</td>
                    <td>{{ $u->sales->count() }}</td>
                    <td>{{ $u->user_address }}</td>
                    <td>{{ $u->user_branch }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
