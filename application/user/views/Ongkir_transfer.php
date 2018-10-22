<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Checkout ======= -->
    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">Payment & Shipping Method</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item " href="<?= site_url('/'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item " href="<?= site_url('bag'); ?>">Bag</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item "
                   href="<?= site_url('checkout/' . $this->uri->segment(2) . '/alamat_pengiriman'); ?>">Address</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item active-bread"
                   href="<?= site_url('checkout/' . $this->uri->segment(2) . '/ongkir_transfer'); ?>">Payment & Shipping
                    Method</a>
            </nav>
        </div>
    </div>


    <!-- ======= Detail Checkout ======= -->
    <div class="container-fluid c-padding-header mb-5">
        <div class="row">
            <div class="col-lg-6">
                <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal'] != ""): ?>
                    <div class="alert alert-danger alert-dismissible fade show"
                         role="alert">
                        <?php echo $_SESSION['gagal']; ?>
                        <button type="button" class="close" data-dismiss="alert"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] != ""): ?>
                    <div class="alert alert-success alert-dismissible fade show"
                         role="alert">
                        <?php echo $_SESSION['berhasil']; ?>
                        <button type="button" class="close" data-dismiss="alert"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6">
                <form class="col-lg-12 col-md-12" action="ongkir_transfer/simpan" method="post">
                    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="orders_noid" value="<?= $orders->orders_noid; ?>">
                    <input type="hidden" name="nomor_order" value="<?= $this->uri->segment(2); ?>">
                    <h6>Shipping Method (Please Select One)</h6>
                    <?php foreach ($pengiriman as $k1): ?>
                        <?php $nama = $k1->name; ?>
                        <?php foreach ($k1->costs as $k2): ?>
                            <?php $service = $k2->service; ?>
                            <?php $deskripsi = $k2->description; ?>
                            <?php foreach ($k2->cost as $k3): ?>
                                <?php $biaya = $k3->value; ?>
                                <?php $estimasi = $k3->etd; ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pengiriman"
                                           onchange="ongkir($(this))"
                                           id="pengiriman-<?= $service; ?>"
                                           data-deskripsi="<?= $deskripsi; ?>"
                                           data-biaya="<?= $biaya; ?>"
                                           data-estimasi="<?= $estimasi; ?>"
                                           data-nama="<?= $nama; ?>"
                                           value="1" required>
                                    <label class="form-check-label" for="pengiriman-<?= $service; ?>">
                                        <?= $nama . ' - ' . $deskripsi . ' (' . $estimasi . ' hari) ('; ?> <span
                                                id="rupiah"><?= $biaya; ?></span>)
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>

                    <br>


                    <h6>Payment Method (Please Select One)</h6>
                    <?php if ($bank_opsi() === true): ?>
                        <?php if ($bank_s() != NULL): ?>
                            <?php foreach ($bank_s() as $bank): ?>
                                <?php $name = $bank->bank_penerbit . ' (A/N: ' . $bank->bank_nama . ') (Nomor Rek: ' . $bank->bank_rek . ')'; ?>
                                <div class="form-check">

                                    <input id="bank-<?= $bank->bank_kode; ?>"
                                           onchange="bank_change($(this))"
                                           class="form-check-input"
                                           type="radio"
                                           data-id="<?= $bank->bank_kode; ?>"
                                           name="bank"
                                           value="1" required>
                                    <label class="form-check-label"
                                           for="bank-<?= $bank->bank_kode; ?>"><?= $name; ?></label>

                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-danger">Admin has not determined the payment method.</p>
                    <?php endif; ?>
                    <br>
                    <input type="hidden" name="bank_id" id="bank_id">
                    <input type="hidden" name="nama" id="nama">
                    <input type="hidden" name="deskripsi" id="deskripsi">
                    <input type="hidden" name="biaya" id="biaya">
                    <input type="hidden" name="estimasi" id="estimasi">
                    <button type="submit" class="btn f-button-color" <?= $bank_opsi() == true ? '' : 'disabled'; ?>>
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>


    <script>
        function ongkir(prepare) {
            var deskripsi = prepare.attr('data-deskripsi');
            var biaya = prepare.attr('data-biaya');
            var estimasi = prepare.attr('data-estimasi');
            var nama = prepare.attr('data-nama');

            $.when(
                $('#nama').val(nama),
                $('#deskripsi').val(deskripsi),
                $('#biaya').val(biaya),
                $('#estimasi').val(estimasi)
            )
        };

        function bank_change(prepare) {
            var bank_id = prepare.attr('data-id');

            $.when(
                $('#bank_id').val(bank_id)
            )
        }

    </script>
<?php
include "layout/Footer.php";
?>