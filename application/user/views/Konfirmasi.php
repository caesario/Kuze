<?php
include "layout/Header.php";
include "layout/Menu.php";
?>
<?php $nomor_order = $this->uri->segment(2); ?>
    <!-- ======= Banner Checkout ======= -->
    <div class="wrapper-cart c-margin-bot-cart">
        <h5 class="text-center c-title-cart">Order Detail</h5>
        <div class="c-breadcrumb text-center c-bread-padding px-2">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item " href="<?= site_url('/'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item " href="<?= site_url('cart'); ?>">Bag</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item " href="<?= site_url('Alamat'); ?>">Address</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item " href="<?= site_url('Metode_pengiriman'); ?>">Metode</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="">Order Detail</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item active-bread" href="<?= site_url('Konfirmasi'); ?>">Confirmation</a>
            </nav>
        </div>
    </div>

    <!-- Detail Konfirmasi Pembayaran -->
    <div class="container">
        <h5 class="text-center c-color-444 mb-5">ORDER DETAIL : #<?= $nomor_order; ?></h5>
    </div>
    <div class="row c-color-444 mx-0">
        <div class="col-md-8 col-12 m-auto">
            <div class="ml-1 row">
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="">
                        <p class="mb-1"><i class="fa fa-credit-card mr-2"></i><b>Recipient</b></p>
                        <p class="mb-0"><?= $nama_nomor; ?></p>

                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="">
                        <p class="mb-2"><i class="fa fa-credit-card mr-2"></i> <b>Bank Account</b></p>
                        <p class="mr-5"><?= $metode_pembayaran; ?></p>
                    </div>
                </div>
            </div>
            <div class="ml-1 row">
                <div class="col-md-6 col-sm-12">
                    <div class="">
                        <p class="mb-2"><i class="fa fa-address-book mr-2"></i> <b>Shipping Address</b></p>
                        <p class="mr-4"><?= $pengiriman; ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="">
                        <p class="mb-2"><i class="fa fa-car mr-2"></i> <b>Shipping Method</b></p>
                        <p class="mr-5">  <?= $jasa; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-12 c-margin-auto">
            <div class="col-lg-12">
                <h5 class="mb-4 mt-4 c-color-333">Your Order</h5>
                <table class="table table-bordered table-responsive-md">
                    <tbody>
                    <tr>
                        <th class="c-order-table-konfirmasi pl-4">Product Name</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                    </tr>

                    <?php foreach ($orders->order_detil as $detil): ?>
                        <tr>
                            <td><p class="c-cart-productname ml-5"><a
                                            href="<?= base_url('Detil'); ?>"><?= $item_detil($detil->item_detil_kode)->item->i_nama; ?></a>
                                </p></td>
                            <td class="text-center"><span class="c-price-cart-3"><?= $detil->orders_detil_qty; ?></span>
                            </td>
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

        <div class="col-md-8 col-12 c-margin-auto mt-4 small">
            <div class="c-cart-total col-lg-6 col-md-6 col-sm-7 px-0 px-sm-3 float-right">
                <h5 class="c-title-cart-total">Promo</h5>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th class="c-table-cart-total p-1 pl-4">Coupon</th>
                        <td>
                            <span class="c-price-cart-3 pl-3"><?= isset($promo->promo_nama) ? $promo->promo_nama : '-'; ?></span>
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <th class="p-1 pl-4">Note</th>
                        <td>
                            <span class="c-price-cart-2 pl-3 c-l-hight"><?= isset($promo->promo_ket) ? $promo->promo_ket : '-'; ?></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <h5 class="c-title-cart-total">Shopping Summary</h5>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th class="c-table-cart-total p-1 pl-4">Total Price</th>
                        <td><span id="rupiah" class="c-price-cart-3 pl-3"><?= $biaya_subtotal; ?></span></td>
                    </tr>
                    <tr>
                        <th class="p-1 pl-4">Disc. Total Price</th>
                        <td><span id="rupiah"
                                  class="c-price-cart-3 pl-3"><?= isset($diskon_harga) ? $diskon_harga : '-'; ?></span>
                        </td>
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

            </div>
        </div>
    </div>

    <div class="container-fluid c-padding-header mb-5">
        <div class="row">
            <div class="col-md-8 col-12 c-margin-auto">
                <h5 class="c-color-444"><i class="fa fa-money mr-2 mt-4 mb-2"></i>Payment Confirmation</h5>
                <form action="konfirmasi_pembayaran/simpan" method="post">
                    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label class="col-form-label">Bank Account <span class="c-form-star">*</span></label>
                        <input type="text"
                               class="form-control"
                               id="inputRekeningNama"
                               placeholder="Enter Bank Account . . ."
                               name="bank"
                               required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label mt-1">Account Name <span class="c-form-star ">*</span></label>
                        <input type="text"
                               class="form-control mt-1"
                               id="inputNamaBank"
                               placeholder="Enter Account Name . . ."
                               name="rek_atasnama"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="example-date-input" class="col-form-label">Transfer Amount<span class="c-form-star">*</span></label>
                        <input class="form-control"
                               type="number"
                               id="inputNominalTransfer"
                               placeholder="Enter Transfer Amount"
                               name="nomor_rekening"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="total_pembayaran">Grand Total : *</label>
                        <input type="number" class="form-control" min="<?= $grand_total; ?>"
                               max="<?= $grand_total; ?>"
                               name="total_pembayaran" placeholder=""
                               value="<?= $grand_total; ?>"
                               required>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-csr c-btn-cart mt-3 mb-5 float-right">PAYMENT
                                CONFIRMATION
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="col-md-8 col-12 c-margin-auto">

    </div>

<?php
include "layout/Footer.php";
?>