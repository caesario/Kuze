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
                <a class="breadcrumb-item" href="<?= site_url('Alamat'); ?>">Alamat</a>
            </nav>
        </div>
    </div>


    <!-- ======= Detail Checkout ======= -->
    <div class="container-fluid c-padding-header mb-5">
        <div class="row">
            <!-- ======= Checkout Left ======= -->
            <div class="col-lg-8 c-margin-auto">
                <h5 class="mb-4">DETAIL ALAMAT</h5>
                <form action="alamat_pengiriman/simpan" method="post" id="form_alamat">
                <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="alamat_simpan" id="alamat_simpan">
                <div class="row form-group">
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="alamat_exist" value="true" id="alamat_exist">
                            <label class="form-check-label" for="alamat_exist">
                                <h5 class=""><i class="fa fa-address-book-o"></i> Pilih Alamat Yang Ada</h5>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" id="check_dropship">
                            <label class="form-check-label" for="check_dropship">
                                <h5 class=""><i class="fa fa-address-card-o"></i> Dropship Pesanan</h5>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row form-group" id="row_nama_alamat" style="display: none;">
                    <div class="col-lg-12 col-sm-12">
<!--                    <select name="pilih_alamat" id="pilih_alamat" class="form-control"></select>-->
                    <label class="col-form-label">Pilih Alamat<span class="c-form-star">*</span></label>
                    <select class="form-control" name="pilih_alamat" id="pilih_alamat">
                    </select>
                    </div>
                </div>
                <div id="pengirim" style="display: none;">
                    <div class="form-group">
                        <label for="nama_pengirim" class="col-form-label">Nama Pengirim<span class="c-form-star">*</span></label>
                        <input type="text" class="form-control" id="nama_pengirim" placeholder="Abdul">
                    </div>
                    <div class="form-group">
                        <label for="kontak_pengirim" class="col-form-label">Nomor Telpon Pengirim<span class="c-form-star">*</span></label>
                        <input type="number" class="form-control" id="kontak_pengirim" placeholder="0821 **** ****">
                    </div>
                    <hr>
                    </form>
                </div>


                <!-- ======= Alamat Tersimpan ======= -->
<!--                <a class="c-collapse" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">-->
<!--                    <h5 class="mt-4 mb-2"><i class="fa fa-address-book-o"></i> Pilih Alamat Yang Ada</h5>-->
<!--                </a>-->
<!--                <div class="collapse" id="collapseExample">-->
<!--                    <form>-->
<!--                        <div class="form-group">-->
<!--                            <label class="col-form-label">Pilih Alamat<span class="c-form-star">*</span></label>-->
<!--                            <select class="form-control" id="exampleFormControlSelect1">-->
<!--                                <option>1</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </form>-->
<!--                </div>-->
                <!-- ======= Dropship ======= -->
