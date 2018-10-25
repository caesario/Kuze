<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <div ng-app="kuze" ng-controller="SaleItemController">
        <!-- ======= Banner Kategori Pesanan ======= -->
        <div class="wrapper-cart mb-0">
            <h5 class="text-center c-title-cart">Sale Item</h5>
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
    </div>
    <script>
        $('[id="title"]').ellipsis();
    </script>
    <script>
        $(function () {
            $('img').Lazy();
        });
    </script>
    <script src="<?= base_url('node_modules/angular/angular.min.js'); ?>"></script>
    <script src="<?= base_url('node_modules/angular-fotorama/angular-fotorama.js'); ?>"></script>
    <script>
        var app = angular.module("kuze", []);
        app.controller("SaleItemController", function ($http, $scope) {

            $http.get("/item/ksale_item").then(function (response) {
                $scope.sale_items = response.data;
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