<!-- ======= Header ======= -->

    <div class="c-padding-header c-header">
        <div class="row">
            <div class="col-12 text-right px-0">
                <?php if (isset($_SESSION['id'])): ?>
                    <a class="alert-link f-link c-header-a" href="<?= site_url('pending'); ?>">
                        Status Order
                    </a>
                    | <a class="alert-link f-link c-header-a" href="<?= site_url('riwayat'); ?>">
                        Riwayat Pesanan
                    </a>
                <?php endif; ?>
                <?php if (isset($_SESSION['isonline']) && $_SESSION['isonline'] == true): ?>
                    | Hallo<a href="<?= site_url('profil'); ?>" class="alert-link f-link c-header-a">
                        <i class="fa fa-user"></i> <?= $_SESSION['nama']; ?>
                    </a>
                    | <a class="alert-link f-link c-header-a" href="<?= site_url('logout'); ?>">
                        Log Out
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

<div class="header-wrapper">
    <div class="container-fluid c-padding-header">
        <div class="row">
            <div class="col-xl-2 col-lg-2 c-head-min">
                <?php if ($logo != NULL): ?>
                    <img src="<?= base_url('upload/' . $logo); ?>" width="130" height="80"
                         class="img-fluid mx-auto d-block"
                         alt="">
                <?php else: ?>
                    <img class="img-fluid mx-auto d-block" width="130" height="80"
                         src="https://upload.wikimedia.org/wikipedia/commons/archive/a/ac/20121003093557%21No_image_available.svg"
                         alt="No Image">
                <?php endif; ?>
            </div>
            <div class="col-xl-8 col-lg-8 col-12">
                <div class="row mt-lg-1 mt-2">
                    <form class="form-inline my-2 my-lg-0 col-12 m-auto" action="<?= site_url('cari'); ?>" method="get">
                        <div class="input-group col-12 px-0">
                            <input class="form-control" type="text" placeholder="Cari Produk"
                                   aria-label="Search" id="cari" name="cari" autocomplete="off">
                            <div class="input-group-addon">
                                <button class="btn btn-search-color f-btn-search" type="submit" style=""
                                        id="search-btn"><i
                                            class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <nav class="navbar navbar-expand-lg navbar-light main-menu m-lg-auto pl-lg-0 pl-3 my-2">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse c-nav" id="navbarNav">
                            <ul class="navbar-nav c-margin-auto">
                                <li class="nav-item">
                                    <a class="nav-link c-dropdown" href="<?= base_url (''); ?>">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url ('Kategori'); ?>">Kategori</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Product Terbaru</a>
<!--                                    <div class="c-dropdown-content" id="c-color-drop">-->
<!--                                        <h6>Product</h6>-->
<!--                                        <a href="#">Full Width Layout</a>-->
<!--                                        <a href="#">With sidebar right</a>-->
<!--                                        <a href="#">Groups Product</a>-->
<!--                                    </div>-->
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Hot Item</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= site_url('Blog') ?>">Blog</a>
                                    <!--<div class="c-dropdown-content" id="c-color-drop">
                                        <a href="#">Update Product</a>
                                        <a href="#">News Site</a>
                                        <a href="#">Groups Join</a>
                                    </div>-->
                                </li>
<!--                                <li class="nav-item">-->
<!--                                    <a class="nav-link" href="#">Contact</a>-->
<!--                                </li>-->

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-12 text-right c-icon-media">
                <?php if (isset($_SESSION['isonline']) && $_SESSION['isonline'] == true): ?>
                <div class="col mt-4 mt-lg-2">
                        <a href="<?= site_url('cart'); ?>"><i class="fa fa-shopping-cart fa-2x c-icon-top"></i></a>
                </div>

<!--                    <a href="--><?//= site_url('Profil'); ?><!--" class="c-dis"><i class="fa fa-search fa-lg c-icon-top"></i></a>-->
<!--                    <a href="--><?//= site_url('Cart'); ?><!--"><i class="fa fa-shopping-cart fa-lg c-icon-top"></i></a>-->
<!--                    <a href="--><?//= site_url(''); ?><!--"  class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sign-out fa-lg c-icon-top"></i></a>-->
<!--                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">-->
<!--                        <a class="dropdown-item" href="#">Action</a>-->
<!--                        <a class="dropdown-item" href="#">Another action</a>-->
<!--                        <a class="dropdown-item" href="#">Something else here</a>-->
<!--                    </div>-->


                <?php else: ?>
                <div class="col mt-4">
                        <a href="<?= site_url('cart'); ?>"><i class="fa fa-shopping-cart fa-2x c-icon-top"></i></a>
                        <a href="<?= site_url('login'); ?>"><i class="fa fa-lock fa-2x c-icon-top"></i></a>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>