<?php
include "layout/Header.php";
?>

    <!-- Register -->
    <div class="container-fluid c-padding-header">
        <div class="c-login">
            <form class="form-signin">
                <h4 class="h4 mb-3 font-weight-normal text-center">Kuze Registration</h4>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control mb-2" placeholder="Email address" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control mb-2" placeholder="Password" required>
                <label for="inputPassword2" class="sr-only">Password</label>
                <input type="password" id="inputPassword2" class="form-control mb-2" placeholder="Confirm Password" required>
                <div class="checkbox">
                    <label class="">
                        <input type="checkbox" value="remember-me"> Required Check
                    </label>
                </div>
                <button class="btn btn-lg btn-block c-login-btn" type="submit">Create Account</button>
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