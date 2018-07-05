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
            <?php if ($logo != NULL): ?>
                <img src="<?= base_url('upload/' . $logo); ?>" width="150" height="80"
                     class="img-fluid mx-auto d-block"
                     alt="">
            <?php else: ?>
                <img class="img-fluid mx-auto d-block" width="150" height="80"
                     src="https://upload.wikimedia.org/wikipedia/commons/archive/a/ac/20121003093557%21No_image_available.svg"
                     alt="No Image">
            <?php endif; ?>
            <p class="c-nomer-footer"><b>Instagram :</b> <?= $instagram; ?></p>
            <p class="c-email-footer"><b>Email :</b> <?= $email; ?></p>
        </div>
        <div class="col-lg col-md-6 col-sm-6">
            <h5 class="c-judul-footer">Category</h5>
            <ul class="c-ul-footer">
                <?php foreach ($menu_kategori as $menukat): ?>
                    <li><a href="<?= site_url('kategori/' . $menukat->k_url); ?>"><?= $menukat->k_nama; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-lg col-md-6 col-sm-6">
            <h5 class="c-judul-footer">Blog</h5>
            <ul class="c-ul-footer">
                <?php if ($blogs != ''): ?>
                    <?php foreach ($blogs as $blog): ?>
                        <li><a href="<?= site_url('blog/' . $blog->artikel_url); ?>"><?= $blog->artikel_judul; ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="col-lg col-md-6 col-sm-6">
            <h5 class="c-judul-footer">Information</h5>
            <ul class="c-ul-footer">
                <li><a href="<?= site_url('resi'); ?>">Laporan Resi</a></li>
                <li><a href="<?= site_url('pending'); ?>">Status Order</a></li>
                <li><a href="<?= site_url('riwayat'); ?>">Riwayat Pesanan</a></li>
            </ul>
        </div>
        <div class="col-lg col-md-6 col-sm-6">
            <p class="c-text-payment">We are support gateway</p>
            <img src="assets/img/payment.png" alt="">
            <p class="c-text-secure">Secure Payment</p>
            <i class="fa fa-lock c-lala-land fa-3x"></i>
            <i class="fa fa-shield fa-3x"></i>
            <i class="fa fa-check fa-3x"></i>
        </div>
    </div>
</div>


<!-- ======= Copyright by EazyDev Team ======= -->
<div class="container-fluid c-padding-header text-center c-padding-footer">
    <h6 class="f-footer-bot">TRUSTED AND SECURE PAYMENT WITH UPS</h6>
    <p class="c-footer-copy">Copyright  © All right reserved  EazyDev.</p>
    <a href="mailto:<?= $email; ?>"><i class="fab fa-line fa-2x f-sosmed mr-2"></i></a>
    <a href="https://www.instagram.com/<?= $instagram; ?>"><i class="fa fa-instagram fa-2x"></i></a>
    <a href="https://wa.me/62<?= $whatsapp; ?>"><i class="fa fa-whatsapp fa-2x"></i></a>
</div>

<script>
    $('#myDropdown').on('show.bs.dropdown', function () {
        $('.dropdown-toggle').dropdown()
    })

</script>
<script>
    // ------------------------------------------------------ //
    // Format Rupiah
    // ------------------------------------------------------ //
    var moneyFormat = wNumb({
        mark: ',',
        decimals: 0,
        thousand: '.',
        prefix: 'Rp. ',
        suffix: ''
    });

    $('[id="rupiah"]').each(function (index) {
        var value = parseInt($(this).html()),
            hasil = moneyFormat.to(value);

        $(this).html(hasil);
    });
</script>
<script>
    $('[id="title"]').ellipsis();
</script>
<script>
    $('[tooltip]').tooltip();
</script>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover({
            container: 'body',
            trigger: 'focus',
            content: $('#pop_cart').html(),
            html: true
        })
    })
</script>
<script>
    $('#table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian.json"
        }
    });
</script>
<?php if (isset($_SESSION['modal'])): ?>
    <script>
        $('#cart').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        $('#cart > div > div > div.modal-body').load('<?= site_url('cart/modal_cart'); ?>');
    </script>
<?php endif; ?>
<script>
    $('div.image.mx-auto.d-block').click(function () {
        var url = $(this).attr('data-url');
        window.location.href = url;
    })
</script>
</body>
</html>