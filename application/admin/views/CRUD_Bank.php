<?php
$url = site_url('bank/simpan');
if ($submit == 'Ubah') {
    $id = $bank->bank_kode;
    $penerbit = $bank->bank_penerbit;
    $nama = $bank->bank_nama;
    $rekening = $bank->bank_rek;
    $isaktif = $bank->bank_isaktif;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $penerbit = '';
    $nama = '';
    $rekening = '';
    $isaktif = 0;
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="form-group">
        <label for="penerbit">Bank</label>
        <input type="text" class="form-control" name="penerbit" id="penerbit" value="<?= $penerbit; ?>" required
               placeholder="Input Bank (BCA, BNI, BRI)">
    </div>
    <div class="form-group">
        <label for="nama">Nama Pemilik Rek</label>
        <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama; ?>" required
               placeholder="Input Nama Pemilik Rekening">
    </div>
    <div class="form-group">
        <label for="rekening">Nomor Rekening</label>
        <input type="number" class="form-control" name="rekening" id="rekening" value="<?= $rekening; ?>" required
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
        <button type="submit" class="btn btn-sm btn-primary"><?= $submit; ?></button>
        <button type="button" onclick="window.location.reload()" class="btn btn-sm btn-danger">Tutup</button>
    </div>
    <?php if (isset($berhasil)): ?>
        <p class="text-success"><?= $berhasil; ?></p>
    <?php endif; ?>
    <?php if (isset($gagal)): ?>
        <p class="text-danger"><?= $gagal; ?></p>
    <?php endif; ?>
</form>
