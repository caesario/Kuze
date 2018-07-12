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
                        <a href="<?= site_url('profil'); ?>" class="list-group-item list-group-item-action ">Profil</a>
                        <a href="<?= site_url('alamat_profil'); ?>" class="list-group-item list-group-item-action ">Alamat</a>
                        <a href="<?= site_url('order_status'); ?>" class="list-group-item list-group-item-action ">Transaksi
                            Tertunda</a>
                        <a href="<?= site_url('order_history'); ?>" class="list-group-item list-group-item-action">Riwayat
                            Transaksi</a>
                        <a href="<?= site_url('resi'); ?>"
                           class="list-group-item list-group-item-action c-profil-active">Laporan Resi</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 c-color-profil">
            <h5>Laporan Resi</h5>
            <div class="table-responsive mt-2">
                <table class="table table-sm table-borderless" id="table">
                    <thead>
                    <tr>
                        <th scope="col">Laporan</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                            <?php if ($resis != NULL): ?>
                                <?php $counter = 0; ?>
                                <?php foreach ($resis as $resi): ?>
                            <tr>
                                <td>
                                    <?= $resi->artikel_judul; ?>
                                </td>
                                <td>
                                    <?= $resi->created_at; ?>
                                </td>
                                <td>
                                    <a class="btn c-login-btn c-edit"
                                       href="<?= site_url('resi/' . $resi->artikel_url . '/detil'); ?>">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
<?php
include "layout/Footer.php";
?>