<!--                <a class="c-collapse" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">-->
<!--                    <h5 class="mt-4 mb-2"><i class="fa fa-address-card-o"></i> Dropship Pesanan</h5>-->
<!--                </a>-->
<!--                <div class="collapse" id="collapseExample2">-->
<!--                    <form>-->
<!--                        <div class="form-group">-->
<!--                            <label class="col-form-label">Nama Pengirim<span class="c-form-star">*</span></label>-->
<!--                            <input type="email" class="form-control" id="inputEmail" placeholder="Abdul">-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <label for="inputAddress" class="col-form-label">Nomor Telpon Pengirim<span class="c-form-star">*</span></label>-->
<!--                            <input type="text" class="form-control" id="inputAddress" placeholder="0821 **** ****">-->
<!--                        </div>-->
<!--                        <hr>-->
<!--                    </form>-->
<!--                </div>-->


                <!-- ======= Alamat ======= -->
                <form>
                    <div class="form-group">
                        <label class="col-form-label" for="nama_penerima">Nama Penerima<span class="c-form-star">*</span></label>
                        <input type="text" class="form-control" name="nama_penerima" id="nama_penerima" placeholder="Jhon">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">E-mail<span class="c-form-star">*</span></label>
                        <input type="email" class="form-control" id="inputEmail" placeholder="Jhon.lincoln@kuze.com">
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-form-label">Address<span class="c-form-star">*</span></label>
                        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Medan Merdeka Street 7th, Central Jakarta">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="provinsi" class="col-form-label">Provinsi<span class="c-form-star">*</span></label>
                            <select name="provinsi" id="provinsi" class="form-control provinsi">
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kabupaten" class="col-form-label">Kota/Kabupaten<span class="c-form-star">*</span></label>
                            <select name="kabupaten" id="kabupaten" class="form-control kabupaten">
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="kecamatan" class="col-form-label">Kecamatan<span class="c-form-star">*</span></label>
                            <select name="kecamatan" id="kecamatan" class="form-control kecamatan">
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kelurahan" class="col-form-label">Kelurahan<span class="c-form-star">*</span></label>
                            <select name="kelurahan" id="kelurahan" class="form-control kelurahan">
                            </select>
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
                <a href="<?= site_url('Metode_pengiriman'); ?>" class="btn btn-csr c-btn-cart mt-3 float-right">METODE PENGIRIMAN</a>
                </form>
            </div>

            <!-- ======= Checkout Right ======= -->
