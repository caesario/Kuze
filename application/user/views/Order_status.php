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
                            <a href="<?= site_url('profil'); ?>"
                               class="list-group-item list-group-item-action ">My Profile</a>
                            <a href="<?= site_url('profil_password'); ?>"
                               class="list-group-item list-group-item-action ">
                                Change Password
                            </a>
                            <a href="<?= site_url('alamat_profil'); ?>"
                               class="list-group-item list-group-item-action ">Address</a>
                            <a href="<?= site_url('order_status'); ?>"
                               class="list-group-item list-group-item-action c-profil-active">Pending Orders</a>
                            <a href="<?= site_url('order_history'); ?>" class="list-group-item list-group-item-action">Order
                                History</a>
                            <a href="<?= site_url('resi'); ?>" class="list-group-item list-group-item-action">Airwaybill
                                Report</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 c-color-profil">
                <h5>Pending Orders</h5>
                <div class="table-responsive mt-3">
                    <table id="table" class="table">
                        <thead>
                        <tr>
                            <th scope="col">Order Detail</th>
                            <th scope="col">Shipping Detail</th>
                            <th scope="col">Price Detail</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($orders != NULL): ?>
                            <?php foreach ($orders as $order): ?>
                                <?php if ($order->orders_status < 6) : ?>
                                    <tr>
                                        <td>
                                            <div class="mb-2">
                                                <b class="c-order-info">Order ID :</b><br>
                                                <?= $order->orders_noid; ?>
                                            </div>

                                            <div class="mb-2">
                                                <b class="c-order-info">Order Dates :</b><br>
                                                <?= $order->created_at; ?>
                                            </div>


                                            <div class="mb-2">
                                                <b class="c-order-info">Status :</b><br>
                                                <?php if ($order->orders_status == 0): ?>
                                                    <div class="text-warning">YOU NEED TO FILL THE ADDRESS</div>
                                                <?php elseif ($order->orders_status == 1): ?>
                                                    <div class="text-warning">YOU NEED TO FILL SHIPPING & PAYMENT
                                                        METHOD
                                                    </div>
                                                <?php elseif ($order->orders_status == 2): ?>
                                                    <div class="text-success">YOU NEED TO CONFIRM YOUR PAYMENT</div>
                                                <?php elseif ($order->orders_status == 3): ?>
                                                    <div class="text-success">ON PROCESS</div>
                                                <?php elseif ($order->orders_status == 4): ?>
                                                    <div class="text-success">ON PROCESS</div>
                                                <?php elseif ($order->orders_status == 5): ?>
                                                    <div class="text-success">ON PROCESS</div>
                                                <?php elseif ($order->orders_status == 6): ?>
                                                    <div class="text-success">On Shipping</div>
                                                <?php elseif ($order->orders_status == 7): ?>
                                                    <div class="text-danger">CANCEL</div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-2">
                                                <b class="c-order-info">Description :</b><br>
                                                <div class="text-danger">
                                                    <?= $order->orders_deskripsi == NULL ? 'No Description' : $order->orders_deskripsi; ?>
                                                </div>
                                            </div>

                                        </td>

                                        <td>
                                            <div class="mb-2">
                                                <b class="c-order-info">Shipper :</b><br>
                                                <?php if ($order->orders_pengiriman_s_nama != NULL): ?>
                                                    <?= $order->orders_pengiriman_s_nama; ?><br>
                                                    <?= $order->orders_pengiriman_s_kontak; ?>
                                                <?php elseif ($order->orders_pengiriman_r_nama != NULL): ?>
                                                    <?= $order->orders_pengiriman_r_nama; ?><br>
                                                    <?= $order->orders_pengiriman_r_kontak; ?>
                                                <?php else: ?>
                                                    No shipper
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-2">
                                                <b class="c-order-info">Recipient :</b><br>
                                                <?php if ($order->orders_pengiriman_r_nama != NULL): ?>
                                                    <?= $order->orders_pengiriman_r_nama; ?><br>
                                                    <?= $order->orders_pengiriman_r_kontak; ?>
                                                <?php else: ?>
                                                    'No recipient'
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-2">
                                                <b class="c-order-info">Unique Code :</b><br>
                                                <div id="rupiah"><?= $order->orders_uniq; ?></div>
                                            </div>

                                            <div class="mb-2">
                                                <b class="c-order-info">Shipping Price :</b><br>
                                                <div id="rupiah"><?= $order->orders_ongkir_biaya; ?></div>
                                            </div>

                                            <div class="mb-2">
                                                <b class="c-order-info">Order Price :</b><br>
                                                <div id="rupiah"><?= $order->total; ?></div>
                                            </div>

                                            <div class="mb-2">
                                                <b class="c-order-info">Price Total :</b><br>
                                                <div class="text-success"
                                                     id="rupiah"><?= $order->total + $order->orders_ongkir_biaya + $order->orders_uniq; ?></div>
                                            </div>

                                        </td>
                                        <td class="align-middle">

                                            <a class="btn c-login-btn c-edit"
                                               href="<?= site_url('order_status/' . $order->orders_noid . '/detil'); ?>"
                                               role="button">
                                                Detail
                                            </a>
                                            <?php if ($order->orders_status == 0): ?>
                                                <a class="btn c-login-btn c-edit"
                                                   href="<?= site_url('checkout/' . $order->orders_noid . '/alamat_pengiriman'); ?>">
                                                    <i class="fas fa-sync mr-2"></i>Process
                                                </a>
                                            <?php elseif ($order->orders_status == 1): ?>
                                                <a class="btn c-login-btn c-edit"
                                                   href="<?= site_url('checkout/' . $order->orders_noid . '/ongkir_transfer'); ?>">
                                                    <i class="fas fa-sync mr-2"></i>Process
                                                </a>
                                            <?php elseif ($order->orders_status == 2): ?>
                                                <a class="btn c-login-btn c-edit"
                                                   href="<?= site_url('checkout/' . $order->orders_noid . '/konfirmasi_pembayaran'); ?>">
                                                    <i class="fas fa-sync mr-2"></i>Process
                                                </a>
                                            <?php else: ?>
                                                <i></i>
                                            <?php endif; ?>
                                            <a class="btn c-login-btn c-edit"
                                               href="">
                                                Invoice
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>

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