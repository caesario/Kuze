<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <!-- ======= Banner Checkout ======= -->
    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">ADDRESS SHIPPING</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item " href="<?= site_url('/'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item " href="<?= site_url('bag'); ?>">Bag</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item active-bread"
                   href="<?= site_url('checkout/' . $this->uri->segment(2) . '/alamat_pengiriman'); ?>">Address</a>
            </nav>
        </div>
    </div>


    <!-- ======= Detail Checkout ======= -->
    <div class="container-fluid c-padding-header mb-5">
        <div class="container-fluid f-padding">
            <div class="row">
                <div class="col-lg-9 col-md-9 c-margin-auto">
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
                <div class="col-lg-9 col-md-9 c-margin-auto">
                    <h5 class="mb-4">ADDRESS DETAIL</h5>
                    <form action="alamat_pengiriman/simpan" method="post" id="form_alamat">
                        <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="alamat_simpan" id="alamat_simpan">
                        <div class="row form-group">
                            <div class="col-lg-12 col-sm-12">
                                <div class="form-check pl-0">
                                    <input class="form-check-input d-none r-check " type="checkbox" name="alamat_exist"
                                           value="false" id="alamat_exist">
                                    <label class="form-check-label r-check-label" for="alamat_exist">
                                        <h5 class=""><i class="fa fa-address-book text-center " style="width:30px;"></i>
                                            Choose an existing address</h5>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <div class="form-check pl-0">
                                    <input class="form-check-input d-none r-check" type="checkbox" value="false"
                                           id="check_dropship">
                                    <label class="form-check-label r-check-label" for="check_dropship">
                                        <h5 class=""><i class="fa fa-cart-arrow-down text-center"
                                                        style="width:30px;"></i> Dropship Order</h5>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" id="row_nama_alamat" style="display: none;">
                            <div class="col-lg-12 col-sm-12">
                                <select name="pilih_alamat" id="pilih_alamat" class="form-control"></select>
                            </div>
                        </div>
                        <div id="pengirim" style="display: none;">
                            <div class="row form-group">
                                <div class="col">
                                    <label for="nama_pengirim">Shipper</label>
                                    <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control"
                                           placeholder="Shipper Name">
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label for="kontak_pengirim">Phone</label>
                                    <input type="number" name="kontak_pengirim" id="kontak_pengirim"
                                           class="form-control"
                                           placeholder="Shipper Phone">
                                </div>
                            </div>
                            <hr class="mb-4 mt-4">
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6 col-sm-12 mb-2">
                                <label for="nama_penerima">Recipient</label>
                                <input type="text" name="nama_penerima" id="nama_penerima" class="form-control"
                                       placeholder="Recipient Name">
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="kontak_penerima">Phone</label>
                                <input type="number" name="kontak_penerima" id="kontak_penerima" class="form-control"
                                       placeholder="Recipient Phone">
                            </div>

                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6 col-sm-12">
                                <label for="provinsi">Province</label>
                                <select name="provinsi" id="provinsi" class="provinsi form-control" required>
                                </select>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="kabupaten">City</label>
                                <select name="kabupaten" id="kabupaten" class="kabupaten form-control" required>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6 col-sm-12">
                                <label for="kecamatan">District</label>
                                <select name="kecamatan" id="kecamatan" class="kecamatan form-control" required>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-3 col-sm-12">
                                <label for="kodepos">Pos Code</label>
                                <input name="kodepos" id="kodepos" type="number"
                                       class="form-control" placeholder="Pos Code" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label class="f-test" for="alamat">Address</label>
                                <textarea name="alamat" id="alamat" class="form-control"
                                          placeholder="Building, Street, ect."
                                          required></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <button id="lanjutbtn"
                                        type="button"
                                        data-toggle="modal"
                                        data-target="#lanjut"
                                        class="btn btn-csr c-btn-cart mt-3">Payment Method
                                </button>
                                <br>
                                <button type="reset" class="btn btn-csr c-btn-cart mt-3">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
        </div>
        <div class="modal fade" id="lanjut" tabindex="-1" role="dialog" aria-labelledby="lanjut" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5>Do you want to save this address?</h5>
                    </div>
                    <div class="modal-footer">
                        <button id="simpan_ya" class="btn btn-csr c-btn-cart">Yes</button>
                        <button id="simpan_tidak" class="btn btn-csr c-btn-cart">No</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#provinsi').select2({
                theme: 'bootstrap4',
                placeholder: 'Choose Province',
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
                placeholder: 'Choose City',
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
            }).on('select2:select', function () {
                var id = $(this).val();
                $.get('<?= site_url('API/get_kodepos/'); ?>' + id, function (res) {
                    $('#kodepos').val(res);
                })
            });
            $('#kecamatan').select2({
                theme: 'bootstrap4',
                placeholder: 'Choose Distric',
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

            $('#pilih_alamat').select2({
                theme: 'bootstrap4',
                placeholder: 'Choose Address',
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

        $(function () {
            var dropship = $('#check_dropship'),
                alamat_exist = $('#alamat_exist'),
                btn_next = $('#lanjutbtn'),
                row_nama_alamat = $('#row_nama_alamat'),
                form_alamat = $('#form_alamat'),
                simpan_ya = $('#simpan_ya'),
                simpan_tidak = $('#simpan_tidak');

            dropship.change(function () {
                if (this.checked) {
                    dropship.val('true');
                    $('[id=pengirim]').show();
                } else {
                    dropship.val('false');
                    $('[id=pengirim]').hide();
                }
            });


            alamat_exist.change(function () {
                if (this.checked) {
                    alamat_exist.val('true');
                    btn_next.prop('type', 'submit').removeAttr("data-toggle").removeAttr("data-target");
                    row_nama_alamat.show();
                } else {
                    alamat_exist.val('false');
                    btn_next.prop('type', 'button').attr("data-toggle", 'modal').attr("data-target", '#lanjut');
                    row_nama_alamat.hide();
                }
            });


            simpan_ya.click(function () {
                form_alamat.find('input[name=alamat_simpan]')
                    .val('true');
                form_alamat.submit();
            });

            simpan_tidak.click(function () {
                form_alamat.find('input[name=alamat_simpan]')
                    .val('false');
                form_alamat.submit();
            })
        })
    </script>

<?php
include "layout/Footer.php";
?>