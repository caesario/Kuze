<?php
include "layout/Header.php";
include "layout/Menu.php";
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
        <h5 class="text-center c-order-info mb-0">DETAIL PESANAN : #421504</h5>
        <p class="text-center c-order-info mb-4">19 May 2018</p>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="c-order-info">
                    <p class="mb-1"><i class="fa fa-credit-card mr-2"></i><b>Nama Penerima</b></p>
                    <p class="ml-5 mb-0">Jhon Pardede</p>
                    <p class="ml-5">082112998381</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="c-order-info">
                    <p class="mb-2"><i class="fa fa-credit-card mr-2"></i> <b>Rekening Transfer</b></p>
                    <p class="ml-5">BCA a/n Kuze Shop - 41299488733</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="c-order-info">
                    <p class="mb-2"><i class="fa fa-address-book mr-2"></i> <b>Alamat Pengiriman</b></p>
                    <p class="ml-5">Jl. Meruya Tower Utara No.17, Cengkareng - Jakarta Barat 12599</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="c-order-info">
                    <p class="mb-2"><i class="fa fa-car mr-2"></i> <b>Metode Pengiriman</b></p>
                    <p class="ml-5">Jalur Nugraha Ekakurir (JNE) - Ongkos Kirim Ekonomis (4-6 hari)</p>
                </div>
            </div>
        </div>
    </div>

        <div class="container-fluid c-padding-header mb-5">
           <div class="row">
               <div class="col-8 c-margin-auto">
                   <h5><i class="fa fa-money mr-2 mt-4 mb-2 "></i>Form Konfirmasi Pembayaran</h5>
                   <form>
                       <div class="form-group">
                           <label class="col-form-label">Rekening Atas Nama  <span class="c-form-star">*</span></label>
                           <input type="text" class="form-control" id="inputRekeningNama" placeholder="Masukkan Nama Pemilik Rekening..." required>
                       </div>
                       <div class="form-group">
                           <label class="col-form-label mt-1">Transfer dari Bank <span class="c-form-star ">*</span></label>
                           <input type="text" class="form-control mt-1" id="inputNamaBank" placeholder="Masukkan Nama Bank..." required>
                       </div>
                       <div class="form-group">
                           <label for="example-date-input" class="col-form-label">Nominal Transfer<span class="c-form-star">*</span></label>
                           <input class="form-control" type="number" id="inputNominalTransfer" placeholder="Masukkan Nominal Transfer" required>
                       </div>
                   </form>
                   <a href="<?= site_url('Detail_pesanan'); ?>" class="btn btn-csr c-btn-cart mt-3 mb-5 float-right">KONFIRMASI PEMBAYARAN</a>
               </div>
           </div>
    </div>

<?php
include "layout/Footer.php";
?>