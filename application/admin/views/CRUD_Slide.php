<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="upload_image">File</label>
            <input class="form-control-file" type="file" name="upload_image" id="upload_image">
            <div id="viewimage" style="display: none"></div>
            <button class="btn btn-sm btn-danger" id="cancel" style="display: none;">Batal</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="caption">Tulisan Promo</label>
            <textarea class="form-control" name="caption" id="caption"></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="aktif" value="1"
                       id="aktif">
                <label class="form-check-label" for="aktif">
                    Tampilkan
                </label>
            </div>
        </div>
    </div>
</div>
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
        var inimage = $('#upload_image'),
            viewimage = $('#viewimage'),
            cancel = $('#cancel');

        var croppie_img = viewimage.croppie({
            enableExif: true,
            viewport: {
                width: 750,
                height: 750,
                type: 'square' //circle
            },
            boundary: {
                width: 750,
                height: 750
            }
        });

        cancel.click(function () {
            inimage.show().val('');
            viewimage.hide();
            cancel.hide();
        });

        inimage.on('change', function () {
            var reader = new FileReader();
            reader.onload = function (event) {
                croppie_img.croppie('bind', {
                    url: event.target.result
                }).then(function () {
                    console.log('jQuery bind complete');
                });
            };
            reader.readAsDataURL(this.files[0]);
            viewimage.show();
            inimage.hide();
            cancel.show();
        });

        $('#doupload').click(function (event) {
            croppie_img.croppie('result', {
                type: 'blob',
                size: 'original'
            }).then(function (response) {
                var aktif = $('#aktif'),
                    caption = $('#caption'),
                    foto = response;
                var fd = new FormData();
                fd.append('ecommerce_eazy', '<?= $this->security->get_csrf_hash(); ?>');
                fd.append('foto', foto);
                fd.append('caption', caption);
                fd.append('aktif', aktif);

                $.ajax({
                    url: "<?= site_url('slide/simpan'); ?>",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        window.location.reload();
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            })
        });

    });
</script>