<!--            <div class="col-lg-6">-->
<!--                <h5 class="mb-4">KERANJANG ANDA</h5>-->
<!--                <table class="table table-bordered">-->
<!--                    <tbody>-->
<!--                    <tr>-->
<!--                        <th></th>-->
<!--                        <th>Nama Produk</th>-->
<!--                        <th class="text-center">Total</th>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td><a href=""><img class="c-img-checkout" src="assets/img/product4.jpg" alt=""></a></td>-->
<!--                        <td><p class="c-cart-productname"><a href="detail-item.html">Tank with V-Neck and Panel Detail x2</a></p></td>-->
<!--                        <td><span class="c-price-cart-3 pl-3">Rp100.000</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td><a href=""><img class="c-img-checkout" src="assets/img/product2.jpg" alt=""></a></td>-->
<!--                        <td><p class="c-cart-productname"><a href="detail-item.html">Lavish Alice Deep Bandeau Asymmetric</a></p></td>-->
<!--                        <td><span class="c-price-cart-3 pl-3">Rp125.000</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th class="c-table-cart-total p-1 pl-4">Subtotal</th>-->
<!--                        <td colspan="2" class="text-center"><span class="c-price-cart-3 pl-3">Rp225.000</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th class="p-1 pl-4">Pengiriman</th>-->
<!--                        <td colspan="2" class="text-center"><span class="c-price-cart-3 pl-3">-</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th class="p-1 pl-4">Lainnya</th>-->
<!--                        <td colspan="2" class="text-center"><span class="c-price-cart-3 pl-3">-</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th class="p-1 pl-4">Total</th>-->
<!--                        <td colspan="2" class="text-center"><span class="c-price-cart-4 pl-3 c-l-hight">Rp250.000</span></td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->

        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#provinsi').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih provinsi',
                ajax: {
                    url: '<?= site_url('API/get_provinsi'); ?>',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    }
                }
            });
            $('#kabupaten').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih kabupaten',
                ajax: {
                    url: '<?= site_url('API/get_kabupaten'); ?>',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            provinsi: $('#provinsi').val()
                        };
                    }
                }
            });
            $('#kecamatan').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih kecamatan',
                ajax: {
                    url: '<?= site_url('API/get_kecamatan'); ?>',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            kabupaten: $('#kabupaten').val()
                        };
                    }
                }
            });
            $('#kelurahan').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih kelurahan / desa',
                ajax: {
                    url: '<?= site_url('API/get_kelurahan'); ?>',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            kecamatan: $('#kecamatan').val()
                        };
                    }
                }
            }).on('select2:select', function () {
                var id = $(this).val();
                $.get('<?= site_url('API/get_kodepos/'); ?>' + id, function (res) {
                    $('#kodepos').val(res);
                })
            });

            $('#pilih_alamat').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih alamat',
                ajax: {
                    url: '<?= site_url('API/get_alamat'); ?>',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    }
                }
            }).on('select2:select', function () {
                var id = $(this).val();
                var nama_penerima = $('#nama_penerima');
                var kontak_penerima = $('#kontak_penerima');
                var nama_pengirim = $('#nama_pengirim');
                var kontak_pengirim = $('#kontak_pengirim');
                var alamat = $('#alamat');
                var provinsi = $('#provinsi');
                var kabupaten = $('#kabupaten');
                var kecamatan = $('#kecamatan');
                var kelurahan = $('#kelurahan');
                $.ajax({
                    dataType: 'json',
                    url: '<?= site_url('API/get_full_alamat/'); ?>' + id
                }).then(function (data) {
                    console.log(data);
                    $.when(
                        $.getJSON('<?= site_url('API/get_provinsi/'); ?>' + data.alamat_provinsi, function (res) {
                            provinsi.append(new Option(
                                res.results[0].text, res.results[0].id, true, true
                            )).trigger('change');
                            provinsi.trigger({
                                type: 'select2:select',
                                params: {
                                    data: res
                                }
                            })
                        }),
                        $.getJSON('<?= site_url('API/get_kabupaten/'); ?>' + data.alamat_kabupaten, function (res) {
                            kabupaten.append(new Option(
                                res.results[0].text, res.results[0].id, true, true
                            )).trigger('change');
                            kabupaten.trigger({
                                type: 'select2:select',
                                params: {
                                    data: res
                                }
                            })
                        }),
                        $.getJSON('<?= site_url('API/get_kecamatan/'); ?>' + data.alamat_kecamatan, function (res) {
                            kecamatan.append(new Option(
                                res.results[0].text, res.results[0].id, true, true
                            )).trigger('change');
                            kecamatan.trigger({
                                type: 'select2:select',
                                params: {
                                    data: res
                                }
                            })
                        }),
                        $.getJSON('<?= site_url('API/get_kelurahan/'); ?>' + data.alamat_desa, function (res) {
                            kelurahan.append(new Option(
                                res.results[0].text, res.results[0].id, true, true
                            )).trigger('change');
                            kelurahan.trigger({
                                type: 'select2:select',
                                params: {
                                    data: res
                                }
                            })
                        }),
                        nama_penerima.val(data.pengguna_alamat_r_nama),
                        kontak_penerima.val(data.pengguna_alamat_r_kontak),
                        nama_pengirim.val(data.pengguna_alamat_s_nama),
                        kontak_pengirim.val(data.pengguna_alamat_s_kontak),
                        alamat.val(data.alamat_deskripsi)
                    );

                });
            })
        });
    </script>
    <script>

        $('#check_dropship').change(function () {
            if (this.checked) {
                $('[id=pengirim]').show();
            } else {
                $('[id=pengirim]').hide();
            }
        });

        $('#alamat_exist').change(function () {
            if (this.checked) {
                $('#lanjutbtn').prop('type', 'submit').removeAttr("data-toggle").removeAttr("data-target");
                $('#row_nama_alamat').show();
            } else {
                $('#lanjutbtn').prop('type', 'button').attr("data-toggle",'modal').attr("data-target",'#lanjut');
                $('#row_nama_alamat').hide();
            }
        });

        function simpan_iya() {
            $('#form_alamat').find('input[name=alamat_simpan]')
                .val(true);
            $('#form_alamat').submit();
        }

        function simpan_tidak() {
            $('#form_alamat').find('input[name=alamat_simpan]')
                .val(false);
            $('#form_alamat').submit();
        }

    </script>

<?php
include "layout/Footer.php";
?>