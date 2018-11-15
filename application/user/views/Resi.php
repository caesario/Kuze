<?php
include "layout/Header.php";
include "layout/Menu.php";
?>
    <style>
        * {
            border-radius: 0 !important;
        }

        .big {
            font-size: 20px !important;
            margin-bottom: 10px;
            font-weight: 300;
        }

        .process-meta {
            display: block;
            margin-bottom: 5px;
            padding: 5px 10px;
            color: #fff;
            margin-top: 15px;
        }

        .b-green {
            background: #41bb19;
            color: #fff;
            margin: 3px 0;
            display: inline-block;
            -webkit-transition: background 1s ease;
            -moz-transition: background 1s ease;
            -o-transition: background 1s ease;
            transition: background 1s ease;
            cursor: default;
        }

        .center {
            text-align: center;
        }
    </style>
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
                            <a href="<?= site_url('order_status'); ?>" class="list-group-item list-group-item-action">Pending
                                Orders</a>
                            <a href="<?= site_url('order_history'); ?>"
                               class="list-group-item list-group-item-action  ">Order History</a>
                            <a href="<?= site_url('resi'); ?>"
                               class="list-group-item list-group-item-action c-profil-active">Airwaybill Report</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 c-color-profil">
                <h5>Airwaybill Report</h5>
                <div class="table-responsive mt-2">
                    <table class="table table-sm table-borderless" id="table">
                        <thead>
                        <tr>
                            <th scope="col">Orders</th>
                            <th scope="col">Airwaybill</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($resis != NULL): ?>
                            <?php $counter = 0; ?>
                            <?php foreach ($resis as $resi): ?>
                                <tr>
                                    <td>
                                        <div class="mb-2">
                                            <b>Order ID</b><br>
                                            <?= $resi->orders_noid; ?>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="mb-2">
                                            <b>Airwaybill</b><br>
                                            <?= $resi->order_resi; ?>
                                        </div>

                                        <div class="mb-2">
                                            <b>Destination</b><br>
                                            <?= $resi->order_pengiriman; ?>
                                        </div>

                                    </td>
                                    <td>
                                        <?php if ($resi->order_resi == 'NULL'): ?>
                                            <button type="button" class="btn c-login-btn c-edit" disabled>
                                                Track
                                            </button>

                                        <?php else: ?>
                                            <a class="btn c-login-btn c-edit" data-toggle="modal"
                                               onclick="show($(this))" data-target="#modaltracking"
                                               data-href="<?= site_url('resi/tracking/' . $resi->orders_noid); ?>">
                                                Track
                                            </a>
                                        <?php endif; ?>
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
    <div class="modal fade" id="modaltracking" tabindex="-1" role="dialog" aria-labelledby="modaltracking"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn c-login-btn c-edit" id="btnprint">Print</button>
                    <button type="button" class="btn c-login-btn c-edit" data-dismiss="modal">Tutup</button>

                </div>
            </div>
        </div>
    </div>
    <script>
        function show(data) {
            d = data;
            url = d.data('href');
            modal = $('#modaltracking');
            bodymodal = modal.find('div.modal-body');

            bodymodal.load(url);
        }
    </script>
<?php
include "layout/Footer.php";
?>