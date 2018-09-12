<?php include "master/Header.php"; ?>
<body>
<?php include 'master/Menu.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($toko != NULL) {
        $tokoid = $toko->t_kode;
        $namatoko = $toko->t_nama;
        $singkatan = $toko->t_singkatan;
        $url = $toko->t_url;
        $provinsi = $toko->t_provinsi;
        $kabupaten = $toko->t_kabupaten;
        $kecamatan = $toko->t_kecamatan;
        $kelurahan = $toko->t_desa;
        $kodepos = $toko->t_kodepos;
        $alamat = $toko->t_alamat;
        $email = $toko->t_email;
        $instagram = $toko->t_insta;
        $whatsapp = $toko->t_wa;
        $line = $toko->t_line;
    } else {
        $tokoid = $id;
        $namatoko = '';
        $singkatan = '';
        $url = '';
        $provinsi = '';
        $kabupaten = '';
        $kecamatan = '';
        $kelurahan = '';
        $kodepos = '';
        $alamat = '';
        $email = '';
        $instagram = '';
        $whatsapp = '';
        $line = '';
    }
}
?>
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
        <?php if (isset($_SESSION['validation']) && $_SESSION['validation'] != ""): ?>
            <div class="col">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['validation']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal'] != ""): ?>
            <div class="col">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['gagal']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] != ""): ?>
            <div class="col">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['berhasil']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h1>Logo</h1>
                        </div>
                        <div class="card-body">
                            <a class="btn btn-primary" data-toggle="modal" href="#" onclick="unggah()"
                               data-target="#upload"
                               data-backdrop="static" data-keyboard="false"><i class="fa fa-plus mr-2"></i>Upload Logo</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h1>Icon</h1>
                        </div>
                        <div class="card-body">
                            <a class="btn btn-primary" data-toggle="modal" href="#" onclick="unggah()"
                               data-target="#upload"
                               data-backdrop="static" data-keyboard="false"><i class="fa fa-plus mr-2"></i>Upload Icon</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h1>Toko</h1>
                </div>
                <form action="<?= site_url('toko/simpan'); ?>" method="post" enctype="multipart/form-data"
                      class="card-body">
                    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="t_kode" value="<?= $tokoid; ?>">
                    <div class="row form-group">
                        <div class="col">
                            <label for="nama">Nama Toko</label>
                            <input type="text" class="form-control" name="nama"
                                   placeholder="Nama Toko (max 50 karakter)" value="<?= $namatoko; ?>" required>
                        </div>
                        <div class="col">
                            <label for="singkatan">Kode Toko</label>
                            <input type="text" class="form-control" name="singkatan" placeholder="Kode (max 2 karakter)"
                                   value="<?= $singkatan; ?>"
                                   required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label for="url">URL</label>
                            <input type="text" class="form-control" name="url"
                                   placeholder="URL Toko"
                                   value="<?= $url; ?>"
                                   required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label for="provinsi">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="provinsi form-control"
                                    value="<?= $provinsi; ?>" required>
                            </select>
                        </div>
                        <div class="col">
                            <label for="kabupaten">Kabupaten / Kota</label>
                            <select name="kabupaten" id="kabupaten" class="kabupaten form-control"
                                    value="<?= $kabupaten; ?>" required>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label for="kecamatan">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="kecamatan form-control"
                                    value="<?= $kecamatan; ?>" required>
                            </select>
                        </div>
                        <div class="col">
                            <label for="kelurahan">Kelurahan / Desa</label>
                            <select name="kelurahan" id="kelurahan" class="kelurahan form-control"
                                    value="<?= $kelurahan; ?>" required>
                            </select>
                        </div>

                        <div class="col">
                            <label for="kodepos">Kode Pos</label>
                            <input name="kodepos" id="kodepos" type="number"
                                   class="form-control" placeholder="Kode Pos" value="<?= $kodepos; ?>" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label class="f-test" for="alamat">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" class="form-control"
                                      placeholder="Nama Gedung, Jalan, dan lainnya"

                                      required><?= $alamat; ?></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" name="email" placeholder="E-mail"
                                   value="<?= $email; ?>" required>
                        </div>
                        <div class="col">
                            <label for="instagram">Instagram</label>
                            <input type="text" class="form-control" name="instagram" value="<?= $instagram; ?>"
                                   placeholder="Instagram">
                        </div>
                        <div class="col">
                            <label for="whatsapp">Whatsapp</label>
                            <input type="text" class="form-control" name="whatsapp" value="<?= $whatsapp; ?>"
                                   placeholder="Whatsapp">
                        </div>
                        <div class="col">
                            <label for="line">Line</label>
                            <input type="text" class="form-control" name="line" value="<?= $line; ?>"
                                   placeholder="Line">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
        <script>
            // ------------------------------------------------------ //
            // Modal CRUD
            // ------------------------------------------------------ //

            function tambah() {
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('users/tambah'); ?>");
            }

            function edit(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('users/ubah/'); ?>" + id);
            }

            function detil(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('users/detil/'); ?>" + id);
            }

            function unggah_logo(data) {
                d = data;
                id = d.attr('data-id');

                modal = $('#upload');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('upload/logo'); ?>" + id);
            }

            function unggah_icon(data) {
                d = data;
                id = d.attr('data-id');

                modal = $('#upload');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('upload/icon'); ?>" + id);
            }

            function hapus(data) {
                d = data;
                id = d.attr('data-id');
                $('a#hapus').attr('href', "<?= site_url('users/hapus/'); ?>" + id);
            }

            // ------------------------------------------------------ //
            // Data table users
            // ------------------------------------------------------ //
            $('#tables').DataTable();

            $(document).ready(function () {
                $('[tooltip]').tooltip();
            });

            // ------------------------------------------------------ //
            // Remove after 5 second
            // ------------------------------------------------------ //

            $(document).ready(function () {
                setTimeout(function () {
                    if ($('[role="alert"]').length > 0) {
                        $('[role="alert"]').remove();
                    }
                }, 5000);
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#provinsi').select2({
                    theme: 'bootstrap4',
                    placeholder: 'Pilih provinsi',
                    ajax: {
                        url: '<?= site_url('API/get_provinsi'); ?>',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term
                            };
                        }
                    }
                });
                $('#kabupaten').select2({
                    theme: 'bootstrap4',
                    placeholder: 'Pilih kabupaten',
                    ajax: {
                        url: '<?= site_url('API/get_kabupaten'); ?>',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term,
                                provinsi: $('#provinsi').val()
                            };
                        }
                    }
                });
                $('#kecamatan').select2({
                    theme: 'bootstrap4',
                    placeholder: 'Pilih kecamatan',
                    ajax: {
                        url: '<?= site_url('API/get_kecamatan'); ?>',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term, // search term
                                kabupaten: $('#kabupaten').val()
                            };
                        }
                    }
                });
                $('#kelurahan').select2({
                    theme: 'bootstrap4',
                    placeholder: 'Pilih kelurahan / desa',
                    ajax: {
                        url: '<?= site_url('API/get_kelurahan'); ?>',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term,
                                kecamatan: $('#kecamatan').val()
                            };
                        }
                    }
                }).on('select2:select', function () {
                    var id = $(this).val();
                    $.get('<?= site_url('API/get_kodepos/'); ?>' + id, function (res) {
                        $('#kodepos').val(res);
                    })
                });
            });
        </script>
        <script>
            var provinsi = $('#provinsi');
            var kabupaten = $('#kabupaten');
            var kecamatan = $('#kecamatan');
            var kelurahan = $('#kelurahan');

            $.when(
                $.getJSON('<?= site_url('API/get_provinsi/'); ?>' + <?= $provinsi; ?>, function (res) {
                    provinsi.append(new Option(
                        res.results[0].text, res.results[0].id, true, true
                    )).trigger('change');
                    provinsi.trigger({
                        type: 'select2:select',
                        params: {
                            data: res
                        }
                    })
                }),
                $.getJSON('<?= site_url('API/get_kabupaten/'); ?>' + <?= $kabupaten; ?>, function (res) {
                    kabupaten.append(new Option(
                        res.results[0].text, res.results[0].id, true, true
                    )).trigger('change');
                    kabupaten.trigger({
                        type: 'select2:select',
                        params: {
                            data: res
                        }
                    })
                }),
                $.getJSON('<?= site_url('API/get_kecamatan/'); ?>' + <?= $kecamatan; ?>, function (res) {
                    kecamatan.append(new Option(
                        res.results[0].text, res.results[0].id, true, true
                    )).trigger('change');
                    kecamatan.trigger({
                        type: 'select2:select',
                        params: {
                            data: res
                        }
                    })
                }),
                $.getJSON('<?= site_url('API/get_kelurahan/'); ?>' + <?= $kelurahan; ?>, function (res) {
                    kelurahan.append(new Option(
                        res.results[0].text, res.results[0].id, true, true
                    )).trigger('change');
                    kelurahan.trigger({
                        type: 'select2:select',
                        params: {
                            data: res
                        }
                    })
                })
            );

        </script>
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
<div class="modal fade" id="crud" tabindex="-1" role="dialog" aria-labelledby="crud" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">

            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="hapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">

            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <a id="hapus" href="#" class="btn btn-sm btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="crudfoto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>


</body>
</html>
