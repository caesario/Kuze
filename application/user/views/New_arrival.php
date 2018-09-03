<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Kategori Pesanan ======= -->
    <div class="wrapper-cart mb-0">
        <h5 class="text-center c-title-cart">New Arrival</h5>
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
                          href="<?= $breadcumburl; ?>"><?= $breadcumb; ?></span>
                </nav>
            </div>
        </div>
    </div>


    <!-- ======= Banner Kategori Pesanan ======= -->
    <div class="container-fluid c-padding-header">
        <div class="container-fluid c-padding-header mt-3">
            <div class="row">
                <?php if (isset($item_kategori) && $item_kategori != NULL): ?>
                    <?php foreach ($item_kategori as $kat): ?>

                        <?php $stok = $qty($kat->item->i_kode); ?>
                        <?php if ($stok >= 1): ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <div class="card">
                                    <?php if ($item_img($kat->item->i_kode) != NULL): ?>
                                        <a class=""
                                           href="<?= site_url('kategori/' . $k_url . '/item/' . $kat->item->i_url . '/detil'); ?>">
                                            <img class="card-img-top"
                                                 src="<?= base_url('upload/' . $item_img($kat->item->i_kode)->ii_nama); ?>"
                                                 alt="<?= $item_img($kat->item->i_kode)->ii_nama; ?>">
                                        </a>
                                    <?php else: ?>
                                        <a class="" href="<?= base_url('Detil'); ?>">
                                            <img class="card-img-top"
                                                 src="https://upload.wikimedia.org/wikipedia/commons/archive/a/ac/20121003093557%21No_image_available.svg"
                                                 alt="No Image">
                                            <div class="middle">
                                                <a href="<?= site_url('kategori/' . $k_url . '/item/' . $kat->item->i_url . '/detil'); ?>"
                                                   class="c-view-kat-text">Quick Viewo</a>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title c-both c-title"><?= $kat->item->i_nama; ?></h5>
                                        <h5 id="rupiah" class="c-price"><?= $kat->item->i_hrg; ?></h5>
                                        <a href="<?= site_url('kategori/' . $k_url . '/item/' . $kat->item->i_url . '/detil'); ?>"
                                           class="btn btn-csr c-cart c-cart-p">
                                            <i class="fa fa-shopping-cart c-cart-i"></i> BELI BARANG
                                        </a>
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

                                    <a class="" href="<?= site_url('kategori/all/item/' . $item->i_url . '/detil'); ?>">
                                        <img class="card-img-top"
                                             src="<?= base_url('upload/' . $item_img($item->i_kode)->ii_nama); ?>"
                                             alt="<?= $item_img($item->i_kode)->ii_nama; ?>">
                                    </a>
                                <?php else: ?>
                                    <a class="" href="<?= site_url('kategori/all/item/' . $item->i_url . '/detil'); ?>">
                                        <img class="card-img-top"
                                             src="https://upload.wikimedia.org/wikipedia/commons/archive/a/ac/20121003093557%21No_image_available.svg"
                                             alt="No Image">
                                    </a>
                                <?php endif; ?>
                                <div class="card-body text-center">
                                    <!--<i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>-->
                                    <h5 class="card-title c-both c-title"><?= $item->i_nama; ?></h5>
                                    <h5 id="rupiah" class="c-price"><?= $kat->item->i_hrg; ?></h5>

                                    <a href="<?= site_url('kategori/all/item/' . $item->i_url . '/detil'); ?>"
                                       class="btn btn-csr c-cart c-cart-p">
                                        <i class="fa fa-plus c-cart-i mr-2"></i>
                                        <p class="d-inline-block m-0 font-weight-normal" style="font-size:1rem;">Add To
                                            Bag</p>
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
    </div>
    <script>
        $('[id="title"]').ellipsis();
    </script>


<?php
include "layout/Footer.php";
?>