<!-- Side Navbar -->
<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
            <!-- User Info-->
            <div class="sidenav-header-inner text-center">
                <?php if (isset($_SESSION['profile']) && $_SESSION['profile'] != ""): ?>
                <img src="<?= base_url('upload/' . $_SESSION['profile']); ?>" alt="person" class="img-fluid rounded-circle">
                <?php else: ?>
                <img src="<?= base_url('assets/img/profile.png'); ?>" alt="person" class="img-fluid rounded-circle">
                <?php endif; ?>
                <h2 class="h5"><?= $_SESSION['nama']; ?></h2><span>Admin</span>
            </div>
            <!-- Small Brand information, appears on minimized sidebar-->
            <div class="sidenav-header-logo"><a href="<?= site_url('dashboard'); ?>" class="brand-small text-center">
                    <strong class="text-primary"><?= $brandkode; ?></strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
            <h5 class="sidenav-heading">Main</h5>
            <ul id="side-main-menu" class="side-menu list-unstyled">
                <li><a href="<?= site_url('dashboard'); ?>"> <i class="icon-home"></i>Dashboard </a></li>
                <li>
                    <a href="#misc" aria-expanded="false" data-toggle="collapse"><i class="fas fa-filter mr-2"></i>Master</a>
                    <ul id="misc" class="collapse list-unstyled ">
                        <li><a href="<?= site_url('kategori'); ?>"><i class="fas fa-angle-right mr-2"></i>Kategori </a>
                        </li>
                        <li><a href="<?= site_url('ukuran'); ?>"><i class="fas fa-angle-right mr-2"></i>Ukuran </a></li>
                        <li><a href="<?= site_url('seri'); ?>"><i class="fas fa-angle-right mr-2"></i>Seri </a></li>
                        <li><a href="<?= site_url('warna'); ?>"><i class="fas fa-angle-right mr-2"></i>Warna </a></li>
                    </ul>
                </li>
                <li><a href="<?= site_url('item'); ?>"><i class="fas fa-shopping-cart mr-2"></i>Item</a></li>
                <li><a href="<?= site_url('promo'); ?>"><i class="fas fa-shopping-cart mr-2"></i>Promo</a></li>
                <li><a href="#transaksi" aria-expanded="false" data-toggle="collapse"><i
                                class="fas fa-exchange-alt mr-2"></i>Transaksi</a>
                    <ul id="transaksi" class="collapse list-unstyled">
                        <li>
                            <a href="<?= site_url('order'); ?>"><i class="fas fa-angle-right mr-2"></i>Order</a>
                        </li>
                        <li>
                            <a href="<?= site_url('order/konfirmasi'); ?>"><i class="fas fa-angle-right mr-2"></i>Pembayaran</a>
                        </li>
                        <li>
                            <a href="<?= site_url('order/invoice'); ?>"><i
                                        class="fas fa-angle-right mr-2"></i>Invoice</a>
                        </li>
                    </ul>
                </li>
                <li><a href="#pelanggan" aria-expanded="false" data-toggle="collapse"><i class="fa fa-users mr-2"></i>Pelanggan
                    </a>
                    <ul id="pelanggan" class="collapse list-unstyled">
                        <li>
                            <a href="<?= site_url('customers'); ?>"><i class="fas fa-angle-right mr-2"></i>Semua</a>
                        </li>
                        <li>
                            <a href="<?= site_url('customers/by_vip'); ?>"><i
                                        class="fas fa-angle-right mr-2"></i>VIP</a>
                        </li>
                        <li>
                            <a href="<?= site_url('customers/by_reseller'); ?>"><i class="fas fa-angle-right mr-2"></i>Reseller</a>
                        </li>
                    </ul>
                </li>
                <li><a href="<?= site_url('artikel'); ?>"><i class="fas fa-newspaper mr-2"></i>Artikel</a></li>
                <li><a href="<?= site_url('resi'); ?>"><i class="fas fa-truck-loading mr-2"></i>Resi</a></li>
            </ul>
        </div>
        <div class="admin-menu">
            <h5 class="sidenav-heading">
                Admin
            </h5>
            <ul id="side-admin-menu" class="side-menu list-unstyled">
                <li>
                    <a href="<?= site_url('pengguna'); ?>"><i class="fa fa-users mr-2"></i>Admin
                    </a>
                </li>
                <li><a href="<?= site_url('toko'); ?>"><i class="fa fa-cogs mr-2"></i>Toko </a></li>
                <li><a href="<?= site_url('bank'); ?>"><i class="fa fa-bank mr-2"></i>Bank </a></li>
                <li><a href="<?= site_url('slide'); ?>"><i class="fas fa-images mr-2"></i>Slide Promo</a></li>
            </ul>
        </div>
    </div>
