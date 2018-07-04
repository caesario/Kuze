<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- Slide Show -->
<?php if ($img_promos != NULL): ?>
    <div class="fotorama" data-fit="cover" data-autoplay="true">
        <?php foreach ($img_promos as $promo): ?>
            <img src="<?= base_url('upload/' . $promo->slide_promo_img); ?>"
                 data-caption="<?= $promo->slide_promo_caption; ?>"
                 alt="<?= $promo->slide_promo_img; ?>">
        <?php endforeach; ?>
    </div>
<?php endif; ?>
    <!-- End Slide Show -->


    <!-- ======= Content ======= -->
    <dic class="container-fluid">
        <div class="row c-padding-header">
            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="content-wrapper">
                            <!--<div class="c-box-info">-->
                            <!--<h5>-->
                            <!--<span>Printed Dress</span><br>-->
                            <!--SUMMER <br> 2017-->
                            <!--</h5>-->    <!-- Tergantung Content Mas, diperlukan atau tidak nanti -->
                            <!--<a href="" class="btn btn-content">-->
                            <!--Shop Now-->
                            <!--</a>-->
                            <!--</div>-->
                            <img src="assets/img/con1.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="content-wrapper">
                            <img src="assets/img/con2.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="content-wrapper">
                            <img src="assets/img/con-3.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="content-wrapper">
                            <img src="assets/img/con4.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="content-wrapper">
                            <img src="assets/img/con5.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </dic>


    <div class="container-fluid c-padding-header text-center c-text-cons">
        <h2 class="">Produk Terbaru</h2>
        <span class="text-muted c-sub-cons">Produk terbaru kami minggu ini</span>
    </div>


    <!-- ======= Product ======= -->
    <div class="container-fluid c-padding-header">
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
        <div class="row">
            <?php if ($terbaru_items() != NULL): ?>
                <?php foreach ($terbaru_items() as $terbaru): ?>
                    <?php $stok = $qty($terbaru->i_kode); ?>
                    <?php if ($stok >= 1): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="card">
                                <a class="" href="<?= base_url('Detil'); ?>">
                                    <?php if ($item_img($terbaru->i_kode) != NULL): ?>
                                        <img class="card-img-top"
                                             src="<?= base_url('upload/' . $item_img($terbaru->i_kode)->ii_nama); ?>"
                                             alt="<?= $item_img($terbaru->i_kode)->ii_nama; ?>">
                                    <?php else: ?>
                                        <img class="img-fluid mx-auto d-block"
                                             src="https://upload.wikimedia.org/wikipedia/commons/archive/a/ac/20121003093557%21No_image_available.svg"
                                             alt="No Image">
                                    <?php endif; ?>
                                    <div class="middle">
                                        <a href="<?= site_url('produk-terbaru/item/' . $terbaru->i_url . '/detil'); ?>"
                                           class="c-view-text">Quick View</a>
                                    </div>
                                </a>
                                <div class="card-body">
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <h5 id="title" class="card-title c-both c-title"><?= $terbaru->i_nama; ?></h5>
                                    <?php if (isset($_SESSION['tipe']) && $_SESSION['tipe'] == '1'): ?>
                                        <h5 id="rupiah" class="c-price"><?= $terbaru->i_hrg_vip; ?></h5>
                                    <?php else: ?>
                                        <h5 id="rupiah" class="c-price"><?= $terbaru->i_hrg_vip; ?></h5>
                                    <?php endif; ?>
                                    <a href="<?= site_url('produk-terbaru/item/' . $terbaru->i_url . '/detil'); ?>"
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
            <?php else: ?>
                <p class="col">Tidak ada item yang ditampilkan</p>
            <?php endif; ?>

        </div>
    </div>


    <!-- ======= Long Product ======= -->
    <div class="containter-fluid c-padding-header c-margin-lon">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="content-wrapper">
                    <img src="assets/img/lon1.jpg" alt="">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="content-wrapper">
                    <img src="assets/img/lon1.jpg" alt="">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="content-wrapper">
                    <img src="assets/img/lon3.jpg" alt="">
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid c-padding-header text-center c-text-cons">
        <h3 class="">NEWS FROM BLOG</h3>
        <span class="text-muted c-sub-cons">Fashion Trends We're Looking Forward</span>
    </div>


    <!-- ======= News Block ======= -->
    <div class="container-fluid c-padding-header">
        <div class="row">
            <?php foreach ($artikel as $artk): ?>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="content-wrapper">
                        <div class="card">
                            <a class="" href="<?= site_url('artikel/' . $artk->artikel_url) ?>"><img
                                        class="card-img-top"
                                        src="assets/img/blog1.jpg"
                                        alt="Card image cap"></a>
                            <div class="card-body">
                                <h5 id="title" class="card-title c-title-blog"><?= $artk->artikel_url; ?></h5>
                                <ul class="c-ul-blog">
                                    <li>Created at <a href="" class="c-date"><?= $artk->created_at; ?></a></li>
                                    <?php if ($artk->updated_at != NULL): ?>
                                        <li>Updated at <a href="" class="c-date"><?= $artk->updated_at; ?></a></li>
                                    <?php endif; ?>

                                </ul>
                                <p id="title" class="c-p-blog"><?= $artk->artikel_content; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>


    <div class="container-fluid c-padding-header text-center c-text-cons">
        <h3 class=""># FOLLOW US ON INSTAGRAM</h3>
        <span class="text-muted c-sub-cons">Fashion Trends We're Looking Forward</span>
    </div>


    <!-- ======= Instagram ======= -->
    <div class="container-fluid">
        <div class="row">
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
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="media">
                    <div class="fa fa-plane c-icon-bot"></div>
                    <div class="media-body c-padding-media-body">
                        <h5 class="mt-0">FREE SHIPING</h5>
                        <p>Free shipping on all Local Area order above $100</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12">
                <div class="media">
                    <div class="fa fa-car c-icon-bot"></div>
                    <div class="media-body c-padding-media-body">
                        <h5 class="mt-0">24/7 SUPPORT</h5>
                        <p>Our Support Team Ready to 7 days a week</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12">
                <div class="media">
                    <div class="fa fa-refresh c-icon-bot"></div>
                    <div class="media-body c-padding-media-body">
                        <h5 class="mt-0">45 DAYS RETURN</h5>
                        <p>Product any fault within 45 days for an exchange</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12">
                <div class="media">
                    <div class="fa fa-money c-icon-bot"></div>
                    <div class="media-body c-padding-media-body">
                        <h5 class="mt-0">PAYMENT SECURE</h5>
                        <p>We ensure 100% secure payment with SecurionPay</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>