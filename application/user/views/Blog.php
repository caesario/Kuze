<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">BLOG</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item" href="<?= site_url('Home'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Blog'); ?>">Blog</a>
            </nav>
        </div>
    </div>

    <div class="container-fluid c-padding-header">
        <div class="row">
            <!-- ======= Side Kiri ======= -->
            <div class="col-lg-3">
                <h5>Post Terbaru</h5>
                <hr>
                <div class="media mb-3">
                    <div class="media-left"><a href="" class="" rel="bookmark" title="Have you seen these stunning breakthroughs in 3D"></a>
                    </div>
                    <div class="media-body">
                        <p class="c-title-blog mb-0"><a href="" rel="bookmark" title="Have you seen these stunning breakthroughs in 3D">Have you seen these stunning breakthroughs in 3D</a></p>
                        <p class="c-text-footer m-0 ">December 1, 2018</p>
                    </div>
                </div>
                <div class="media mb-3">
                    <div class="media-left">
                        <a href="" class="" rel="bookmark" title="Have you seen these stunning breakthroughs in 3D"></a>
                    </div>
                    <div class="media-body">
                        <p class="c-title-blog mb-0"><a href="" rel="bookmark" title="Have you seen these stunning breakthroughs in 3D">Have you seen these stunning breakthroughs in 3D</a></p>
                        <p class="c-text-footer m-0">December 1, 2018</p>
                    </div>
                </div>
                <div class="media mb-3">
                    <div class="media-left">
                        <a href="" class="" rel="bookmark" title="Have you seen these stunning breakthroughs in 3D">
                    </div>
                    <div class="media-body">
                        <p class="c-title-blog mb-0"><a href="" rel="bookmark" title="Have you seen these stunning breakthroughs in 3D">Have you seen these stunning breakthroughs in 3D</a></p>
                        <p class="c-text-footer m-0">December 1, 2018</p>
                    </div>
                </div>
            </div>

            <!-- ======= Side Kanan ======= -->
            <div class="col-lg-6 col-sm-12 ml-lg-5">
                <div class="card mb-4">
                    <div class="card-body pt-1">
                        <h4 class="card-title mb-2">Special title treatment</h4>
                        <p class="c-text-footer m-0">December 1, 2018</p>
                        <p class="card-text c-text-blog">With supporting text below as a natural lead-in lorem to additional content. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa fugiat, laborum maxime molestias omnis quos? Accusamus aliquam commodi debitis, distinctio doloribus eius illo libero provident qui quod soluta veniam vero.</p>
                        <a href="<?= site_url('Artikel') ?>" class="btn btn-csr c-btn-blog mt-1 float-right">Read More</a>
                    </div>
                </div>
                <hr>
                <div class="card mb-4">
                    <div class="card-body pt-1">
                        <h4 class="card-title mb-2">Special title treatment</h4>
                        <p class="c-text-footer m-0">December 1, 2018</p>
                        <p class="card-text c-text-blog">With supporting text below as a natural lead-in lorem to additional content. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa fugiat, laborum maxime molestias omnis quos? Accusamus aliquam commodi debitis, distinctio doloribus eius illo libero provident qui quod soluta veniam vero.</p>
                        <a href="#" class="btn btn-csr c-btn-blog mt-1 float-right">Read More</a>
                    </div>
                </div>
                <hr>
                <div class="card mb-4">
                    <div class="card-body pt-1">
                        <h4 class="card-title mb-2">Special title treatment</h4>
                        <p class="c-text-footer m-0">December 1, 2018</p>
                        <p class="card-text c-text-blog">With supporting text below as a natural lead-in lorem to additional content. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa fugiat, laborum maxime molestias omnis quos? Accusamus aliquam commodi debitis, distinctio doloribus eius illo libero provident qui quod soluta veniam vero.</p>
                        <a href="#" class="btn btn-csr c-btn-blog mt-1 float-right">Read More</a>
                    </div>
                </div>
                <hr>
                <div class="">
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

<?php
include "layout/Footer.php";
?>