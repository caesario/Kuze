<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Checkout ======= -->
    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">METODE PENGIRIMAN</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item" href="<?= site_url('Home'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Keranjang'); ?>">Keranjang</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Alamat'); ?>">Alamat Pengiriman</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Metode_pengiriman'); ?>">Metode Pengiriman</a>
            </nav>
        </div>
    </div>


    <!-- ======= Detail Checkout ======= -->
    <div class="container-fluid c-padding-header mb-5">
        <div class="row">
            <!-- ======= Checkout Left ======= -->
            <div class="col-lg-6">
                <h5 class="mb-4">PENGIRIMAN</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        <p class="c-pengiriman-jne">JNE REG (Reguler) - Ongkos Kirim Ekonomis (4-6 hari) ( Rp. 44.000)</p>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                    <label class="form-check-label" for="exampleRadios2">
                        <p class="c-pengiriman-jne">JNE YES (Yakin Esok Sampai) - Layanan Reguler (2-4 hari) ( Rp. 50.000)
                        </p>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">
                    <label class="form-check-label" for="exampleRadios3">
                        <p class="c-pengiriman-jne">JNE OKE (Ongkos Kirim Ekonomis) - Layanan Reguler (5-7 hari) ( Rp. 37.000)
                        </p>
                    </label>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="option4">
                    <label class="form-check-label" for="exampleRadios4">
                        <p class="c-pengiriman-jne">JNE PIPO (Pick-Up Point)</p>
                    </label>
                </div>

                <!-- ======= Bank Method ======= -->
                <h5 class="mb-4">BANK</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleBank" id="exampleBank1" value="option1" checked>
                    <label class="form-check-label" for="exampleBank1">
                        <p class="c-pengiriman-jne">BCA a/n Pevita Pearce 345512756</p>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleBank" id="exampleBank2" value="option2">
                    <label class="form-check-label" for="exampleBank2">
                        <p class="c-pengiriman-jne">Mandiri a/n Pevita Pearce 698223541</p>
                    </label>
                </div>
                <a href="<?= site_url('Detail_pesanan'); ?>" class="btn btn-csr c-btn-cart mt-3 float-left">PROSES PESANAN</a>
            </div>


            <!-- ======= Checkout Right ======= -->
<!--            <div class="col-lg-6">-->
<!--                <h5 class="mb-4">KERANJANG ANDA</h5>-->
<!--                <table class="table table-bordered">-->
<!--                    <tbody>-->
<!--                    <tr>-->
<!--                        <th></th>-->
<!--                        <th>Nama Produk</th>-->
<!--                        <th class="text-center">Total</th>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td><a href=""><img class="c-img-checkout" src="assets/img/product4.jpg" alt=""></a></td>-->
<!--                        <td><p class="c-cart-productname"><a href="detail-item.html">Tank with V-Neck and Panel Detail</a></p></td>-->
<!--                        <td><span class="c-price-cart-3 pl-3">Rp100.000</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td><a href=""><img class="c-img-checkout" src="assets/img/product2.jpg" alt=""></a></td>-->
<!--                        <td><p class="c-cart-productname"><a href="detail-item.html">Lavish Alice Deep Bandeau Asymmetric</a></p></td>-->
<!--                        <td><span class="c-price-cart-3 pl-3">Rp125.000</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th class="c-table-cart-total p-1 pl-4">Subtotal</th>-->
<!--                        <td colspan="2" class="text-center"><span class="c-price-cart-3 pl-3">Rp225.000</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th class="p-1 pl-4">Pengiriman</th>-->
<!--                        <td colspan="2" class="text-center"><span class="c-price-cart-3 pl-3">RP25.000</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th class="p-1 pl-4">Lainnya</th>-->
<!--                        <td colspan="2" class="text-center"><span class="c-price-cart-3 pl-3">-</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th class="p-1 pl-4">Total</th>-->
<!--                        <td colspan="2" class="text-center"><span class="c-price-cart-4 pl-3 c-l-hight">Rp250.000</span></td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
        </div>
    </div>

<?php
include "layout/Footer.php";
?>