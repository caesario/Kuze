<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Cart ======= -->
    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">Cart</h5>

        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item " href="<?= site_url('/'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item active-bread" href="<?= site_url('cart'); ?>">Cart</a>
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


    <!-- ======= Detail Cart ======= -->

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


            <?php if ($cart_s($_SESSION['id']) != NULL): ?>
                <?php foreach ($cart_s($_SESSION['id']) as $cart): ?>
                    <tr>

                        <td>
                            <?php if ($item_detil($cart->item_detil_kode)->item->i_kode): ?>
                                <?php $item_kode = $item_detil($cart->item_detil_kode)->item->i_kode; ?>
                                <?php if ($item_img($item_kode) != NULL): ?>
                                    <a href=""><img class="c-img-cart"
                                                    src="<?= base_url('upload/' . $item_img($item_kode)->ii_nama); ?>"
                                                    alt="<?= $item_img($item_kode)->ii_nama; ?>"></a>
                                <?php else: ?>
                                    <a href=""><img class="c-img-cart"
                                                    src="https://upload.wikimedia.org/wikipedia/commons/archive/a/ac/20121003093557%21No_image_available.svg"
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
                            <a tooltip title="Hapus item" href="<?= site_url('cart/' . $cart->ca_kode . '/delete'); ?>"><i
                                        class="fa fa-times c-black"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>


    <div class="container-fluid c-padding-header c-margin-cart-total">
        <div class="c-cart-total col-lg-5 col-md-6 col-sm-7 px-0 px-sm-3 float-right">
            <h5 class="c-title-cart-total">Promo Code</h5>
            <form action="<?= site_url('cart'); ?>" method="get" class="form-group">

                <div class="input-group mb-3">
                    <input name="kode_promo" type="text" class="form-control" placeholder="Enter Promo Code"
                           aria-label="Masukan Kode Voucher" aria-describedby="basic-addon2" required>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-kupon btn-csr">Use Code</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <br>


    <!-- ======= Total Cart ======= -->
    <div class="container-fluid c-padding-header c-margin-cart-total">
        <div class="c-cart-total col-lg-5 col-md-6 col-sm-7 px-0 px-sm-3 float-right">
            <h5 class="c-title-cart-total">Shopping Summary</h5>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th class="c-table-cart-total p-1 pl-4">Total Price</th>
                    <td><span id="rupiah" class="c-price-cart-3 pl-3"><?= $cart_total($_SESSION['id']); ?></span></td>
                </tr>
                <tr>
                    <th class="p-1 pl-4">Discount</th>
                    <td><span class="c-price-cart-3 pl-3">-</span></td>
                </tr>
                <tr>
                    <th class="p-1 pl-4">Other</th>
                    <td><span class="c-price-cart-3 pl-3">-</span></td>
                </tr>

                <tr>
                    <th class="p-1 pl-4">Total</th>
                    <td><span id="rupiah"
                              class="c-price-cart-2 pl-3 c-l-hight"><?= $cart_total($_SESSION['id']); ?></span></td>
                </tr>
                </tbody>
            </table>
            <a href="<?= site_url('cart/checkout'); ?>" class="btn btn-csr c-btn-cart mt-3 float-right">Address
                Shipping</a>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>