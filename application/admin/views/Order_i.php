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
                            <h1>Invoice</h1>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tables" class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">Detail Order</th>
                                <th scope="col">Detail Biaya</th>
                                <th scope="col">Detail Pengiriman</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($orders != NULL): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td class="align-middle">
                                            <div class="mb-2">
                                                <b>Nomor Order :</b><br>
                                                <div class="text-danger">
                                                    <?= $order->orders_noid; ?>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <b>Tanggal Order :</b><br>
                                                <?= $order->created_at; ?>
                                            </div>
                                            <div class="mb-2">
                                                <b>Nama Pelanggan :</b><br>
                                                <?= $order->pengguna_nama; ?>
                                            </div>

                                            <div class="mb-2">
                                                <b>Status Order :</b><br>
                                                <?php if ($order->orders_status == 0): ?>
                                                    <div class="text-warning"><b>BELUM MENGISI ALAMAT PENGIRIMAN</b>
                                                    </div>
                                                <?php elseif ($order->orders_status == 1): ?>
                                                    <div class="text-warning"><b>BELUM MENGISI METODE PENGIRIMAN &
                                                            PEMBAYARAN</b>
                                                    </div>
                                                <?php elseif ($order->orders_status == 2): ?>
                                                    <div class="text-success"><b>PELANGGAN BELUM KONFIRMASI
                                                            PEMBAYARAN</b>
                                                    </div>
                                                <?php elseif ($order->orders_status == 3): ?>
                                                    <div class="text-success"><b>ADMIN BELUM KONFIRMASI PEMBAYARAN</b>
                                                    </div>
                                                <?php elseif ($order->orders_status == 4): ?>
                                                    <div class="text-success"><b>ADMIN SEDANG MEMPROSES ORDER</b></div>
                                                <?php elseif ($order->orders_status == 5): ?>
                                                    <div class="text-success"><b>ADMIN BELUM KONFIRMASI PENGIRIMAN</b>
                                                    </div>
                                                <?php elseif ($order->orders_status == 6): ?>
                                                    <div class="text-success"><b>TELAH DIKIRIM</b></div>
                                                <?php elseif ($order->orders_status == 7): ?>
                                                    <div class="text-danger"><b>BATAL</b></div>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td class="align-middle">
                                            <div class="mb-2">
                                                <b>Kode Unik :</b><br>
                                                <div class="text-danger">
                                                    <?= $order->orders_uniq; ?>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <b>Pembayaran :</b><br>
                                                <div id="rupiah" value="<?= $order->total; ?>"></div>
                                            </div>
                                            <div class="mb-2">
                                                <b>Pengiriman :</b><br>
                                                <div id="rupiah" value="<?= $order->orders_ongkir_biaya; ?>"></div>
                                            </div>
                                            <div class="mb-2">
                                                <b>Grand Total :</b><br>
                                                <div id="rupiah" class="text-success"
                                                     value="<?= $order->total + $order->orders_ongkir_biaya + $order->orders_uniq; ?>"></div>
                                            </div>
                                        </td>
                                        <td>

                                            <div class="mb-2">
                                                <b>Pengirim :</b><br>
                                                <?php if ($order->orders_pengiriman_s_nama != NULL && $order->orders_pengiriman_s_kontak != NULL): ?>
                                                    <?= $order->orders_pengiriman_s_nama; ?><br>
                                                    <?= $order->orders_pengiriman_s_kontak; ?>
                                                <?php else: ?>
                                                    <?= $order->orders_pengiriman_r_nama; ?><br>
                                                    <?= $order->orders_pengiriman_r_kontak; ?>
                                                <?php endif; ?>

                                            </div>
                                            <div class="mb-2">
                                                <b>Penerima :</b><br>
                                                <?= $order->orders_pengiriman_r_nama; ?><br>
                                                <?= $order->orders_pengiriman_r_kontak; ?>
                                            </div>
                                            <div class="mb-2">
                                                <b>Resi :</b><br>
                                                <?= $order->orders_resi_unik; ?>
                                                <?= $order->orders_resi_no; ?><br>
                                            </div>
                                        </td>

                                        <td class="align-middle">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                               onclick="detil($(this))" data-target="#cruddetil"
                                               data-id="<?= $order->orders_noid; ?>"><i
                                                        class="fas fa-sync mr-2"></i>Lihat Order

                                            </a>
                                            <a class="btn btn-sm btn-primary" data-toggle="modal"
                                               title="Lacak Pengiriman" href="#"
                                               onclick="lacak($(this))" data-target="#modaltracking"
                                               data-backdrop="static" data-keyboard="false"
                                               data-id="<?= $order->orders_noid; ?>">
                                                Lacak Pengiriman
                                            </a>
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

                bodymodal.load("<?= site_url('ukuran/tambah'); ?>");
            }

            function edit(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('ukuran/ubah/'); ?>" + id);
            }

            function lacak(data) {
                d = data;
                id = d.attr('data-id');

                modal = $('#modaltracking');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('resi/tracking/'); ?>" + id);
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

            // ------------------------------------------------------ //
            // Data table users
            // ------------------------------------------------------ //
            $('#tables').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian.json"
                },
                "fnDrawCallback": function (oSettings) {
                    $(oSettings.nTHead).hide();
                    $('div[id="rupiah"]').each(function (index) {
                        var value = parseInt($(this).attr('value')),
                            hasil = moneyFormat.to(value);

                        $(this).html(hasil);
                    });
                }
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
<div class="modal fade" id="modaltracking" tabindex="-1" role="dialog" aria-labelledby="modaltracking"
     aria-hidden="true">
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


</body>
</html>
