<?php
include "layout/Header.php";
include "layout/Menu.php";
?>
<?php $nomor_order = $this->uri->segment(2); ?>
<?php $biaya_subtotal = $biaya_subtotal();
$biaya_pengiriman = $biaya_pengiriman();
$total = $biaya_subtotal + $biaya_pengiriman;
?>
    <!-- ======= Banner Checkout ======= -->
    <div class="wrapper-cart c-margin-bot-cart">
        <h5 class="text-center c-title-cart">Konfirmasi Pembayaran</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <p>

            </p>
        </div>
    </div>

    <!-- Detail Konfirmasi Pembayaran -->
    <div class="container c-padding-header">
        <h5 class="text-center c-order-info mb-5">DETAIL PESANAN : #<?= $nomor_order; ?></h5>

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="c-order-info">
                    <p class="ml-5 mb-1"><i class="fa fa-credit-card mr-2"></i><b>Nama Penerima</b></p>
                    <p class="ml-5 mb-0"><?= $nama_nomor(); ?></p>

                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="c-order-info">
                    <p class="ml-5 mb-2"><i class="fa fa-credit-card mr-2"></i> <b>Rekening Transfer</b></p>
                    <p class="ml-5"><?= $metode_pembayaran(); ?></p>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6 col-sm-12">
                <div class="c-order-info">
                    <p class=" ml-5 mb-2"><i class="fa fa-address-book mr-2"></i> <b>Alamat Pengiriman</b></p>
                    <p class=" ml-5 mr-4">    <?= $pengiriman(); ?></p>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="c-order-info">
                    <p class="ml-5 mb-2"><i class="fa fa-car mr-2"></i> <b>Metode Pengiriman</b></p>
                    <p class="ml-5 mr-4">  <?= $jasa(); ?></p>
                </div>
            </div>
        </div>
    </div>

        <div class="container-fluid c-padding-header mb-5">
           <div class="row">
               <div class="col-8 c-margin-auto">
                   <h5><i class="fa fa-money mr-2 mt-4 mb-2 "></i>Form Konfirmasi Pembayaran</h5>
                   <form action="konfirmasi_pembayaran/simpan" method="post" enctype="multipart/form-data">
                       <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                       <div class="form-group">
                           <label class="col-form-label">Pembayaran Dari Bank   <span class="c-form-star">*</span></label>
                           <input type="text"
                                  class="form-control"
                                  id="inputRekeningNama"
                                  placeholder="Masukkan Nama Pemilik Rekening..."
                                  name="bank"
                                  required>
                       </div>
                       <div class="form-group">
                           <label class="col-form-label mt-1">Rekening Atas Nama <span class="c-form-star ">*</span></label>
                           <input type="text"
                                  class="form-control mt-1"
                                  id="inputNamaBank"
                                  placeholder="Masukkan Nama Bank..."
                                  name="rek_atasnama"
                                  required>
                       </div>
                       <div class="form-group">
                           <label for="example-date-input" class="col-form-label">Nominal Transfer<span class="c-form-star">*</span></label>
                           <input class="form-control"
                                  type="number"
                                  id="inputNominalTransfer"
                                  placeholder="Masukkan Nominal Transfer"
                                  name="nomor_rekening"
                                  required>
                       </div>
                       <div class="form-group">
                           <label for="total_pembayaran">Total Pembayan : *</label>
                           <input type="number" class="form-control" min="<?= $total; ?>"
                                  max="<?= $total; ?>"
                                  name="total_pembayaran" placeholder="Input Total Pembayaran"
                                  value="<?= $total; ?>"
                                  required>
                       </div>

                       <div class="form-group">
                           <label for="bukti_pembayaran">Upload Bukti Pembayaran : </label>
                           <br>
                           <div class="r-upload-f-button-font-wrapper">
                               <button class="r-btn"><i class="fa fa-upload" style="font-size: 18px;"></i>Unggah
                                   Bukti
                               </button>
                               <input type="file" name="bukti_pembayaran">
                           </div>
                       </div>
                   </form>
                   <a type="submit" href="<?= site_url('Detail_pesanan'); ?>" class="btn btn-csr c-btn-cart mt-3 mb-5 float-right">KONFIRMASI PEMBAYARAN</a>
               </div>
           </div>
    </div>

<?php
include "layout/Footer.php";
?>