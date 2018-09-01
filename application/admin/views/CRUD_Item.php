<?php

if ($submit == 'Ubah') {
    $url = site_url('item/simpan');
    $id = $items->i_kode;
    $nama = $items->i_nama;
    $hrg = $items->i_hrg;
    $deskripsi = $items->i_deskripsi;
    $berat = $items->i_berat;
    $i_hot = $items->i_hot;
    $i_new = $items->i_new;
    $i_best = $items->i_best;
} else if ($submit == 'Simpan') {
    $url = site_url('item/simpan');
    $id = $kode;
    $nama = '';
    $hrg = '';
    $deskripsi = '';
    $berat = '';
    $i_hot = '';
    $i_new = '';
    $i_best = '';

} else if ($submit == 'Tambah Detail') {
    $url = site_url('item/tambah_detil_simpan');
    $id = $items->i_kode;
}
?>
<?php if (!isset($warna_all) && $warna_all == NULL): ?>
    <div class="row">
        <div class="col">
            <p class="text-danger">Master Warna tidak ada.</p>
            <button class="btn btn-sm btn-danger" onclick="window.location.reload()">Tutup</button>
        </div>
    </div>
<?php elseif (!isset($kategori_all) && $kategori_all == NULL): ?>
    <div class="row">
        <div class="col">
            <p class="text-danger">Master Warna tidak ada.</p>
            <button class="btn btn-sm btn-danger" onclick="window.location.reload()">Tutup</button>
        </div>
    </div>
<?php else: ?>
    <form action="<?= $url; ?>" method="post">
        <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <?php if ($submit == 'Simpan' || $submit == 'Ubah'): ?>
            <div class="form-group">
                <label for="nama">Item</label>
                <input type="text" class="form-control" name="nama" placeholder="Input Kode Item" value="<?= $nama; ?>"
                       required>
            </div>
        <?php endif; ?>
        <div class="row">
            <?php if ($submit == 'Simpan'): ?>
                <div class="col-xs-12 col-md-12 col-lg-6">
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori[]" id="kategori" class="form-control" multiple required>
                            <?php foreach ($this->kategori->get_all() as $katitem): ?>
                                <option value="<?= $katitem->k_kode; ?>"><?= $katitem->k_nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            <?php elseif ($submit == 'Ubah'): ?>
                <div class="col-xs-12 col-md-12 col-lg-6">
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori[]" id="kategori" class="form-control" multiple>
                            <?php foreach ($this->kategori->get_all() as $katitem): ?>
                                <option value="<?= $katitem->k_kode; ?>" <?= $kategori_selected($katitem->k_kode, $id); ?>><?= $katitem->k_nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($submit == 'Simpan' || $submit == 'Ubah'): ?>
                <div class="col-xs-12 col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="hrg_reseller">Harga</label>
                                <input type="number" class="form-control" min="1000" name="hrg"
                                       placeholder="Input Hrg"
                                       value="<?= $hrg; ?>" required>
                            </div>
                        </div>

                        <!--                        <div class="col-12">-->
                        <!--                            <div class="form-group">-->
                        <!--                                <label for="hrg_vip">Harga VIP</label>-->
                        <!--                                <input type="number" class="form-control" min="1000" name="hrg_vip"-->
                        <!--                                       placeholder="Input Hrg VIP"-->
                        <!--                                       value="--><? //= $hrg_vip; ?><!--" required>-->
                        <!--                            </div>-->
                        <!--                        </div>-->

                        <div class="col-12">
                            <div class="form-group">
                                <label for="berat">Berat (Gram)</label>
                                <input type="number" class="form-control" min="1" max="1000" name="berat"
                                       placeholder="Berat"
                                       value="<?= $berat; ?>" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="i_hot" value="1"
                                           id="aktif" <?= $i_hot == 1 ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="aktif">
                                        Hot Deal
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="i_new" value="1"
                                           id="aktif" <?= $i_new == 1 ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="aktif">
                                        New
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="i_best" value="1"
                                           id="aktif" <?= $i_best == 1 ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="aktif">
                                        Best
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($submit == 'Simpan' || $submit == 'Ubah'): ?>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi Item"
                ><?= $deskripsi; ?></textarea>
            </div>
        <?php endif; ?>

        <?php if ($submit == 'Simpan' || $submit == 'Tambah Detail'): ?>
            <div class="form-group">
                <table class="table table-sm" id="tabel">
                    <thead>
                    <tr>
                        <th scope="col">Ukuran</th>
                        <th scope="col">QTY</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <select name="ukuran[]" id="ukuran" class="form-control small" required>
                                <?php foreach ($this->ukuran->get_all() as $ukuran): ?>
                                    <option value="<?= $ukuran->u_kode; ?>"><?= $ukuran->u_nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input name="qty[]" id="qty" type="number" class="form-control" value="0" min="0"></td>
                        <td>
                            <a href="#" class="mt-1" onclick="hapus_detil($(this))"><i
                                        class="fa fa-window-close fa-2x"></i></a>
                        </td>
                    </tr>
                    <tfoot>
                    <tr>
                        <th colspan="4">
                            <a href="#" class="mt-1" id="baru_detil">Tambah Detail</a>
                        </th>
                    </tr>
                    </tfoot>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <input type="hidden" id="counter" name="counter" value="1">
            <button type="submit" class="btn btn-primary"><?= $submit; ?></button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        </div>
    </form>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/select/css/multi-select.css'); ?>">
    <script src="<?= base_url('assets/vendor/select/js/jquery.multi-select.js'); ?>"></script>
    <script>
        $(document).ready(function () {
            $('select#kategori').multiSelect();
        });

        var $table = $('#tabel').find("tbody");

        $('#baru_detil').click(function () {
            var $warna = $('[id="warna"]'),
                $ukuran = $('[id="ukuran"]'),
                $seri = $('[id="seri"]');

            var $trLast = $table.find("tr:last"),
                $trNew = $trLast.clone(),
                $counter = $('#counter');

            // $('option', $trNew.find('select#warna')).filter(function (i) {
            //     return $warna.find('option:selected[value="' + $(this).val() + '"]').length;
            // }).remove();

            $trNew.find('input#qty').val(0);

            if ($trLast.find('select#warna option').length !== 1) {
                $trLast.after($trNew);
                var countup = parseInt($counter.val());
                $counter.val(countup + 1);
            }

        });

        function hapus_detil($data) {
            if ($('#tabel > tbody > tr').length > 1) {
                $('#tabel > tbody > tr:last')
                    .prev()
                    .find('input, select')
                    .attr('disabled', false);
                $data.closest('tr').remove();
                $('#counter').val(counter - 1);
            }
        }
    </script>

<?php endif; ?>
<script>
    $(document).ready(function () {
        tinymce.remove();
        tinymce.init({
            selector: 'textarea',
            height: 200,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css']
        });
    })

</script>
