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
    <div ng-app="kuze" ng-controller="homeController">
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
                                         alt="<?= $img3->blb_judul; ?>" style="height: 104%;">
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
                <div ng-repeat="new_arrival in new_arrivals" class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="row">
                            <div class="c-ribbon c-ribbon2">
                                <span>New Arrival</span>
                            </div>
                        </div>

                        <a href="<?= site_url(); ?>new_arrival/item/{{new_arrival.i_url}}/detil">
                            <img id="{{new_arrival.i_kode}}"
                                 onmouseover="img_hover($(this))"
                                 onmouseleave="img_off($(this))"
                                 src="<?= base_url('assets/img/loader.gif'); ?>"
                                 class="img-fluid mx-auto d-block">

                            <div class="card-body text-center">
                                <h5 class="card-title c-both c-title">{{new_arrival.i_nama}}</h5>

                                <h5 id="rupiah" class="c-price">{{new_arrival.i_hrg}}</h5>
                                <a href="<?= site_url(); ?>new_arrival/item/{{new_arrival.i_url}}/detil"
                                   class="btn btn-csr c-cart c-cart-p">
                                    <i class="fa fa-shopping-bag c-cart-i mr-2"></i>
                                    <p class="d-inline-block m-0 font-weight-normal"
                                       style="font-size:1rem;">Add
                                        To Bag</p>
                                </a>
                            </div>
                        </a>

                    </div>
                </div>
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

                <div ng-repeat="best_seller in best_sellers" class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="row">
                            <div class="c-ribbon c-ribbon2">
                                <span>Best Seller</span>
                            </div>
                        </div>

                        <a href="<?= site_url(); ?>best_seller/item/{{best_seller.i_url}}/detil">
                            <img id="{{best_seller.i_kode}}"
                                 onmouseover="img_hover($(this))"
                                 onmouseleave="img_off($(this))"
                                 src="<?= base_url('assets/img/loader.gif'); ?>"
                                 class="img-fluid mx-auto d-block">

                            <div class="card-body text-center">
                                <h5 class="card-title c-both c-title">{{best_seller.i_nama}}</h5>

                                <h5 id="rupiah" class="c-price">{{best_seller.i_hrg}}</h5>
                                <a href="<?= site_url(); ?>best_seller/item/{{best_seller.i_url}}/detil"
                                   class="btn btn-csr c-cart c-cart-p">
                                    <i class="fa fa-shopping-bag c-cart-i mr-2"></i>
                                    <p class="d-inline-block m-0 font-weight-normal"
                                       style="font-size:1rem;">Add
                                        To Bag</p>
                                </a>
                            </div>
                        </a>

                    </div>
                </div>


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

                <div ng-repeat="sale_item in sale_items" class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="row">
                            <div class="c-ribbon c-ribbon2">
                                <span>Best Seller</span>
                            </div>
                        </div>

                        <a href="<?= site_url(); ?>sale_item/item/{{sale_item.i_url}}/detil">
                            <img id="{{sale_item.i_kode}}"
                                 onmouseover="img_hover($(this))"
                                 onmouseleave="img_off($(this))"
                                 src="<?= base_url('assets/img/loader.gif'); ?>"
                                 class="img-fluid mx-auto d-block">

                            <div class="card-body text-center">
                                <h5 class="card-title c-both c-title">{{sale_item.i_nama}}</h5>

                                <h5 id="rupiah" class="c-price">{{sale_item.i_hrg}}</h5>
                                <a href="<?= site_url(); ?>sale_item/item/{{sale_item.i_url}}/detil"
                                   class="btn btn-csr c-cart c-cart-p">
                                    <i class="fa fa-shopping-bag c-cart-i mr-2"></i>
                                    <p class="d-inline-block m-0 font-weight-normal"
                                       style="font-size:1rem;">Add
                                        To Bag</p>
                                </a>
                            </div>
                        </a>

                    </div>
                </div>


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
        $(function () {
            $('img').Lazy();
        });
    </script>
    <script src="<?= base_url('node_modules/angular/angular.min.js'); ?>"></script>
    <script src="<?= base_url('node_modules/angular-base64/angular-base64.min.js'); ?>"></script>
    <script>
        var app = angular.module("kuze", ['base64']);
        app.controller("homeController", function ($http, $scope, $base64) {
            $http.get("/home/new_arrival").then(function (response) {
                $scope.new_arrivals = response.data;
            });

            $http.get("/home/best_seller").then(function (response) {
                $scope.best_sellers = response.data;
            });

            $http.get("/home/sale_item").then(function (response) {
                $scope.sale_items = response.data;
            });

            $scope.init_image = function (item_kode) {
                return $http.get("/home/get_image/" + item_kode).then(function (response) {
                    return response.data;
                })
            };

            $http.get("/home/get_billboard").then(function (response) {
                $scope.img1 = response.data.img1;
                $scope.img1.src = "data:" + response.data.img1.ii_type + ";base64," + $base64.encode(response.data.img1.ii_data);
                $scope.img2 = response.data.img2;
                $scope.img2.src = "data:" + response.data.img2.ii_type + ";base64," + $base64.encode(response.data.img2.ii_data);
                $scope.img3 = response.data.img3;
                $scope.img3.src = "data:" + response.data.img3.ii_type + ";base64," + $base64.encode(response.data.img3.ii_data);
                $scope.img4 = response.data.img4;
                $scope.img4.src = "data:" + response.data.img4.ii_type + ";base64," + $base64.encode(response.data.img4.ii_data);
                $scope.img5 = response.data.img5;
                $scope.img5.src = "data:" + response.data.img5.ii_type + ";base64," + $base64.encode(response.data.img5.ii_data);
            });

        });
    </script>

<?php
include "layout/Footer.php";
?>