</nav>
<script>
    // ------------------------------------------------------ //
    // Menu
    // ------------------------------------------------------ //
    $(document).ready(function () {

        // MENU MISC
        var c_misc = $.cookie('misc_menu');
        var $menu_misc = $('#side-main-menu > li:nth-child(2) > a');
        var $ul_misc = $('#misc');

        if (c_misc == 'expanded') {
            $menu_misc.removeClass('collapsed').attr('aria-expanded', 'true');
            $ul_misc.addClass('show');
        }

        if (c_misc == 'collapsed') {
            $menu_misc.addClass('collapsed').attr('aria-expanded', 'false');
            $ul_misc.removeClass('show');
        }

        $menu_misc.click(function () {
            if ($menu_misc.hasClass('collapsed')) {
                $.cookie('misc_menu', 'expanded', {path: '/', expires: 100});
            } else
            {
                $.cookie('misc_menu', 'collapsed', {path: '/', expires: 100});
            }
        });
        // END MISC

        // ITEM
        // var c_item = $.cookie('item_menu');
        // var $menu_item = $('#side-main-menu > li:nth-child(3) > a');
        // var $ul_item = $('#item');
        //
        // if (c_item == 'expanded') {
        //     $menu_item.removeClass('collapsed').attr('aria-expanded', 'true');
        //     $ul_item.addClass('show');
        // }
        //
        // if (c_item == 'collapsed') {
        //     $menu_item.addClass('collapsed').attr('aria-expanded', 'false');
        //     $ul_item.removeClass('show');
        // }
        //
        // $menu_item.click(function () {
        //     if ($menu_item.hasClass('collapsed')) {
        //         $.cookie('item_menu', 'expanded', {path: '/', expires: 100});
        //     } else
        //     {
        //         $.cookie('item_menu', 'collapsed', {path: '/', expires: 100});
        //     }
        // });
        // END ITEM

        // MENU TRANSAKSI
        var c_transaksi = $.cookie('transaksi_menu');
        var $menu_transaksi = $('#side-main-menu > li:nth-child(4) > a');
        var $ul_transaksi = $('#transaksi');

        if (c_transaksi == 'expanded') {
            $menu_transaksi.removeClass('collapsed').attr('aria-expanded', 'true');
            $ul_transaksi.addClass('show');
        }

        if (c_transaksi == 'collapsed') {
            $menu_transaksi.addClass('collapsed').attr('aria-expanded', 'false');
            $ul_transaksi.removeClass('show');
        }

        $menu_transaksi.click(function () {
            if ($menu_transaksi.hasClass('collapsed')) {
                $.cookie('transaksi_menu', 'expanded', {path: '/', expires: 100});
            } else
            {
                $.cookie('transaksi_menu', 'collapsed', {path: '/', expires: 100});
            }
        });

        // MENU PELANGGAN
        var c_pelanggan = $.cookie('pelanggan_menu');
        var $menu_pelanggan = $('#side-main-menu > li:nth-child(5) > a');
        var $ul_pelanggan = $('#pelanggan');

        if (c_pelanggan == 'expanded') {
            $menu_pelanggan.removeClass('collapsed').attr('aria-expanded', 'true');
            $ul_pelanggan.addClass('show');
        }

        if (c_pelanggan == 'collapsed') {
            $menu_pelanggan.addClass('collapsed').attr('aria-expanded', 'false');
            $ul_pelanggan.removeClass('show');
        }

        $menu_pelanggan.click(function () {
            if ($menu_pelanggan.hasClass('collapsed')) {
                $.cookie('pelanggan_menu', 'expanded', {path: '/', expires: 100});
            } else
            {
                $.cookie('pelanggan_menu', 'collapsed', {path: '/', expires: 100});
            }
        });
    });
</script>