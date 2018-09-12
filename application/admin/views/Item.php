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
                    <h1><?= $title_page; ?></h1>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p>
                                <a class="btn btn-primary" data-toggle="modal" href="#" onclick="tambah()"
                                   data-target="#crud"
                                   data-backdrop="static" data-keyboard="false"><i class="fa fa-plus mr-2"></i>Buat Data</a>
                            </p>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tables" class="table">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Kode Item</th>
                                <th scope="col">Nama Item</th>
                                <th scope="col">New Arrival</th>
                                <th scope="col">Best Seller</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Berat (Gram)</th>
                                <th scope="col">Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($items != NULL): ?>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td scope="row" class="align-middle">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button id="itembtn" type="button"
                                                        class="btn btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    Opsi Item
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="itembtn">
                                                    <a class="dropdown-item small" data-toggle="modal"
                                                       href="#"
                                                       onclick="edit_item($(this))" data-target="#crud"
                                                       data-backdrop="static" data-keyboard="false"
                                                       data-id="<?= $item->i_kode; ?>"><i
                                                                class="far fa-edit mr-2"></i>Ubah Item</a>
                                                    <a class="dropdown-item small" data-toggle="modal"
                                                       href="#"
                                                       onclick="tambah_detil($(this))" data-target="#crud"
                                                       data-backdrop="static" data-keyboard="false"
                                                       data-id="<?= $item->i_kode; ?>"><i
                                                                class="fas fa-plus mr-2"></i>Tambah Detail</a>
                                                    <a class="dropdown-item small" data-toggle="modal"
                                                       data-backdrop="static" data-keyboard="false"
                                                       href="#"
                                                       onclick="foto($(this))" data-target="#crudfoto"
                                                       data-id="<?= $item->i_kode; ?>"><i
                                                                class="far fa-images mr-2"></i>Lihat Gambar</a>
                                                    <a class="dropdown-item small" data-toggle="modal"
                                                       data-backdrop="static" data-keyboard="false"
                                                       href="#"
                                                       onclick="unggah($(this))" data-target="#crudfoto"
                                                       data-id="<?= $item->i_kode; ?>"><i
                                                                class="fas fa-upload mr-2"></i>Upload Gambar</a>
                                                    <?php if (!isset($item->item_detil)): ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item small" data-toggle="modal"
                                                           data-backdrop="static" data-keyboard="false"
                                                           href="#"
                                                           onclick="hapus_item($(this))"
                                                           data-target="#modal_hapus"
                                                           data-id="<?= $item->i_kode; ?>"><i
                                                                    class="far fa-trash-alt mr-2"></i>Hapus Item</a>
                                                    <?php endif; ?>
                                                </div>

                                            </div>
                                        </td>

                                        <td scope="row" class="align-middle"><?= $item->i_kodeitem; ?></td>
                                        <td scope="row" class="align-middle"><?= $item->i_nama; ?></td>
                                        <td scope="row"
                                            class="align-middle text-center"><?= $item->i_new == 0 ? '<i class="fas fa-times"></i>' : '<i class="fas fa-check"></i>'; ?></td>
                                        <td scope="row"
                                            class="align-middle text-center"><?= $item->i_best == 0 ? '<i class="fas fa-times"></i>' : '<i class="fas fa-check"></i>'; ?></td>

                                        <td scope="row" class="align-middle" id="rupiah"><?= $item->i_hrg; ?></td>
                                        <td scope="row" class="align-middle"><?= $item->i_berat; ?> Gram</td>
                                        <td>
                                            <?php if (isset($item->item_detil)): ?>
                                                <table class="table table-sm table-borderless">
                                                    <thead>
                                                    <tr>
                                                        <th>Ukuran</th>
                                                        <th>QTY</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($item->item_detil as $detil): ?>
                                                        <tr>
                                                            <td class="align-middle">
                                                                <?= $ukuran($detil->item_detil_kode, $detil->u_kode)->u_nama; ?>
                                                            </td>
                                                            <td class="align-middle">
                                                                <?= $qty($detil->item_detil_kode); ?>
                                                            </td>

                                                            <td class="align-middle">
                                                                <div class="btn-group btn-group-sm" role="group">
                                                                    <button id="opsi" type="button"
                                                                            class="btn btn-primary dropdown-toggle"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                        Opsi Detail
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="opsi">
                                                                        <a class="dropdown-item small"
                                                                           data-toggle="modal"
                                                                           href="#"
                                                                           onclick="edit_detil($(this))"
                                                                           data-target="#crud"
                                                                           data-backdrop="static" data-keyboard="false"
                                                                           data-id="<?= $detil->item_detil_kode; ?>"><i
                                                                                    class="far fa-edit mr-2"></i> Ubah
                                                                            Detail</a>
                                                                        <a class="dropdown-item small"
                                                                           data-toggle="modal"
                                                                           href="#"
                                                                           onclick="tambah_qty($(this))"
                                                                           data-target="#crud"
                                                                           data-backdrop="static" data-keyboard="false"
                                                                           data-id="<?= $detil->item_detil_kode; ?>"><i
                                                                                    class="fas fa-cart-plus mr-2"></i>
                                                                            Tambah t
                                                                            QTY</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item small"
                                                                           data-toggle="modal"
                                                                           href="#"
                                                                           onclick="hapus($(this))"
                                                                           data-target="#modal_hapus"
                                                                           data-backdrop="static" data-keyboard="false"
                                                                           data-id="<?= $detil->item_detil_kode; ?>"><i
                                                                                    class="far fa-trash-alt mr-2"></i>
                                                                            Hapus</a>
                                                                    </div>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </tbody>

                                                </table>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

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

                bodymodal.load("<?= site_url('item/tambah'); ?>");
            }

            function edit_item(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('item/edit_item/'); ?>" + id);
            }

            function tambah_detil(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('item/tambah_detil/'); ?>" + id);
            }

            function detil_item(data) {
                d = data;
                url = d.attr('data-url');

                modal = $('#detil_item');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load(url);
            }

            function deskripsi(data) {
                d = data;
                msg = d.attr('data-msg');

                $('textarea#deskripsi').val(msg);
            }

            function foto(data) {
                d = data;
                id = d.attr('data-id');

                modal = $('#crudfoto');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('item_img/foto/'); ?>" + id);
            }

            function unggah(data) {
                d = data;
                id = d.attr('data-id');

                modal = $('#crudfoto');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('item_img/unggah/'); ?>" + id);
            }

            function edit_detil(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('item/ubah_detil/'); ?>" + id);
            }

            function tambah_qty(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('item/tambah_qty/'); ?>" + id);
            }

            function detil(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('item/detil/'); ?>" + id);
            }

            function hapus(data) {
                d = data;
                id = d.attr('data-id');
                $('a#hapus').attr('href', "<?= site_url('item/hapus/'); ?>" + id);
            }

            function hapus_item(data) {
                d = data;
                id = d.attr('data-id');
                $('a#hapus').attr('href', "<?= site_url('item/hapus_item/'); ?>" + id);
            }

            // ------------------------------------------------------ //
            // Data table Pagination
            // ------------------------------------------------------ //
            // $('#tables').DataTable();
            // $('#click').click(function () {
            //     $(this).closest('tr').nextUntil("tr:has(#child)").show();
            // });

            // ------------------------------------------------------ //
            // Data table
            // ------------------------------------------------------ //
            $('#tables').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian.json"
                },
                "columnDefs": [{
                    "targets": [0, 5],
                    "orderable": false
                }]
            });

            // ------------------------------------------------------ //
            // Tooltip
            // ------------------------------------------------------ //
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

            // ------------------------------------------------------ //
            // Format Rupiah
            // ------------------------------------------------------ //
            var moneyFormat = wNumb({
                mark: ',',
                decimals: 0,
                thousand: '.',
                prefix: 'IDR ',
                suffix: ''
            });

            $(document).ready(function () {
                $('td[id="rupiah"]').each(function (index) {
                    var value = parseInt($(this).html()),
                        hasil = moneyFormat.to(value);

                    $(this).html(hasil);
                })
            });

            $('.table-responsive').on('show.bs.dropdown', function () {
                $('.table-responsive').css("overflow", "inherit");
            });

            $('.table-responsive').on('hide.bs.dropdown', function () {
                $('.table-responsive').css("overflow", "auto");
            })

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
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deskripsi" tabindex="-1" role="dialog" aria-labelledby="deskripsi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="form-group">
                    <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" onclick="window.location.reload()">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="detil_item" tabindex="-1" role="dialog" aria-labelledby="detil_item" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="crudfoto" tabindex="-1" role="dialog" aria-labelledby="crudfoto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_hapus" tabindex="-1" role="dialog" aria-labelledby="modal_hapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <a id="hapus" href="#" class="btn btn-sm btn-danger">Hapus</a>
                <a id="batal" href="#" class="btn btn-sm btn-primary" data-dismiss="modal">Batal</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
