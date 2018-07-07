<?php
include "layout/Header.php";
include "layout/Menu.php";
?>
<?php $nomor_order = $this->uri->segment(2); ?>
    <!-- ======= Banner Checkout ======= -->
    <div class="wrapper-cart c-margin-bot-cart">
        <h5 class="text-center c-title-cart">Detail Pesanan</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item" href="<?= site_url('/'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('cart'); ?>">Keranjang</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Alamat'); ?>">Alamat</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Metode_pengiriman'); ?>">Metode Pengiriman</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Konfirmasi'); ?>">Konfirmasi</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Konfirmasi_sukses'); ?>">Konfirmasi Sukses</a>
            </nav>
        </div>
    </div>


    <!-- ======= Detail Order ======= -->
    <div class="container-fluid c-padding-header c-margin-bot-detail-order">
        <!--        <div class="c-order-info">-->
        <!--            <p>Thank you, Your order has been received</p>-->
        <!--            <ul>-->
        <!--                <li>Order number : <b>#421504</b></li>-->
        <!--                <li>Date : <b>19 May 2018</b></li>-->
        <!--            </ul>-->
        <!--        </div>-->

        <div class="container">
            <h5 class="text-center c-order-info mb-3">DETAIL PESANAN : #<?= $nomor_order; ?></h5>
            <br>
            <div class="row mt-3">
                <div class="col-md-6 col-sm-12">
                    <div class="c-order-info">
                        <p class="mb-1"><i class="fa fa-credit-card mr-2"></i><b>Nama Penerima</b></p>
                        <p class="ml-5 mb-0"> <?= $nama_nomor(); ?></p>

                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="c-order-info">
                        <p class="mb-2"><i class="fa fa-credit-card mr-2"></i> <b>Rekening Transfer</b></p>
                        <p class="ml-5"><?= $metode_pembayaran(); ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="c-order-info">
                        <p class="mb-2"><i class="fa fa-address-book mr-2"></i> <b>Alamat Pengiriman</b></p>
                        <p class="ml-5"> <?= $pengiriman(); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="c-order-info">
                        <p class="mb-2"><i class="fa fa-car mr-2"></i> <b>Metode Pengiriman</b></p>
                        <p class="ml-5"> <?= $jasa(); ?></p>
                    </div>
                </div>
            </div>
        </div>

    <hr style="color:black;">

        <h4 class="text-center mt-5">
            <b>Konfirmasi Pembayaran</b>
        </h4>
        <h2 class="text-center">Sukses</h2>
        <br>
        <div class="row mb-3">
            <div class="col-3 m-auto">
                <a href="<?= site_url('order_status'); ?>" class="btn btn-csr c-btn-cart btn-lg pt-4 pb-4 btn-block f-button-font">
                    Lihat Status</a>
            </div>
        </div>

    </div>
<!--
    </div>

<?php $biaya_subtotal = $biaya_subtotal();
$biaya_pengiriman = $biaya_pengiriman();
$total = $biaya_subtotal + $biaya_pengiriman;
?>

<?php
include "layout/Footer.php";
?>