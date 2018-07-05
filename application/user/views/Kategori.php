<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Kategori Pesanan ======= -->
    <div class="wrapper-cart mb-0">
        <h5 class="text-center c-title-cart">Kategori Produk</h5>
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


        <div class="row">


            <div class="col-12 col-sm-12 col-md-2 col-lg-2">


                <h5 class="card-title mb-0 text-left">Kategori</h5>

                <hr>

                <ul class="nav flex-column c-ul-footer">
                    <?php if ($menu_kategori != NULL): ?>
                        <?php foreach ($menu_kategori as $menukat): ?>
                            <li class="nav-item mb-1 ml-1 ">
                                <a class=""
                                   href="<?= site_url('kategori/' . $menukat->k_url); ?>"><?= $menukat->k_nama; ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <hr>

            </div>

            <div class="col-12 col-sm-12 col-md-10 col-lg-10">
                <div class="container-fluid c-padding-header mt-3">
                    <div class="row">
                        <?php if (isset($item_kategori) && $item_kategori != NULL): ?>
                            <?php foreach ($item_kategori as $kat): ?>

                                <?php $stok = $qty($kat->item->i_kode); ?>
                                <?php if ($stok >= 1): ?>
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                        <div class="card">
                                            <?php if ($item_img($kat->item->i_kode) != NULL): ?>

                                                <a class="" href="<?= base_url('Detil'); ?>">
                                                    <img class="card-img-top"
                                                         src="<?= base_url('upload/' . $item_img($kat->item->i_kode)->ii_nama); ?>"
                                                         alt="<?= $item_img($kat->item->i_kode)->ii_nama; ?>">
                                                    <div class="middle">
                                                        <a href="<?= site_url('kategori/' . $k_url . '/item/' . $kat->item->i_url . '/detil'); ?>"
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
                                                <h5 class="card-title c-both c-title"><?= $kat->item->i_nama; ?></h5>
                                                <?php if (isset($_SESSION['tipe']) && $_SESSION['tipe'] == '1'): ?>
                                                    <h5 id="rupiah" class="c-price"><?= $kat->item->i_hrg_vip; ?></h5>
                                                <?php else: ?>
                                                    <h5 id="rupiah"
                                                        class="c-price"><?= $kat->item->i_hrg_reseller; ?></h5>
                                                <?php endif; ?>
                                                <a href="<?= site_url('kategori/' . $k_url . '/item/' . $kat->item->i_url . '/detil'); ?>"
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
                        <?php if (isset($items) && $item != NULL): ?>

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
                        <?php endif; ?>
                    </div>
                </div>

                <div class="c-padding-header">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item c-pagination disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item c-pagination"><a class="page-link" href="#">1</a></li>
                            <li class="page-item c-pagination"><a class="page-link" href="#">2</a></li>
                            <li class="page-item c-pagination"><a class="page-link" href="#">3</a></li>
                            <li class="page-item c-pagination">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>

    </div>
    <script>
        $('[id="title"]').ellipsis();
    </script>


<?php
include "layout/Footer.php";
?>