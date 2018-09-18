<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Kategori Pesanan ======= -->
    <div class="wrapper-cart mb-0">
        <h5 class="text-center c-title-cart">Category</h5>
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
    <div class="container-fluid c-padding-header">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                <h5 class="card-title mb-0 text-left">Category</h5>
                <hr>
                <?php if ($menu_kategori != NULL): ?>
                    <ul class="nav flex-column c-ul-footer">

                        <?php foreach ($menu_kategori as $menukat): ?>
                            <li class="nav-item mb-1 ml-1 ">
                                <a class=""
                                   href="<?= site_url('kategori/' . $menukat->k_url); ?>"><?= $menukat->k_nama; ?></a>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                <?php else: ?>
                    <p>Tidak ada kategori</p>
                <?php endif; ?>
                <hr>
            </div>

            <div class="col-12 col-sm-12 col-md-10 col-lg-10">
                <h5 class="card-title mb-0 text-left">Product</h5>
                <hr>
                <div class="container-fluid c-padding-header mt-3">
                    <div class="row">

                    </div>
                </div>

                <div class="c-padding-header">
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
    <script>
        $('[id="title"]').ellipsis();
    </script>


<?php
include "layout/Footer.php";
?>