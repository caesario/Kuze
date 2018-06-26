<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Checkout ======= -->
    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">ALAMAT PENGIRIMAN</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item" href="<?= site_url('Home'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Keranjang'); ?>">Keranjang</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Metode'); ?>">Metode Pengiriman</a>
            </nav>
        </div>
    </div>


    <!-- ======= Detail Checkout ======= -->
    <div class="container-fluid c-padding-header mb-5">
        <div class="row">
            <!-- ======= Checkout Left ======= -->
            <div class="col-lg-6">
                <h5 class="mb-4">DETAIL ALAMAT</h5>
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">First Name<span class="c-form-star">*</span></label>
                            <input type="text" class="form-control" id="inputFirstName" placeholder="Jhon">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Last Name<span class="c-form-star">*</span></label>
                            <input type="text" class="form-control" id="inputLastName" placeholder="Lincoln">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">E-mail<span class="c-form-star">*</span></label>
                        <input type="email" class="form-control" id="inputEmail" placeholder="Jhon.lincoln@kuze.com">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress" class="col-form-label">Address<span class="c-form-star">*</span></label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="Medan Merdeka Street 7th, Central Jakarta">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity" class="col-form-label">City<span class="c-form-star">*</span></label>
                            <select id="inputCity" class="form-control">
                                <option selected>Choose City ...</option>
                                <option value="1">Jakarta</option>
                                <option value="2">Bandung</option>
                                <option value="3">Bogor</option>
                                <option value="4">Depok</option>
                                <option value="5">Tangerang</option>
                                <option value="6">Banten</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState" class="col-form-label">State<span class="c-form-star">*</span></label>
                            <select id="inputState" class="form-control">
                                <option value="1">...</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputSubdistric" class="col-form-label">Subdistric<span class="c-form-star">*</span></label>
                            <select id="inputSubdistric" class="form-control">
                                <option value="1">...</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputZip" class="col-form-label">Postcode</label>
                            <input type="text" class="form-control" id="inputZip" placeholder="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPhone" class="col-form-label">Phone*</label>
                            <input type="text" class="form-control" id="inputPhone" placeholder="0812 **** ****">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="exampleFormControlTextarea1" class="col-form-label">Order notes</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                        </div>
                    </div>
                </form>
                <!-- ======= Checkout Collapse ======= -->
                <a class="c-collapse" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <h5 class="mt-4 mb-4"><i class="fa fa-address-book-o"></i> DROPSHIP PESANAN</h5>
                </a>
                <div class="collapse" id="collapseExample">
                    <form>
                        <div class="form-group">
                            <label class="col-form-label">Nama Pengirim<span class="c-form-star">*</span></label>
                            <input type="email" class="form-control" id="inputEmail" placeholder="Jhon">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="col-form-label">Nama Penerima<span class="c-form-star">*</span></label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="Bob">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1" class="col-form-label">Order notes</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ======= Checkout Right ======= -->
            <div class="col-lg-6">
                <h5 class="mb-4">KERANJANG ANDA</h5>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th></th>
                        <th>Nama Produk</th>
                        <th class="text-center">Total</th>
                    </tr>
                    <tr>
                        <td><a href=""><img class="c-img-checkout" src="assets/img/product4.jpg" alt=""></a></td>
                        <td><p class="c-cart-productname"><a href="detail-item.html">Tank with V-Neck and Panel Detail</a></p></td>
                        <td><span class="c-price-cart-3 pl-3">Rp100.000</span></td>
                    </tr>
                    <tr>
                        <td><a href=""><img class="c-img-checkout" src="assets/img/product2.jpg" alt=""></a></td>
                        <td><p class="c-cart-productname"><a href="detail-item.html">Lavish Alice Deep Bandeau Asymmetric</a></p></td>
                        <td><span class="c-price-cart-3 pl-3">Rp125.000</span></td>
                    </tr>
                    <tr>
                        <th class="c-table-cart-total p-1 pl-4">Subtotal</th>
                        <td colspan="2" class="text-center"><span class="c-price-cart-3 pl-3">Rp225.000</span></td>
                    </tr>
                    <tr>
                        <th class="p-1 pl-4">Pengiriman</th>
                        <td colspan="2" class="text-center"><span class="c-price-cart-3 pl-3">-</span></td>
                    </tr>
                    <tr>
                        <th class="p-1 pl-4">Lainnya</th>
                        <td colspan="2" class="text-center"><span class="c-price-cart-3 pl-3">-</span></td>
                    </tr>
                    <tr>
                        <th class="p-1 pl-4">Total</th>
                        <td colspan="2" class="text-center"><span class="c-price-cart-4 pl-3 c-l-hight">Rp250.000</span></td>
                    </tr>
                    </tbody>
                </table>
                <a href="<?= site_url('Metode_pengiriman'); ?>" class="btn btn-csr c-btn-cart mt-3 float-right">METODE PENGIRIMAN</a>
            </div>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>