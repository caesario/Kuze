<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <div ng-app="kuze" ng-controller="NewArrivalController">
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
                                <h5 class="card-title c-both c-title font-weight-bold"
                                    ng-bind="new_arrival.i_nama"></h5>

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
        app.controller("NewArrivalController", function ($http, $scope) {
            $http.get("/item/knew_arrival").then(function (response) {
                $scope.new_arrivals = response.data;
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