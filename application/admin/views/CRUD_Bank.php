<?php
$url = site_url('bank/simpan');
if ($submit == 'Ubah') {
    $id = $bank->b_kode;
    $penerbit = $bank->b_penerbit;
    $nama = $bank->b_nama;
    $rekening = $bank->b_rek;
    $isaktif = $bank->b_isaktif;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $penerbit = '';
    $nama = '';
    $rekening = '';
    $isaktif = 0;
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="token_fg" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="form-group">
        <label for="penerbit">Bank</label>
        <input type="text" class="form-control" name="penerbit" id="penerbit" value="<?= $penerbit; ?>"
               placeholder="Input Bank (BCA, BNI, BRI)">
    </div>
    <div class="form-group">
        <label for="nama">Nama Pemilik Rek</label>
        <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama; ?>"
               placeholder="Input Nama Pemilik Rekening">
    </div>
    <div class="form-group">
        <label for="rekening">Nomor Rekening</label>
        <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $rekening; ?>"
               placeholder="Input Nomor Rekening">
    </div>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="aktif" value="1"
                   id="aktif" <?= $isaktif == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label" for="aktif">
                Aktif
            </label>
        </div>
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
