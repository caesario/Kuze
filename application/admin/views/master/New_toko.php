<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Konfigurasi Toko</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/select2/select2-bootstrap4.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/all.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/font-awesome.min.css'); ?>"
          type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/css/fontastic.css'); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="<?= base_url('assets/css/grasp_mobile_progress_circle-1.0.0.min.css'); ?>">

    <link rel="stylesheet"
          href="<?= base_url('assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.default.css'); ?>">

    <style>
        .show > .btn-primary.dropdown-toggle:focus {
            box-shadow: none;
        }

        .btn-group-sm > .btn, .btn-sm {
            border-radius: 0;
        }

        .form-control {
            border-radius: 0;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #258141;
            box-shadow: none;
        }

        .custom-file-label {
            border-radius: 0;
        }

        .custom-file-input:focus ~ .custom-file-label {
            border-color: #258141;
            box-shadow: none;
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/datatable/css/dataTables.bootstrap4.min.css'); ?>">
    <link rel="shortcut icon" href="<?= base_url('upload/' . $icon); ?>">

    <!-- Javascript files-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="<?= base_url('assets/vendor/popper.js/umd/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatable/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatable/js/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/grasp_mobile_progress_circle-1.0.0.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery.cookie/jquery.cookie.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/loadingoverlay/loadingoverlay.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/loadingoverlay/loadingoverlay_progress.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-ellipsis/jquery.ellipsis.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/wnumb/wNumb.js'); ?>"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=omulajpwx33earwq4t3xfgo7zbqaoey3a7cd3zipl90xlzbu"></script>

    <!-- Main File-->
    <script src="<?= base_url('assets/js/front.js'); ?>"></script>
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $tokoid = $id;
    $namatoko = '';
    $singkatan = '';
    $url = base_url();
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
?>
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
        <div class="card">
            <div class="card-header">
                <h1>Konfigurasi Toko</h1>
            </div>
            <form action="<?= site_url('new_toko/simpan'); ?>" method="post" enctype="multipart/form-data"
                  class="card-body">
                <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="t_kode" value="<?= $tokoid; ?>">
                <div class="row form-group">
                    <div class="col">
                        <label for="logo">Logo</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo">
                            <label class="custom-file-label" for="logo">Pilih Logo...</label>
                        </div>
                    </div>
                    <div class="col">
                        <label for="icon">Icon</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="icon" name="icon">
                            <label class="custom-file-label" for="icon">Pilih Icon...</label>
                        </div>
                    </div>
                </div>
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
                    <button type="submit" class="btn btn-primary">Selanjutnya</button>
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


</body>
</html>
