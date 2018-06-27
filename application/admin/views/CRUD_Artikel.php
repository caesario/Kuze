<?php
$url = site_url('artikel/simpan');
if ($submit == 'Ubah') {
    $id = $artikel->artikel_kode;
    $judul = $artikel->artikel_judul;
    $content = $artikel->artikel_content;
    $ispromo = $artikel->artikel_ispromo;
    $isblog = $artikel->artikel_isblog;
    $isresi = $artikel->artikel_isresi;
    $isnotifikasi = $artikel->artikel_isnotifikasi;
    $isaktif = $artikel->artikel_isaktif;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $judul = '';
    $content = '';
    $ispromo = 0;
    $isblog = 0;
    $isresi = 0;
    $isnotifikasi = 0;
    $isaktif = 0;
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" class="form-control" name="judul" value="<?= $judul; ?>" placeholder="Input Judul Artikel">
    </div>
    <div class="form-group">
        <label>Kategori</label>
        <div class="row">
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="promo" value="1"
                           id="promo" <?= $ispromo == 1 ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="promo">
                        Promo
                    </label>
                </div>
            </div>
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="blog" value="1"
                           id="blog" <?= $isblog == 1 ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="blog">
                        Blog
                    </label>
                </div>
            </div>
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="notikasi" value="1"
                           id="notikasi" <?= $isnotifikasi == 1 ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="notikasi">
                        Notifikasi
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="content">Konten</label>
        <textarea class="form-control" name="content" id="content" cols="30" rows="10"><?= $content; ?></textarea>
    </div>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="aktif" value="1"
                   id="aktif" <?= $isaktif == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label" for="aktif">
                Tampilkan
            </label>
        </div>
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
    $(document).ready(function () {
        tinymce.remove();
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
    })

</script>