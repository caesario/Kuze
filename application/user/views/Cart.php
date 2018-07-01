<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Cart ======= -->
    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">KERANJANG</h5>
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
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item" href="<?= site_url('Home'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Keranjang'); ?>">Keranjang</a>
            </nav>
        </div>
    </div>


    <!-- ======= Detail Cart ======= -->
<?php if ($cart_s($_SESSION['id']) != NULL): ?>
    <?php foreach ($cart_s($_SESSION['id']) as $cart): ?>
    <div class="container-fluid c-padding-header">
        <?php if ($item_detil($cart->item_detil_kode)->item->i_kode): ?>
            <?php $item_kode = $item_detil($cart->item_detil_kode)->item->i_kode; ?>
            <?php if ($item_img($item_kode) != NULL): ?>
        <table class="table table-responsive-md table-bordered c-table-vertical">
            <tr>
                <th class="c-table-thumbnail"></th>
                <th class="c-table-name">Nama Produk</th>
<!--                <th class="c-table-code text-center">Code</th>-->
                <th class="c-table-price text-center">Harga</th>
                <th class="c-table-quantity text-center">Jumlah</th>
                <th class="c-table-total text-center">Total</th>
                <td class="c-table-del text-center"><i class="fa fa-times"></i></td>
            </tr>
            <tr>
                <td>
                    <a href=""><img class="c-img-cart" src="<?= base_url('upload/' . $item_img($item_kode)->ii_nama); ?>" alt=""></a>
                </td>
                <td>
                    <p class="c-cart-productname"><a href="detail-item.html"><?= $item_detil($cart->item_detil_kode)->item->i_nama; ?></a></p>
                    <?php else: ?>
                    <p class="c-cart-productname"><a href="detail-item.html"><?= base_url('assets/img/noimg.png'); ?></a></p>
                </td>
                <?php endif; ?>
<!--                <td class="text-center"><p class="c-cart-productname">ACL-03</p></td>-->
                <td class="text-center">
                    <span class="c-price-cart c-price-cart">Rp100.000</span>
                </td>
                <td class="text-center c-input-cart">
                    <input type="number" class="c-number-inc">
                </td>
                <td class="text-center">
                    <span class="c-price-cart-2"><?= $cart->ca_tharga; ?></span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <a href=""><i class="fa fa-times c-black"></i></a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href=""><img class="c-img-cart" src="assets/img/product2.jpg" alt=""></a>
                </td>
                <td>
                    <p class="c-cart-productname"><a href="detail-item.html">Lavish Alice Deep Bandeau Asymmetric</a></p>
                </td>
<!--                <td class="text-center"><p class="c-cart-productname">ACS-00</p></td>-->
                <td class="text-center">
                    <span class="c-price-cart c-price-cart">Rp125.000</span>
                </td>
                <td class="text-center c-input-cart">
                    <input type="number" class="c-number-inc">
                </td>
                <td class="text-center">
                    <span class="c-price-cart-2">Rp125.000</span>
                </td>
                <td class="text-center">
                    <a href=""><i class="fa fa-times c-black"></i></a>
                </td>
            </tr>
        </table>
    </div>
                <?php endforeach; ?>
            <?php endif; ?>


    <!-- ======= Total Cart ======= -->
    <div class="container-fluid c-padding-header c-margin-cart-total">
        <div class="c-cart-total col-lg-5 col-md-6 col-sm-7 float-right">
            <h5 class="c-title-cart-total">CART TOTALS</h5>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th class="c-table-cart-total p-1 pl-4">Subtotal</th>
                    <td><span class="c-price-cart-3 pl-3">Rp<?= $cart_total($_SESSION['id']); ?></span></td>
                </tr>
<!--                <tr>-->
<!--                    <th class="p-1 pl-4">Pengiriman</th>-->
<!--                    <td><span class="c-price-cart-3 pl-3">Rp25.000</span></td>-->
<!--                </tr>-->
                <tr>
                    <th class="p-1 pl-4">Lain-lain</th>
                    <td><span class="c-price-cart-3 pl-3">-</span></td>
                </tr>
                <tr>
                    <th class="p-1 pl-4">Total</th>
                    <td><span class="c-price-cart-2 pl-3 c-l-hight">Rp<?= $cart_total($_SESSION['id']); ?></span></td>
                </tr>
                </tbody>
            </table>
            <a href="<?= site_url('cart/checkout'); ?>" class="btn btn-csr c-btn-cart mt-3 float-right">LANJUTKAN KE ALAMAT</a>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>