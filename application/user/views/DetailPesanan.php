<?php
include "layout/Header.php";
include "layout/Menu.php";
?>
    <!-- ======= Banner Checkout ======= -->
    <div class="wrapper-cart c-margin-bot-cart">
        <h5 class="text-center c-title-cart">Order Detail</h5>
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
                    <div class="col-12">
                        <div class="list-group mb-4">
                            <a href="<?= site_url('profil'); ?>"
                               class="list-group-item list-group-item-action ">
                                My Profile
                            </a>
                            <a href="<?= site_url('profil'); ?>"
                               class="list-group-item list-group-item-action ">
                                Change Password
                            </a>
                            <a href="<?= site_url('alamat_profil'); ?>" class="list-group-item list-group-item-action ">Address</a>
                            <a href="<?= site_url('order_status'); ?>"
                               class="list-group-item list-group-item-action">Pending Orders</a>
                            <a href="<?= site_url('order_history'); ?>" class="list-group-item list-group-item-action">Order History</a>
                            <a href="<?= site_url('resi'); ?>" class="list-group-item list-group-item-action">Airwaybill Report</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-9">
                <div class="card bg-light">
                <div class="container">
                    <h5 class="text-center c-order-info mt-4">ORDER ID : #<?= $orders_noid; ?></h5>
                    <p class="text-center c-order-info mt-2 mb-4">Status :
                        <?php if ($orders->orders_status == 0): ?>
                            YOU NEED TO FILL THE ADDRESS
                        <?php elseif ($orders->orders_status == 1): ?>
                            YOU NEED TO FILL SHIPPING & PAYMENT METHOD
                        <?php elseif ($orders->orders_status == 2): ?>
                            YOU NEED TO CONFIRM YOUR PAYMENT
                        <?php elseif ($orders->orders_status == 3): ?>
                            ON PROCESS
                        <?php elseif ($orders->orders_status == 4): ?>
                            ON PROCESS
                        <?php elseif ($orders->orders_status == 5): ?>
                            ON PROCESS
                        <?php elseif ($orders->orders_status == 6): ?>
                            SUCCESS (Telah dikirim)
                        <?php elseif ($orders->orders_status == 7): ?>
                           CANCEL
                        <?php endif; ?></p>


                    <?php if ($orders->orders_status > 2): ?>
                    <div class="row ml-3 mr-2 mt-2">
                        <div class="col-md-7 col-sm-12">
                            <div class="c-order-info">
                                <p class="mb-1"><i class="fa fa-credit-card mr-2"></i><b>Recipient</b></p>
                                <p class="ml-5 mb-0"><?= $nama_nomor; ?></p>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="c-order-info">
                                <p class="mb-2"><i class="fa fa-credit-card mr-2"></i> <b>Bank Account</b></p>
                                <p class="ml-5"><?= $metode_pembayaran; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row ml-3 mr-2 mt-2">
                        <div class="col-md-7 col-sm-12">
                            <div class="c-order-info">
                                <p class="mb-2"><i class="fa fa-address-book mr-2"></i> <b>Shipping Address</b></p>
                                <p class="ml-5"><?= $pengiriman; ?></p>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="c-order-info">
                                <p class="mb-2"><i class="fa fa-car mr-2"></i> <b>Shipping Method</b></p>
                                <p class="ml-5"> <?= $jasa; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>


                <div class="row mb-5">
                    <!-- ======= Detail Order Table ======= -->
                    <div class="container">
                    <div class="col-lg-12">
                        <h5 class="mb-4 mt-4">YOUR ORDER</h5>
                        <table class="table table-bordered table-responsive-md">
                            <tbody>
                            <tr>
                                <th class="c-order-table pl-4">PRODUCT NAME</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">PRICE</th>
                                <th class="text-center">TOTAL</th>
                            </tr>

                            <?php foreach ($orders->order_detil as $detil): ?>
                            <tr>
                                <td><p class="c-cart-productname ml-5"><a href="<?= base_url('Detil'); ?>"><?= $item_detil($detil->item_detil_kode)->item->i_nama; ?></a></p></td>
                                <td class="text-center"><span class="c-price-cart-3"><?= $detil->orders_detil_qty; ?></span></td>
                                <td class="text-center"><span id="rupiah"
                                                              class="c-price-cart-3"><?= $detil->orders_detil_harga; ?></span>
                                </td>
                                <td class="text-center"><span id="rupiah"
                                                              class="c-price-cart-3"><?= $detil->orders_detil_tharga; ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    </div>

                </div>
                <div class="container">
                    <div class="c-cart-total col-lg-6 col-md-6 col-sm-7 px-0 px-sm-3 float-right">
                        <h5 class="c-title-cart-total">Promo</h5>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th class="c-table-cart-total p-1 pl-4">Coupon</th>
                                <td>
                                    <span class="c-price-cart-3 pl-3"><?= isset($promo) ? $promo->promo_nama : '-'; ?></span>
                                </td>
                            </tr>
                            <tr>
                            <tr>
                                <th class="p-1 pl-4">Note</th>
                                <td>
                                    <span class="c-price-cart-2 pl-3 c-l-hight"><?= isset($promo) ? $promo->promo_ket : '-'; ?></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <h5 class="c-title-cart-total">Shopping Summary</h5>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th class="c-table-cart-total p-1 pl-4">Total Price</th>
                                <td><span id="rupiah"
                                          class="c-price-cart-3 pl-3"><?= isset($biaya_subtotal) ? $biaya_subtotal : '-'; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-1 pl-4">Disc. Total Price</th>
                                <td><span id="rupiah"
                                          class="c-price-cart-3 pl-3"><?= isset($diskon_harga) ? $diskon_harga : '-'; ?></span></td>
                            </tr>
                            <tr>
                                <th class="p-1 pl-4">Shipping Charges</th>
                                <td><span id="rupiah"
                                          class="c-price-cart-3 pl-3"><?= isset($biaya_pengiriman) ? $biaya_pengiriman : '-'; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th nowrap class="p-1 pl-4 pr-4">Disc. Shipping Charges</th>
                                <td><span class="c-price-cart-3 pl-3">-</span></td>
                            </tr>

                            <tr>
                                <th class="p-1 pl-4">Grand Total</th>
                                <td><span id="rupiah"
                                          class="c-price-cart-2 pl-3 c-l-hight"><?= $grand_total; ?></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <a href="<?= current_url() . '/order_status'; ?>" class="btn btn-csr c-btn-cart mt-3 float-right">Kembali</a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>