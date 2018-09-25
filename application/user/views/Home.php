<?php
include "layout/Header.php";
include "layout/Menu.php";
?>
<?php if ($img_promos != NULL): ?>
    <div class="fotorama mb-4" data-fit="cover" data-autoplay="true" data-width="100%" data-height="80%">
        <?php foreach ($img_promos as $promo): ?>
            <img src="data:<?= $promo->slide_promo_type . ';base64,' . (base64_encode($promo->slide_promo_data)); ?>"
                 alt="<?= (string)$promo->slide_promo_caption; ?>">
        <?php endforeach; ?>
    </div>
<?php endif; ?>

    <div class="container-fluid px-0 mb-3">
        <div class="row c-padding-header">
            <?php if ($rand_image): ?>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                <div class="row">
                    <?php if (isset($img1)): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img data-src="data:<?= $img1->blb_type . ';base64,' . (base64_encode($img1->blb_data)); ?>"
                                     src="<?= base_url('assets/img/loader.gif'); ?>"
                                     alt="<?= $img1->blb_judul; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($img2)): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img data-src="data:<?= $img2->blb_type . ';base64,' . (base64_encode($img2->blb_data)); ?>"
                                     src="<?= base_url('assets/img/loader.gif'); ?>"
                                     alt="<?= $img2->blb_judul; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                <div class="row">
                    <?php if (isset($img3)): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img data-src="data:<?= $img3->blb_type . ';base64,' . (base64_encode($img3->blb_data)); ?>"
                                     src="<?= base_url('assets/img/loader.gif'); ?>"
                                     alt="<?= $img3->blb_judul; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                <div class="row">
                    <?php if (isset($img4)): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img data-src="data:<?= $img4->blb_type . ';base64,' . (base64_encode($img4->blb_data)); ?>"
                                     src="<?= base_url('assets/img/loader.gif'); ?>"
                                     alt="<?= $img4->blb_judul; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($img5)): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img data-src="data:<?= $img5->blb_type . ';base64,' . (base64_encode($img5->blb_data)); ?>"
                                     src="<?= base_url('assets/img/loader.gif'); ?>"
                                     alt="<?= $img5->blb_judul; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- End Slide Show -->

    <!-- ======= Content New Arrival ======= -->

    <div class="container-fluid c-padding-header text-center c-text-cons">
        <h2 class="">New Arrival</h2>
        <span class="text-muted c-sub-cons">New Arrival This Week</span>
    </div>
    <div class="container-fluid c-padding-header">
        <div class="row">
            <?php if ($new_arrivals() != NULL): ?>
                <?php foreach ($new_arrivals() as $new_arrival): ?>
                    <?php $stok = $qty($new_arrival->i_kode); ?>
                    <?php if ($stok >= 1): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="card">
                                <div class="row">
                                    <div class="c-ribbon c-ribbon2">
                                        <span>New Arrival</span>
                                    </div>
                                </div>

                                <a href="<?= site_url('new_arrival/item/' . $new_arrival->i_url . '/detil'); ?>">
                                    <?php if ($item_img($new_arrival->i_kode) != NULL): ?>
                                        <?php if ($item_img_count($new_arrival->i_kode) > 1): ?>
                                            <img id="<?= $new_arrival->i_kode; ?>"
                                                 onmouseover="img_hover($(this))"
                                                 onmouseleave="img_off($(this))"
                                                 data-src="data:<?= $item_img($new_arrival->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($new_arrival->i_kode)->ii_data)); ?>"
                                                 src="<?= base_url('assets/img/loader.gif'); ?>"
                                                 alt="<?= $item_img($new_arrival->i_kode)->ii_kode; ?>"
                                                 class="img-fluid mx-auto d-block">
                                        <?php else: ?>
                                            <img id="<?= $new_arrival->i_kode; ?>"
                                                 src="data:<?= $item_img($new_arrival->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($new_arrival->i_kode)->ii_data)); ?>"
                                                 alt="<?= $item_img($new_arrival->i_kode)->ii_kode; ?>"
                                                 class="img-fluid mx-auto d-block">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <img class="img-fluid mx-auto d-block"
                                             src="<?= base_url('assets/img/noimage.jpg'); ?>"
                                             alt="No Image">
                                    <?php endif; ?>

                                    <div class="card-body text-center">
                                        <h5 class="card-title c-both c-title"><?= $new_arrival->i_nama; ?></h5>
                                        <h5 id="rupiah" class="c-price"><?= $new_arrival->i_hrg; ?></h5>
                                        <a href="<?= site_url('produk-terbaru/item/' . $new_arrival->i_url . '/detil'); ?>"
                                           class="btn btn-csr c-cart c-cart-p">
                                            <i class="fa fa-shopping-bag c-cart-i mr-2"></i>
                                            <p class="d-inline-block m-0 font-weight-normal" style="font-size:1rem;">Add
                                                To Bag</p>
                                        </a>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col">
                    <p class="text-center">Tidak ada item yang ditampilkan</p>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <!-- ======= End Product New Arrival ======= -->

    <!-- ======= Product Best Seller ======= -->

    <div class="container-fluid c-padding-header text-center c-text-cons">
        <h2 class="">Best Seller</h2>
        <span class="text-muted c-sub-cons">Best Seller on This Month</span>
    </div>

    <div class="container-fluid c-padding-header">
        <div class="row">
            <?php if ($best_sellers() != NULL): ?>
                <?php foreach ($best_sellers() as $best_seller): ?>
                    <?php $stok = $qty($best_seller->i_kode); ?>
                    <?php if ($stok >= 1): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="card">
                                <div class="row">
                                    <div class="c-ribbon c-ribbon1">
                                        <span>Best Seller</span>
                                    </div>
                                </div>

                                <a href="<?= site_url('best_seller/item/' . $best_seller->i_url . '/detil'); ?>">
                                    <?php if ($item_img($best_seller->i_kode) != NULL): ?>
                                        <?php if ($item_img_count($best_seller->i_kode) > 1): ?>
                                            <img id="<?= $best_seller->i_kode; ?>"
                                                 onmouseover="img_hover($(this))"
                                                 onmouseleave="img_off($(this))"
                                                 data-src="data:<?= $item_img($best_seller->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($best_seller->i_kode)->ii_data)); ?>"
                                                 src="<?= base_url('assets/img/loader.gif'); ?>"
                                                 alt="<?= $item_img($best_seller->i_kode)->ii_kode; ?>"
                                                 class="img-fluid mx-auto d-block">
                                        <?php else: ?>
                                            <img id="<?= $best_seller->i_kode; ?>"
                                                 src="data:<?= $item_img($best_seller->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($best_seller->i_kode)->ii_data)); ?>"
                                                 alt="<?= $item_img($best_seller->i_kode)->ii_kode; ?>"
                                                 class="img-fluid mx-auto d-block">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <img class="img-fluid mx-auto d-block"
                                             src="<?= base_url('assets/img/noimage.jpg'); ?>"
                                             alt="No Image">
                                    <?php endif; ?>

                                    <div class="card-body text-center">
                                        <h5 class="card-title c-both c-title"><?= $best_seller->i_nama; ?></h5>

                                        <h5 id="rupiah" class="c-price"><?= $best_seller->i_hrg; ?></h5>
                                        <a href="<?= site_url('produk-terbaru/item/' . $best_seller->i_url . '/detil'); ?>"
                                           class="btn btn-csr c-cart c-cart-p">
                                            <i class="fa fa-shopping-bag c-cart-i mr-2"></i>
                                            <p class="d-inline-block m-0 font-weight-normal" style="font-size:1rem;">Add
                                                To Bag</p>
                                        </a>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col">
                    <p class="text-center">Tidak ada item yang ditampilkan</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- ======= End Product Best Seller ======= -->


    <!-- ======= Product Sale Item ======= -->

    <div class="container-fluid c-padding-header text-center c-text-cons">
        <h2 class="">Sale Item</h2>
        <span class="text-muted c-sub-cons">Sale Item This Month</span>
    </div>

    <div class="container-fluid c-padding-header">
        <div class="row">
            <?php if ($sale_items() != NULL): ?>
                <?php foreach ($sale_items() as $sale_item): ?>
                    <?php $stok = $qty($sale_item->i_kode); ?>
                    <?php if ($stok >= 1): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="card">
                                <div class="row">
                                    <div class="c-ribbon c-ribbon3">
                                        <span>Sale Item</span>
                                    </div>
                                </div>

                                <a href="<?= site_url('produk-terbaru/item/' . $sale_item->i_url . '/detil'); ?>">
                                    <?php if ($item_img($sale_item->i_kode) != NULL): ?>
                                        <?php if ($item_img_count($sale_item->i_kode) > 1): ?>
                                            <img id="<?= $sale_item->i_kode; ?>"
                                                 onmouseover="img_hover($(this))"
                                                 onmouseleave="img_off($(this))"
                                                 data-src="data:<?= $item_img($sale_item->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($sale_item->i_kode)->ii_data)); ?>"
                                                 src="<?= base_url('assets/img/loader.gif'); ?>"
                                                 alt="<?= $item_img($sale_item->i_kode)->ii_kode; ?>"
                                                 class="img-fluid mx-auto d-block">
                                        <?php else: ?>
                                            <img id="<?= $sale_item->i_kode; ?>"
                                                 src="data:<?= $item_img($sale_item->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($sale_item->i_kode)->ii_data)); ?>"
                                                 alt="<?= $item_img($sale_item->i_kode)->ii_kode; ?>"
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <img class="img-fluid mx-auto d-block"
                                             src="<?= base_url('assets/img/noimage.jpg'); ?>"
                                             alt="No Image">
                                    <?php endif; ?>

                                    <div class="card-body text-center">
                                        <h5 class="card-title c-both c-title"><?= $sale_item->i_nama; ?></h5>

                                        <h5 id="rupiah" class="c-price"><?= $sale_item->i_hrg; ?></h5>
                                        <a href="<?= site_url('produk-terbaru/item/' . $sale_item->i_url . '/detil'); ?>"
                                           class="btn btn-csr c-cart c-cart-p">
                                            <i class="fa fa-shopping-bag c-cart-i mr-2"></i>
                                            <p class="d-inline-block m-0 font-weight-normal" style="font-size:1rem;">Add
                                                To Bag</p>
                                        </a>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col">
                    <p class="text-center">Tidak ada item yang ditampilkan</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- ======= End Product Best Seller ======= -->


    <!-- ======= Long Product ======= -->
    <!--    <div class="containter-fluid c-padding-header c-margin-lon">-->
    <!--        <div class="row">-->
    <!--            <div class="col-md-4 col-sm-12">-->
    <!--                <div class="content-wrapper">-->
    <!--                    <img src="assets/img/lon1.jpg" alt="">-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col-md-4 col-sm-12">-->
    <!--                <div class="content-wrapper">-->
    <!--                    <img src="assets/img/lon1.jpg" alt="">-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col-md-4 col-sm-12">-->
    <!--                <div class="content-wrapper">-->
    <!--                    <img src="assets/img/lon3.jpg" alt="">-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->


    <!--    <div class="container-fluid c-padding-header text-center c-text-cons">-->
    <!--        <h3 class="">NEWS FROM BLOG</h3>-->
    <!--        <span class="text-muted c-sub-cons">Fashion Trends We're Looking Forward</span>-->
    <!--    </div>-->




    <div class="container-fluid c-padding-header text-center c-text-cons">
        <h3 class=""># FOLLOW US ON INSTAGRAM</h3>
        <a href="https://www.instagram.com/<?= $instagram; ?>" target="_blank"><i
                    class="fab fa-instagram fa-2x c-ig-color"></i></a>
        <span class="text-muted c-sub-cons">@kuze.co</span>
    </div>


    <!-- ======= Instagram ======= -->
    <div class="container-fluid">
        <div class="row px-4 px-lg-5">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12 c-ig-padding">
                <a href="" class="c-icon-ig">
                    <img src="assets/img/ig1.jpg" class="c-ig" alt="">
                    <div class="middle-ig">
                        <div class="text">
                            <i class="fa fa-heart"> 1</i>
                            <i class="fa fa-comment"> 3</i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12 c-ig-padding">
                <a href="" class="c-icon-ig">
                    <img src="assets/img/ig2.jpg" class="c-ig" alt="">
                    <div class="middle-ig">
                        <div class="text">
                            <i class="fa fa-heart"> 1</i>
                            <i class="fa fa-comment"> 3</i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12 c-ig-padding">
                <a href="" class="c-icon-ig">
                    <img src="assets/img/ig3.jpg" class="c-ig" alt="">
                    <div class="middle-ig">
                        <div class="text">
                            <i class="fa fa-heart"> 1</i>
                            <i class="fa fa-comment"> 3</i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12 c-ig-padding">
                <a href="" class="c-icon-ig">
                    <img src="assets/img/ig4.jpg" class="c-ig" alt="">
                    <div class="middle-ig">
                        <div class="text">
                            <i class="fa fa-heart"> 1</i>
                            <i class="fa fa-comment"> 3</i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12 c-ig-padding">
                <a href="" class="c-icon-ig">
                    <img src="assets/img/ig5.jpg" class="c-ig" alt="">
                    <div class="middle-ig">
                        <div class="text">
                            <i class="fa fa-heart"> 1</i>
                            <i class="fa fa-comment"> 3</i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12 c-ig-padding">
                <a href="" class="c-icon-ig">
                    <img src="assets/img/ig6.jpg" class="c-ig" alt="">
                    <div class="middle-ig">
                        <div class="text">
                            <i class="fa fa-heart"> 1</i>
                            <i class="fa fa-comment"> 3</i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>


    <!-- ======= Store Info ======= -->
    <div class="container-fluid c-padding-media ">
        <div class="row ">
            <div class="col-lg-3 col-md-12">
                <!--                <div class="media">-->
                <!--                    <div class="fa fa-plane c-icon-bot"></div>-->
                <!--                    <div class="media-body c-padding-media-body">-->
                <!--                        <h5 class="mt-0">FREE SHIPING</h5>-->
                <!--                        <p>Free shipping on all Local Area order above $100</p>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
            <div class="col-lg-3 col-md-12">
                <!--                <div class="media">-->
                <!--                    <div class="fa fa-car c-icon-bot"></div>-->
                <!--                    <div class="media-body c-padding-media-body">-->
                <!--                        <h5 class="mt-0">24/7 SUPPORT</h5>-->
                <!--                        <p>Our Support Team Ready to 7 days a week</p>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
            <div class="col-lg-3 col-md-12">
                <!--                <div class="media">-->
                <!--                    <div class="fa fa-refresh c-icon-bot"></div>-->
                <!--                    <div class="media-body c-padding-media-body">-->
                <!--                        <h5 class="mt-0">7 DAYS RETURN</h5>-->
                <!--                        <p>Product any fault within 7 days for an exchange</p>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
            <div class="col-lg-3 col-md-12">
                <!--                <div class="media">-->
                <!--                    <div class="fa fa-money c-icon-bot"></div>-->
                <!--                    <div class="media-body c-padding-media-body">-->
                <!--                        <h5 class="mt-0">PAYMENT SECURE</h5>-->
                <!--                        <p>We ensure 100% secure payment with SecurionPay</p>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('img').Lazy({
                placeholder: "data:image/gif;base64,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"
            });
        });
    </script>
<?php
include "layout/Footer.php";
?>