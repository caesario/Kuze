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
            <div class="col-lg-9">
                <form>
                    <div class="form-group col-md-6 mb-0">
                        <label class="col-form-label">Full Name<span class="c-form-star">*</span></label>
                        <input type="text" class="form-control" id="inputName" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <label class="col-form-label">E-mail<span class="c-form-star">*</span></label>
                        <input type="email" class="form-control" id="inputEmail" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <label class="col-form-label">Phone<span class="c-form-star">*</span></label>
                        <input type="text" class="form-control" id="inputPhone" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6 ">
                        <label for="inputAddress" class="col-form-label">Address<span class="c-form-star">*</span></label>
                        <input type="text" class="form-control" id="inputAddress" autocomplete="off">
                    </div>
                </form>
                <button class="btn c-login-btn float-left ml-3 mb-5" type="submit">Save</button>

            </div>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>