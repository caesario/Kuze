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
                            <a href="<?= site_url('Order_status'); ?>" class="list-group-item list-group-item-action">Status Pesanan</a>
                            <a href="<?= site_url('Order_history'); ?>" class="list-group-item list-group-item-action c-profil-active">Riwayat Transaksi</a>
                            <a href="#" class="list-group-item list-group-item-action">Konfirmasi Pembayaran</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <div class="media c-border-status p-2 mb-2">
                            <!--<img class="d-flex mr-3 c-img-order" src="assets/img/detail_product1.jpg" alt="Generic placeholder image">-->
                            <div class="media-body">
                                <a href="<?= site_url('Detail_pesanan'); ?>" class="c-title"><h5 class="mt-0 c-color-profil">B1H04EV  - <span class="c-success">Completed</span></h5></a>
                                <h5 class="c-price-history mb-1">Rp100.000,-</h5>
                                <p class="card-text"><small class="text-muted">24 Sep 2018</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="media c-border-status p-2 mb-2">
                            <!--<img class="d-flex mr-3 c-img-order" src="assets/img/detail_product1.jpg" alt="Generic placeholder image">-->
                            <div class="media-body">
                                <a href="" class="c-title"><h5 class="mt-0">B1H04EV  - <span class="c-success">Completed</span></h5></a>
                                <h5 class="c-price-history mb-1">Rp100.000,-</h5>
                                <p class="card-text"><small class="text-muted">24 Sep 2018</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="media c-border-status p-2 mb-2">
                            <!--<img class="d-flex mr-3 c-img-order" src="assets/img/detail_product1.jpg" alt="Generic placeholder image">-->
                            <div class="media-body">
                                <a href="" class="c-title"><h5 class="mt-0">B1H04EV  - <span class="c-success">Completed</span></h5></a>
                                <h5 class="c-price-history mb-1">Rp100.000,-</h5>
                                <p class="card-text"><small class="text-muted">24 Sep 2018</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="media c-border-status p-2 mb-2">
                            <!--<img class="d-flex mr-3 c-img-order" src="assets/img/detail_product1.jpg" alt="Generic placeholder image">-->
                            <div class="media-body">
                                <a href="" class="c-title"><h5 class="mt-0">B1H04EV  - <span class="c-success">Completed</span></h5></a>
                                <h5 class="c-price-history mb-1">Rp100.000,-</h5>
                                <p class="card-text"><small class="text-muted">24 Sep 2018</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="media c-border-status p-2 mb-2">
                            <!--<img class="d-flex mr-3 c-img-order" src="assets/img/detail_product1.jpg" alt="Generic placeholder image">-->
                            <div class="media-body">
                                <a href="" class="c-title"><h5 class="mt-0">B1H04EV  - <span class="c-success">Completed</span></h5></a>
                                <h5 class="c-price-history mb-1">Rp100.000,-</h5>
                                <p class="card-text"><small class="text-muted">24 Sep 2018</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="media c-border-status p-2 mb-2">
                            <!--<img class="d-flex mr-3 c-img-order" src="assets/img/detail_product1.jpg" alt="Generic placeholder image">-->
                            <div class="media-body">
                                <a href="" class="c-title"><h5 class="mt-0">B1H04EV  - <span class="c-success">Completed</span></h5></a>
                                <h5 class="c-price-history mb-1">Rp100.000,-</h5>
                                <p class="card-text"><small class="text-muted">24 Sep 2018</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="media c-border-status p-2 mb-2">
                            <!--<img class="d-flex mr-3 c-img-order" src="assets/img/detail_product1.jpg" alt="Generic placeholder image">-->
                            <div class="media-body">
                                <a href="" class="c-title"><h5 class="mt-0">B1H04EV  - <span class="c-success">Completed</span></h5></a>
                                <h5 class="c-price-history mb-1">Rp100.000,-</h5>
                                <p class="card-text"><small class="text-muted">24 Sep 2018</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="media c-border-status p-2 mb-2">
                            <!--<img class="d-flex mr-3 c-img-order" src="assets/img/detail_product1.jpg" alt="Generic placeholder image">-->
                            <div class="media-body">
                                <a href="" class="c-title"><h5 class="mt-0">B1H04EV  - <span class="c-success">Completed</span></h5></a>
                                <h5 class="c-price-history mb-1">Rp100.000,-</h5>
                                <p class="card-text"><small class="text-muted">24 Sep 2018</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item c-pagination disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item c-pagination"><a class="page-link" href="#">1</a></li>
                                <li class="page-item c-pagination"><a class="page-link" href="#">2</a></li>
                                <li class="page-item c-pagination"><a class="page-link" href="#">3</a></li>
                                <li class="page-item c-pagination">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>