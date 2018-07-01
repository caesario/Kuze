<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <hr class="c-hr-reset">

    <!-- ======= Breadcrumb ======= -->
    <div class="wrapper-bredcrumb">
        <div class="container-flu c-padding-header">
            <div class="c-breadcrumb">
                <nav class="c-nav-breadcrumb">
                    <a class="breadcrumb-item" href="<?= site_url('/'); ?>">Home</a>
                    <i class="fa fa-arrow-right"></i>
                    <a class="breadcrumb-item" href="<?= $breadcumburl; ?>"><?= $breadcumb; ?></a>
                    <i class="fa fa-arrow-right"></i>
                    <span class="breadcrumb-item c-breadcrum-active"><a href="<?= $breadcumburl1; ?>"><?= $breadcumb1; ?></a></span>
                </nav>
            </div>
        </div>
    </div>


    <!-- ======= Detail Site ======= -->
    <div class="container-flu c-padding-header">
        <div class="row">
            <?php if (isset($item) && $item != NULL): ?>

            <div class="col-lg-6 col-md-6">
                <div class="fotorama"
                     data-fit="cover"
                     data-navposition="bottom"
                     data-transition="dissolve"
                     data-nav="thumbs"
                     data-allowfullscreen="native"
                     data-width="600"
                     data-height="400">
                    <?php if ($item_img_all($item->i_kode) != NULL): ?>
                        <?php foreach ($item_img_all($item->i_kode) as $img): ?>
                            <img src="<?= base_url('upload/' . $img->ii_nama); ?>" class="card-img-top">
                        <?php endforeach; ?>
                    <?php else: ?>
                        <img src="<?= base_url('assets/img/noimg.png'); ?>" class="card-img-top">
                    <?php endif; ?>
                </div>
            </div>

<!--            <div class="col-lg-6 col-md-6">-->
<!--                <div class="row">-->
<!--                    <div class="col-lg-3 col-md-3 col-sm-2">-->
<!--                        <div class="c-img-side">-->
<!--                            <ul class="c-ul-side ">-->
<!--                                <li class="c-li-side">-->
<!--                                    <img src="assets/img/detail_product1.jpg" alt="">-->
<!--                                </li>-->
<!--                                <li class="c-li-side">-->
<!--                                    <img src="assets/img/detail_product2.jpg" alt="">-->
<!--                                </li>-->
<!--                                <li class="c-li-side">-->
<!--                                    <img src="assets/img/detail_product3.jpg" alt="">-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-lg-9 col-md-9 col-sm-10">-->
<!--                        <div class="c-img-show">-->
<!--                            <img src="assets/img/detail_product1.jpg" alt="">-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                </div>
                </div -->

            <div class="col-lg-6 col-md-6">
                <div class="c-detail-info">
                    <form action="add_to_cart" method="post">
                        <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                    <h5><?= $item->i_nama; ?></h5>
                    <div class="row">
                        <div class="col c-review">
                            <i class="fa fa-star c-star"></i>
                            <i class="fa fa-star c-star"></i>
                            <i class="fa fa-star c-star"></i>
                            <i class="fa fa-star c-star"></i>
                            <i class="fa fa-star-o c-star"></i>
<!--                            <span>&nbsp | &nbsp</span><a href=""> (3 Customer Reviews)</a>-->
                        </div>
                        <!--<div class="col c-review">-->
                        <!--<a href="">(3 Customer Reviews)</a>-->
                        <!--</div>-->
                    </div>
                    <div class="c-detail-price">
                        <input type="hidden" name="harga" value="<?= isset($_SESSION['tipe']) && $_SESSION['tipe'] == 1 ? $item->i_hrg_vip : $item->i_hrg_reseller; ?>">
                        <p id="rupiah"
                            class="">Rp <?= isset($_SESSION['tipe']) && $_SESSION['tipe'] == 1 ? $item->i_hrg_vip : $item->i_hrg_reseller; ?></p>

                    </div>
                    <div class="c-detail-p mb-5">
                        <p>
                            <?= $item->i_deskripsi; ?>
                        </p>
                    </div>

                    <div class="c-detail-number mb-3">
                        <input type="number" name="qty" min="1" id="qty" value="1">
                        <input type="text" id="stok" class="c-detail-stock ml-2" placeholder="4 pcs" disabled>
                    </div>

                    <div class="c-detail-warna mb-5">
                        <select name="wu" id="wu" class="custom-select mr-sm-2 form-control" required>
                            <option data-qty="0" value="">Pilih Warna</option>
                            <?php foreach ($item_detil_with_item_all($item->i_kode) as $id): ?>
                                <option data-qty="<?= $qty_detil($id->item_detil_kode); ?>" value="<?= $id->item_detil_kode; ?>">
                                    <?= $id->warna->w_nama; ?> -
                                    <?= $id->ukuran->u_nama; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="c-detail-btn">
                        <button type="submit" href="" class="btn btn-csr c-cart-detail c-cart-p">
                            <i class="fa fa-shopping-cart c-cart-i"></i> Buy Product
                        </button>
