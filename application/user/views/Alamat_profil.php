<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <hr class="mb-5 c-hr-reset">

    <div class="container-fluid c-padding-header">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <!-- <div class="col-12">
                        <div class="mb-4">
                          <div class="">
                            <h5 class="card-title mb-1">Jhon Doe Ponegoro</h5>
                            <p class="card-text mb-1">Caesar Tower, 27th Cengkareng Raya Street, South Cengkareng Indonesia 12520</p>
                            <p class="card-text"><small class="text-muted">Join 24 Sep 2018</small></p>
                          </div>
                        </div>
                    </div> -->
                    <div class="col-12">
                        <div class="list-group mb-4">
                            <a href="<?= site_url('profil'); ?>"
                               class="list-group-item list-group-item-action ">My Profile</a>
                            <a href="<?= site_url('profil_password'); ?>"
                               class="list-group-item list-group-item-action ">
                                Change Password
                            </a>
                            <a href="<?= site_url('alamat_profil'); ?>"
                               class="list-group-item list-group-item-action c-profil-active">Address</a>
                            <a href="<?= site_url('order_status'); ?>" class="list-group-item list-group-item-action">Pending Orders</a>
                            <a href="<?= site_url('order_history'); ?>" class="list-group-item list-group-item-action">Order History</a>
                            <a href="<?= site_url('resi'); ?>" class="list-group-item list-group-item-action">Airwaybill Report</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 c-color-profil">
                <h5 class="mb-2">Address</h5>
                <div class="">
                    <div class="card-body pt-0">
                        <div class="row container-fluid mt-3">

                            <div class="col-lg-12 col-md-12">

                                <form action="profil_alamat/simpan" method="post">
                                    <input type="hidden" name="ecommerce_eazy"
                                           value="<?= $this->security->get_csrf_hash(); ?>">
                                    <input type="hidden" name="alamat_kode" id="alamat_kode">
                                    <div class="row form-group" id="row_nama_alamat">
                                        <div class="col">
                                            <select name="pilih_alamat" id="pilih_alamat" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="row form-group" id="row_judul_alamat" style="display: none;">
                                        <div class="col">
                                            <label for="nama_alamat">Address Title</label>
                                            <input type="text" name="nama_alamat" id="nama_alamat" class="form-control"
                                                   placeholder="Address Title" required>
                                        </div>
                                    </div>
                                    <h6 class="mb-2">Shipper</h6>
                                    <div id="pengirim">
                                        <div class="row form-group">
                                            <div class="col">
                                                <label for="nama_pengirim">Sender Name</label>
                                                <input type="text" name="nama_pengirim" id="nama_pengirim"
                                                       class="form-control"
                                                       placeholder="Sender Name">

                                            </div>
                                            <div class="col">
                                                <label for="kontak_pengirim">Phone Number </label>
                                                <input type="text" name="kontak_pengirim" id="kontak_pengirim"
                                                       class="form-control"
                                                       placeholder="Sender Phone Number">
                                            </div>
                                        </div>
                                        <hr>
                                        <h6 class="mb-2">Recipient</h6>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="nama_penerima">Full Name</label>
                                            <input type="text" name="nama_penerima" id="nama_penerima"
                                                   class="form-control"
                                                   placeholder="Full Name...">
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="kontak_penerima">Phone Number</label>
                                            <input type="text" name="kontak_penerima" id="kontak_penerima"
                                                   class="form-control"
                                                   placeholder="Phone Number...">
                                        </div>

                                    </div>
                                    <div class="row form-group">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="provinsi">Province</label>
                                            <select name="provinsi" id="provinsi" class="provinsi form-control"
                                                    required>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="kabupaten">City</label>
                                            <select name="kabupaten" id="kabupaten" class="kabupaten form-control"
                                                    required>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group mt-2">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="kecamatan">
                                                Districts</label>
                                            <select name="kecamatan" id="kecamatan" class="kecamatan form-control"
                                                    required>
                                            </select>
                                        </div>



                                        <div class="col mt-2">
                                            <label for="kodepos">Post Code</label>
                                            <input name="kodepos" id="kodepos" type="number"
                                                   class="form-control" placeholder="Kode Pos" required>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col">
                                            <label class="f-test" for="alamat">Full Address</label>
                                            <textarea name="alamat" id="alamat" class="form-control"
                                                      placeholder="Street, Building, or etc"
                                                      required></textarea>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col">
                                            <button type="submit" class="btn c-login-btn c-edit">Save
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal'] != ""): ?>
                                            <div class="col">
                                                <div class="alert alert-danger alert-dismissible fade show"
                                                     role="alert">
                                                    <?php echo $_SESSION['gagal']; ?>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] != ""): ?>
                                            <div class="col">
                                                <div class="alert alert-success alert-dismissible fade show"
                                                     role="alert">
                                                    <?php echo $_SESSION['berhasil']; ?>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>




            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#provinsi').select2({
                theme: 'bootstrap4',
                placeholder: 'Select Province',
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
                placeholder: 'Select City',
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
                placeholder: 'Select District',
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
                placeholder: 'Select Village',
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
                placeholder: 'Select Address',
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
                var alamat_kode = $('#alamat_kode');
                var nama_alamat = $('#nama_alamat');
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
                        nama_alamat.val(data.a_nama),
                        nama_penerima.val(data.pengguna_alamat_r_nama),
                        kontak_penerima.val(data.pengguna_alamat_r_kontak),
                        nama_pengirim.val(data.pengguna_alamat_s_nama),
                        kontak_pengirim.val(data.pengguna_alamat_s_kontak),
                        alamat.val(data.alamat_deskripsi),
                        alamat_kode.val(data.alamat_kode)
                    );

                });
            })
        });
    </script>
<?php
include "layout/Footer.php";
?>