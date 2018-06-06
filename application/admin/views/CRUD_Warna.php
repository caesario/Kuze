<?php
$url = site_url('warna/simpan');
if ($submit == 'Ubah') {
    $id = $warnas->w_kode;
    $nama = $warnas->w_nama;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $nama = '';
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="token_fg" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="form-group">
        <label for="nama">Warna</label>
        <input type="text" class="form-control" name="nama" placeholder="Input Warna" value="<?= $nama; ?>" required>
        <p>
            <?= form_error('nama'); ?>
        </p>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block"><?= $submit; ?></button>
        <button type="button" onclick="window.location.reload()" class="btn btn-danger btn-block">Tutup</button>
    </div>
    <?php if (isset($berhasil)): ?>
        <p class="text-success"><?= $berhasil; ?></p>
    <?php endif; ?>
    <?php if (isset($gagal)): ?>
        <p class="text-danger"><?= $gagal; ?></p>
    <?php endif; ?>
</form>
