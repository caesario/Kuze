<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Checkout ======= -->
    <div class="wrapper-cart c-margin-bot-cart">
        <h5 class="text-center c-title-cart">Detail Pesanan</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item" href="<?= site_url('Home'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Keranjang'); ?>">Keranjang</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Alamat'); ?>">Alamat</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Metode_pengiriman'); ?>">Metode Pengiriman</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Detal_pesanan'); ?>">Detail Pesanan</a>
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
            <h5 class="text-center c-order-info mb-0">DETAIL PESANAN : #421504</h5>
            <p class="text-center c-order-info mb-4">19 May 2018</p>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="c-order-info">
                        <p class="mb-1"><i class="fa fa-credit-card mr-2"></i><b>Nama Penerima</b></p>
                        <p class="ml-5 mb-0">Jhon Pardede</p>
                        <p class="ml-5">082112998381</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="c-order-info">
                        <p class="mb-2"><i class="fa fa-credit-card mr-2"></i> <b>Rekening Transfer</b></p>
                        <p class="ml-5">BCA a/n Kuze Shop - 41299488733</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="c-order-info">
                        <p class="mb-2"><i class="fa fa-address-book mr-2"></i> <b>Alamat Pengiriman</b></p>
                        <p class="ml-5">Jl. Meruya Tower Utara No.17, Cengkareng - Jakarta Barat 12599</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="c-order-info">
                        <p class="mb-2"><i class="fa fa-car mr-2"></i> <b>Metode Pengiriman</b></p>
                        <p class="ml-5">Jalur Nugraha Ekakurir (JNE) - Ongkos Kirim Ekonomis (4-6 hari)</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-5">
            <!-- ======= Detail Order Table ======= -->
            <div class="col-lg-12">
                <h5 class="mb-4 mt-4">PESANAN ANDA</h5>
                <table class="table table-bordered table-responsive-md">
                    <tbody>
                    <tr>
                        <th class="c-order-table pl-4">Nama Produk</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Total</th>
                    </tr>
                    <tr>
                        <td><p class="c-cart-productname ml-5"><a href="<?= base_url('Detail_item'); ?>">Tank with V-Neck and Panel Detail</a></p></td>
                        <td class="text-center"><span class="c-price-cart-3">Rp100.000</span></td>
                        <td class="text-center"><span class="c-price-cart-3">2</span></td>
                        <td class="text-center"><span class="c-price-cart-3">Rp250.000</span></td>
                    </tr>
                    <tr>
                        <td><p class="c-cart-productname ml-5"><a href="detail-item.html">Lavish Alice Deep Bandeau Asymmetric</a></p></td>
                        <td class="text-center"><span class="c-price-cart-3">Rp200.000</span></td>
                        <td class="text-center"><span class="c-price-cart-3">1</span></td>
                        <td class="text-center"><span class="c-price-cart-3">Rp250.000</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="">
            <div class="c-cart-total col-lg-5 col-md-6 col-sm-7 float-right p-0">
                <h5 class="c-title-cart-total">PERHITUNGAN HARGA</h5>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th class="c-table-cart-total p-1 pl-4">Subtotal</th>
                        <td><span class="c-price-cart-3 pl-3">Rp225.000</span></td>
                    </tr>
                    <tr>
                        <th class="p-1 pl-4">Pengiriman</th>
                        <td><span class="c-price-cart-3 pl-3">Rp25.000</span></td>
                    </tr>
                    <tr>
                        <th class="p-1 pl-4">Lain-lain</th>
                        <td><span class="c-price-cart-3 pl-3">-</span></td>
                    </tr>
                    <tr>
                        <th class="p-1 pl-4">Total</th>
                        <td><span class="c-price-cart-2 pl-3 c-l-hight">Rp450.000</span></td>
                    </tr>
                    </tbody>
                </table>
                <a href="<?= site_url('#'); ?>" class="btn btn-csr c-btn-cart mt-3 float-right">KONFIRMASI PEMBAYARAN</a>
            </div>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>