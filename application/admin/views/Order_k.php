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
                            <h1>Pembayaran</h1>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tables" class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">No. Order</th>
                                <th scope="col">Detail Pembayaran</th>
                                <th scope="col">Detail Bank</th>
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
                                                <b>Tanggal Konfirmasi :</b><br>
                                                <?= $order->created_at; ?>
                                            </div>
                                            <div class="mb-2">
                                                <b>Kode Unik :</b><br>
                                                <div class="text-danger"><?= $order->orders_uniq; ?></div>
                                            </div>
                                            <div class="mb-2">
                                                <b>Total Pembayaran : </b><br>
                                                <div id="rupiah"
                                                     value="<?= $order->orders_bukti_nominal + $order->orders_uniq; ?>"></div>
                                            </div>
                                            <div class="mb-2">
                                                <b>Total yang dibayarkan : </b><br>
                                                <div id="rupiah"
                                                     value="<?= $order->orders_bukti_nominal + $order->orders_uniq; ?>"></div>
                                            </div>
                                            <div class="mb-2">
                                                <b>Bukti : </b><br>
                                                <?php if ($order->orders_bukti_foto != NULL): ?>
                                                    <div class="fotorama"
                                                         data-nav="false"
                                                         data-arrows="false"
                                                         data-click="true"
                                                         data-swipe="true"
                                                         data-allowfullscreen="true"
                                                         data-width="220"
                                                         data-height="150">
                                                        <img src="<?= base_url('upload/' . $order->orders_bukti_foto); ?>"
                                                             width="220" height="150">
                                                    </div>
                                                <?php else: ?>
                                                    Tidak ada gambar.
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-2">
                                                <b>Status : </b><br>
                                                <?php if ($order->orders_status == 0): ?>
                                                    <div class="text-warning"><b>BELUM MENGISI ALAMAT PENGIRIMAN</b>
                                                    </div>
                                                <?php elseif ($order->orders_status == 1): ?>
                                                    <div class="text-warning">BELUM MENGISI METODE PENGIRIMAN &
                                                        PEMBAYARAN
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
                                        <td>
                                            <div class="mb-2">
                                                <b>Bank : </b><br>
                                                <?= $order->orders_bukti_bank_nama; ?>
                                            </div>
                                            <div class="mb-2">
                                                <b>Nama Pemilik Rekening : </b><br>
                                                <?= $order->orders_bukti_nama_rek; ?>
                                            </div>
                                            <div class="mb-3">
                                                <b>Nomor Pemilik Rekening : </b><br>
                                                <?= $order->orders_bukti_no_rek; ?>
                                            </div>
                                            <div class="mb-2">
                                                <b>Transfer ke :</b><br>
                                            </div>
                                            <div class="mb-2">
                                                <b>Atas Nama :</b><br>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <a class="btn btn-sm btn-primary" data-toggle="modal" href="#"
                                               onclick="proses($(this))" data-target="#proses"
                                               data-id="<?= $order->orders_noid; ?>"><i class="fas fa-check mr-2"></i>Proses</a>
                                            <a class="btn btn-sm btn-danger" data-toggle="modal" href="#"
                                               onclick="proses_revert($(this))" data-target="#proses_revert"
                                               data-id="<?= $order->orders_noid; ?>"><i class="fas fa-times mr-2"></i>Revert</a>
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                               onclick="detil($(this))" data-target="#cruddetil"
                                               data-id="<?= $order->orders_noid; ?>"><i
                                                        class="fas fa-sync mr-2"></i>Lihat Order

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

            function proses(data) {
                d = data;
                id = d.attr('data-id');
                $('a#proses').attr('href', "<?= site_url('order/proses_konfirmasi/'); ?>" + id);
            }

            function proses_revert(data) {
                d = data;
                id = d.attr('data-id');
                $('a#proses_revert').attr('href', "<?= site_url('order/proses_revert/'); ?>" + id);
            }

            function detil(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#cruddetil');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('order/detil/'); ?>" + id);
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
                decimals: 0,
                thousand: '.',
                prefix: 'IDR ',
                suffix: ''
            });

            // ------------------------------------------------------ //
            // Data table
            // ------------------------------------------------------ //
            $('#tables').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian.json"
                },
                "fnDrawCallback": function (oSettings) {
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
                <p>Apakah anda yakin ingin melakukan proses ini ?</p>
            </div>
            <div class="modal-footer">
                <a id="proses" href="#" class="btn btn-sm btn-primary">Proses</a>
                <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="proses_revert" tabindex="-1" role="dialog" aria-labelledby="proses_revert"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Apakah anda yakin ingin melakukan proses ini ?<br>
                    Setelah proses ini dilakukan maka order akan di-revert ke konfirmasi pembayaran.</p>
            </div>
            <div class="modal-footer">
                <a id="proses_revert" href="#" class="btn btn-sm btn-primary">Revert</a>
                <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="cruddetil" tabindex="-1" role="dialog" aria-labelledby="crud" aria-hidden="true">
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

<div class="modal fade" id="cruddetil" tabindex="-1" role="dialog" aria-labelledby="proses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">

            <div class="modal-body">
                <p>Apakah anda yakin?</p>
            </div>
            <div class="modal-footer">
                <a id="proses" href="#" class="btn btn-sm btn-primary">Proses</a>
                <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</a>
            </div>
        </div>
    </div>
</div>


</body>
</html>
