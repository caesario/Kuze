<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="upload_image" id="upload_image" class="custom-file-input" required>
                    <label class="custom-file-label">Pilih gambar</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="viewimage" style="display: none"></div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <button type="button" id="doupload" class="btn btn-primary">Upload</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

        $image_crop = $('#viewimage').croppie({
            enableExif: true,
            viewport: {
                width: 350,
                height: 350,
                type: 'square' //circle
            },
            boundary: {
                width: 350,
                height: 350
            }
        });

        $('#upload_image').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function () {
                    console.log('jQuery bind complete');
                });
            };
            reader.readAsDataURL(this.files[0]);
            $('#viewimage').show();
        });

        $('#doupload').click(function (event) {
            $image_crop.croppie('result', {
                type: 'blob',
                size: 'original'
            }).then(function (response) {
                console.log(response);
                var fd = new FormData();
                fd.append('ecommerce_eazy', '<?= $this->security->get_csrf_hash(); ?>');
                fd.append('image', response);
                fd.append('i_kode', '<?= $i_kode ?>');
                $.ajax({
                    url: "<?= site_url('upload/simpan_img'); ?>",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        window.location.reload();
                    }
                });
            })
        });

    });
</script>