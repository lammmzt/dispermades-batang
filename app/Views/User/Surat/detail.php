<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title fw-bold">Detail Surat Keluar</h4>
            </div>
            <div class="header-title">
                <a href="<?= base_url('Surat'); ?>" class="btn btn-primary btn-md align-items-center float-end">
                    Kembali
                </a>
            </div>
        </div>
        <div class="card-body px-0">

            <div class="bd-example mx-3">
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </symbol>
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </symbol>
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </symbol>
                </svg>

                <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                        <use xlink:href="#check-circle-fill" />
                    </svg>
                    <div>
                        <strong>Berhasil!</strong> <?= session()->getFlashdata('success'); ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>
                        <strong>Terjadi Kesalahan!</strong>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="mt-2 mx-3">


                <input type="hidden" name="id_surat_keluar" value="<?= $surat_keluar['id_surat_keluar']; ?>"
                    id="id_surat_keluar">
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="judul_surat_keluar" class="form-label">Judul Surat Keluar</label>
                        <input type="text" class="form-control" id="judul_surat_keluar" name="judul_surat_keluar"
                            value="<?= $surat_keluar['judul_surat_keluar']; ?>" placeholder="No Surat" readonly>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="nama_user" class="form-label">Konseptor</label>
                        <input type="text" class="form-control" id="nama_user" name="nama_user"
                            value="<?= $surat_keluar['nama_user']; ?>" placeholder="No Surat" readonly>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="nomor_surat_keluar" class="form-label">No Surat</label>
                        <input type="text" class="form-control" id="nomor_surat_keluar" name="nomor_surat_keluar"
                            value="<?= $surat_keluar['kode_surat'].'/'.$surat_keluar['nomor_surat_keluar']; ?>"
                            placeholder="No Surat" readonly>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="tanggal_surat_keluar" class="form-label">Tanggal Surat</label>
                        <input type="date" class="form-control" id="tanggal_surat_keluar" name="tanggal_surat_keluar"
                            value="<?= $surat_keluar['tanggal_surat_keluar']; ?>" placeholder="Tanggal Surat" readonly>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="keterangan_surat_keluar" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan_surat_keluar" name="keterangan_surat_keluar"
                            readonly
                            placeholder="Keterangan Surat"><?= $surat_keluar['keterangan_surat_keluar']; ?></textarea>
                    </div>
                    <input type="hidden" name="id_jenis_surat" value="<?= $id_jenis_surat; ?>">
                    <div class="mt-3">
                        <!-- <label for="tipe_lampiran_surat_keluar" class="form-label">Lampiran</label> -->
                        <select class="form-select" id="tipe_lampiran_surat_keluar" name="tipe_lampiran_surat_keluar"
                            hidden style="width: 100%;">
                            <option selected>Pilih Tipe File</option>
                            <option value="img"
                                <?= $surat_keluar['tipe_lampiran_surat_keluar'] == 'img' ? 'selected' : ''; ?>>
                                Gambar
                            </option>
                            <option value="pdf"
                                <?= $surat_keluar['tipe_lampiran_surat_keluar'] == 'pdf' ? 'selected' : ''; ?>>PDF
                            </option>
                        </select>
                    </div>
                </div>
                <div class="accordion accordion-flush bg-white" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse"
                                data-bs-target="#prevHasilSurat" aria-expanded="true" aria-controls="prevHasilSurat">
                                <h5 class="card-title">Preview Hasil Surat</h5>
                            </button>
                        </h2>
                        <div id="prevHasilSurat" class="accordion-collapse collapse bg-white"
                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body bg-white">
                                <div class="row mb-3">
                                    <div class="col-md-12 mt-1">
                                        <label for="preview_hasil_surat" class="form-label">Preview
                                            Surat</label>
                                        <textarea class="form-control" id="preview_hasil_surat"
                                            name="preview_hasil_surat" required
                                            placeholder="Preview Hasil Surat"><?= $template; ?></textarea>
                                    </div>

                                </div>
                                <?php if($surat_keluar['lampiran_surat_keluar'] != null): ?>
                                <div class="row_lapiran">
                                    <div class="mt-3" id="file_lampiran_container" style="display: none;">
                                        <label for="file_lampiran" class="form-label">File Lampiran</label>
                                        <input type="file" class="form-control" id="file_lampiran" name="file_lampiran"
                                            value="<?= old('file_lampiran'); ?>" placeholder="File Surat">
                                    </div>
                                    <!-- preview  -->
                                    <div class="mt-3" id="preview" style="display: none;">
                                        <label for="preview" class="form-label">Preview Lampiran</label>
                                        <img src="" id="img-preview" class="img-fluid" alt="preview"
                                            style="display: none;">
                                        <embed src="" id="pdf-preview" type="application/pdf" width="100%"
                                            height="600px" style="display: none;">
                                    </div>

                                    <!-- preview  -->
                                    <div class="mt-2" id="preview" style="display: none;">
                                        <label for="preview" class="form-label">Preview Lampiran</label>
                                        <img src="" id="img-preview" class="img-fluid" alt="preview"
                                            style="display: none;">
                                        <embed src="" id="pdf-preview" type="application/pdf" width="100%"
                                            height="600px" style="display: none;">
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<script style="text/javascript">
$(document).ready(function() {
    // when change select id_jenis_surat submit form_filter
    $('#id_jenis_surat').change(function() {
        $('#form_filter').submit();
    });

    var file_lampiran = <?= json_encode($surat_keluar['lampiran_surat_keluar']); ?>;
    var tipe_lampiran = <?= json_encode($surat_keluar['tipe_lampiran_surat_keluar']); ?>;
    // console.log(file_lampiran, tipe_lampiran);
    if (file_lampiran != null) {
        $('#file_lampiran').attr('style', 'display: block');
        $('#file_lampiran').attr('value', file_lampiran);
        $('#preview').attr('style', 'display: block');
        if (tipe_lampiran == 'img') {
            $('#img-preview').attr('style', 'display: block');
            $('#img-preview').attr('src', '<?= base_url('Assets/file_lampiran_surat_keluar/') ?>' +
                file_lampiran);
            $('#pdf-preview').attr('style', 'display: none');
            $('#pdf-preview').attr('src', '');
        } else if (tipe_lampiran == 'pdf') {
            $('#pdf-preview').attr('style', 'display: block');
            $('#pdf-preview').attr('src', '<?= base_url('Assets/file_lampiran_surat_keluar/') ?>' +
                file_lampiran);
            $('#img-preview').attr('style', 'display: none');
            $('#img-preview').attr('src', '');
        }
    }

    function chnageTipe(tipe) {

        if (tipe == 'img') {
            $('#file_lampiran_container').attr('style', 'display: block');
            $('#file_lampiran').attr('type', 'file');
            $('#file_lampiran').attr('accept', 'image/*');
            $('#file_lampiran').attr('name', 'file_lampiran');
            $('#file_lampiran').attr('required', 'required');
            $('#file_lampiran').attr('value', '');
            $('#file_lampiran').attr('class', 'form-control');
            $('#file_lampiran').attr('placeholder', 'File Surat');
            $('#file_lampiran').attr('style', 'display: block');
            $('#preview').attr('style', 'display: none');
            $('#pdf-preview').attr('src', '');
            $('#img-preview').attr('src', '');
        } else if (tipe == 'pdf') {
            $('#file_lampiran_container').attr('style', 'display: block');
            $('#file_lampiran').attr('type', 'file');
            $('#file_lampiran').attr('accept', 'application/pdf');
            $('#file_lampiran').attr('name', 'file_lampiran');
            $('#file_lampiran').attr('required', 'required');
            $('#file_lampiran').attr('value', '');
            $('#file_lampiran').attr('class', 'form-control');
            $('#file_lampiran').attr('placeholder', 'File Surat');
            $('#file_lampiran').attr('style', 'display: block');
            $('#preview').attr('style', 'display: none');
            $('#pdf-preview').attr('src', '');
            $('#img-preview').attr('src', '');
        } else {
            $('#file_lampiran_container').attr('style', 'display: none');
            $('#file_lampiran').attr('type', 'hidden');
            $('#file_lampiran').attr('name', '');
            $('#file_lampiran').attr('required', '');
            $('#file_lampiran').attr('value', '');
            $('#file_lampiran').attr('class', '');
            $('#file_lampiran').attr('placeholder', '');
            $('#file_lampiran').attr('style', 'display: none');
            $('#preview').attr('style', 'display: none');
            $('#img-preview').attr('src', '');
            $('#pdf-preview').attr('src', '');
        }
    }
    $('#tipe_lampiran_surat_keluar').change(function() {
        var tipe = $(this).val();
        chnageTipe(tipe);
    });
    $('#file_lampiran').change(function() {
        var file = $(this).val();
        var tipe = $('#tipe_lampiran_surat_keluar').val();
        $('#preview').attr('style', 'display: block');
        if (tipe == 'img') {
            $('#pdf-preview').attr('style', 'display: none');
            $('#pdf-preview').attr('src', '');
            $('#img-preview').attr('style', 'display: block');
            $('#img-preview').attr('src', URL.createObjectURL(event.target.files[0]));
        }
        if (tipe == 'pdf') {
            $('#img-preview').attr('style', 'display: none');
            $('#pdf-preview').attr('style', 'display: block');
            $('#img-preview').attr('src', '');
            $('#pdf-preview').attr('src', URL.createObjectURL(event.target.files[0]));
        }
    });
});


// ubah data isian_surat_keluar
var data_isian_surat = <?= json_encode($surat_keluar['isian_surat_keluar']); ?>;
// console.log(data_isian_surat);   

// masukan value ke dalam input berdasarkan id
data_isian_surat = JSON.parse(data_isian_surat);
for (var key in data_isian_surat) {
    $('#' + key).val(data_isian_surat[key]);
}

// preview hasil surat ckeditor preview_hasil_surat
var judul_surat = <?= json_encode($surat_keluar['judul_surat_keluar']); ?> +
    ' ' + <?= json_encode($surat_keluar['nomor_surat_keluar']); ?> +
    ' ' + <?= json_encode($surat_keluar['tanggal_surat_keluar']); ?>;
CKEDITOR.replace('preview_hasil_surat', {
    height: '1000px',
    width: '100%',
    baseFloatZIndex: 10005,
    // tidak bisa mengedit
    readOnly: true,
    // hilangkan buttons
    removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,HorizontalRule,SpecialChar,PageBreak,Iframe,About,Save,',
    // judul print preview
    title: judul_surat,
});
</script>
<?= $this->endSection('script'); ?>