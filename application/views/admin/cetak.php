<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran</title>
    <link href="<?php echo base_url('assets/user') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/user') ?>/css/freelancer.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/user') ?>/lib/noty.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/user') ?>/lib/themes/metroui.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
        }

        .card {
            width: 100%;
            border: 1px solid #000;
            padding: 20px;
            margin: 20px auto;
        }

        .list-group-item {
            border: none;
            padding: 5px 0;
        }

        .list-group-item h3,
        .list-group-item h4,
        .list-group-item h5,
        .list-group-item h6,
        .list-group-item p {
            margin: 5px 0;
        }

        .list-group-item h8 {
            font-size: 0.875rem;
        }

        .barcode {
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <script type="text/javascript">
        window.print();
    </script>
</head>

<body>
    <div class="card">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center">
                <h3>BUKTI PENDAFTARAN ONLINE PASIEN RAWAT JALAN</h3>
            </li>
            <li class="list-group-item text-center">
                <h4>ANTRIAN</h4>
                <h1><?php echo $row->no_antrian_poli; ?></h1>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-6">
                        <p>POLI</p>
                    </div>
                    <div class="col-6">
                        <p>: <?php echo $row->nama_poli ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>NAMA</p>
                    </div>
                    <div class="col-6">
                        <p>: <?php echo $nama_pasien; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>NIK</p>
                    </div>
                    <div class="col-6">
                        <p>: <?php echo $no_identitas; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>TANGGAL LAHIR</p>
                    </div>
                    <div class="col-6">
                        <p>: <?php echo $tgl_lahir; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>ALAMAT</p>
                    </div>
                    <div class="col-6">
                        <p>: <?php echo $alamat; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>NO. HP</p>
                    </div>
                    <div class="col-6">
                        <p>: <?php echo $no_hp; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>NAMA DOKTER</p>
                    </div>
                    <div class="col-6">
                        <p>: <?php echo $nama_dokter; ?></p>
                    </div>
                </div>
                <p class="text-center">Bukti pendaftaran offline ini berlaku pada tanggal <?php echo date('d - m - Y'); ?> pukul 08.00 s.d 10:00 WIB</p>
            </li>
        </ul>
    </div>
</body>

</html>