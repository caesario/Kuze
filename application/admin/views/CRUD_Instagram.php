<?php
$url = site_url('instagram/simpan');
if ($submit == 'Ubah') {
    $id = $slide_insta->slide_insta_kode;
    $img = $slide_insta->slide_insta_img;
    $caption = $slide_insta->slide_insta_caption;
    $isaktif = $slide_insta->slide_insta_isaktif;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $img = '';
    $caption = '';
    $isaktif = '';
}
?>

<form action="<?= $url; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" id="inputfilename" name="image" value="<?= $img; ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="form-group">
        <label for="file">Gambar</label>
        <img class="img-fluid mx-auto d-block mb-2" height="300" width="300" src="" id="filename"
             style="display: none;">
        <div class="custom-file">
            <input class="custom-file-input " id="imageupload" type="file" name="image"
                   data-url="<?= site_url('upload/single_image'); ?>">
            <label class="custom-file-label" for="customFile">Pilih gambar</label>
        </div>
        <div class="progress" style="display: none;">
            <div class="progress-bar bg-success" id="progress" role="progressbar" style="width: 25%" aria-valuenow="25"
                 aria-valuemin="0" aria-valuemax="100">25%
            </div>
        </div>

        <div class="form-group">
            <label for="caption">Tulisan Promo</label>
            <textarea class="form-control" name="caption" id="caption"><?= $caption; ?></textarea>
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
    $(function () {
        $('#imageupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $('#filename').attr("src", "<?= base_url('upload/');?>" + data.result.file_name);
                $('#inputfilename').attr("value", data.result.file_name);
            },
            progressall: function (e, data) {
                var showimgsrc = $('#filename');
                var hideupload = $('#crud > div > div > div > form > div:nth-child(4) > div.custom-file');
                var showprogress = $('#crud > div > div > div > form > div:nth-child(4) > div.progress');

                hideupload.hide();
                showprogress.show();
                showimgsrc.show();

                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress').css(
                    'width',
                    progress + '%'
                ).text(progress + '%');
            }
        });
    });
</script>
