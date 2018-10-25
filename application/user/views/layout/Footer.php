<!-- Modal -->
<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="cart"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<!-- ======= Footer ======= -->
<div class="container-fluid c-padding-header c-footer c-both">
    <div class="row">
        <div class="col-lg col-md-6 col-sm-12 c-margin-bot">
            <h5 class="c-judul-footer">Kuze Original</h5>
                <ul class="c-ul-footer">
                    <li><a href="<?= site_url('Aboutus'); ?>">About Us</a></li>
                    <li><a href="<?= site_url('Contact'); ?>">Contact </a></li>
                </ul>
<!--            --><?php //if ($logo != NULL): ?>
<!--                <img src="--><?//= base_url('upload/' . $logo); ?><!--" width="150" height="80"-->
<!--                     class="img-fluid mx-auto d-block"-->
<!--                     alt="">-->
<!--            --><?php //else: ?>
<!--                <img class="img-fluid mx-auto d-block" width="150" height="80"-->
            <!--                     src="<?= base_url('assets/img/noimage.jpg'); ?>"-->
<!--                     alt="No Image">-->
<!--            --><?php //endif; ?>
<!--            <p class="c-nomer-footer"><b>Instagram :</b> --><?//= $instagram; ?><!--</p>-->
<!--            <p class="c-email-footer"><b>Email :</b> --><?//= $email; ?><!--</p>-->
        </div>


        <div class="col-lg col-md-6 col-sm-6">
            <h5 class="c-judul-footer">Information</h5>
            <ul class="c-ul-footer">
                <li><a href="<?= site_url('resi'); ?>">Airway Bill Report</a></li>
                <li><a href="<?= site_url('Order_status'); ?>">Order Status</a></li>
                <li><a href="<?= site_url('Order_history'); ?>">Order History</a></li>
            </ul>
        </div>
        <div class="col-lg col-md-6 col-sm-6">
            <h5 class="c-judul-footer">Help</h5>
            <ul class="c-ul-footer">

                <li><a href="<?= site_url('Howtoorder'); ?>">How to Order</a></li>
                
                <li><a href="<?= site_url('Faq'); ?>">FAQ</a></li>
            </ul>
        </div>
        <div class="col-lg col-md-6 col-sm-6">
            <p class="c-text-payment">We are support payment</p>
            <img style="width:120px;" src="<?= base_url('assets/img/BCA-Kuze.png'); ?>" alt="">
<!--            <p class="c-text-secure">Secure Payment</p>-->
<!--            <i class="fa fa-lock c-lala-land fa-3x"></i>-->
<!--            <i class="fas fa-shield-alt fa-3x c-lala-land"></i>-->
<!--            <i class="fa fa-check fa-3x c-lala-land"></i>-->
        </div>
    </div>
</div>


<!-- ======= Copyright by EazyDev Team ======= -->
<div class="container-fluid c-padding-header text-center c-padding-footer">
    <h6 class="f-footer-bot">TRUSTED AND SECURE PAYMENT</h6>
    <p class="c-footer-copy">Copyright © 2018 KuzeOriginal | Dev by EazyDev.</p>
    <a href="mailto:<?= $email; ?>" target="_blank"><i class="fab fa-line fa-2x f-sosmed mr-2"></i></a>
    <a href="https://www.instagram.com/<?= $instagram; ?>" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
    <a href="https://wa.me/62<?= $whatsapp; ?>" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>
</div>
<script>
    $(function () {
        $('#myDropdown').on('show.bs.dropdown', function () {
            $('.dropdown-toggle').dropdown()
        })
    });

    $(function () {
        // ------------------------------------------------------ //
        // Format Rupiah
        // ------------------------------------------------------ //


        var moneyFormat = wNumb({
            mark: ',',
            decimals: 0,
            thousand: '.',
            prefix: 'IDR ',
            suffix: ''
        });
        $('[id="rupiah"]').each(function (index) {
            var value = parseInt($(this).html()),
                hasil = moneyFormat.to(value);

            if ($(this).html() === '-') {
            } else {
                $(this).html(hasil);
            }
        });
    });

    $(function () {
        $('[id="title"]').ellipsis();
    });

    $(function () {
        // ------------------------------------------------------ //
        // Data table users
        // ------------------------------------------------------ //
        $('#table').DataTable({
            "fnDrawCallback": function (oSettings) {
                $(oSettings.nTHead).hide();
            }
        });
    });

    $(function () {
        $('div.image.mx-auto.d-block').click(function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        })
    });


</script>
<?php if (isset($_SESSION['modal'])): ?>
    <script>
        $('#cart').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        $('#cart > div > div > div.modal-body').load('<?= site_url('bag/modal_bag'); ?>');
    </script>
<?php endif; ?>
</body>
</html>