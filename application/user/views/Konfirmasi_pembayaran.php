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
    <div class="container-fluid c-padding-header    ">

        <div class="c-order-info">
            <p>Detail Order</p>
            <ul>
                <li>Order number : <b>1504</b></li>
                <li>Date : <b>19 May 2018</b></li>
                <li>Total : <b>Rp250.000</b></li>
                <li>Payment method : <b>Bank Transfer</b></li>
            </ul>
        </div>
        <div class="c-order-info">
            <p class="mb-2">Rekening Transfer</p>
            <p class="ml-4"><b>BCA a/n Kuze Shop - 41299488733</b></p>
        </div>

        <h5><i class="fa fa-money mr-2 mt-4 mb-2"></i>Form Konfirmasi Pembayaran</h5>

           <div class="row">
               <div class="col">
                   <form>
                       <div class="form-group">
                           <label class="col-form-label">Kode Invoice <span class="c-form-star ">*</span></label>
                           <input type="text" class="form-control" id="inputKodeinvoice" placeholder="Masukkan Kode Invoice.." required>
                       </div>
                       <div class="form-group">
                           <label class="col-form-label mt-1">Alamat Email <span class="c-form-star">*</span></label>
                           <input type="email" class="form-control mt-1" id="inputAlamatEmail" placeholder="Masukkam Alamat Email..." required>
                       </div>
                       <div class="form-group">
                           <label for="example-date-input mt-1" class="col-form-label">Tanggal Transfer <span class="c-form-star">*</span></label>
                           <input class="form-control mt-1" type="date" value="dd-mm-yy" id="example-date-input" required>
                       </div>
                       <div class="form-group">
                           <label class="col-form-label mt-1">Transfer dari Bank <span class="c-form-star ">*</span></label>
                           <input type="text" class="form-control mt-1" id="inputNamaBank" placeholder="Masukkan Nama Bank..." required>
                       </div>
                   </form>

               </div>

               <div class="col">
                   <form>

                       <div class="form-group">
                           <label class="col-form-label">Rekening Atas Nama  <span class="c-form-star">*</span></label>
                           <input type="text" class="form-control" id="inputRekeningNama" placeholder="Masukkan Nama Pemilik Rekening..." required>
                       </div>
                       <div class="form-group">
                           <label for="example-date-input" class="col-form-label">Nominal Transfer<span class="c-form-star">*</span></label>
                           <input class="form-control" type="number" id="inputNominalTransfer" placeholder="Masukkan Nominal Transfer" required>

                       </div>
                       <div class="form-group ">
                           <label for="example-date-input" class="col-form-label">Catatan ( Opsional )</label>
                           <textarea class="form-control " type="text" id="inputCatatan" rows="5" placeholder="Masukkan Catatan.."></textarea>

                       </div>
                   </form>
                   <a href="<?= site_url(''); ?>" class="btn btn-csr c-btn-cart mt-3 float-right">KONFIRMASI PEMBAYARAN</a>
               </div>

           </div>
    </div>


<?php
include "layout/Footer.php";
?>