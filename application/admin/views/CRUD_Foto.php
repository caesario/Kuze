<form action="<?= site_url('upload/do_upload'); ?>" enctype="multipart/form-data" method="post">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="image" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="i_kode" value="<?= $i_kode ?>">
    <div class="form-group">
        <div class="input-group">
            <div class="custom-file">
                <input type="file" name="images[]" class="custom-file-input" accept="image/jpeg,image/png" multiple
                       required>
                <label class="custom-file-label">Pilih gambar</label>
            </div>
        </div>
    </div>


    <div class="form-group">
        <button type="submit" class="btn btn-primary">Upload</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
    </div>
</form>
