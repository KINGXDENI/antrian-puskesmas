<!-- Morris Charts CSS -->
<link href="css/plugins/morris.css" rel="stylesheet">
<div class="container">
    <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Laporan Poli Umum</h2>

    <form method="POST" action="<?php echo base_url('admin/LaporanPoliUmum'); ?>">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="poli">Jenis Poli</label>
                    <select class="form-control" id="poli" name="poli">
                        <option value="">Pilih Poli</option>
                        <?php foreach ($poli_names as $id => $name) : ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="periode">Periode</label>
                    <select class="form-control" id="periode" name="periode">
                        <option value="">Pilih Periode</option>
                        <option value="weekly">Mingguan</option>
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-2 text-center">
                <button type="submit" class="btn btn-dark">Cari</button>
            </div>
        </div>
    </form>

    <?php if (!empty($data_view)) : ?>
        <div class="row mt-5">
            <div class="col-lg-12">
                <h2>Laporan <?php echo $poli_names[$poli_id]; ?> - <?php echo ucfirst($periode); ?></h2>
                <?php if (empty($data_view)) : ?>
                    <div class="alert alert-warning" role="alert">
                        Tidak ada data untuk periode ini.
                    </div>
                <?php else : ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo ucfirst($periode); ?></th>
                                <th>Jumlah Pasien</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_view as $data) : ?>
                                <tr>
                                    <td><?php echo $data->date; ?></td>
                                    <td><?php echo !empty($data->total) ? $data->total : 0; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="js/jquery.js"></script>
<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>