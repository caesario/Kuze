<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <hr class="mb-5 c-hr-reset">

    <div class="container-fluid c-padding-header mb-5">
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
                            <a href="<?= site_url('Alamat_profil'); ?>" class="list-group-item list-group-item-action ">Alamat</a>
                            <a href="<?= site_url('Order_status'); ?>" class="list-group-item list-group-item-action c-profil-active">Transaksi Tertunda</a>
                            <a href="<?= site_url('Order_history'); ?>" class="list-group-item list-group-item-action">Riwayat Transaksi</a>
                            <a href="<?= site_url('Resi'); ?>" class="list-group-item list-group-item-action">Laporan Resi</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 c-color-profil">
                <h5>Riwayat Pesanan</h5>
                <div class="table-responsive mt-3">
                    <table id="table" class="table">
                        <thead>
                        <tr>
                            <th scope="col">Nomor Order</th>
                            <th scope="col">Detail Order</th>
                            <th class="text-center" scope="col">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="align-middle">
                                   LNTG001
                                </td>
                                <td class="align-middle">
                                    <b class="c-order-info">Tanggal Order :</b><br>
                                    23/01/2018
                                    <br>
                                    <b class="c-order-info">Total Harga :</b><br>
                                    10000
                                    <br>
                                    <b class="c-order-info">Status :</b><br>
                                    <span class="c-success">SUKSES (Telah dikirim)</span><br>
                                    <b class="c-order-info">Deskripsi :</b><br>
                                    <div>
                                        SUKSES (Telah dikirim)
                                    </div>

                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn c-login-btn c-edit" href="" role="button">Lihat Detail</a>
                                    <a class="btn c-login-btn c-edit" href="" role="button">Proses</a>
                                </td>
                            </tr>

                            <tr>
                                <td class="align-middle">
                                    LNTG001
                                </td>
                                <td class="align-middle">
                                    <b class="c-order-info">Tanggal Order :</b><br>
                                    23/01/2018
                                    <br>
                                    <b class="c-order-info">Total Harga :</b><br>
                                    10000
                                    <br>
                                    <b class="c-order-info">Status :</b><br>
                                    <span class="c-success">SUKSES (Telah dikirim)</span><br>
                                    <b class="c-order-info">Deskripsi :</b><br>
                                    <div>
                                        SUKSES (Telah dikirim)
                                    </div>

                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn c-login-btn c-edit" href="" role="button">Lihat Detail</a>
                                    <a class="btn c-login-btn c-edit" href="" role="button">Proses</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
    </div>

<?php
include "layout/Footer.php";
?>