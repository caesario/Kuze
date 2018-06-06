<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css"
          integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?= base_url('assets/css/fontastic.css'); ?>">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="<?= base_url('assets/css/grasp_mobile_progress_circle-1.0.0.min.css'); ?>">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet"
          href="<?= base_url('assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css'); ?>">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.default.css" id="theme-stylesheet'); ?>">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/rzslider/rzslider.min.css'); ?>">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico'); ?>">
    <script>
        var base_url = '<?= base_url(); ?>';
        var hashing = '<?= $this->security->get_csrf_hash(); ?>';
    </script>
    <script src="<?= base_url('assets/vendor/rzslider/rzslider.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/app.js'); ?>"></script>
</head>
<body>
<?php include_once('master/Menu.php'); ?>
<div class="page">
    <!-- navbar-->
    <header class="header">
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                    <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i
                                    class="icon-bars"> </i></a><a href="<?= base_url('adm.php/dashboard') ?>"
                                                                  class="navbar-brand">
                            <div class="brand-text d-none d-md-inline-block"><strong
                                        class="text-primary"><?= $brandname; ?></strong></div>
                        </a></div>
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <li class="nav-item"><a href="<?= base_url('adm.php/auth/logout') ?>" class="nav-link logout">Logout<i
                                        class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <br>
    <section>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2>Alamat</h2>

                </div>
                <div class="card-body">
                    <form action="<?= site_url('customers/alamat/' . $id . '/tambah'); ?>" method="post">
                        <input type="hidden" name="token_fg" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" name="judul" placeholder="Input Judul" required>
                            <p>
                                <?= form_error('judul'); ?>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="provinsi">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control">
                                <option value="">Pilih Provinsi</option>
                            </select>
                            <p>
                                <?= form_error('provinsi'); ?>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="kabupaten">Kabupaten</label>
                            <select name="kabupaten" id="kabupaten" class="form-control">
                                <option value="">Pilih Kabupaten</option>
                            </select>
                            <p>
                                <?= form_error('kabupaten'); ?>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-control">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            <p>
                                <?= form_error('KecamatanM'); ?>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="desa">Desa</label>
                            <select name="desa" id="desa" class="form-control">
                                <option value="">Pilih Desa</option>
                            </select>
                            <p>
                                <?= form_error('desa'); ?>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="kodepos">Kodepos</label>
                            <input type="text" class="form-control" name="kodepos" id="kodepos"
                                   placeholder="Input Kodepos" required>
                            <p>
                                <?= form_error('kodepos'); ?>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="alamat_lengkap">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" cols="30"
                                      rows="10"></textarea>
                            <p>
                                <?= form_error('alamat_lengkap'); ?>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="penerima_nama">Nama Penerima</label>
                            <input type="text" class="form-control" name="penerima_nama"
                                   placeholder="Input Nama Penerima" required>
                            <p>
                                <?= form_error('judul'); ?>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="penerima_nomor">Nomor Kontak</label>
                            <input type="text" class="form-control" name="penerima_nomor"
                                   placeholder="Input Nomor Kontak" required>
                            <p>
                                <?= form_error('judul'); ?>
                            </p>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><?= $submit; ?></button>
                            <button type="button" onclick="window.location.reload()" class="btn btn-danger">Tutup
                            </button>
                            <a href="<?= site_url('customers/alamat/' . $id); ?>" class="btn btn-danger">Kembali</a>
                        </div>
                        <?php if (isset($berhasil)): ?>
                            <p class="text-success"><?= $berhasil; ?></p>
                        <?php endif; ?>
                        <?php if (isset($gagal)): ?>
                            <p class="text-danger"><?= $gagal; ?></p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <footer class="main-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <p><?= $brandname; ?> &copy; 2018</p>
                </div>

            </div>
        </div>
    </footer>
</div>
<!-- Javascript files-->
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/popper.js/umd/popper.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/grasp_mobile_progress_circle-1.0.0.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/jquery.cookie/jquery.cookie.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/chart.js/Chart.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/loadingoverlay/loadingoverlay.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/loadingoverlay/loadingoverlay_progress.min.js'); ?>"></script>
<!-- Main File-->
<script src="<?= base_url('assets/js/front.js'); ?>"></script>
</body>
</html>
