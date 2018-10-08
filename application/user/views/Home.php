<?php
include "layout/Header.php";
include "layout/Menu.php";
?>




    <div ng-app="kuze" ng-controller="homeController">
        <div fotorama item="fotorama_items" class="fotorama"
             data-fit="cover"
             data-width="100%"
             data-height="80%"
             data-ratio="1024/768">
        </div>
        <br>
        <div class="container-fluid px-0 mb-3">
            <div class="row c-padding-header">
                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <div class="row">
                        <div ng-if="img1" class="col-12">
                            <div class="content-wrapper">
                                <img id="{{ img1['id'] }}"
                                     ng-src="{{ img1['src'] }}"
                                     alt="{{ img1['alt'] }}">
                            </div>
                        </div>
                        <div ng-if="img2" class="col-12">
                            <div class="content-wrapper">
                                <img id="{{ img2['id'] }}"
                                     ng-src="{{ img2['src'] }}"
                                     alt="{{ img2['alt'] }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <div class="row">
                        <div ng-if="img3" class="col-12">
                            <div class="content-wrapper">
                                <img id="{{ img3['id'] }}"
                                     ng-src="{{ img3['src'] }}"
                                     alt="{{ img3['alt'] }}" style="height: 104%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <div class="row">
                        <div ng-if="img4" class="col-12">
                            <div class="content-wrapper">
                                <img id="{{ img4['id'] }}"
                                     ng-src="{{ img4['src'] }}"
                                     alt="{{ img4['alt'] }}">
                            </div>
                        </div>
                        <div ng-if="img5" class="col-12">
                            <div class="content-wrapper">
                                <img id="{{ img5['id'] }}"
                                     ng-src="{{ img5['src'] }}"
                                     alt="{{ img5['alt'] }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Slide Show -->

        <!-- ======= Content New Arrival ======= -->

        <div class="container-fluid c-padding-header text-center c-text-cons">
            <h2 class="">New Arrival</h2>
            <span class="text-muted c-sub-cons">New Arrival This Week</span>
        </div>
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
        <div ng-if="new_arrivals" class="container-fluid c-padding-header">
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
                                 ng-src="{{ new_arrival.i_img }}"
                                 class="img-fluid mx-auto d-block">

                            <div class="card-body text-center">
                                <h5 class="card-title c-both c-title font-weight-bold" ng-bind="new_arrival.i_nama"></h5>

                                <h5 class="c-price" ng-bind="new_arrival.i_hrg | rupiah"></h5>
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
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
        <div ng-if="best_sellers" class="container-fluid c-padding-header">
            <div class="row">
                <div ng-repeat="best_seller in best_sellers track by $index"
                     class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="row">
                            <div class="c-ribbon c-ribbon2">
                                <span>Best Seller</span>
                            </div>
                        </div>

                        <a href="<?= site_url(); ?>best_seller/item/{{best_seller.i_url}}/detil">
                            <img id="{{best_seller.i_kode}}"
                                 ng-src="{{ best_seller.i_img }}"
                                 class="img-fluid mx-auto d-block">

                            <div class="card-body text-center">
                                <h5 class="card-title c-both c-title font-weight-bold" ng-bind="best_seller.i_nama"></h5>

                                <h5 class="c-price" ng-bind="best_seller.i_hrg | rupiah"></h5>
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

        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
        <div ng-if="sale_items" class="container-fluid c-padding-header">
            <div class="row">

                <div ng-repeat="sale_item in sale_items" class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="row">
                            <div class="c-ribbon c-ribbon2">
                                <span>Sale Item</span>
                            </div>
                        </div>

                        <a href="<?= site_url(); ?>sale_item/item/{{sale_item.i_url}}/detil">
                            <img id="{{sale_item.i_kode}}"
                                 ng-src="{{ sale_item.i_img }}"
                                 class="img-fluid mx-auto d-block">

                            <div class="card-body text-center">
                                <h5 class="card-title c-both c-title font-weight-bold" ng-bind="sale_item.i_nama"></h5>

                                <h5 class="c-price" ng-bind="sale_item.i_hrg | rupiah"></h5>
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
    <script src="<?= base_url('node_modules/angular-fotorama/angular-fotorama.js'); ?>"></script>
    <script>
        var app = angular.module("kuze", ['angular-fotorama']);
        app.controller("homeController", function ($http, $scope) {
            $http.get("/item/new_arrival").then(function (response) {
                $scope.new_arrivals = response.data;
            });

            $http.get("/item/best_seller").then(function (response) {
                $scope.best_sellers = response.data;
            });

            $http.get("/item/sale_item").then(function (response) {
                $scope.sale_items = response.data;
            });

            $http.get("/image/slide").then(function (response) {
                $scope.fotorama_items = response.data;
            });

            $http.get("/image/billboard").then(function (response) {
                $scope.img1 = response.data[1];
                $scope.img2 = response.data[2];
                $scope.img3 = response.data[3];
                $scope.img4 = response.data[4];
                $scope.img5 = response.data[5];
            });
        });

        app.config(function ($httpProvider) {
            $httpProvider.interceptors.push(function ($q) {
                return {
                    'request': function (config) {
                        $('.spinner').show();
                        return config;
                    },

                    'response': function (response) {
                        $('.spinner').hide();
                        return response;
                    }
                };
            });
        });

        app.run(function ($rootScope) {
            if ($rootScope.$last) {
                $('.spinner').hide();
            } else {
                $('.spinner').show();
            }

        });

        app.filter('rupiah', function () {
            return function (val) {
                while (/(\d+)(\d{3})/.test(val.toString())) {
                    val = val.toString().replace(/(\d+)(\d{3})/, '$1' + '.' + '$2');
                }
                var val = 'IDR ' + val;
                return val;
            };
        });
    </script>

<?php
include "layout/Footer.php";
?>