<!--                        <a href="" class="btn btn-csr c-cart">-->
<!--                            <i class="fa fa-heart c-cart-i2"></i>-->
<!--                        </a>-->
<!--                        <a href="" class="btn btn-csr c-cart">-->
<!--                            <i class="fa fa-refresh c-cart-i2""></i>-->
<!--                        </a>-->
                    </div>
                    <div class="c-detail-category">
                        <p>Category : <a href="">Jackets</a></p>
                    </div>
<!--                    <div class="c-share-sosmed">-->
<!--                        <a href=""><i class="fa fa-facebook fa-2x"></i></a>-->
<!--                        <a href=""><i class="fa fa-twitter fa-2x"></i></a>-->
<!--                        <a href=""><i class="fa fa-google-plus fa-2x"></i></a>-->
<!--                        <a href=""><i class="fa fa-pinterest fa-2x"></i></a>-->
<!--                        <a href=""><i class="fa fa-linkedin fa-2x"></i></a>-->
<!--                    </div>-->
                    </form>
                    <?php else: ?>
                        <div class="col">
                            <h2 class="text-center text-muted">Item tidak ditemukan</h2>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid c-padding-header">
        <div class="c-tab-list">
            <h5>Description</h5>
            <hr>
            <p class="c-detail-des"> <?= $item->i_deskripsi; ?></p>
        </div>
    </div>


    <div class="container-fluid c-padding-header text-center c-text-cons">
        <h3 class="">Hot Item</h3>
    </div>


    <div class="container-fluid c-padding-header c-margin-related">
        <div class="row">
            <?php foreach ($this->item->with_item_img('where:ii_default =1')->limit(5)->get_all() as $hot): ?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="card border">
                    <?php if ($item_img($hot->i_kode) != NULL): ?>
                    <a class="" href=""><img class="card-img-top" src="<?= base_url('upload/' . $item_img($hot->i_kode)->ii_nama); ?>" alt="<?= $item_img($hot->i_kode)->ii_nama; ?>">
                        <div class="middle">
                            <a href="" class="c-view-text">Quick View</a>
                        </div>
                    </a>
                    <?php else: ?>
                    <a class="" href="">
                    <img class="img-fluid" src="<?= base_url('assets/img/noimg.png'); ?>" alt="No Image">
                        <div class="middle">
                            <a href="" class="c-view-text">Quick View</a>
                        </div>
                    </a>
                    <?php endif; ?>
                    <div class="card-body c-card-vis">
                        <h5 class="card-subtitle mb-1 text-muted text-center c-subtitle-second">Kuze Product</h5>
                        <h5 class="card-title text-center mb-2 c-title-second"><a href=""><?= $hot->i_nama; ?></a></h5>
                        <?php if (isset($_SESSION['tipe']) && $_SESSION['tipe'] == '1'): ?>
                        <h5 class="c-price text-center"><?= $hot->i_hrg_vip; ?></h5>
                        <?php else: ?>
                        <h5 class="c-price text-center"><?= $hot->i_hrg_vip; ?></h5>
                        <?php endif; ?>
                    </div>
                    <!--<div class="card-body text-center c-card-dis">-->
                    <!--<h5 class="c-price">Rp100.000</h5>-->
                    <!--<a href="" class="btn btn-csr c-cart">-->
                    <!--<i class="fa fa-heart c-cart-i2"></i>-->
                    <!--</a>-->
                    <!--<a href="" class="btn btn-csr c-cart">-->
                    <!--<i class="fa fa-refresh c-cart-i2""></i>-->
                    <!--</a>-->
                    <!--</div>-->
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        $('#wu').change(function () {
            var qty = $(this).find(':selected').data('qty');
            var value = $(this).val();
            $.when(
                $('#stok').val(qty),
                $('#qty').attr('max', qty)
            );
            if (qty === 0 && value !== '') {
                $('body > div.container > div > form > div:nth-child(8) > div:nth-child(2)').removeClass('mt-3');
                $('#check').show()
                    .removeClass('text-success')
                    .addClass('text-danger')
                    .html('Stok habis');
            } else if (qty > 0 && value !== '') {
                $('body > div.container > div > form > div:nth-child(8) > div:nth-child(2)').removeClass('mt-3');
                $('#check').show()
                    .removeClass('text-danger')
                    .addClass('text-success')
                    .html('Stok tersedia');
            } else {
                $('body > div.container > div > form > div:nth-child(8) > div:nth-child(2)').addClass('mt-3');
                $('#check').hide();
            }
        })
    </script>

<?php
include "layout/Footer.php";
?>