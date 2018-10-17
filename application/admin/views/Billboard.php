<?php include "master/Header.php"; ?>
<body>
<?php include 'master/Menu.php'; ?>
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
    <section class="mr-3 ml-3">

        <?php if (isset($_SESSION['validation']) && $_SESSION['validation'] != ""): ?>
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['validation']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal'] != ""): ?>
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['gagal']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] != ""): ?>
            <div class="row">
                <div class="col">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['berhasil']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Billboard</h1>
                        <p class="card-text">Klip Foto</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <p>Preview 1</p>
                                <?php if ($img1 != NULL): ?>
                                    <img class="img-fluid mx-auto d-block"
                                         src="data:<?= $img1->blb_type . ';base64,' . (base64_encode($img1->blb_data)); ?>"
                                         alt="<?= $img1->blb_judul; ?>">
                                <?php else: ?>
                                    <img class="img-fluid mx-auto d-block"
                                         src="<?= base_url('assets/img/noimage.jpg'); ?>" alt="No Image">
                                <?php endif; ?>
                                <div class="mt-4"></div>
                                <p>Preview 2</p>
                                <?php if ($img2 != NULL): ?>
                                    <img class="img-fluid mx-auto d-block"
                                         src="data:<?= $img2->blb_type . ';base64,' . (base64_encode($img2->blb_data)); ?>"
                                         alt="<?= $img2->blb_judul; ?>">
                                <?php else: ?>
                                    <img class="img-fluid mx-auto d-block"
                                         src="<?= base_url('assets/img/noimage.jpg'); ?>" alt="No Image">
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <p>Preview 3</p>
                                <?php if ($img3 != NULL): ?>
                                    <img class="img-fluid mx-auto d-block"
                                         src="data:<?= $img3->blb_type . ';base64,' . (base64_encode($img3->blb_data)); ?>"
                                         alt="<?= $img3->blb_judul; ?>">
                                <?php else: ?>
                                    <img class="img-fluid mx-auto d-block"
                                         src="<?= base_url('assets/img/noimage.jpg'); ?>" alt="No Image">
                                <?php endif; ?>
                                <div class="mb-2"></div>
                            </div>
                            <div class="col">
                                <p>Preview 4</p>
                                <?php if ($img4 != NULL): ?>
                                    <img class="img-fluid mx-auto d-block"
                                         src="data:<?= $img4->blb_type . ';base64,' . (base64_encode($img4->blb_data)); ?>"
                                         alt="<?= $img4->blb_judul; ?>">
                                <?php else: ?>
                                    <img class="img-fluid mx-auto d-block"
                                         src="<?= base_url('assets/img/noimage.jpg'); ?>" alt="No Image">
                                <?php endif; ?>
                                <div class="mt-4"></div>
                                <p>Preview 5</p>
                                <?php if ($img5 != NULL): ?>
                                    <img class="img-fluid mx-auto d-block"
                                         src="data:<?= $img5->blb_type . ';base64,' . (base64_encode($img5->blb_data)); ?>"
                                         alt="<?= $img5->blb_judul; ?>">
                                <?php else: ?>
                                    <img class="img-fluid mx-auto d-block"
                                         src="<?= base_url('assets/img/noimage.jpg'); ?>" alt="No Image">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <h1>Foto</h1>
                                        <p class="card-text">Posisi Kiri Atas</p>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="upload_foto1">File</label>
                                            <div class="card-img-top" id="viewfoto1" style="display: none"></div>
                                            <button class="btn btn-sm btn-danger" id="cancel1" style="display: none;">
                                                Batal
                                            </button>
                                            <input class="form-control-file" type="file" name="upload_foto"
                                                   id="upload_foto1">
                                        </div>
                                        <div class="form-group">
                                            <div id="viewfoto1" style="display: none"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="judul1">Judul</label>
                                            <input class="form-control" type="text" name="judul" id="judul1"
                                                   placeholder="Judul"
                                                   value="<?= isset($img1->blb_judul) ? $img1->blb_judul : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="url1">URL</label>
                                            <input class="form-control" type="text" name="url" id="url1"
                                                   placeholder="URL"
                                                   value="<?= isset($img1->blb_url) ? $img1->blb_url : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="ket1">Keterangan</label>
                                            <textarea class="form-control" name="ket" id="ket1"
                                                      placeholder="Keterangan"><?= isset($img1->blb_ket) ? $img1->blb_ket : ''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="doupload1" class="btn btn-primary">Upload
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <h1>Foto</h1>
                                        <p class="card-text">Posisi Kiri Bawah</p>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="upload_foto2">File</label>
                                            <div class="card-img-top" id="viewfoto2" style="display: none"></div>
                                            <button class="btn btn-sm btn-danger" id="cancel2" style="display: none;">
                                                Batal
                                            </button>
                                            <input class="form-control-file" type="file" name="upload_foto"
                                                   id="upload_foto2">
                                        </div>
                                        <div class="form-group">
                                            <div id="viewfoto2" style="display: none"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="judul2">Judul</label>
                                            <input class="form-control" type="text" name="judul" id="judul2"
                                                   placeholder="Judul"
                                                   value="<?= isset($img2->blb_judul) ? $img2->blb_judul : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="url2">URL</label>
                                            <input class="form-control" type="text" name="url" id="url2"
                                                   placeholder="URL"
                                                   value="<?= isset($img2->blb_url) ? $img2->blb_url : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="ket2">Keterangan</label>
                                            <textarea class="form-control" name="ket" id="ket2"
                                                      placeholder="Keterangan"><?= isset($img2->blb_ket) ? $img2->blb_ket : ''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="doupload2" class="btn btn-primary">Upload
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <h1>Foto</h1>
                                        <p class="card-text">Posisi Tengah</p>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="upload_foto3">File</label>
                                            <div class="card-img-top" id="viewfoto3" style="display: none"></div>
                                            <button class="btn btn-sm btn-danger" id="cancel3" style="display: none;">
                                                Batal
                                            </button>
                                            <input class="form-control-file" type="file" name="upload_foto"
                                                   id="upload_foto3">
                                        </div>
                                        <div class="form-group">
                                            <label for="judul3">Judul</label>
                                            <input class="form-control" type="text" name="judul" id="judul3"
                                                   placeholder="Judul"
                                                   value="<?= isset($img3->blb_judul) ? $img3->blb_judul : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="url3">URL</label>
                                            <input class="form-control" type="text" name="url" id="url3"
                                                   placeholder="URL"
                                                   value="<?= isset($img3->blb_url) ? $img3->blb_url : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="ket3">Keterangan</label>
                                            <textarea class="form-control" name="ket" id="ket3"
                                                      placeholder="Keterangan"><?= isset($img3->blb_ket) ? $img3->blb_ket : ''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="doupload3" class="btn btn-primary">Upload
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <h1>Foto</h1>
                                        <p class="card-text">Posisi Kanan Atas</p>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="upload_foto4">File</label>
                                            <div class="card-img-top" id="viewfoto4" style="display: none"></div>
                                            <button class="btn btn-sm btn-danger" id="cancel4" style="display: none;">
                                                Batal
                                            </button>

                                            <input class="form-control-file" type="file" name="upload_foto"
                                                   id="upload_foto4">
                                        </div>
                                        <div class="form-group">
                                            <label for="judul4">Judul</label>
                                            <input class="form-control" type="text" name="judul" id="judul4"
                                                   placeholder="Judul"
                                                   value="<?= isset($img4->blb_judul) ? $img4->blb_judul : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="url4">URL</label>
                                            <input class="form-control" type="text" name="url" id="url4"
                                                   placeholder="URL"
                                                   value="<?= isset($img4->blb_url) ? $img4->blb_url : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="ket4">Keterangan</label>
                                            <textarea class="form-control" name="ket" id="ket4"
                                                      placeholder="Keterangan"><?= isset($img4->blb_ket) ? $img4->blb_ket : ''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="doupload4" class="btn btn-primary">Upload
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <h1>Foto</h1>
                                        <p class="card-text">Posisi Kanan Bawah</p>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="upload_foto5">File</label>
                                            <div class="card-img-top" id="viewfoto5" style="display: none"></div>
                                            <button class="btn btn-sm btn-danger" id="cancel5" style="display: none;">
                                                Batal
                                            </button>

                                            <input class="form-control-file" type="file" name="upload_foto"
                                                   id="upload_foto5">
                                        </div>
                                        <div class="form-group">
                                            <label for="judul5">Judul</label>
                                            <input class="form-control" type="text" name="judul" id="judul5"
                                                   placeholder="Judul"
                                                   value="<?= isset($img5->blb_judul) ? $img5->blb_judul : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="url5">URL</label>
                                            <input class="form-control" type="text" name="url" id="url5"
                                                   placeholder="URL"
                                                   value="<?= isset($img5->blb_url) ? $img5->blb_url : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="ket5">Keterangan</label>
                                            <textarea class="form-control" name="ket" id="ket5"
                                                      placeholder="Keterangan"><?= isset($img5->blb_ket) ? $img5->blb_ket : ''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="doupload5" class="btn btn-primary">Upload
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
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
                        <a id="hapus" href="#" class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
        <script>

            function hapus(data) {
                d = data;
                id = d.attr('data-id');
                $('a#hapus').attr('href', "<?= site_url('slide/hapus/'); ?>" + id);
            }


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
                var input_foto1 = $('#upload_foto1'),
                    tampil1 = $('#viewfoto1'),
                    cancel1 = $('#cancel1');
                var input_foto2 = $('#upload_foto2'),
                    tampil2 = $('#viewfoto2'),
                    cancel2 = $('#cancel2');
                var input_foto3 = $('#upload_foto3'),
                    tampil3 = $('#viewfoto3'),
                    cancel3 = $('#cancel3');
                var input_foto4 = $('#upload_foto4'),
                    tampil4 = $('#viewfoto4'),
                    cancel4 = $('#cancel4');
                var input_foto5 = $('#upload_foto5'),
                    tampil5 = $('#viewfoto5'),
                    cancel5 = $('#cancel5');

                var obj1 = tampil1.croppie({
                    viewport: {width: 350, height: 350},
                    boundary: {width: 350, height: 350},
                    showZoomer: false,
                });
                var obj2 = tampil2.croppie({
                    viewport: {width: 350, height: 350},
                    boundary: {width: 350, height: 350},
                    showZoomer: false,
                });
                var obj3 = tampil3.croppie({
                    viewport: {width: 350, height: 700},
                    boundary: {width: 350, height: 700},
                    showZoomer: false,
                });
                var obj4 = tampil4.croppie({
                    viewport: {width: 350, height: 350},
                    boundary: {width: 350, height: 350},
                    showZoomer: false,
                });
                var obj5 = tampil5.croppie({
                    viewport: {width: 350, height: 350},
                    boundary: {width: 350, height: 350},
                    showZoomer: false,
                });

                cancel1.click(function () {
                    input_foto1.show().val('');
                    tampil1.hide();
                    cancel1.hide();
                });

                cancel2.click(function () {
                    input_foto2.show().val('');
                    tampil2.hide();
                    cancel2.hide();
                });

                cancel3.click(function () {
                    input_foto3.show().val('');
                    tampil3.hide();
                    cancel3.hide();
                });

                cancel4.click(function () {
                    input_foto4.show().val('');
                    tampil4.hide();
                    cancel4.hide();
                });

                cancel5.click(function () {
                    input_foto5.show().val('');
                    tampil5.hide();
                    cancel5.hide();
                });

                input_foto1.change(function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        obj1.croppie('bind', {
                            url: event.target.result
                        }).then(function () {
                            console.log('Bind Foto 1 selesai');
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                    tampil1.show();
                    cancel1.show();
                    input_foto1.hide();
                });

                input_foto2.change(function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        obj2.croppie('bind', {
                            url: event.target.result
                        }).then(function () {
                            console.log('Bind Foto 2 selesai');
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                    tampil2.show();
                    cancel2.show();
                    input_foto2.hide();
                });

                input_foto3.change(function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        obj3.croppie('bind', {
                            url: event.target.result
                        }).then(function () {
                            console.log('Bind Foto 3 selesai');
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                    tampil3.show();
                    cancel3.show();
                    input_foto3.hide();
                });

                input_foto4.change(function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        obj4.croppie('bind', {
                            url: event.target.result
                        }).then(function () {
                            console.log('Bind Foto 4 selesai');
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                    tampil4.show();
                    cancel4.show();
                    input_foto4.hide();
                });

                input_foto5.change(function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        obj5.croppie('bind', {
                            url: event.target.result
                        }).then(function () {
                            console.log('Bind Foto 5 selesai');
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                    tampil5.show();
                    cancel5.show();
                    input_foto5.hide();
                });


                // Upload gambar1
                $('#doupload1').click(function (event) {
                    obj1.croppie('result', {
                        type: 'blob',
                        size: 'original'
                    }).then(function (response) {

                        var judul1 = $('#judul1').val(),
                            url1 = $('#url1').val(),
                            ket1 = $('#ket1').val(),
                            foto = response;

                        var dataForm = new FormData();
                        dataForm.append('ecommerce_eazy', '<?= $this->security->get_csrf_hash(); ?>');
                        dataForm.append('id', 1);
                        dataForm.append('foto', foto);
                        dataForm.append('judul', judul1);
                        dataForm.append('url', url1);
                        dataForm.append('ket', ket1);

                        $.ajax({
                            url: "<?= site_url('billboard/simpan'); ?>",
                            type: "POST",
                            data: dataForm,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                window.location.reload();
                            },
                            error: function (data) {
                                console.log(data.responseText);
                            }
                        });

                    });
                });
                // end upload gambar1

                // upload gambar2
                $('#doupload2').click(function (event) {
                    obj2.croppie('result', {
                        type: 'blob',
                        size: 'original'
                    }).then(function (response) {
                        var judul2 = $('#judul2').val(),
                            url2 = $('#url2').val(),
                            ket2 = $('#ket2').val(),
                            foto = response;

                        var dataForm = new FormData();
                        dataForm.append('ecommerce_eazy', '<?= $this->security->get_csrf_hash(); ?>');
                        dataForm.append('id', 2);
                        dataForm.append('foto', foto);
                        dataForm.append('judul', judul2);
                        dataForm.append('url', url2);
                        dataForm.append('ket', ket2);
                        $.ajax({
                            url: "<?= site_url('billboard/simpan'); ?>",
                            type: "POST",
                            data: dataForm,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                window.location.reload();
                            },
                            error: function (data) {
                                console.log(data.responseText);
                            }
                        });
                    })
                });
                // end upload gambar2


                // upload gambar3
                $('#doupload3').click(function (event) {
                    obj3.croppie('result', {
                        type: 'blob',
                        size: 'original'
                    }).then(function (response) {
                        var judul3 = $('#judul3').val(),
                            url3 = $('#url3').val(),
                            ket3 = $('#ket3').val(),
                            foto = response;
                        var dataForm = new FormData();
                        dataForm.append('ecommerce_eazy', '<?= $this->security->get_csrf_hash(); ?>');
                        dataForm.append('id', 3);
                        dataForm.append('foto', foto);
                        dataForm.append('judul', judul3);
                        dataForm.append('url', url3);
                        dataForm.append('ket', ket3);
                        $.ajax({
                            url: "<?= site_url('billboard/simpan'); ?>",
                            type: "POST",
                            data: dataForm,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                window.location.reload();
                            },
                            error: function (data) {
                                console.log(data.responseText);
                            }
                        });
                    })
                });
                // end upload gambar3

                // upload gambar4
                $('#doupload4').click(function (event) {
                    obj4.croppie('result', {
                        type: 'blob',
                        size: 'original'
                    }).then(function (response) {
                        var judul4 = $('#judul4').val(),
                            url4 = $('#url4').val(),
                            ket4 = $('#ket4').val(),
                            foto = response;
                        var dataForm = new FormData();
                        dataForm.append('ecommerce_eazy', '<?= $this->security->get_csrf_hash(); ?>');
                        dataForm.append('id', 4);
                        dataForm.append('foto', foto);
                        dataForm.append('judul', judul4);
                        dataForm.append('url', url4);
                        dataForm.append('ket', ket4);
                        $.ajax({
                            url: "<?= site_url('billboard/simpan'); ?>",
                            type: "POST",
                            data: dataForm,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                window.location.reload();
                            },
                            error: function (data) {
                                console.log(data.responseText);
                            }
                        });
                    })
                });
                // end upload gambar4


                // upload gambar5
                $('#doupload5').click(function (event) {
                    obj5.croppie('result', {
                        type: 'blob',
                        size: 'original'
                    }).then(function (response) {
                        var judul5 = $('#judul5').val(),
                            url5 = $('#url5').val(),
                            ket5 = $('#ket5').val(),
                            foto = response;
                        var dataForm = new FormData();
                        dataForm.append('ecommerce_eazy', '<?= $this->security->get_csrf_hash(); ?>');
                        dataForm.append('id', 5);
                        dataForm.append('foto', foto);
                        dataForm.append('judul', judul5);
                        dataForm.append('url', url5);
                        dataForm.append('ket', ket5);
                        $.ajax({
                            url: "<?= site_url('billboard/simpan'); ?>",
                            type: "POST",
                            data: dataForm,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                window.location.reload();
                            },
                            error: function (data) {
                                console.log(data.responseText);
                            }
                        });
                    })
                });
                // end upload gambar5
            });
        </script>

    </section>
</div>
</body>
</html>
