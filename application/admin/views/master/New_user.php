<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Konfigurasi User</title>
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
    $url = site_url('new_user/simpan');
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
                <h1>Konfigurasi User</h1>
            </div>
            <div class="card-body">
                <form action="<?= $url; ?>" method="post">
                    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Input Nama" value="" required>
                        <p>
                            <?= form_error('nama'); ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Input Username" value=""
                               max="25"
                               required>
                        <p>
                            <?= form_error('username'); ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Input Password"
                               value="" required>
                        <p>
                            <?= form_error('password'); ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" name="email" placeholder="Input E-mail" value=""
                               required>
                        <p>
                            <?= form_error('email'); ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
