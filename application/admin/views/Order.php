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
                    <div class="row">
                        <div class="col-sm-10">
                            <h1>Order</h1>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tables" class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">No. Order</th>
                                <th scope="col">Detail Order</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($orders != NULL): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td class="align-middle text-danger"><?= $order->orders_noid; ?></td>
                                        <td class="align-middle">
                                            <div class="mb-2">
                                                <b>Nama Pelanggan :</b><br>
                                                <?= $order->pengguna_nama; ?>
                                            </div>
                                            <div class="mb-2">
                                                <b>Total Pembayaran : </b><br>
                                                <div id="rupiah">
                                                    <?= $order->total; ?>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <b>Tanggal Order : </b><br>
                                                <?= $order->created_at; ?>
                                            </div>
                                            <div class="mb-2">
                                                <b>Status Order : </b><br>
                                                <?php if ($order->orders_status == 0): ?>
                                                    <div class="text-warning">BELUM MENGISI ALAMAT PENGIRIMAN</div>
                                                <?php elseif ($order->orders_status == 1): ?>
                                                    <div class="text-warning">BELUM MENGISI METODE PENGIRIMAN &
                                                        PEMBAYARAN
                                                    </div>
                                                <?php elseif ($order->orders_status == 2): ?>
                                                    <div class="text-success">PELANGGAN BELUM KONFIRMASI PEMBAYARAN
                                                    </div>
                                                <?php elseif ($order->orders_status == 3): ?>
                                                    <div class="text-success">ADMIN BELUM KONFIRMASI PEMBAYARAN</div>
                                                <?php elseif ($order->orders_status == 4): ?>
                                                    <div class="text-success">ADMIN SEDANG MEMPROSES ORDER</div>
                                                <?php elseif ($order->orders_status == 5): ?>
                                                    <div class="text-success">ADMIN BELUM KONFIRMASI PENGIRIMAN</div>
                                                <?php elseif ($order->orders_status == 6): ?>
                                                    <div class="text-success">SUKSES (Telah dikirim)</div>
                                                <?php elseif ($order->orders_status == 7): ?>
                                                    <div class="text-danger">BATAL</div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                               onclick="detil($(this))" data-target="#cruddetil"
                                               data-id="<?= $order->orders_noid; ?>"><i
                                                        class="fas fa-sync mr-2"></i>Lihat <?= $title_page; ?>

                                            </a>
                                            <?php if ($order->orders_status > 4 && $order->orders_status < 7): ?>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button id="cetak" type="button"
                                                            class="btn btn-primary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        Cetak
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="opsi">
                                                        <a class="dropdown-item"
                                                           href="<?= site_url('print_pdf/slip_pengiriman/' . $order->orders_noid); ?>"
                                                        ><i class="far fa-file-alt mr-2"></i>Slip Pengiriman
                                                        </a>
                                                        <a class="dropdown-item" data-toggle="modal" href="#"
                                                           onclick="print_invoice($(this))" data-target="#crud"
                                                           data-id="<?= $order->orders_noid; ?>"><i
                                                                    class="far fa-file-alt mr-2"></i>Invoice
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($order->orders_status == 3): ?>
                                                <a class="btn btn-sm btn-primary" data-toggle="modal" href="#"
                                                   onclick="konfirmasi($(this))" data-target="#konfirmasi"
                                                   data-id="<?= $order->orders_noid; ?>"><i
                                                            class="fas fa-sync mr-2"></i>Konfirmasi &
                                                    Proses <?= $title_page; ?>
                                                </a>

                                            <?php endif; ?>

                                            <?php if ($order->orders_status == 4): ?>
                                                <a class="btn btn-sm btn-primary" <?= $order->orders_status == 4 ? '' : 'disabled'; ?>
                                                   data-toggle="modal" href="#"
                                                   onclick="proses($(this))" data-target="#konfirmasi"
                                                   data-id="<?= $order->orders_noid; ?>">Proses <?= $title_page; ?>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($order->orders_status == 5): ?>
                                                <a class="btn btn-sm btn-primary" data-toggle="modal"
                                                   title="Konfirmasi Pengiriman" href="#"
                                                   onclick="pengiriman($(this))" data-target="#crud"
                                                   data-backdrop="static" data-keyboard="false"
                                                   data-id="<?= $order->orders_noid; ?>">
                                                    Konfirmasi Pengiriman
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($order->orders_status != 7 && $order->orders_status < 5): ?>
                                                <a class="btn btn-sm btn-danger"
                                                   data-toggle="modal"
                                                   data-target="#batal"
                                                   data-url="<?= site_url('order/batal/' . $order->orders_noid); ?>"
                                                   onclick="batal($(this))"
                                                   href="#"><i class="fas fa-times mr-2"></i>
                                                    Batalkan <?= $title_page; ?>
                                                </a>
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

            function konfirmasi(data) {
                d = data;
                id = d.attr('data-id');
                $('a#konfirmasi').attr('href', "<?= site_url('order/konfirmasi/'); ?>" + id + "/proses");
            }

            function proses(data) {
                d = data;
                id = d.attr('data-id');
                $('a#konfirmasi').attr('href', "<?= site_url('order/proses/'); ?>" + id + "/proses");
            }

            function pengiriman(data) {
                d = data;
                id = d.attr('data-id');

                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('order/resi/'); ?>" + id);
            }

            function batal(data) {
                d = data;
                url = d.attr('data-url');
                modal = $('#batal');
                formmodal = modal.find('div.modal-body > form');
                formmodal.prop('action', url);
            }

            function edit(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('ukuran/ubah/'); ?>" + id);
            }

            function detil(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#cruddetil');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('order/detil/'); ?>" + id);
            }

            function hapus(data) {
                d = data;
                id = d.attr('data-id');
                $('a#hapus').attr('href', "<?= site_url('ukuran/hapus/'); ?>" + id);
            }

            // ------------------------------------------------------ //
            // Data table
            // ------------------------------------------------------ //
            $('#tables').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian.json"
                }
            });

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
                decimals: 2,
                thousand: '.',
                prefix: 'Rp. ',
                suffix: ''
            });

            $(document).ready(function () {
                $('div[id="rupiah"]').each(function (index) {
                    var value = parseInt($(this).html()),
                        hasil = moneyFormat.to(value);

                    $(this).html(hasil);
                })
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

<div class="modal fade" id="cruddetil" tabindex="-1" role="dialog" aria-labelledby="cruddetil" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="konfirmasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">

            <div class="modal-body">
                <p>Apakah anda yakin ingin melanjutkan proses ini?</p>
            </div>
            <div class="modal-footer">
                <a id="konfirmasi" href="#" class="btn btn-sm btn-primary">Proses</a>
                <a data-dismiss="modal" href="#" class="btn btn-sm btn-danger">Tutup</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="batal" tabindex="-1" role="dialog" aria-labelledby="batal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="#" method="post">
                    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="alasan">Alasan</label>
                        <textarea class="form-control" name="alasan" id="alasan" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Batalkan</button>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
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
