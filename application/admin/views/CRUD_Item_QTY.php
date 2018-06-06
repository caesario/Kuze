<?php
$url = site_url('item/tambah_qty/' . $kode);
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="token_fg" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $kode; ?>">
    <div class="form-group">
        <label for="qty">QTY</label>
        <input type="number" class="form-control" name="qty" placeholder="Input Jmlh QTY" required>
        <p>
            <?= form_error('qty'); ?>
        </p>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><?= $submit; ?></button>
        <button type="button" onclick="window.location.reload()" class="btn btn-danger">Tutup</button>
    </div>
    <?php if (isset($berhasil)): ?>
        <p class="text-success"><?= $berhasil; ?></p>
    <?php endif; ?>
    <?php if (isset($gagal)): ?>
        <p class="text-danger"><?= $gagal; ?></p>
    <?php endif; ?>
</form>
