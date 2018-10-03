<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Bag ======= -->
    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">Bag</h5>

        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item" href="">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item active-bread" href="">Bag</a>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal'] != ""): ?>
                <div class="col">
                    <div class="alert alert-danger alert-dismissible fade show"
                         role="alert">
                        <?php echo $_SESSION['gagal']; ?>
                        <button type="button" class="close" data-dismiss="alert"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] != ""): ?>
                <div class="col">
                    <div class="alert alert-success alert-dismissible fade show"
                         role="alert">
                        <?php echo $_SESSION['berhasil']; ?>
                        <button type="button" class="close" data-dismiss="alert"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <!-- ======= Detail Bag ======= -->
    <div class="container-fluid c-padding-header">
        <table class="table table-responsive-md table-bordered c-table-vertical">
            <tr>
                <th class="c-table-thumbnail"></th>
                <th class="c-table-name">Product Name</th>
                <th class="c-table-price text-center">Size</th>
                <th class="c-table-price text-center">Price</th>
                <th class="c-table-quantity text-center">Quantity</th>
                <th class="c-table-total text-center">Total</th>
                <td class="c-table-del text-center"><i class="fa fa-times"></i></td>
            </tr>


            <?php if ($cart_s != NULL): ?>
                <?php foreach ($cart_s as $cart): ?>
                    <tr>
                        <td class="text-center">
                            <?php if ($item_detil($cart->item_detil_kode)->item->i_kode): ?>
                                <?php $item_kode = $item_detil($cart->item_detil_kode)->item->i_kode; ?>
                                <?php if ($item_img($item_kode) != NULL): ?>
                                    <a href=""><img class="c-img-cart"
                                                    src="data:<?= $item_img($item_kode)->ii_type . ';base64,' . (base64_encode($item_img($item_kode)->ii_data)); ?>"
                                                    alt="<?= $item_img($item_kode)->ii_kode; ?>"></a>
                                <?php else: ?>
                                    <a href=""><img class="c-img-cart"
                                                    src="<?= base_url('assets/img/noimage.jpg'); ?>"
                                                    alt="noimg.png"></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <p class="c-cart-productname">
                                <a href="#"><?= $item_detil($cart->item_detil_kode)->item->i_nama; ?></a>
                            </p>
                        </td>
                        <td class="text-center">
                            <p class="c-cart-productname">
                                <?= $item_detil($cart->item_detil_kode)->ukuran->u_nama; ?>
                            </p>
                        </td>
                        <td class="text-center">
                            <span id="rupiah" class="c-price-cart c-price-cart"><?= $cart->ca_harga; ?></span>
                        </td>
                        <td class="text-center">
                            <p class="c-cart-productname">
                                <?= $cart->ca_qty; ?>
                            </p>
                        </td>
                        <td class="text-center">
                            <span id="rupiah" class="c-price-cart-2"><?= $cart->ca_tharga; ?></span>
                        </td>
                        <td class="text-center">
                            <a tooltip title="Hapus item"
                               href="<?= site_url('bag/' . $cart->ca_kode . '/delete'); ?>"><i
                                        class="fa fa-times c-black"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>


    <!-- ======= Total Bag ======= -->
    <div class="container-fluid c-padding-header c-margin-cart-total">
        <div class="c-cart-total col-lg-5 col-md-7 col-sm-10 px-0 px-sm-3 float-right">
            <!-- ======= Promo Code ======= -->
            <h5 class="c-title-cart-total">Promo Code</h5>
            <div class="input-group mb-3">
                <input name="kode_promo" id="kode_promo" type="text" class="form-control" placeholder="Enter Promo Code"
                       aria-label="Masukan Kode Voucher">
                <div class="input-group-append">
                    <button type="submit" id="btn_kode" class="btn btn-kupon btn-csr">Use Code</button>
                </div>
            </div>
            <script>
                $('#btn_kode').click(function () {
                    kode_promo = $('#kode_promo').val();
                    window.location.href = '/bag/promo/' + kode_promo;
                });
            </script>
            <br>
            <!-- ======= Promo ======= -->
            <h5 class="c-title-cart-total">Promo</h5>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th class="p-1 pl-4">Coupon</th>
                    <td><span class="c-price-cart-3 pl-3"><?= isset($kode_promo) ? $kode_promo : '-'; ?></span></td>
                </tr>
                <tr>
                <tr>
                    <th class="p-1 pl-4">Note</th>
                    <td><span class="c-price-cart-2 pl-3 c-l-hight"><?= isset($promo_ket) ? $promo_ket : '-'; ?></span>
                    </td>
                </tr>
                </tbody>
            </table>
            <br>
            <!-- ======= Summary ======= -->
            <h5 class="c-title-cart-total">Shopping Summary</h5>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th class="c-table-cart-total p-1 pl-4">Total Price</th>
                    <td><span id="rupiah" class="c-price-cart-3 pl-3"><?= $cart_total; ?></span></td>
                </tr>
                <tr>
                    <th class="p-1 pl-4">Disc. Total Price (-)</th>
                    <td class="text-right"><span id="rupiah"
                              class="c-price-cart-3 pl-3 text-center"><?= isset($diskon_harga) ? $diskon_harga : '-'; ?></span></td>
                </tr>
                <tr>
                    <th class="p-1 pl-4">Shipping Charges</th>
                    <td class="text-right"><span class="c-price-cart-3 pl-3">-</span></td>
                </tr>
                <tr>
                    <th nowrap class="p-1 pl-4 pr-4">Disc. Shipping Charges</th>
                    <td class="text-right"><span class="c-price-cart-3 pl-3">-</span></td>
                </tr>

                <tr>
                    <th class="p-1 pl-4">Grand Total</th>
                    <td class="text-right"><span id="rupiah"
                              class="c-price-cart-2 pl-3 c-l-hight"><?= $grand_total; ?></span></td>
                </tr>
                </tbody>
            </table>
            <a href="<?= current_url() . '/checkout'; ?>" class="btn btn-csr c-btn-cart mt-3 float-right">Address
                Shipping</a>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>