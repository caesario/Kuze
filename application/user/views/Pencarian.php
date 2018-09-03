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
            <?php if ($keywords != NULL): ?>
                <?php foreach ($keywords as $keyword): ?>
                    <?php $stok = $qty($keyword->i_kode); ?>
                    <?php if ($stok >= 1): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="card">
                                <a href="<?= site_url('item/' . $keyword->i_url . '/detil'); ?>">
                                    <?php if ($item_img($keyword->i_kode) != NULL): ?>
                                        <img class="card-img-top"
                                             src="<?= base_url('upload/' . $item_img($keyword->i_kode)->ii_nama); ?>"
                                             alt="<?= $item_img($keyword->i_kode)->ii_nama; ?>">
                                    <?php else: ?>
                                        <img class="img-fluid mx-auto d-block"
                                             src="<?= base_url('assets/img/noimage.jpg'); ?>"
                                             alt="No Image">
                                    <?php endif; ?>

                                    <div class="card-body text-center">
                                        <h5 class="card-title c-both c-title"><?= $keyword->i_nama; ?></h5>
                                        <h5 id="rupiah" class="c-price"><?= $keyword->i_hrg; ?></h5>
                                        <a href="<?= site_url('item/' . $keyword->i_url . '/detil'); ?>"
                                           class="btn btn-csr c-cart c-cart-p">
                                            <i class="fa fa-shopping-cart c-cart-i mr-2"></i>
                                            <p class="d-inline-block m-0 font-weight-normal" style="font-size:1rem;">Add
                                                To Bag</p>
                                        </a>
                                    </div>
                            </div>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="col">Tidak ada item yang ditampilkan</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        $('[id="title"]').ellipsis();
    </script>
<?php
include "layout/Footer.php";
?>