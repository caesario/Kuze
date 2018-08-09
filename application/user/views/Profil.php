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
                               class="list-group-item list-group-item-action c-profil-active">My Profil</a>
                            <a href="<?= site_url('profil_password'); ?>"
                               class="list-group-item list-group-item-action ">
                                Change Password
                            </a>
                            <a href="<?= site_url('alamat_profil'); ?>" class="list-group-item list-group-item-action">Address</a>
                            <a href="<?= site_url('order_status'); ?>" class="list-group-item list-group-item-action">Pending Orders</a>
                            <a href="<?= site_url('order_history'); ?>" class="list-group-item list-group-item-action">Order History</a>
                            <a href="<?= site_url('resi'); ?>" class="list-group-item list-group-item-action">Airwaybill Report</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 c-color-profil">
                <h5 class="card-title mb-1">My Profile</h5>
                <form action="profil/simpan" method="post" >
                    <input type="hidden" name="ecommerce_eazy"
                           value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="id" value="<?= $_SESSION['id']; ?>">


                    <div class="form-group col-md-6 mb-0">
                        <label class="col-form-label">User Type <span class="c-form-star">*</span></label>
                        <input type="text" class="form-control" value="<?= $profil->pengguna_tipe == 1 ? 'VIP' : 'Reseller'; ?>" placeholder="tipe" disabled>
                    </div>


                    <div class="form-group col-md-6 mb-0">
                        <label class="col-form-label">Full Name <span class="c-form-star">*</span></label>
                        <input type="text" class="form-control" id="inputEmail" value="<?= $profil->pengguna_nama; ?>" name="nama" autocomplete="off">
                    </div>


                    <div class="form-group col-md-6 mb-0">
                        <label class="col-form-label">Email <span class="c-form-star">*</span></label>
                        <input type="email" class="form-control" id="inputPhone" name="email"  value="<?= $profil->pengguna_email; ?>" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6 ">
                        <label for="inputAddress" class="col-form-label">Phone Number <span class="c-form-star">*</span></label>
                        <input type="text" class="form-control" id="inputNumber" value="<?= $profil->pengguna_telp; ?>" name="notelp" autocomplete="off">
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <button type="submit" class="btn float-left c-login-btn mb-5 ml-3 c-edit">Save
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

            </div>
        </div>
    </div>

<?php
include "layout/Footer.php";
?>