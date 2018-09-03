<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Kategori Pesanan ======= -->
    <div class="wrapper-cart mb-0">
        <h5 class="text-center c-title-cart">Pencarian</h5>
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
                          href="Pencarian "><?= $keyword; ?></span>
                </nav>
            </div>
        </div>
    </div>


    <!-- Pencarian -->
    <div class="container-fluid c-padding-header">
        <div class="row">
            <pre>
                <?php print_r($cari_s); ?>
            </pre>
        </div>
    </div>
    <script>
        $('[id="title"]').ellipsis();
    </script>
<?php
include "layout/Footer.php";
?>