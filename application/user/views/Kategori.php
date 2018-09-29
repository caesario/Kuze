<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <div ng-app="kuze" ng-controller="kategoriController">
        <!-- ======= Banner Kategori Pesanan ======= -->
        <div class="wrapper-cart mb-0">
            <h5 class="text-center c-title-cart">Category</h5>
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
                    <h5 class="card-title mb-0 text-left">Category</h5>
                    <hr>
                    <?php if ($menu_kategori != NULL): ?>
                        <ul class="nav flex-column c-ul-footer">
                            <?php foreach ($menu_kategori as $menukat): ?>
                                <li class="nav-item mb-1 ml-1 ">
                                    <a href="<?= site_url('category/' . $menukat->k_url); ?>"><?= $menukat->k_nama; ?></a>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    <?php else: ?>
                        <p>Tidak ada kategori</p>
                    <?php endif; ?>
                    <hr>
                </div>

                <div class="col-12 col-sm-12 col-md-10 col-lg-10">
                    <h5 class="card-title mb-0 text-left">Product</h5>
                    <hr>
                    <div class="container-fluid c-padding-header mt-3">
                        <div class="row">
                            <?php if (isset($item_kategori) && $item_kategori != NULL): ?>
                                <?php foreach ($item_kategori as $kat): ?>

                                    <?php $stok = $qty($kat->item->i_kode); ?>
                                    <?php if ($stok >= 1 && $kat->i_kode != NULL): ?>
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                            <div class="card">
                                                <?php if ($item_img($kat->item->i_kode) != NULL): ?>
                                                    <a href="<?= site_url('category/' . $k_url . '/item/' . $kat->item->i_url . '/detil'); ?>">
                                                        <img class="card-img-top"
                                                             data-src="data:<?= $item_img($kat->item->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($kat->item->i_kode)->ii_data)); ?>"
                                                             src="<?= base_url('assets/img/loader.gif'); ?>"
                                                             alt="<?= $item_img($kat->item->i_kode)->ii_kode; ?>">
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= base_url('Detil'); ?>">
                                                        <img class="card-img-top"
                                                             src="<?= base_url('assets/img/noimage.jpg'); ?>"
                                                             alt="No Image">

                                                    </a>
                                                <?php endif; ?>

                                                <div class="card-body text-center">
                                                    <h5 id="title"
                                                        class="card-title c-both c-title"><?= $kat->item->i_nama; ?></h5>
                                                    <h5 id="rupiah" class="c-price"><?= $kat->item->i_hrg; ?></h5>
                                                    <a href="<?= site_url('category/' . $k_url . '/item/' . $kat->item->i_url . '/detil'); ?>"
                                                       class="btn btn-csr c-cart c-cart-p">
                                                        <i class="fa fa-plus c-cart-i mr-2"></i>
                                                        <p class="d-inline-block m-0 font-weight-normal"
                                                           style="font-size:1rem;">Add To Bag</p>
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

                                                <a href="<?= site_url('category/all/item/' . $item->i_url . '/detil'); ?>">
                                                    <img class="card-img-top"
                                                         data-src="data:<?= $item_img($item->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($item->i_kode)->ii_data)); ?>"
                                                         src="<?= base_url('assets/img/loader.gif'); ?>"
                                                         alt="<?= $item_img($item->i_kode)->ii_kode; ?>">
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= site_url('category/all/item/' . $item->i_url . '/detil'); ?>">
                                                    <img class="card-img-top"
                                                         src="<?= base_url('assets/img/noimage.jpg'); ?>"
                                                         alt="No Image">
                                                </a>
                                            <?php endif; ?>
                                            <div class="card-body text-center">
                                                <h5 id="title"
                                                    class="card-title c-both c-title"><?= $item->i_nama; ?></h5>
                                                <h5 id="rupiah" class="c-price"><?= $item->i_hrg; ?></h5>
                                                <a href="<?= site_url('category/all/item/' . $item->i_url . '/detil'); ?>"
                                                   class="btn btn-csr c-cart c-cart-p">
                                                    <i class="fa fa-plus c-cart-i mr-2"></i>
                                                    <p class="d-inline-block m-0 font-weight-normal"
                                                       style="font-size:1rem;">Add To Bag</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('node_modules/angular/angular.min.js'); ?>"></script>
    <script>
        $('[id="title"]').ellipsis();
    </script>
    <script>
        $(function () {
            $('img').Lazy();
        });
    </script>
    <script>
        var app = angular.module("kuze", []);
        app.controller("kategoriController", function ($http, $scope) {

        }
    </script>


<?php
include "layout/Footer.php";
?>