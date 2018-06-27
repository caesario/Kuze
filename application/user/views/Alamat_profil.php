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
                            <a href="<?= site_url('Profil'); ?>" class="list-group-item list-group-item-action ">Profil</a>
                            <a href="<?= site_url('Alamat_profil'); ?>" class="list-group-item list-group-item-action c-profil-active">Alamat</a>
                            <a href="<?= site_url('Order_status'); ?>" class="list-group-item list-group-item-action">Transaksi Tertunda</a>
                            <a href="<?= site_url('Order_history'); ?>" class="list-group-item list-group-item-action">Riwayat Transaksi</a>
                            <a href="<?= site_url('Resi'); ?>" class="list-group-item list-group-item-action">Laporan Resi</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 c-color-profil">
                <h5>Alamat Saya</h5>
                <div class="card">
                    <div class="card-body pt-0">
                        <div class="row">
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
                                            <label for="nama_alamat">Judul</label>
                                            <input type="text" name="nama_alamat" id="nama_alamat" class="form-control"
                                                   placeholder="Judul Alamat" required>
                                        </div>
                                    </div>
                                    <div id="pengirim">
                                        <div class="row form-group">
                                            <div class="col">
                                                <label for="nama_pengirim">Nama Pengirim</label>
                                                <input type="text" name="nama_pengirim" id="nama_pengirim"
                                                       class="form-control"
                                                       placeholder="Nama Pengirim">
                                            </div>
                                            <div class="col">
                                                <label for="kontak_pengirim">Nomor Telp. Pengirim</label>
                                                <input type="text" name="kontak_pengirim" id="kontak_pengirim"
                                                       class="form-control"
                                                       placeholder="Kontak Pengirim">
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="nama_penerima">Nama Lengkap</label>
                                            <input type="number" name="nama_penerima" id="nama_penerima"
                                                   class="form-control"
                                                   placeholder="Nama Lengkap Anda...">
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="kontak_penerima">Nomor Telepon</label>
                                            <input type="text" name="kontak_penerima" id="kontak_penerima"
                                                   class="form-control"
                                                   placeholder="Nomor Telepon Anda..">
                                        </div>

                                    </div>
                                    <div class="row form-group">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="provinsi">Provinsi</label>
                                            <select name="provinsi" id="provinsi" class="provinsi form-control"
                                                    required>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="kabupaten">Kabupaten / Kota</label>
                                            <select name="kabupaten" id="kabupaten" class="kabupaten form-control"
                                                    required>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="kecamatan">Kecamatan</label>
                                            <select name="kecamatan" id="kecamatan" class="kecamatan form-control"
                                                    required>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="kelurahan">Kelurahan / Desa</label>
                                            <select name="kelurahan" id="kelurahan" class="kelurahan form-control"
                                                    required>
                                            </select>
                                        </div>

                                        <div class="col">
                                            <label for="kodepos">Kode Pos</label>
                                            <input name="kodepos" id="kodepos" type="number"
                                                   class="form-control" placeholder="Kode Pos" required>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col">
                                            <label class="f-test" for="alamat">Alamat Lengkap</label>
                                            <textarea name="alamat" id="alamat" class="form-control"
                                                      placeholder="Nama Gedung, Jalan, dan lainnya"
                                                      required></textarea>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col text-right">
                                            <a class="btn c-login-btn c-edit" href="<?= site_url('Profil'); ?>" role="button">Simpan</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>




            </div>
        </div>
    </div>
<?php
include "layout/Footer.php";
?>