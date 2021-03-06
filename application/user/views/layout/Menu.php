<!-- ======= Header ======= -->
<div class="c-padding-header c-header">
    <div class="row">
        <div class="col-12 text-right px-0">
            <?php if (isset($_SESSION['id'])): ?>
                <a class="alert-link f-link c-header-a ml-1 mr-1" href="<?= site_url('order_status'); ?>">
                    Pending Orders
                </a>
                | <a class="alert-link f-link c-header-a ml-1 mr-1" href="<?= site_url('order_history'); ?>">
                    Order History
                </a>
            <?php endif; ?>
            <?php if (isset($_SESSION['isonline']) && $_SESSION['isonline'] == true): ?>
                | Hello<a href="<?= site_url('profil'); ?>" class="alert-link f-link c-header-a ml-1">
                    <i class="fa fa-user"></i> <?= $_SESSION['nama']; ?>
                </a>
                | <a class="alert-link f-link c-header-a ml-1 mr-1" href="<?= site_url('logout'); ?>">
                    Log Out
                </a>
            <?php else: ?>
                <a class="alert-link f-link c-header-a ml-1 mr-1" href="<?= site_url('login'); ?>">
                    Login
                </a>
                | <a class="alert-link f-link c-header- ml-1 mr-1" href="<?= site_url('register'); ?>">
                    Register
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="header-wrapper">
    <div class="container-fluid c-padding-header">
        <div class="row">
            <div class="col-xl-2 col-lg-2 c-head-min">

                    <img src="<?= base_url('assets/img/kuzelogo.jpeg'); ?>" width="130" height="80"
                         class="img-fluid mx-auto d-block"
                         alt="">

            </div>
            <div class="col-xl-8 col-lg-8 col-12">
                <div class="row mt-lg-1 mt-2">
                    <form class="form-inline my-2 my-lg-0 col-12 m-auto" action="<?= site_url('cari'); ?>" method="get">
                        <div class="input-group col-12 px-0">
                            <input class="form-control" type="text" placeholder="Search"
                                   aria-label="Search" id="keyword" name="keyword" autocomplete="off">
                            <div class="input-group-addon">
                                <button class="btn btn-search-color f-btn-search" type="submit" style=""
                                        id="search-btn"><i
                                            class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>




                <div class="row">
                    <nav class="navbar navbar-expand-sm navbar-light main-menu pl-lg-0 pl-3 my-2 hidden-hp"
                         style="overflow: hidden;">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse c-nav" id="navbarNav">
                            <ul class="navbar-nav c-margin-auto">
                                <li class="nav-item">
                                    <a class="nav-link c-dropdown font-weight-bold" href="<?= base_url(''); ?>">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold"
                                       href="<?= base_url('category'); ?>">Category</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" href="<?= base_url('new_arrival'); ?>">New
                                        Arrival</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" href="<?= base_url('best_seller'); ?>">Best
                                        Seller</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" href="<?= base_url('sale_item'); ?>">Sale
                                        Item</a>
                                </li>
<!--                                <li class="nav-item">-->
<!--                                    <a class="nav-link font-weight-bold" href="--><!--">Event</a>-->
<!--                                </li>-->
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" href="<?= base_url('Howtoorder'); ?>">How to
                                        Order</a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-12 text-right text-lg-left c-icon-media iconhp" style="overflow: hidden;">
                <?php if (isset($_SESSION['isonline']) && $_SESSION['isonline'] == true): ?>
                    <div class="col mt-4 mt-lg-2">
                        <a href="<?= site_url('bag'); ?>">
                            <i class="fa fa-shopping-bag c-icon-top" style="font-size:1.7rem;"></i>
                        </a>
                        <?php if (isset($bag_counter)): ?>
                            <div class="badge badge-warning r-badge r-cart-badge"><?= $bag_counter; ?></div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="col mt-4 mt-lg-2">
                        <a href="<?= site_url('bag'); ?>">
                            <i class="fa fa-shopping-bag c-icon-top" style="font-size:1.7rem;"></i>
                        </a>
                        <?php if (isset($bag_counter)): ?>
                            <div lass="badge badge-warning r-badge r-cart-badge"><?= $bag_counter; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>




    </div>

    <div class="container-fluid">
        <div class="row show-hp" style="overflow: hidden;">
            <div class="col-8 col-sm-8">
                <nav class="navbar navbar-expand-lg navbar-light pl-lg-0 pl-3 my-2" style="overflow: hidden;">

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03"
                            aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse c-nav" id="navbarsExample03">
                        <ul class="navbar-nav c-margin-auto">
                            <li class="nav-item">
                                <a class="nav-link c-dropdown font-weight-bold" href="<?= base_url(''); ?>">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold"
                                   href="<?= base_url('kategori'); ?>">Category</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" href="<?= base_url('new_arrival'); ?>">New
                                    Arrival</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" href="<?= base_url('best_seller'); ?>">Best
                                    Seller</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" href="<?= base_url('sale_item'); ?>">Sale
                                    Item</a>
                            </li>
                            <!--                                <li class="nav-item">-->
                            <!--                                    <a class="nav-link font-weight-bold" href="-->
                            <!--">Event</a>-->
                            <!--                                </li>-->
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" href="<?= base_url('Howtoorder'); ?>">How to
                                    Order</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div
        </div>
    </div>


</div>