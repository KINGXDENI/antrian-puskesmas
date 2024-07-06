<!DOCTYPE html>
<html>

<head>
    <title>Print All Data Pasien</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            margin: 0 auto;
            padding: 20px;
        }

        .header,
        .footer {
            text-align: center;
            margin: 20px 0;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="header">
            <h1>Data Pasien</h1>
        </div>
        <div class="content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pasien</th>
                        <th>No Identitas</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Username</th>
                        <th>Pengguna BPJS</th>
                        <th>No BPJS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pasien as $p) : ?>
                        <tr>
                            <td><?= $p->id_pasien ?></td>
                            <td><?= $p->no_identitas ?></td>
                            <td><?= $p->nama ?></td>
                            <td><?= $p->jenis_kelamin ?></td>
                            <td><?= $p->tgl_lahir ?></td>
                            <td><?= $p->alamat ?></td>
                            <td><?= $p->no_telp ?></td>
                            <td><?= $p->username ?></td>
                            <td><?= $p->pengguna_bpjs ?></td>
                            <td><?= $p->no_bpjs ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>&copy; <?= date('Y') ?> Your Company</p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>