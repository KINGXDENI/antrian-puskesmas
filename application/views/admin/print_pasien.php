<!DOCTYPE html>
<html>

<head>
    <title>Cetak Data Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Detail Pasien</h2>
    <table>
        <tr>
            <th>No Identitas</th>
            <td><?php echo $pasien->no_identitas; ?></td>
        </tr>
        <tr>
            <th>Nama</th>
            <td><?php echo $pasien->nama; ?></td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td><?php echo $pasien->jenis_kelamin; ?></td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td><?php echo $pasien->tgl_lahir; ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?php echo $pasien->alamat; ?></td>
        </tr>
        <tr>
            <th>No Telepon</th>
            <td><?php echo $pasien->no_telp; ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?php echo $pasien->username; ?></td>
        </tr>
        <tr>
            <th>Pengguna BPJS</th>
            <td><?php echo $pasien->pengguna_bpjs ? 'Ya' : 'Tidak'; ?></td>
        </tr>
        <tr>
            <th>No BPJS</th>
            <td><?php echo $pasien->no_bpjs; ?></td>
        </tr>
    </table>
</body>

</html>