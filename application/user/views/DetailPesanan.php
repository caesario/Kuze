<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Checkout ======= -->
    <div class="wrapper-cart c-margin-bot-cart">
        <h5 class="text-center c-title-cart">Detail Pesanan</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
            </nav>
        </div>
    </div>


    <!-- ======= Detail Order ======= -->
    <div class="container-fluid c-padding-header c-margin-bot-detail-order ">

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
                            <a href="<?= site_url('Profil'); ?>" class="list-group-item list-group-item-action ">Profil</a>
                            <a href="<?= site_url('Alamat_profil'); ?>" class="list-group-item list-group-item-action ">Alamat</a>
                            <a href="<?= site_url('Order_status'); ?>" class="list-group-item list-group-item-action c-profil-active">Transaksi Tertunda</a>
                            <a href="<?= site_url('Order_history'); ?>" class="list-group-item list-group-item-action">Riwayat Transaksi</a>
                            <a href="<?= site_url('Resi'); ?>" class="list-group-item list-group-item-action">Laporan Resi</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-9">
                <div class="card bg-light">
                <div class="container">
                    <h5 class="text-center c-order-info mt-4">DETAIL PESANAN : #<?= $orders_noid; ?></h5>
                    <p class="text-center c-order-info mt-2 mb-4">Status :
                        <?php if ($orders->orders_status == 0): ?>
                            BELUM MENGISI ALAMAT PENGIRIMAN
                        <?php elseif ($orders->orders_status == 1): ?>
                            BELUM MENGISI METODE PENGIRIMAN & PEMBAYARAN
                        <?php elseif ($orders->orders_status == 2): ?>
                            PELANGGAN BELUM KONFIRMASI PEMBAYARAN
                        <?php elseif ($orders->orders_status == 3): ?>
                            ADMIN BELUM KONFIRMASI PEMBAYARAN
                        <?php elseif ($orders->orders_status == 4): ?>
                            ADMIN SEDANG MEMPROSES ORDER
                        <?php elseif ($orders->orders_status == 5): ?>
                            ADMIN BELUM KONFIRMASI PENGIRIMAN
                        <?php elseif ($orders->orders_status == 6): ?>
                            SUKSES (Telah dikirim)
                        <?php elseif ($orders->orders_status == 7): ?>
                            BATAL
                        <?php endif; ?></p>


                    <?php if ($orders->orders_status > 2): ?>
                    <div class="row ml-3 mr-2 mt-2">
                        <div class="col-md-7 col-sm-12">
                            <div class="c-order-info">
                                <p class="mb-1"><i class="fa fa-credit-card mr-2"></i><b>Nama Penerima</b></p>
                                <p class="ml-5 mb-0"><?= $nama_nomor(); ?></p>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="c-order-info">
                                <p class="mb-2"><i class="fa fa-credit-card mr-2"></i> <b>Rekening Transfer</b></p>
                                <p class="ml-5"><?= $metode_pembayaran(); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row ml-3 mr-2 mt-2">
                        <div class="col-md-7 col-sm-12">
                            <div class="c-order-info">
                                <p class="mb-2"><i class="fa fa-address-book mr-2"></i> <b>Alamat Pengiriman</b></p>
                                <p class="ml-5"><?= $pengiriman(); ?></p>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="c-order-info">
                                <p class="mb-2"><i class="fa fa-car mr-2"></i> <b>Metode Pengiriman</b></p>
                                <p class="ml-5"> <?= $jasa(); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>


                <div class="row mb-5">
                    <!-- ======= Detail Order Table ======= -->
                    <div class="container">
                    <div class="col-lg-12">
                        <h5 class="mb-4 mt-4">PESANAN ANDA</h5>
                        <table class="table table-bordered table-responsive-md">
                            <tbody>
                            <tr>
                                <th class="c-order-table pl-4">Nama Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Harga Satuan</th>
                                <th class="text-center">Total Harga</th>
                            </tr>

                            <?php foreach ($orders->order_detil as $detil): ?>
                            <tr>
                                <td><p class="c-cart-productname ml-5"><a href="<?= base_url('Detil'); ?>"><?= $item_detil($detil->item_detil_kode)->item->i_nama; ?></a></p></td>
                                <td class="text-center"><span class="c-price-cart-3"><?= $detil->orders_detil_qty; ?></span></td>
                                <td class="text-center"><span class="c-price-cart-3"><?= $detil->orders_detil_harga; ?></span></td>
                                <td class="text-center"><span class="c-price-cart-3"><?= $detil->orders_detil_tharga; ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    </div>

                </div>
                <div class="container">
                    <div class="c-cart-total col-lg-5 col-md-6 col-sm-7 float-right p-0">
                        <h5 class="c-title-cart-total">PERHITUNGAN HARGA</h5>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th class="c-table-cart-total p-1 pl-4">Subtotal</th>
                                <td><span class="c-price-cart-3 pl-3"><?= $biaya_subtotal(); ?></span></td>
                            </tr>
                            <tr>
                                <th class="p-1 pl-4">Pengiriman</th>
                                <td><span class="c-price-cart-3 pl-3"> <?= $biaya_pengiriman(); ?></span></td>
                            </tr>
                            <tr>
                                <th class="p-1 pl-4">Lain-lain</th>
                                <td><span class="c-price-cart-3 pl-3">-</span></td>
                            </tr>
                            <tr>
                                <th class="p-1 pl-4">Total</th>
                                <td><span class="c-price-cart-2 pl-3 c-l-hight"> <?= $biaya_subtotal() + $biaya_pengiriman(); ?></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <a href="<?= site_url('Order_status'); ?>" class="btn btn-csr c-btn-cart mt-3 float-right">Kembali</a>
                    </div>
                </div>
                </div>
            </div>
        </div>
<!--        <div class="c-order-info">-->
<!--            <p>Thank you, Your order has been received</p>-->
<!--            <ul>-->
<!--                <li>Order number : <b>#421504</b></li>-->
<!--                <li>Date : <b>19 May 2018</b></li>-->
<!--            </ul>-->
<!--        </div>-->


    </div>

<?php
include "layout/Footer.php";
?>