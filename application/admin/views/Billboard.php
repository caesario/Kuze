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
                    <h1>Billboard</h1>
                    <p class="card-text">Klip Foto</p>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header text-white bg-primary">
                                    <h1>Foto</h1>
                                    <p class="card-text">Posisi Kiri Atas</p>
                                </div>
                                <div class="card-img-top" id="viewimage1" style="display: none"></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="upload_image1">File</label>
                                        <input class="form-control-file" type="file" name="upload_image"
                                               id="upload_image1">
                                    </div>
                                    <div class="form-group">
                                        <div id="viewimage1" style="display: none"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input class="form-control" type="text" name="judul" id="judul"
                                               placeholder="Judul">
                                    </div>
                                    <div class="form-group">
                                        <label for="url">URL</label>
                                        <input class="form-control" type="text" name="url" id="url" placeholder="URL">
                                    </div>
                                    <div class="form-group">
                                        <label for="ket">Keterangan</label>
                                        <textarea class="form-control" name="ket" id="ket"
                                                  placeholder="Keterangan"></textarea>
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
                                <div class="card-header text-white bg-primary">
                                    <h1>Foto</h1>
                                    <p class="card-text">Posisi Kiri Bawah</p>
                                </div>
                                <div class="card-img-top" id="viewimage2" style="display: none"></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="upload_image2">File</label>
                                        <input class="form-control-file" type="file" name="upload_image"
                                               id="upload_image2">
                                    </div>
                                    <div class="form-group">
                                        <div id="viewimage2" style="display: none"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input class="form-control" type="text" name="judul" id="judul"
                                               placeholder="Judul">
                                    </div>
                                    <div class="form-group">
                                        <label for="url">URL</label>
                                        <input class="form-control" type="text" name="url" id="url" placeholder="URL">
                                    </div>
                                    <div class="form-group">
                                        <label for="ket">Keterangan</label>
                                        <textarea class="form-control" name="ket" id="ket"
                                                  placeholder="Keterangan"></textarea>
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
                                <div class="card-header text-white bg-primary">
                                    <h1>Foto</h1>
                                    <p class="card-text">Posisi Tengah</p>
                                </div>
                                <div class="card-img-top" id="viewimage3" style="display: none"></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="upload_image3">File</label>
                                        <input class="form-control-file" type="file" name="upload_image"
                                               id="upload_image3">
                                    </div>
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input class="form-control" type="text" name="judul" id="judul"
                                               placeholder="Judul">
                                    </div>
                                    <div class="form-group">
                                        <label for="url">URL</label>
                                        <input class="form-control" type="text" name="url" id="url" placeholder="URL">
                                    </div>
                                    <div class="form-group">
                                        <label for="ket">Keterangan</label>
                                        <textarea class="form-control" name="ket" id="ket"
                                                  placeholder="Keterangan"></textarea>
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
                                <div class="card-header text-white bg-primary">
                                    <h1>Foto</h1>
                                    <p class="card-text">Posisi Kanan Atas</p>
                                </div>
                                <div class="card-img-top" id="viewimage4" style="display: none"></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="upload_image4">File</label>
                                        <input class="form-control-file" type="file" name="upload_image"
                                               id="upload_image4">
                                    </div>
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input class="form-control" type="text" name="judul" id="judul"
                                               placeholder="Judul">
                                    </div>
                                    <div class="form-group">
                                        <label for="url">URL</label>
                                        <input class="form-control" type="text" name="url" id="url" placeholder="URL">
                                    </div>
                                    <div class="form-group">
                                        <label for="ket">Keterangan</label>
                                        <textarea class="form-control" name="ket" id="ket"
                                                  placeholder="Keterangan"></textarea>
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
                                <div class="card-header text-white bg-primary">
                                    <h1>Foto</h1>
                                    <p class="card-text">Posisi Kanan Bawah</p>
                                </div>
                                <div class="card-img-top" id="viewimage5" style="display: none"></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="upload_image5">File</label>
                                        <input class="form-control-file" type="file" name="upload_image"
                                               id="upload_image5">
                                    </div>
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input class="form-control" type="text" name="judul" id="judul"
                                               placeholder="Judul">
                                    </div>
                                    <div class="form-group">
                                        <label for="url">URL</label>
                                        <input class="form-control" type="text" name="url" id="url" placeholder="URL">
                                    </div>
                                    <div class="form-group">
                                        <label for="ket">Keterangan</label>
                                        <textarea class="form-control" name="ket" id="ket"
                                                  placeholder="Keterangan"></textarea>
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
                var $klip1 = $('#upload_image1'),
                    $tampil1 = $('#viewimage1');
                var $klip2 = $('#upload_image2'),
                    $tampil2 = $('#viewimage2');
                var $klip3 = $('#upload_image3'),
                    $tampil3 = $('#viewimage3');
                var $klip4 = $('#upload_image4'),
                    $tampil4 = $('#viewimage4');
                var $klip5 = $('#upload_image5'),
                    $tampil5 = $('#viewimage5');

                var $obj1 = $tampil1.croppie({
                    enableExif: true,
                    viewport: {
                        width: 350,
                        height: 350,
                        type: 'square' //circle
                    },
                    boundary: {
                        width: 350,
                        height: 350
                    }
                });
                var $obj2 = $tampil2.croppie({
                    enableExif: true,
                    viewport: {
                        width: 350,
                        height: 350,
                        type: 'square' //circle
                    },
                    boundary: {
                        width: 350,
                        height: 350
                    }
                });
                var $obj3 = $tampil3.croppie({
                    enableExif: true,
                    viewport: {
                        width: 350,
                        height: 700,
                        type: 'square' //circle
                    },
                    boundary: {
                        width: 350,
                        height: 700
                    }
                });
                var $obj4 = $tampil4.croppie({
                    enableExif: true,
                    viewport: {
                        width: 350,
                        height: 350,
                        type: 'square' //circle
                    },
                    boundary: {
                        width: 350,
                        height: 350
                    }
                });
                var $obj5 = $tampil5.croppie({
                    enableExif: true,
                    viewport: {
                        width: 350,
                        height: 350,
                        type: 'square' //circle
                    },
                    boundary: {
                        width: 350,
                        height: 350
                    }
                });

                $klip1.change(function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $obj1.croppie('bind', {
                            url: event.target.result
                        }).then(function () {
                            console.log('Bind Foto 1 selesai');
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                    $tampil1.show();
                });

                $klip2.change(function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $obj2.croppie('bind', {
                            url: event.target.result
                        }).then(function () {
                            console.log('Bind Foto 2 selesai');
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                    $tampil2.show();
                });

                $klip3.change(function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $obj3.croppie('bind', {
                            url: event.target.result
                        }).then(function () {
                            console.log('Bind Foto 3 selesai');
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                    $tampil3.show();
                });

                $klip4.change(function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $obj4.croppie('bind', {
                            url: event.target.result
                        }).then(function () {
                            console.log('Bind Foto 4 selesai');
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                    $tampil4.show();
                });

                $klip5.change(function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $obj5.croppie('bind', {
                            url: event.target.result
                        }).then(function () {
                            console.log('Bind Foto 5 selesai');
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                    $tampil5.show();
                });

            });
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
                <a id="hapus" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>


</body>
</html>
