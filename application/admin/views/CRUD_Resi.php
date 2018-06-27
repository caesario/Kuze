<?php
$url = site_url('resi/simpan');
if ($submit == 'Ubah') {
    $id = $artikel->artikel_kode;
    $judul = $artikel->artikel_judul;
    $content = $artikel->artikel_content;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $judul = 'Laporan Resi ' . date('d-m-Y');
    $content = '';
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <input type="hidden" name="judul" value="<?= $judul; ?>">
    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" class="form-control" value="<?= $judul; ?>" placeholder="Input Judul Artikel" disabled>
    </div>
    <div class="form-group">
        <label for="content">Konten</label>
        <textarea class="form-control" name="content" id="content" cols="30" rows="10"><?= $content; ?></textarea>
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
<script>
    tinymce.init({
        selector: 'textarea',
        height: 300,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code help wordcount'
        ],
        toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css']
    });
</script>
