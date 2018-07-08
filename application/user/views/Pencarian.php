<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Kategori Pesanan ======= -->
    <div class="wrapper-cart mb-0">
        <h5 class="text-center c-title-cart">Pencarian</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <p>

            </p>
        </div>
    </div>

    <!-- ======= Breadcrumb ======= -->
    <div class="wrapper-bredcrumb">
        <div class="container-flu c-padding-header">
            <div class="c-breadcrumb">
                <nav class="c-nav-breadcrumb">
                    <a class="breadcrumb-item" href="<?= site_url('/'); ?>">Home</a>
                    <i class="fa fa-arrow-right"></i>
                    <span class="breadcrumb-item c-breadcrum-active"
                          href="Pencarian "><?= $this->input->get('cari'); ?></span>
                </nav>
            </div>
        </div>
    </div>


    <!-- Pencarian -->
    <div class="container-fluid c-padding-header">
    <div class="row">
        <?php if (isset($cari_s) && $cari_s != NULL): ?>
            <?php foreach ($cari_s as $cari): ?>
                <?php $stok = $qty($cari->i_kode); ?>
                <?php if ($stok > 1): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="card">
                            <?php if ($item_img($cari->i_kode) != NULL): ?>

                                <a class="" href="<?= base_url('Detil'); ?>">
                                    <img class="card-img-top"
                                         src="<?= base_url('upload/' . $item_img($cari->i_kode)->ii_nama); ?>"
                                         alt="<?= $item_img($cari->i_kode)->ii_nama; ?>">
                                    <div class="middle">
                                        <a href="<?= site_url('produk-terbaru/item/' . $cari->i_url . '/detil'); ?>"
                                           class="c-view-kat-text">Quick View</a>
                                    </div>
                                </a>
                            <?php else: ?>
                                <a class="" href="<?= base_url('Detil'); ?>">
                                    <img class="card-img-top"
                                         src="https://upload.wikimedia.org/wikipedia/commons/archive/a/ac/20121003093557%21No_image_available.svg"
                                         alt="No Image">
                                    <div class="middle">
                                        <a href="<?= site_url('kategori/' . $k_url . '/item/' . $kat->item->i_url . '/detil'); ?>"
                                           class="c-view-kat-text">Quick View</a>
                                    </div>
                                </a>
                            <?php endif; ?>
                            <div class="card-body">
                                <i class="fa fa-star c-star"></i>
                                <i class="fa fa-star c-star"></i>
                                <i class="fa fa-star c-star"></i>
                                <i class="fa fa-star c-star"></i>
                                <i class="fa fa-star c-star"></i>
                                <h5 class="card-title c-both c-title"><?= $cari->i_nama; ?></h5>
                                <?php if (isset($_SESSION['tipe']) && $_SESSION['tipe'] == '1'): ?>
                                    <h5 id="rupiah" class="c-price"><?= $cari->i_hrg_vip; ?></h5>
                                <?php else: ?>
                                    <h5 id="rupiah"
                                        class="c-price"><?= $cari->i_hrg_reseller; ?></h5>
                                <?php endif; ?>
                                <a href="                                        <a href="<?= site_url('produk-terbaru/item/' . $cari->i_url . '/detil'); ?>"
                                "
                                   class="btn btn-csr c-cart c-cart-p">
                                    <i class="fa fa-shopping-cart c-cart-i"></i> BELI BARANG
                                </a>
                                <!--                        <a href="" class="btn btn-csr c-cart">-->
                                <!--                            <i class="fa fa-heart c-cart-i2"></i>-->
                                <!--                        </a>-->
                                <!--                        <a href="" class="btn btn-csr c-cart">-->
                                <!--                            <i class="fa fa-refresh c-cart-i2""></i>-->
                                <!--                        </a>-->
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (isset($items) && $items != NULL): ?>
            <?php foreach ($items as $item): ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <?php if ($item_img($item->i_kode) != NULL): ?>

                            <a class="" href="<?= base_url('Detil'); ?>">
                                <img class="card-img-top"
                                     src="<?= base_url('upload/' . $item_img($item->i_kode)->ii_nama); ?>"
                                     alt="<?= $item_img($item->i_kode)->ii_nama; ?>">
                                <div class="middle">
                                    <a href="<?= site_url('kategori/all/item/' . $item->i_url . '/detil'); ?>"
                                       class="c-view-kat-text">Quick View</a>
                                </div>
                            </a>
                        <?php else: ?>
                            <a class="" href="<?= base_url('Detil'); ?>">
                                <img class="card-img-top"
                                     src="https://upload.wikimedia.org/wikipedia/commons/archive/a/ac/20121003093557%21No_image_available.svg"
                                     alt="No Image">
                                <div class="middle">
                                    <a href="<?= site_url('kategori/all/item/' . $item->i_url . '/detil'); ?>"
                                       class="c-view-kat-text">Quick View</a>
                                </div>
                            </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <i class="fa fa-star c-star"></i>
                            <i class="fa fa-star c-star"></i>
                            <i class="fa fa-star c-star"></i>
                            <i class="fa fa-star c-star"></i>
                            <i class="fa fa-star c-star"></i>
                            <h5 class="card-title c-both c-title"><?= $item->i_nama; ?></h5>
                            <?php if (isset($_SESSION['tipe']) && $_SESSION['tipe'] == '1'): ?>
                                <h5 id="rupiah" class="c-price"><?= $item->i_hrg_vip; ?></h5>
                            <?php else: ?>
                                <h5 id="rupiah" class="c-price"><?= $item->i_hrg_reseller; ?></h5>
                            <?php endif; ?>
                            <a href="<?= site_url('kategori/all/item/' . $item->i_url . '/detil'); ?>"
                               class="btn btn-csr c-cart c-cart-p">
                                <i class="fa fa-shopping-cart c-cart-i"></i> BELI BARANG
                            </a>
                            <!--                        <a href="" class="btn btn-csr c-cart">-->
                            <!--                            <i class="fa fa-heart c-cart-i2"></i>-->
                            <!--                        </a>-->
                            <!--                        <a href="" class="btn btn-csr c-cart">-->
                            <!--                            <i class="fa fa-refresh c-cart-i2""></i>-->
                            <!--                        </a>-->
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>

        <?php endif; ?>
    </div>
    </div>
    <script>
        $('[id="title"]').ellipsis();
    </script>
<?php
include "layout/Footer.php";
?>