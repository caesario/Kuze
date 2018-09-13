<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">Contact    </h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item" href="<?= site_url('Home'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Contact'); ?>">Contact</a>
            </nav>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card-contact text-center">
                    <i class="fa fa-envelope fa-3x mt-2"></i>
                    <p class="mt-2">Kuzeoriginal@email.com</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-contact text-center">
                    <i class="fa fa-phone fa-3x mt-2"></i>
                    <p class="mt-2">082x xxxx xxxx</p>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card-contact text-center">
                    <i class="fab fa-whatsapp fa-3x mt-2"></i>
                    <p class="mt-2">082x xxxx xxxx</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-contact text-center">
                    <i class="fab fa-line fa-3x mt-2"></i>
                    <p class="mt-2">@kuze</p>
                </div>
            </div>
        </div>


    </div>








<?php
include "layout/Footer.php";
?>