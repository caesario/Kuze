<?php include "master/Header.php"; ?>
<body>
<?php include 'master/Menu.php'; ?>
<link rel="stylesheet" href="<?= base_url('assets/vendor/fotorama/fotorama.css'); ?>">
<script src="<?= base_url('assets/vendor/fotorama/fotorama.js'); ?>"></script>
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
                            <h1><i class="fas fa-file-alt"></i> Pembayaran</h1>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tables" class="table table-sm table-borderless">
                            <thead>
                            <tr>
                                <th scope="col">No. Order</th>
                                <th scope="col">Nominal</th>
                                <th scope="col" class="text-center">Konfirmasi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($orders != NULL): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td class="text-danger"><?= $order->o_noorder; ?></td>
                                        <td id="rupiah"><?= $order->ob_nominal; ?></td>
                                        <td class="text-center">
                                            <a tooltip data-toggle="modal" title="Proses <?= $title_page; ?>" href="#"
                                               onclick="proses($(this))" data-target="#proses"
                                               data-id="<?= $order->o_kode; ?>"><i class="fas fa-check"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><b>No Pemilik Rekening : </b><br>
                                            <?= $order->ob_no_rek; ?>
                                        </td>
                                        <td rowspan="2"><b>Bukti : </b>
                                            <div class="fotorama"
                                                 data-nav="false"
                                                 data-arrows="false"
                                                 data-click="true"
                                                 data-swipe="true"
                                                 data-allowfullscreen="true"
                                                 data-width="220"
                                                 data-height="150">
                                                <img src="http://s.fotorama.io/1.jpg" width="220" height="150">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><b>Nama Pemilik Rekening : </b><br>
                                            <?= $order->ob_nama_rek; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><b>Bank : </b><br>
                                            <?= $order->ob_bank_nama; ?>
                                        </td>
                                        <td><b>Status : </b><br>
                                            <?php if ($order->o_status == 0): ?>
                                                <div class="text-warning">BELUM MENGISI ALAMAT PENGIRIMAN</div>
                                            <?php elseif ($order->o_status == 1): ?>
                                                <div class="text-warning">BELUM MENGISI METODE PENGIRIMAN & PEMBAYARAN
                                                </div>
                                            <?php elseif ($order->o_status == 2): ?>
                                                <div class="text-success">PELANGGAN BELUM KONFIRMASI PEMBAYARAN</div>
                                            <?php elseif ($order->o_status == 3): ?>
                                                <div class="text-success">ADMIN BELUM KONFIRMASI PEMBAYARAN</div>
                                            <?php elseif ($order->o_status == 4): ?>
                                                <div class="text-success">ADMIN SEDANG MEMPROSES ORDER</div>
                                            <?php elseif ($order->o_status == 5): ?>
                                                <div class="text-success">ADMIN BELUM KONFIRMASI PENGIRIMAN</div>
                                            <?php elseif ($order->o_status == 6): ?>
                                                <div class="text-success">SUKSES</div>
                                            <?php elseif ($order->o_status == 7): ?>
                                                <div class="text-danger">BATAL</div>
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

            function proses(data) {
                d = data;
                id = d.attr('data-id');
                $('a#proses').attr('href', "<?= site_url('order/proses_konfirmasi/'); ?>" + id);
            }

            // ------------------------------------------------------ //
            // Data table users
            // ------------------------------------------------------ //
            // $('#tables').DataTable();

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
                $('td[id="rupiah"]').each(function (index) {
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

<div class="modal fade" id="proses" tabindex="-1" role="dialog" aria-labelledby="proses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">

            <div class="modal-body">
                <p>Apakah anda yakin?</p>
            </div>
            <div class="modal-footer">
                <a id="proses" href="#" class="btn btn-primary btn-sm">Proses</a>
                <a data-dismiss="modal" href="#" class="btn btn-danger btn-sm">Tutup</a>
            </div>
        </div>
    </div>
</div>


</body>
</html>
