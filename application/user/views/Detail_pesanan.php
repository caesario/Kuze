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
        <div class="c-order-info">
            <p>Thank you, Your order has been received</p>
            <ul>
                <li>Order number : <b>1504</b></li>
                <li>Date : <b>19 May 2018</b></li>
                <li>Total : <b>Rp250.000</b></li>
                <li>Payment method : <b>Virtual Account</b></li>
            </ul>
        </div>
        <div class="c-order-info">
            <p class="mb-2">Rekening Transfer</p>
            <p class="ml-4"><b>BCA a/n Kuze Shop - 41299488733</b></p>
        </div>
        <div class="row">
            <!-- ======= Detail Order Table ======= -->
            <div class="col-lg-12">
                <h5 class="mb-4 mt-4">YOUR ORDER</h5>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th class="c-order-table pl-4">Product</th>
                        <th class="text-center">Total</th>
                    </tr>
                    <tr>
                        <td><p class="c-cart-productname ml-5"><a href="<?= base_url('Detail_item'); ?>">Tank with V-Neck and Panel Detail</a></p></td>
                        <td class="text-center"><span class="c-price-cart-3">Rp100.000</span></td>
                    </tr>
                    <tr>
                        <td><p class="c-cart-productname ml-5"><a href="detail-item.html">Lavish Alice Deep Bandeau Asymmetric</a></p></td>
                        <td class="text-center"><span class="c-price-cart-3">Rp125.000</span></td>
                    </tr>
                    <tr>
                        <th class="c-table-cart-total p-1 pl-4">Subtotal</th>
                        <td class="text-center"><span class="c-price-cart-3">Rp225.000</span></td>
                    </tr>
                    <tr>
                        <th class="p-1 pl-4">Shipping</th>
                        <td class="text-center"><span class="c-price-cart-3">Rp25.000</span></td>
                    </tr>
                    <tr>
                        <th class="p-1 pl-4">Other</th>
                        <td class="text-center"><span class="c-price-cart-3">-</span></td>
                    </tr>
                    <tr>
                        <th class="p-1 pl-4">Total</th>
                        <td class="text-center"><span class="c-price-cart-4 c-l-hight">Rp250.000</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="<?= site_url(''); ?>" class="btn btn-csr c-btn-cart mt-3 float-right">KONFIRMASI PEMBAYARAN</a>
    </div>

<?php
include "layout/Footer.php";
?>