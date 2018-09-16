<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">How To Order</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item" href="<?= site_url('Home'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Faq'); ?>">How To Order</a>
            </nav>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-2 col-12 col-md-2 col-sm-12 col-xs-12 pl-0 pr-0">
                <div class="card-howto">
                    <i class="fa fa-box text-center fa-2x mt-3"></i>
                    <h6 class="text-center mt-3">1. Select Product & Add Product To Cart</h6>
                </div>
            </div>
            <div class="col-lg-1 col-12 col-md-1 col-sm-12 col-xs-12 text-center pl-0 pr-0">

                    <i class="fa fa-angle-right fa-3x mt-5 iccolor"></i>


            </div>
            <div class="col-lg-2 col-12 col-md-2 col-sm-12 col-xs-12 pl-0 pr-0">
                <div class="card-howto">
                    <i class="fa fa-map-marker-alt text-center fa-2x mt-3"></i>
                    <h6 class="text-center mt-3">2. Check Out & Fill your address</h6>
                </div>
            </div>
            <div class="col-lg-1 col-12 col-md-1 col-sm-12 col-xs-12 text-center pl-0 pr-0">
                <i class="fa fa-angle-right fa-3x mt-5 iccolor"></i>
            </div>

            <div class="col-lg-2 col-12 col-md-2 col-sm-12 col-xs-12 pl-0 pr-0">
                <div class="card-howto">
                    <i class="fa fa-credit-card text-center fa-2x mt-3"></i>
                    <h6 class="text-center mt-3">3. Select Payment and Shipping Method</h6>
                </div>
            </div>
            <div class="col-lg-1 col-12 col-md-1 col-sm-12 col-xs-12 text-center pl-0 pr-0">
                <i class="fa fa-angle-right fa-3x mt-5 iccolor"></i>
            </div>
            <div class="col-lg-2 col-12 col-md-2 col-sm-12 col-xs-12 pr-0 pl-0">
                <div class="card-howto">
                    <i class="fa fa-truck-moving text-center fa-2x mt-3"></i>
                    <h6 class="text-center mt-3">4. Confirm Your Payment & we will send the product</h6>
                </div>
            </div>



        </div>
    </div>





<?php
include "layout/Footer.php";
?>