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
                    <span class="breadcrumb-item c-breadcrum-active"><a
                                href="<?= $breadcumburl1; ?>"><?= $breadcumb1; ?></a></span>
                </nav>
            </div>
        </div>
    </div>


    <!-- ======= Detail Site ======= -->
    <div class="container-flu c-padding-header c-margin-100">
        <div class="row justify-content-center">
            <?php if (isset($item) && $item != NULL): ?>

            <div class="col-lg-5 col-md-5">
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
                        <img src="<?= base_url('assets/img/noimage.jpg'); ?>"
                             class="card-img-top">
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="c-detail-info">
                    <form action="add_to_bag" method="post">
                        <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                        <h5 class="mb-2"><?= $item->i_nama; ?></h5>
                        <hr class="mb-2">
                        <div class="row mb-3">
                            <div class="col c-review">
                                <i class="fa fa-star c-star m-0"></i>
                                <i class="fa fa-star c-star m-0"></i>
                                <i class="fa fa-star c-star m-0"></i>
                                <i class="fa fa-star c-star m-0"></i>
                                <i class="fa fa-star c-star m-0"></i>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="c-detail-price">
                                    <input type="hidden" name="harga"
                                           value="<?= $item->i_hrg; ?>">
                                    <p id="rupiah"
                                       class=""><?= $item->i_hrg; ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                                <div class="col c-detail-des"> <?= $item->i_deskripsi; ?></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <label for="wu" class="c-detil-add">Size</label>
                                <select name="wu" id="wu" class="custom-select mr-sm-2 form-control" required>
                                    <?php foreach ($item_detil_with_item_all($item->i_kode) as $id): ?>
                                        <option data-qty="<?= $qty_detil($id->item_detil_kode); ?>"
                                                value="<?= $id->item_detil_kode; ?>">
                                            <?= $id->ukuran->u_nama; ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
<!--                            <div class="col-lg-2 col-md-12">-->
<!--                                <label for="stok" class="c-detil-add">Stok</label>-->
<!--                                <input class="form-control" type="number" name="stok" id="stok" disabled>-->
<!--                            </div>-->
                            <div class="col-lg-2 col-md-12">
                                <div class="form-group">
                                    <label for="qty" class="c-detil-add">QTY</label>
                                    <input class="form-control" type="number" name="qty" id="qty" min="1" value="1">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <button type="submit" class="btn btn-block c-cart-detail c-cart-p"><i
                                            class="fa fa-shopping-cart mr-2"></i>Buy Product
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php else: ?>
                        <div class="col">
                            <h2 class="text-center text-muted">No Item found</h2>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <hr>
    <br>

    <div class="container-fluid c-padding-header text-center c-text-cons">
        <h3 class="">- Hot Item -</h3>
    </div>


    <div class="container-fluid c-padding-header c-margin-related">
        <div class="row">
            <?php foreach ($this->item->with_item_img('where:ii_default =1')->limit(4)->get_all() as $hot): ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <a class="" href="<?= site_url('hot-item/item/' . $hot->i_url . '/detil'); ?>">
                            <?php if ($item_img($hot->i_kode) != NULL): ?>
                                <img class="card-img-top"
                                     src="<?= base_url('upload/' . $item_img($hot->i_kode)->ii_nama); ?>"
                                     alt="<?= $item_img($hot->i_kode)->ii_nama; ?>">
                            <?php else: ?>
                                <img class="img-fluid mx-auto d-block"
                                     src="<?= base_url('assets/img/noimage.jpg'); ?>"
                                     alt="No Image">
                            <?php endif; ?>
                        </a>
                        <div class="card-body text-center">
<!--                            <i class="fa fa-star c-star m-0"></i>-->
<!--                            <i class="fa fa-star c-star m-0"></i>-->
<!--                            <i class="fa fa-star c-star m-0"></i>-->
<!--                            <i class="fa fa-star c-star m-0"></i>-->
<!--                            <i class="fa fa-star c-star m-0"></i>-->
                            <h5 id="title" class="card-title c-both c-title"><?= $hot->i_nama; ?></h5>
                            <h5 id="rupiah" class="c-price"><?= $item->i_hrg; ?></h5>
                            <a href="<?= site_url('hot-item/item/' . $hot->i_url . '/detil'); ?>"
                               class="btn btn-csr c-cart c-cart-p">
                                <i class="fa fa-plus c-cart-i mr-2"></i><p class="d-inline-block m-0 font-weight-normal" style="font-size:1rem;">Add To Bag</p>
                            </a>
                        </div>
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
    <script>
        $(document).ready(function () {
            var options = $('#wu option');
            var arr = options.map(function (_, o) {
                return {t: $(o).text(), v: o.value, q: $(o).attr('data-qty')};
            }).get();
            arr.sort(function (o1, o2) {
                var t1 = o1.t.toLowerCase(), t2 = o2.t.toLowerCase();

                return t1 > t2 ? 1 : t1 < t2 ? -1 : 0;
            });
            options.each(function (i, o) {
                o.value = arr[i].v;
                $(o).text(arr[i].t);
                $(o).attr('data-qty', arr[i].q);
            });
            $("#wu").prepend("<option value='' selected='selected'>Select Size</option>");
        })
    </script>

<?php
include "layout/Footer.php";
?>