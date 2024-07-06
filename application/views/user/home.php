<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Antrian Puskesmas </title>
  <link rel="shortcut icon" href="assets/user/img/logo.png">

  <!-- Custom fonts for this theme -->
  <link href="<?php echo base_url('assets/user') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Theme CSS -->
  <link href="<?php echo base_url('assets/user') ?>/css/freelancer.min.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/user') ?>/lib/noty.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/user') ?>/lib/themes/metroui.css" rel="stylesheet">

</head>
<style type="text/css">
  .btncostume {
    background: #2c3e50;
    color: white;
  }

  sup {
    color: red;
  }

  .border1 {
    border: thin solid;
  }

  .costum {
    background: white;
    border: thin solid #fff;
  }

  .masthead .masthead-avatar {
    width: 8rem !important;
  }

  .disabled {
    pointer-events: none;
    opacity: 0.5;
  }
</style>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">PUSKESMAS SURANADI</a>
      <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <?php if (empty($this->session->userdata('id_pasien'))) { ?>
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" data-toggle="modal" data-target="#loginModal">Login</a>
            </li>
          <?php } else { ?>
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#"><?php echo $this->session->userdata('nama'); ?></a>
            </li>
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="<?php echo base_url('Index/logout') ?>">Logout</a>
            </li>
          <?php } ?>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#bantuan">Bantuan</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- Masthead -->
  <header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">

      <!-- Masthead Avatar Image -->


      <!-- Masthead Heading -->
      <h1 class="masthead-heading text-uppercase mb-0"><img class="masthead-avatar mb-5" src="<?php echo base_url('assets/user') ?>/img/logo.png" alt="">Puskesmas Suranadi</h1>
      <div class="row">
        <div class="col-md-12" style="border: thin solid;">
          <h3>ANTRIAN SAAT INI</h3>
          <h1 style="margin-top: 5px;">
            <?php
            if (isset($status_antrian)) {
              if ($status_antrian == 'pending') {
                echo 'pending';
              } elseif ($status_antrian == 'approved') {
                echo $no_antrian;
              } elseif ($status_antrian == 'rejected') {
                echo 'ditolak';
              } else {
                echo $no_antrian;
              }
            } else {
              echo $no_antrian;
            }
            ?>
          </h1>
        </div>
      </div>
      <?php if (!empty($this->session->userdata('id_pasien'))) { ?>
        <div class="row" style="margin-top: 60px">
          <div class="col-md-3" style="border: thin solid;">
            <h3><?php echo isset($poli_umum) ? $poli_umum : 0; ?></h3>
            <h6>Poli Umum</h6>
          </div>
          <div class="col-md-3" style="border: thin solid;">
            <h3><?php echo isset($poli_gigi) ? $poli_gigi : 0; ?></h3>
            <h6>Poli Gigi</h6>
          </div>
          <div class="col-md-3" style="border: thin solid;">
            <h3><?php echo isset($poli_anak) ? $poli_anak : 0; ?></h3>
            <h6>Poli Imunisasi</h6>
          </div>
          <div class="col-md-3" style="border: thin solid;">
            <h3><?php echo isset($poli_tb) ? $poli_tb : 0; ?></h3>
            <h6>Poli Tuberculosis</h6>
          </div>
          <div class="col-md-3" style="border: thin solid;">
            <h3><?php echo isset($poli_konseling) ? $poli_konseling : 0; ?></h3>
            <h6>Poli Konseling</h6>
          </div>
          <div class="col-md-3" style="border: thin solid;">
            <h3><?php echo isset($poli_kia) ? $poli_kia : 0; ?></h3>
            <h6>Poli KIA</h6>
          </div>
          <div class="col-md-3" style="border: thin solid;">
            <h3><?php echo isset($poli_gizi) ? $poli_gizi : 0; ?></h3>
            <h6>Poli Gizi</h6>
          </div>
        </div>
      <?php } ?>

      <?php if (empty($this->session->userdata('id_pasien'))) { ?>
        <h4 class="masthead mb-0" style="margin-top: 10px !important;padding: 20px;">Selamat Datang di Puskesmas Suranadi.
          <br> Jika anda belum memiliki akun, silakan Registrasi terlebih dahulu.
        </h4>
        <button type="button" class="btn btncostume" data-toggle="modal" data-target="#exampleModal">
          BUAT AKUN
        </button>
      <?php } ?>
      <!-- Icon Divider -->
      <div class="divider-custom divider-light">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
          <i class="fas fa-star"></i>
        </div>
        <div class="divider-custom-line"></div>
      </div>

      <!-- Masthead Subheading -->
      <?php
      $id_pasien = $this->session->userdata('id_pasien');
      $id_pasienNew = $this->session->userdata('id_pasienNew');

      if (!empty($id_pasienNew)) {
        $id_to_use = $id_pasienNew;
      } else {
        $id_to_use = $id_pasien;
      }

      if (!empty($id_to_use)) {
      ?>
        <div class="row" style="width: 60%;">
          <div class="col-md-5 text-right">
            <label>
              <h5>Nomor Antrian Anda :</h5>
            </label>
          </div>
          <div class="col-md-2 text-justify">
            <h5><?php echo $antrian_pasien ?></h5>
          </div>
          <?php if (!empty($id_antrian_poli)) { ?>
            <div class="col-md-5">
              <a href="<?php echo base_url('Index/cetak') . "/" . $id_antrian_poli ?>" style="color: #000; background: #fff; padding: 10px;" target="_blank" <?php if (isset($status_antrian) && ($status_antrian == 'pending' || $status_antrian == 'rejected')) echo 'class="disabled" style="pointer-events: none; opacity: 0.5;"'; ?>>
                Cetak
              </a>
            </div>
          <?php } ?>
        </div>
        <div class="row" style="width: 60%;">
          <div class="col-md-5 text-right">
            <label>
              <h5>Poli :</h5>
            </label>
          </div>
          <div class="col-md-5 text-justify">
            <h5><?php echo $nama_poli ?></h5>
          </div>
        </div>
      <?php } ?>


    </div>
  </header>

  <!-- Portfolio Section -->
  <section class="page-section portfolio" id="registrasi">
    <?php if (!empty($this->session->userdata('id_pasien'))) { ?>
      <div class="container">

        <div class="text-center mb-4">
          <button type="button" class="btn btn-dark mr-2" data-toggle="modal" data-target="#newRegistrationModal" onclick="showNewPatientForm()">Pasien Baru</button>
          <button type="button" class="btn btn-dark" onclick="showExistingPatientForm()">Pasien Lama</button>
        </div>



        <div>
          <!-- Form Pencarian NIK -->
          <div id="existingPatientForm" style="display:none;" class="row justify-content-md-center" style="margin-top: 20px">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5>Cari Pasien Berdasarkan NIK</h5>
                </div>
                <div class="card-body">
                  <form id="searchForm" method="post">
                    <div class="row">
                      <div class="col-md-2">
                        <h6><label>NIK</label></h6>
                      </div>
                      <div class="col-md-5">
                        <input type="text" name="nik" id="nik" class="form-control" required>
                      </div>
                      <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Cari</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Tampilkan data user di sini -->
          <div id="patientData" style="display:none;">
            <div class="row justify-content-md-center">
              <div class="col-md-12" style="margin-top: 20px">
                <div class="card">
                  <div class="card-header">
                    <h5>Data Pasien</h5>
                  </div>
                  <div class="card-body">
                    <p><strong>Nomor KTP:</strong> <span id="no_identitas"></span></p>
                    <p><strong>Nama:</strong> <span id="nama"></span></p>
                    <p><strong>Jenis Kelamin:</strong> <span id="jenis_kelamin"></span></p>
                    <p><strong>Tanggal Lahir:</strong> <span id="tgl_lahir"></span></p>
                    <p><strong>Alamat:</strong> <span id="alamat"></span></p>
                    <p><strong>No Telepon:</strong> <span id="no_telp"></span></p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Display previous poli visits -->
            <div class="row justify-content-md-center" style="margin-top: 20px">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Riwayat Poli</h5>
                  </div>
                  <div class="card-body">
                    <ul id="riwayat_poli">
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="antrianData" style="display:none;" class="mt-3">
            <!-- Portfolio Section Heading -->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Ambil Antrian</h2>

            <!-- Icon Divider -->
            <div class="divider-custom">
              <div class="divider-custom-line"></div>
              <div class="divider-custom-icon">
                <i class="fas fa-star"></i>
              </div>
              <div class="divider-custom-line"></div>
            </div>

            <!-- Portfolio Grid Items -->
            <div class="row">
              <div class="container">
                <div class="row justify-content-md-center">
                  <div class="col-md-12" style="margin-top: 20px">
                    <!-- <h1 align="center">Login </h1> -->
                    <form action="<?php echo base_url('Index/saveAntrian') ?>" method="post">
                      <div class="row">
                        <div class="col-md-2">
                          <h6><label>Pilih Poli</label></h6>
                        </div>

                        <div class="col-md-5">
                          <select name="id_poli" id="id_poli" class="form-control" onchange="noAntrian(this.value)">
                            <option value=""> pilih </option>
                            <?php foreach ($getPoli as $row) {
                            ?>
                              <option value="<?php echo $row->id_poli; ?>"> <?php echo $row->kode_poli; ?> </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-2">
                          <h6><label>No Antrian Poli</label></h6>
                        </div>

                        <div class="col-md-5">
                          <input type="text" name="no_antrian_poli2" id="no_antrian_poli2" value="" disabled="" class="form-control">
                          <input type="hidden" name="no_antrian_poli" id="no_antrian_poli" value="" class="form-control">
                          <input type="hidden" name="no_antrian" value="<?php echo $no_antrian ?>">
                        </div>
                      </div>


                      <div class="row text-right">
                        <div class="col-md-7">
                          <input type="submit" name="simpan" id="simpan" value="Ambil Antrian" class="btn btn-primary">
                        </div>
                      </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
        </div>
        <div id="antrian" style="display:none;">
          <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Ambil Antrian</h2>

          <!-- Icon Divider -->
          <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
              <i class="fas fa-star"></i>
            </div>
            <div class="divider-custom-line"></div>
          </div>

          <!-- Portfolio Grid Items -->
          <div class="row">
            <div class="container">
              <div class="row justify-content-md-center">
                <div class="col-md-12" style="margin-top: 20px">
                  <!-- <h1 align="center">Login </h1> -->
                  <form action="<?php echo base_url('Index/saveAntrian') ?>" method="post">
                    <div class="row">
                      <div class="col-md-2">
                        <h6><label>Pilih Poli</label></h6>
                      </div>

                      <div class="col-md-5">
                        <select name="id_poli" id="id_poli" class="form-control" onchange="noAntrian(this.value)">
                          <option value=""> pilih </option>
                          <?php foreach ($getPoli as $row) {
                          ?>
                            <option value="<?php echo $row->id_poli; ?>"> <?php echo $row->kode_poli; ?> </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-2">
                        <h6><label>No Antrian Poli</label></h6>
                      </div>

                      <div class="col-md-5">
                        <input type="text" name="no_antrian_poli2" id="no_antrian_poli2New" value="" disabled="" class="form-control">
                        <input type="hidden" name="no_antrian_poli" id="no_antrian_poliNew" value="" class="form-control">
                        <input type="hidden" name="no_antrianNew" value="<?php echo $no_antrian ?>">
                      </div>
                    </div>


                    <div class="row text-right">
                      <div class="col-md-7">
                        <input type="submit" name="simpan" id="simpanNew" value="Ambil Antrian" class="btn btn-primary">
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>


      </div>

    <?php } ?>
  </section>

  <!-- About Section -->
  <section class="page-section bg-primary text-white mb-0" id="bantuan">
    <div class="container">

      <!-- About Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-white">Bantuan</h2>

      <!-- Icon Divider -->
      <div class="divider-custom divider-light">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
          <i class="fas fa-star"></i>
        </div>
        <div class="divider-custom-line"></div>
      </div>

      <!-- About Section Content -->
      <div class="container">
        <div class="row">
          <div class="col-lg-4.ml-auto" align="center">
            <p class="lead">Klik Login > Pilih Poli > Klik Cetak</p>
            <p class="lead">Pasien melakukan Registrasi > Input Nomor Identitas, Nama Pasien, Jenis Kelamin, Usia, Tanggal Lahir, Alamat, Nomor Telephone, Username dan Password > Klik Login > Pilih Poli > Klik Cetak </p>
          </div>
        </div>
      </div>
      <!-- About Section Button -->
      <!-- <div class="text-center mt-4">
        <a class="btn btn-xl btn-outline-light" href="https://startbootstrap.com/themes/freelancer/">
          <i class="fas fa-download mr-2"></i>
          Free Download!
        </a>
      </div> -->
      <!-- </div>
    </div> -->
  </section>




  <!-- Footer -->
  <footer class="footer text-center">
    <div class="container">
      <div class="row">

        <!-- Footer Location -->
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h4 class="text-uppercase mb-4">Location</h4>
          <p class="lead mb-0">Suranadi, Kec. Narmada, Kabupaten Lombok Barat,
            <br>Nusa Tenggara Bar. 83371
        </div>

        <!-- Footer About Text -->
        <div class="col-lg-6">
          <h4 class="text-uppercase mb-4">Telephone</h4>

          <p class="lead mb-0">(0370)7563363</p>
        </div>

      </div>
    </div>
  </footer>

  <!-- Copyright Section -->
  <section class="copyright py-4 text-center text-white">
    <div class="container">
      <small>&copy; 20241Q - PKM SURANADI </small>
    </div>
  </section>

  <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
  <div class="scroll-to-top d-lg-none position-fixed ">
    <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
      <i class="fa fa-chevron-up"></i>
    </a>
  </div>

  <!-- Modal -->
  <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Registrasi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo base_url('Index/registrasi') ?>" method="post">


            <div>
              <label>Username <sup>*</sup></label>
              <input type="text" id="username" name="username" class="form-control" value="" placeholder="Username" required="">
            </div>

            <div>
              <label>Password <sup>*</sup></label>
              <input type="password" id="password" name="password" class="form-control" value="" placeholder="Password" required="">
            </div>
            <div>
              <label>No Telephone</label>
              <input type="no_telp" id="no_telp" name="no_telp" class="form-control" value="" placeholder="No Telephone">
            </div>
            <br><br>
            <div align="right">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal Registrasi Baru -->
  <div class="modal fade bd-example-modal-lg" id="newRegistrationModal" tabindex="-1" role="dialog" aria-labelledby="newRegistrationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newRegistrationModalLabel">Registrasi Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo base_url('Index/new_registration') ?>" method="post">
            <!-- Isian Username -->
            <div>
              <label>Nomor KTP <sup>*</sup></label>
              <input type="text" id="no_identitas" name="no_identitas" class="form-control" value="" placeholder="Nomor KTP" required="">
            </div>

            <div>
              <label>Nama <sup>*</sup></label>
              <input type="text" id="nama" name="nama" class="form-control" value="" placeholder="Nama" required="">
            </div>

            <div>
              <label>Jenis Kelamin</label>
              <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                <option value="">Pilih</option>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>

            <div>
              <label>Tanggal Lahir <sup>*</sup></label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control" value="" placeholder="Tanggal Lahir" required="">
            </div>

            <div>
              <label>Apakah Pengguna BPJS <sup>*</sup></label>
              <input type="radio" class="form-control" name="pengguna_bpjs" value="Ya" onclick="toggleBPJSField(true)">YA
              <input type="radio" class="form-control" name="pengguna_bpjs" value="Tidak" onclick="toggleBPJSField(false)">Tidak
            </div>

            <div id="bpjsField" style="display: none;">
              <label>Masukkan Nomor BPJS<sup>*</sup></label>
              <input type="number" class="form-control" name="nomor_bpjs">
            </div>

            <div>
              <label>Alamat</label>
              <textarea id="alamat" name="alamat" class="form-control" placeholder="Alamat"></textarea>
            </div>

            <br><br>
            <div align="right">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo base_url('Index/proses_login') ?>" method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" class="form-control">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-dark">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo base_url('assets/user') ?>/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url('assets/user') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="<?php echo base_url('assets/user') ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact Form JavaScript -->
  <script src="<?php echo base_url('assets/user') ?>/js/jqBootstrapValidation.js"></script>
  <script src="<?php echo base_url('assets/user') ?>/js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="<?php echo base_url('assets/user') ?>/js/freelancer.min.js"></script>
  <script src="<?php echo base_url('assets/user') ?>/lib/noty.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#searchForm').on('submit', function(event) {
        event.preventDefault();
        var nik = $('#nik').val();

        $.ajax({
          url: '<?php echo base_url('Index/cariPasienByNIK'); ?>',
          method: 'POST',
          data: {
            nik: nik
          },
          dataType: 'json',
          success: function(response) {
            if (response.data_pasien) {
              $('#no_identitas').text(response.data_pasien.no_identitas);
              $('#nama').text(response.data_pasien.nama);
              $('#jenis_kelamin').text(response.data_pasien.jenis_kelamin);
              $('#tgl_lahir').text(response.data_pasien.tgl_lahir);
              $('#alamat').text(response.data_pasien.alamat);
              $('#no_telp').text(response.data_pasien.no_telp);

              var riwayatPoliHtml = '';
              response.data_poli.forEach(function(poli) {
                riwayatPoliHtml += '<li>' + poli.nama_poli + '</li>';
              });
              $('#riwayat_poli').html(riwayatPoliHtml);

              $('#patientData').show();
              $('#antrianData').show();
            } else {
              alert('Pasien tidak ditemukan');
              $('#patientData').hide();
            }
          }
        });
      });
    });
  </script>

  <script type="text/javascript">
    function noAntrian(id_poli) {
      console.log(id_poli);
      if (id_poli != "") {
        $.ajax({
          url: "<?php echo base_url('Index/getNoAntrian'); ?>",
          type: "POST",
          data: "id_poli=" + id_poli,
          datatype: "json",
          success: function(response) {
            try {
              var output = JSON.parse(response);
              console.log("Parsed output: ", output); // Debug
              if (output.no > output.maks) {
                $("#no_antrian_poli2").val('Data Sudah Penuh');
                $("#simpan").prop("disabled", true);
              } else {
                $("#no_antrian_poli").val(output.no_hasil);
                $("#no_antrian_poli2").val(output.no_hasil);
                $("#no_antrian").val(output.no); // Set the hidden input with the 'no' value
                $("#simpan").prop("disabled", false);

                $("#no_antrian_poliNew").val(output.no_hasil);
                $("#no_antrian_poli2New").val(output.no_hasil);
                $("#no_antrianNew").val(output.no); // Set the hidden input with the 'no' value
                $("#simpanNew").prop("disabled", false);
              }
            } catch (e) {
              console.error("Parsing error: ", e);
              $("#no_antrian_poli2").val('Error retrieving data');
              $("#simpan").prop("disabled", true);
            }
          },
          error: function(xhr, status, error) {
            console.error("AJAX Error: ", status, error); // Debug
            $("#no_antrian_poli2").val('Error retrieving data');
            $("#simpan").prop("disabled", true);
          }
        });
      } else {
        $("#no_antrian_poli").val("");
        $("#no_antrian_poli2").val("");
        $("#no_antrian").val(""); // Clear the hidden input
      }
    }

    function showNewPatientForm() {
      document.getElementById('existingPatientForm').style.display = 'none';
    }

    function showExistingPatientForm() {
      document.getElementById('existingPatientForm').style.display = 'block';
      <?php $this->session->set_flashdata('poli', null);  ?>
    }

    function toggleBPJSField(show) {
      document.getElementById('bpjsField').style.display = show ? 'block' : 'none';
    }
  </script>


  <?php
  if ($this->session->flashdata('notif')) {
  ?>
    <script type="text/javascript">
      // Get the flashdata values from PHP
      var text = '<?php echo $this->session->flashdata('pesan'); ?>';
      var type = '<?php echo $this->session->flashdata('type'); ?>';
      // Show the notification
      new Noty({
        text: text,
        timeout: 3000,
        theme: "metroui",
        type: type,
      }).show();

      // Check if the notification type is "success" and the text is "Registrasi baru berhasil!"
      if (type === 'success' && text === 'Registrasi baru berhasil!') {
        // Set the session variable 'poli' to true
        <?php $this->session->set_flashdata('poli', true); ?>

        // Display the element with ID "antrian"
        document.getElementById('antrian').style.display = 'block';
      }

      // Clear the session flash data
      <?php
      $this->session->set_flashdata('notif', null);
      $this->session->set_flashdata('pesan', null);
      $this->session->set_flashdata('type', null);
      ?>
    </script>
  <?php
  } elseif ($this->session->flashdata('poli')) {
  ?>
    <script type="text/javascript">
      // Display the element with ID "antrian"
      document.getElementById('antrian').style.display = 'block';
    </script>
  <?php
  }
  ?>




</body>

</html>