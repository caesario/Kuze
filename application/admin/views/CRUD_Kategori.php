<?php
$url = site_url('kategori/simpan');
if ($submit == 'Ubah') {
    $id = $kategori->k_kode;
    $nama = $kategori->k_nama;
    $parent = $kategori->k_parent_kode;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $nama = '';
    $parent = 0;
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="token_fg" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="form-group">
        <label for="parent">Parent Kategori</label>
        <select name="parent" id="parent" class="form-control">
            <option value="0">Root</option>
            <?php foreach ($kategoris as $kategori): ?>
                <option value="<?= $kategori->k_kode; ?>"><?= $kategori->k_nama; ?></option>
            <?php endforeach; ?>
        </select>
        <p>
            <?= form_error('parent'); ?>
        </p>
    </div>
    <div class="form-group">
        <label for="nama">Nama Kategori</label>
        <input type="text" class="form-control" name="nama" placeholder="Input Nama Kategori" value="<?= $nama; ?>"
               required>
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
