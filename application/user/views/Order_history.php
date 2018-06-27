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
                            <a href="<?= site_url('Order_status'); ?>" class="list-group-item list-group-item-action ">Transaksi Tertunda</a>
                            <a href="<?= site_url('Order_history'); ?>" class="list-group-item list-group-item-action c-profil-active">Riwayat Transaksi</a>
                            <a href="<?= site_url('Resi'); ?>" class="list-group-item list-group-item-action">Laporan Resi</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <h5>Riwayat Pesanan</h5>
                <div class="table-responsive mt-2">
                    <table class="table table-sm table-borderless" id="table">
                        <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Detail Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="align-middle" style="width: 250px">
                                    LNTG001
                                </td>
                                <td class="align-middle" style="width: 450px;" >
                                    <b class="c-order-info">Tanggal Transaksi</b><br>
                                    23/01/2018<br>
                                    <b class="c-order-info">Nomer Resi</b><br>
                                    2389183928923849328 <br>
                                    <b class="c-order-info">Total Harga</b><br>
                                    10000<br>
                                    <b class="c-order-info">Status : </b><br>
                                    <span class="c-success">SUKSES (Telah dikirim)<span><br>
                                </td>

                                <td class="align-middle">
                                    <a class="btn c-login-btn c-edit"
                                       href="">
                                        Detail
                                    </a>
                                    <a class="btn c-login-btn c-edit"
                                       href="">
                                        Invoice
                                    </a>
                                </td>
                            </tr>



                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>