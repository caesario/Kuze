<?php
    include "layout/Header.php";
    include "layout/Menu.php";
?>

    <hr class="mb-5 c-hr-reset">

    <div class="container-fluid c-padding-header">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <!-- <div class="col-12">
                        <div class="mb-4">
                          <div class="">
                            <h5 class="card-title mb-1">Jhon Doe Ponegoro</h5>
                            <p class="card-text mb-1">Caesar Tower, 27th Cengkareng Raya Street, South Cengkareng Indonesia 12520</p>
                            <p class="card-text"><small class="text-muted">Join 24 Sep 2018</small></p>
                          </div>
                        </div>
                    </div> -->
                    <div class="col-12">
                        <div class="list-group mb-4">
                            <a href="<?= site_url('Profil'); ?>" class="list-group-item list-group-item-action c-profil-active">Profil</a>
                            <a href="<?= site_url('Order_status'); ?>" class="list-group-item list-group-item-action">Order Status</a>
                            <a href="<?= site_url('Order_status'); ?>" class="list-group-item list-group-item-action">Transaction History</a>
                            <a href="#" class="list-group-item list-group-item-action">Shipping  Order</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 c-color-profil">
                <h5 class="card-title">Jhon Doe Ponegoro</h5>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><i class="fa fa-envelope c-profil-icon"></i> diponegoro@eazydev.com</li>
                    <li class="list-group-item"><i class="fa fa-phone c-width-i c-profil-icon"></i> 082112343211</li>
                    <li class="list-group-item"><i class="fa fa-calendar-check-o c-profil-icon"></i> 17 Aug 1871</li>
                    <li class="list-group-item"><i class="fa fa-map-marker c-width-i c-profil-icon"></i> Caesar Tower, 27th Cengkareng Raya Street, South Cengkareng Indonesia 12520</li>
                    <li class="list-group-item"><i class="fa fa-sign-in c-profil-icon"></i> 24 Sep 2018</li>
                </ul>

                <a class="btn c-login-btn float-right mb-5 c-edit" href="<?= site_url('Profil_edit'); ?>" role="button">Edit</a>

            </div>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>