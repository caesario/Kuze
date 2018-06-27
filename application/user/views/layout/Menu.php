<!-- ======= Header ======= -->
<div class="header-wrapper">
    <div class="container-fluid c-padding-header">
        <div class="row">
            <div class="col-xl-2 col-lg-2">
                <div class="logo">
                    <img src="assets/img/logo.png" alt="">
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-6">
                <nav class="navbar navbar-expand-lg navbar-light main-menu">
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
                                <div class="c-dropdown-content" id="c-color-drop">
                                    <div class="row">
                                        <div class="col">
                                            <h6>Catalog Produk</h6>
                                            <a href="#">Man Cloth</a>
                                            <a href="#">Dress Woman</a>
                                            <a href="#">Slim Bag</a>
                                            <a href="#">Aing Macan Loncat</a>
                                            <a href="#">Catalog Layout</a>
                                        </div>
                                        <div class="col">
                                            <h6>Product Featured</h6>
                                            <a href="#"> Swatch Default</a>
                                            <a href="#">Swatch Images</a>
                                            <a href="#">Groups Product</a>
                                            <a href="#">External/Affiliate Product</a>
                                            <a href="#">On-sale schedule price</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Product Terbaru</a>
                                <div class="c-dropdown-content" id="c-color-drop">
                                    <h6>Product</h6>
                                    <a href="#">Full Width Layout</a>
                                    <a href="#">With sidebar right</a>
                                    <a href="#">Groups Product</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Hot Item</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('Blog') ?>">Blog</a>
                                <div class="c-dropdown-content" id="c-color-drop">
                                    <a href="#">Update Product</a>
                                    <a href="#">News Site</a>
                                    <a href="#">Groups Join</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contact</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-xl-2 col-lg-2 col-6 text-right c-icon-media">
                <a href="<?= site_url('Profil'); ?>"><i class="fa fa-search fa-lg c-icon-top c-dis"></i></a>
                <a href="<?= site_url('Login'); ?>"><i class="fa fa-lock fa-lg c-icon-top"></i></a>
                <a href="<?= site_url('Keranjang'); ?>"><i class="fa fa-shopping-cart fa-lg c-icon-top"></i></a>
            </div>
        </div>
    </div>
</div>