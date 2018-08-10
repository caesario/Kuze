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
                               class="list-group-item list-group-item-action c-profil-active ">
                                Change Password
                            </a>
                            <a href="<?= site_url('alamat_profil'); ?>"
                               class="list-group-item list-group-item-action ">Address</a>
                            <a href="<?= site_url('order_status'); ?>" class="list-group-item list-group-item-action">Pending Orders</a>
                            <a href="<?= site_url('order_history'); ?>" class="list-group-item list-group-item-action">Order History</a>
                            <a href="<?= site_url('resi'); ?>" class="list-group-item list-group-item-action">Airwaybill Report</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 c-color-profil">
                <h5 class="card-title mb-1">Change Password</h5>


                <div class="container">
                    <div class="card-body">
                        <div class="row r-layout-konten-profile">
                            <?php if (isset($validation_error)): ?>
                                <div class="col-12 col-sm-12 col-md-8">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= $validation_error; ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] != ""): ?>
                                <div class="col-12 col-sm-12 col-md-8">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo $_SESSION['berhasil']; ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal'] != ""): ?>
                                <div class="col-12 col-sm-12 col-md-8">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo $_SESSION['gagal']; ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="col-12 col-sm-12 col-md-6">
                                <form action="profil_password/simpan" method="post">
                                    <input type="hidden" name="ecommerce_eazy"
                                           value="<?= $this->security->get_csrf_hash(); ?>">
                                    <input type="hidden" name="id" value="<?= $_SESSION['id']; ?>">
                                    <div class="form-group">
                                        <label class="r-font-konten-profile">New Password : </label>
                                        <input type="password" class="form-control" name="sandi"
                                               placeholder="New Password">
                                    </div>

                                    <div class="form-group">
                                        <label class="r-font-konten-profile">New Password Confirmation : </label>
                                        <input type="password" class="form-control" name="sandi_konfirm"
                                               placeholder="New Password Confirmation">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn c-login-btn c-edit">Save
                                        </button>
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