<?php if (isset($_SESSION['validation']) && $_SESSION['validation'] != ""): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['validation']; ?>
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
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] != ""): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['berhasil']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<section class="gallery-block cards-gallery">
    <div class="container">
        <div class="heading">
            <h2>Gambar Item</h2>
        </div>
        <div class="row">
            <?php if ($item_imgs != NULL): ?>
                <?php foreach ($item_imgs as $img): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 transform-on-hover">
                            <a class="lightbox" href="<?= base_url('upload/' . $img->ii_nama); ?>">
                                <img src="<?= base_url('upload/' . $img->ii_nama); ?>" alt="Card Image"
                                     class="card-img-top">
                            </a>
                            <div class="card-body">
                                <p class="text-muted card-text">
                                    <a class="text-gray"
                                       href="<?= site_url('item_img/set_default/' . $img->i_kode . '/' . $img->ii_kode); ?>"
                                       onclick="utama($(this))" data-id="<?= $img->ii_kode; ?>">Set Default</a>
                                    <br>
                                    <a class="text-danger" href="<?= site_url('item_img/hapus/' . $img->ii_kode); ?>"
                                       data-id="<?= $img->ii_kode; ?>">Hapus</a>
                                </p>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<hr>
<button class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
<script>
    // ------------------------------------------------------ //
    // Modal CRUD
    // ------------------------------------------------------ //

    function tambah() {
        modal = $('#crud');
        bodymodal = modal.find('div.modal-body');

        bodymodal.load("<?= site_url('item/tambah'); ?>");
    }

    function edit(data) {
        d = data;
        id = d.attr('data-id');
        modal = $('#crud');
        bodymodal = modal.find('div.modal-body');

        bodymodal.load("<?= site_url('item/ubah/'); ?>" + id);
    }

    function tambah_qty(data) {
        d = data;
        id = d.attr('data-id');
        modal = $('#crud');
        bodymodal = modal.find('div.modal-body');

        bodymodal.load("<?= site_url('item/tambah_qty/'); ?>" + id);
    }

    function detil(data) {
        d = data;
        id = d.attr('data-id');
        modal = $('#crud');
        bodymodal = modal.find('div.modal-body');

        bodymodal.load("<?= site_url('item/detil/'); ?>" + id);
    }

    function hapus(data) {
        d = data;
        id = d.attr('data-id');
        $('a#hapus').attr('href', "<?= site_url('item_img/hapus/'); ?>" + id);
    }

    $(document).ready(function () {
        $('[tooltip]').tooltip();
    });

    // ------------------------------------------------------ //
    // Remove after 5 second
    // ------------------------------------------------------ //

    $(document).ready(function () {
        setTimeout(function () {
            if ($('[role="alert"]').length > 0) {
                $('[role="alert"]').remove();
            }
        }, 5000);
    });
</script>
</body>
</html>