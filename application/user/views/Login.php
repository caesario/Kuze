<?php
include "layout/Header.php";
?>

    <div class="-fluid c-head-login">
        <a href="<?= site_url('/') ?>" class="c-kembali ml-2"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
<?php if (isset($log) && $log != ""): ?>
    <p class="text-danger text-center"><?= $log; ?></p>
<?php endif; ?>



    <!-- Login -->
    <div class="container-fluid c-padding-header">
        <div class="c-login">
            <form method="post" action="<?= site_url('login'); ?>" class="form-signin">
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
<!--                <h4 class="h4 mb-3 font-weight-normal text-center">--><?//= $brandname; ?><!--</h4>-->
                <h4 class="h4 mb-3 font-weight-normal text-center">Kuze Login</h4>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" name="email" class="form-control mb-2" placeholder="Email address" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" name="password" class="form-control mb-2" placeholder="Password" required>
                <div class="checkbox">
                    <label class="">
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-block c-login-btn" type="submit">Sign in</button>
                <p class="text-center"><a class="c-link-color" href="">Forgot your password?</a></p>
                <hr>
                <p class="text-center">Don't have an account? <a class="c-link-color" href="<?= site_url('register'); ?>">Sign Up</a></p>
            </form>
        </div>
    </div>

    <!-- End Login -->
<div class="container-fluid c-padding-header text-center c-padding-footer c-footer">
    <h6 class="f-footer-bot">TRUSTED AND SECURE PAYMENT WITH UPS</h6>
    <p class="c-footer-copy">Copyright  © All right reserved  EazyDev.</p>
    <a href="mailto:<?= $email; ?>"><i class="fab fa-line fa-2x f-sosmed mr-2"></i></a>
    <a href="https://www.instagram.com/<?= $instagram; ?>"><i class="fa fa-instagram fa-2x"></i></a>
    <a href="https://wa.me/62<?= $whatsapp; ?>"><i class="fa fa-whatsapp fa-2x"></i></a>
</div>
</body>
</html>