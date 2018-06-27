<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <hr class="mb-5 c-hr-reset">

    <div class="container-fluid c-padding-header mb-5">
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
                            <a href="<?= site_url('Profil'); ?>" class="list-group-item list-group-item-action">Profil</a>
                            <a href="<?= site_url('Order_status'); ?>" class="list-group-item list-group-item-action c-profil-active">Status Pesanan</a>
                            <a href="<?= site_url('Order_history'); ?>" class="list-group-item list-group-item-action">Riwayat Transaksi</a>
                            <a href="#" class="list-group-item list-group-item-action">Konfirmasi Pembayaran</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="media c-border-status p-2 mb-2">
                    <a href="<?= site_url('Detail_item'); ?>"><img class="d-flex mr-3 c-img-order" src="assets/img/detail_product1.jpg" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <a href="<?= site_url('Detail_item'); ?>" class="c-title"><h5 class="mt-0">Lavish Alice Deep Bandeau - <span class="c-success">Pending</span></h5></a>
                        <h5 class="c-price-history mb-1">Rp100.000 X 2</h5>
                        <p class="card-text"><small class="text-muted">24 Sep 2018</small></p>
                    </div>
                </div>
                <div class="media c-border-status p-2 mb-2">
                    <a href="detail-item.html"><img class="d-flex mr-3 c-img-order" src="assets/img/detail_product3.jpg" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <a href="detail-item.html" class="c-title"><h5 class="mt-0">Boxy Fit River Island - <span class="c-success">Pending</span></h5></a>
                        <h5 class="c-price-history mb-1">Rp125.000 X 1</h5>
                        <p class="card-text"><small class="text-muted">22 Sep 2018</small></p>
                    </div>
                </div>
                <div class="media c-border-status p-2 mb-2">
                    <a href="detail-item.html"><img class="d-flex mr-3 c-img-order" src="assets/img/detail_product2.jpg" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <a href="detail-item.html" class="c-title"><h5 class="mt-0">Asymmetric Hem Midi Dress - <span class="c-out">Out of Stock</span></h5></a>
                        <h5 class="c-price-history mb-1">Rp80.000 X 1</h5>
                        <p class="card-text"><small class="text-muted">17 Sep 2018</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>