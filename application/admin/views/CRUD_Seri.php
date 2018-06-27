<?php
$url = site_url('seri/simpan');
if ($submit == 'Ubah') {
    $id = $seris->s_kode;
    $nama = $seris->s_nama;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $nama = '';
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="form-group">
        <label for="nama">Nomor Seri</label>
        <input type="text" class="form-control" name="nama" placeholder="Input Nomor Seri" value="<?= $nama; ?>"
               required>
        <p>
            <?= form_error('nama'); ?>
        </p>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary"><?= $submit; ?></button>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
    </div>
    <?php if (isset($berhasil)): ?>
        <p class="text-success"><?= $berhasil; ?></p>
    <?php endif; ?>
    <?php if (isset($gagal)): ?>
        <p class="text-danger"><?= $gagal; ?></p>
    <?php endif; ?>
</form>
