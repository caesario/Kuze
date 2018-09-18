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
                <?php if (isset($items) && $items != NULL): ?>
                    <?php foreach ($items as $item): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="card">
                                <div class="row">
                                    <div class="c-ribbon c-ribbon2">
                                        <span>New Arrival</span>
                                    </div>
                                </div>
                                <?php if ($item_img($item->i_kode) != NULL): ?>

                                    <a class="" href="<?= site_url('new_arrival/item/' . $item->i_url . '/detil'); ?>">
                                        <img class="card-img-top"
                                             data-src="data:<?= $item_img($item->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($item->i_kode)->ii_data)); ?>"
                                             src="https://i.gifer.com/AvGf.gif"
                                             id="menuImg" onmouseover="onHover();"
                                             onmouseout="offHover();"
                                             alt="<?= $item_img($item->i_kode)->ii_kode; ?>">
                                    </a>
                                <?php else: ?>
                                    <a class="" href="<?= site_url('new_arrival/item/' . $item->i_url . '/detil'); ?>">
                                        <img class="card-img-top"
                                             src="<?= base_url('assets/img/noimage.jpg'); ?>"
                                             alt="No Image">
                                    </a>
                                <?php endif; ?>
                                <div class="card-body text-center">
                                    <h5 class="card-title c-both c-title"><?= $item->i_nama; ?></h5>
                                    <h5 id="rupiah" class="c-price"><?= $item->i_hrg; ?></h5>

                                    <a href="<?= site_url('new_arrival/item/' . $item->i_url . '/detil'); ?>"
                                       class="btn btn-csr c-cart c-cart-p">
                                        <i class="fa fa-plus c-cart-i mr-2"></i>
                                        <p class="d-inline-block m-0 font-weight-normal" style="font-size:1rem;">Add To
                                            Bag</p>
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
    <script>
        $('[id="title"]').ellipsis();
    </script>
    <script>
        $(function () {
            $('img').Lazy({
                placeholder: "https://i.gifer.com/AvGf.gif"
            });
        });
    </script>


<?php
include "layout/Footer.php";
?>