<?php
include "layout/Header.php";
?>

    <?php if (isset($log) && $log != ""): ?>
        <p class="text-danger text-center"><?= $log; ?></p>
    <?php endif; ?>

    <div class="-fluid c-head-login">
        <a href="<?= site_url('/') ?>" class="c-kembali ml-2"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>

    <!-- Register -->
    <div class="container-fluid c-padding-header">
        <div class="c-login">
            <form class="form-signin">
                <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
                <?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] != ""): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['berhasil']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal'] != ""): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['gagal']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo validation_errors(); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
<!--                <h4 class="h4 mb-3 font-weight-normal text-center">--><?//= $brandname; ?><!--</h4>-->
                <h4 class="h4 mb-3 font-weight-normal text-center">Kuze Registration</h4>

                <div class="form-group">
                    <label for="nama" class="sr-only">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Lengkap"
                           value="<?= set_value('nama'); ?>" required>
                    <p><?= form_error('nama'); ?></p>
                </div>

                <div class="form-group">
                    <label for="email" class="sr-only">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email Address"
                           value="<?= set_value('email'); ?>" required>
                    <p><?= form_error('nama'); ?></p>
                </div>

                <div class="form-group">
                    <label for="notelp" class="sr-only">Nomor Telp</label>
                    <input type="text" id="notelp" name="notelp" class="form-control" placeholder="Nomor Telepon"
                           value="<?= set_value('notelp'); ?>" required>
                    <p><?= form_error('nama'); ?></p>
                </div>

                <div class="form-group">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" name="password" class="form-control" minlength="8" maxlength="15"
                           placeholder="Password" value="<?= set_value('password'); ?>" required>
                    <p><?= form_error('nama'); ?></p>
                </div>

                <div class="checkbox">
                    <label class="">
                        <input type="checkbox" value="remember-me"> Required Check
                    </label>
                </div>
                <button class="btn btn-lg btn-block c-login-btn" type="submit">Buat Akun</button>
                <!--<p class="text-center"><a class="c-link-color" href="">Forgot your password?</a></p>-->
                <hr>
                <p class="text-center">Alredy have an account? <a class="c-link-color" href="<?= base_url ('login'); ?>">Sign In</a></p>
            </form>
        </div>
    </div>
    <!-- End Register -->

<?php
include "layout/Footer.php";
?>