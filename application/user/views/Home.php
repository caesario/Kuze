<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- Slide Show -->

<?php if ($img_promos != NULL): ?>
    <div class="fotorama mb-4" data-fit="cover" data-autoplay="true">
        <?php foreach ($img_promos as $promo): ?>
            <img src="<?= base_url('upload/' . $promo->slide_promo_img); ?>"
                 data-caption="<?= $promo->slide_promo_caption; ?>"
                 alt="<?= $promo->slide_promo_img; ?>">
        <?php endforeach; ?>
    </div>
<?php endif; ?>

    <div class="container-fluid px-0 mb-3">
        <div class="row c-padding-header">
            <?php if ($rand_image): ?>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                <div class="row">
                    <?php if (isset($rand_image[0])): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img src="data:<?= $rand_image[0]->ii_type . ';base64,' . (base64_encode($rand_image[0]->ii_data)); ?>"
                                     alt="<?= $rand_image[0]->ii_kode; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($rand_image[1])): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img src="data:<?= $rand_image[1]->ii_type . ';base64,' . (base64_encode($rand_image[1]->ii_data)); ?>"
                                     alt="<?= $rand_image[1]->ii_kode; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                <div class="row">
                    <?php if (isset($rand_image[2])): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img src="data:<?= $rand_image[2]->ii_type . ';base64,' . (base64_encode($rand_image[2]->ii_data)); ?>"
                                     alt="<?= $rand_image[2]->ii_kode; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($rand_image[3])): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img src="data:<?= $rand_image[3]->ii_type . ';base64,' . (base64_encode($rand_image[3]->ii_data)); ?>"
                                     alt="<?= $rand_image[3]->ii_kode; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                <div class="row">
                    <?php if (isset($rand_image[4])): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img src="data:<?= $rand_image[4]->ii_type . ';base64,' . (base64_encode($rand_image[4]->ii_data)); ?>"
                                     alt="<?= $rand_image[4]->ii_kode; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($rand_image[5])): ?>
                        <div class="col-12">
                            <div class="content-wrapper">
                                <img src="data:<?= $rand_image[5]->ii_type . ';base64,' . (base64_encode($rand_image[5]->ii_data)); ?>"
                                     alt="<?= $rand_image[5]->ii_kode; ?>">
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
                                                 src="data:<?= $item_img($new_arrival->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($new_arrival->i_kode)->ii_data)); ?>"
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
                                                 src="data:<?= $item_img($best_seller->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($best_seller->i_kode)->ii_data)); ?>"
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
                                                 src="data:<?= $item_img($sale_item->i_kode)->ii_type . ';base64,' . (base64_encode($item_img($sale_item->i_kode)->ii_data)); ?>"
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


    <!-- ======= News Block ======= -->
    <div class="container-fluid c-padding-header">
        <div class="row">
            <?php if ($event != NULL): ?>
                <?php foreach ($event as $artk): ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="content-wrapper">
                            <div class="card">
                                <a class="" href="<?= site_url('event/' . $artk->event_url) ?>"><img
                                            class="img-fluid mx-auto d-block"
                                            src="assets/img/blog1.jpg"
                                            alt="Card image cap"></a>
                                <div class="card-body">
                                    <h5 id="title" class="card-title c-title-blog"><?= $artk->event_url; ?></h5>
                                    <ul class="c-ul-blog">
                                        <li>Created at <a href="" class="c-date"><?= $artk->created_at; ?></a></li>
                                        <?php if ($artk->updated_at != NULL): ?>
                                            <li>Updated at <a href="" class="c-date"><?= $artk->updated_at; ?></a></li>
                                        <?php endif; ?>

                                    </ul>
                                    <p id="title" class="c-p-blog"><?= $artk->event_content; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </div>


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
        function img_hover(data) {
            var img = data,
                id = img.attr('id'),
                hasil = "";
            $.getJSON("/API/get_last_img/" + id, function (data) {
                img.fadeOut("fast", function () {
                    hasil = "data:" + data["type"] + ";base64," + data["img"];
                    img.attr("src", hasil);
                    img.fadeIn("fast");
                });
            });

        }

        function img_off(data) {
            var img = data,
                id = img.attr('id'),
                hasil = "";

            $.getJSON("/API/get_default_img/" + id, function (data) {
                img.fadeOut("fast", function () {
                    hasil = "data:" + data["type"] + ";base64," + data["img"];
                    img.attr("src", hasil);
                    img.fadeIn("fast");
                });
            });
        }
    </script>

<?php
include "layout/Footer.php";
?>