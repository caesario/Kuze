<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <hr class="mb-5 c-hr-reset">

    <div class="container-fluid c-padding-header mb-5">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <!-- <div class="col-12">
                        <div class="mb-4">
                          <div class="">
                            <h5 class="card-title mb-1">Jhon Doe Ponegoro</h5>
                            <p class="card-text mb-1">Caesar Tower, 27th Cengkareng Raya Street, South Cengkareng Indonesia 12520</p>
                            <p class="card-text"><small class="text-muted">Join 24 Sep 2018</small></p>
                          </div>
                        </div>
                    </div> -->
                    <div class="col-12">
                        <div class="list-group mb-4">
                            <a href="<?= site_url('profil'); ?>"
                               class="list-group-item list-group-item-action ">Profil</a>
                            <a href="<?= site_url('alamat_profil'); ?>" class="list-group-item list-group-item-action ">Alamat</a>
                            <a href="<?= site_url('order_status'); ?>" class="list-group-item list-group-item-action ">Transaksi
                                Tertunda</a>
                            <a href="<?= site_url('order_history'); ?>"
                               class="list-group-item list-group-item-action c-profil-active">Riwayat Transaksi</a>
                            <a href="<?= site_url('resi'); ?>" class="list-group-item list-group-item-action">Laporan
                                Resi</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <h5>Riwayat Pesanan</h5>
                <div class="table-responsive mt-2">
                    <table class="table table-sm table-borderless" id="table">
                        <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Detail Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if ($orders != NULL): ?>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td class="align-middle">
                                        <?= $order->orders_noid; ?>
                                    </td>
                                    <td class="align-middle">
                                        <b>Tanggal Order :</b><br>
                                        <?= $order->created_at; ?>
                                        <br>
                                        <b>Total Harga :</b><br>
                                        <div id="rupiah"><?= $order->total; ?></div>
                                        <br>
                                        <b>Status :</b><br>
                                        <?php if ($order->orders_status == 0): ?>
                                            <div class="text-warning">BELUM MENGISI ALAMAT PENGIRIMAN</div>
                                        <?php elseif ($order->orders_status == 1): ?>
                                            <div class="text-warning">BELUM MENGISI METODE PENGIRIMAN & PEMBAYARAN</div>
                                        <?php elseif ($order->orders_status == 2): ?>
                                            <div class="text-success">PELANGGAN BELUM KONFIRMASI PEMBAYARAN</div>
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
                                        <b>Deskripsi :</b><br>
                                        <div class="text-danger">
                                            <?= $order->orders_deskripsi; ?>
                                        </div>

                                    </td>

                                    <td class="align-middle">
                                        <a class="btn c-login-btn c-edit"
                                           href="<?= site_url('pending/' . $order->orders_noid . '/detil'); ?>">
                                            Detail
                                        </a>
                                        <?php if ($order->orders_status == 0): ?>
                                            <a class="btn btn-primary r-btn-pink"
                                               href="<?= site_url('checkout/' . $order->orders_noid . '/alamat_pengiriman'); ?>">
                                                <i class="fas fa-sync mr-2"></i>Proses
                                            </a>
                                        <?php elseif ($order->orders_status == 1): ?>
                                            <a class="btn btn-primary r-btn-pink"
                                               href="<?= site_url('checkout/' . $order->orders_noid . '/ongkir_transfer'); ?>">
                                                <i class="fas fa-sync mr-2"></i>Proses
                                            </a>
                                        <?php elseif ($order->orders_status == 2): ?>
                                            <a class="btn btn-primary r-btn-pink"
                                               href="<?= site_url('checkout/' . $order->orders_noid . '/konfirmasi_pembayaran'); ?>">
                                                <i class="fas fa-sync mr-2"></i>Proses
                                            </a>
                                        <?php else: ?>
                                            <i></i>
                                        <?php endif; ?>
                                        <a class="btn c-login-btn c-edit"
                                           href="">
                                            Invoice
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

<?php
include "layout/Footer.php";
?>