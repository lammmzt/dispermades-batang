<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title fw-bold">Detail Surat Masuk</h4>
            </div>
        </div>
        <div class="card-body px-0">

            <div class="row m-2">
                <div class="col-12">
                    <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Selamat!</strong> <?= session()->getFlashdata('success'); ?>.
                    </div>

                    <?php endif; ?>
                    <?php if(session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal!</strong> <?= session()->getFlashdata('errors'); ?>.
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mt-2 mx-3">
                <form action="<?= base_url('Disposisi/Balasan'); ?>" method="post" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_surat_masuk" value="<?= $surat_masuk['id_surat_masuk']; ?>">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="pengirim_surat_masuk" class="form-label">Pengirim Surat</label>
                            <input type="text" class="form-control" id="pengirim_surat_masuk"
                                name="pengirim_surat_masuk"
                                value="<?= (old('pengirim_surat_masuk')) ? old('pengirim_surat_masuk') : $surat_masuk['pengirim_surat_masuk']; ?>"
                                disabled autofocus placeholder="Pengirim Surat">
                        </div>
                        <div class="col-md-6">
                            <label for="perihal_surat_masuk" class="form-label">Perihal Surat</label>
                            <input type="text" class="form-control" id="perihal_surat_masuk" name="perihal_surat_masuk"
                                value="<?= (old('perihal_surat_masuk')) ? old('perihal_surat_masuk') : $surat_masuk['perihal_surat_masuk']; ?>"
                                disabled placeholder="Perihal Surat">
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="no_surat_masuk" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" id="no_surat_masuk" name="no_surat_masuk"
                                value="<?= (old('no_surat_masuk')) ? old('no_surat_masuk') : $surat_masuk['no_surat_masuk']; ?>"
                                disabled placeholder="Nomor Surat">
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_surat_masuk" class="form-label">Tanggal Surat</label>
                            <input type="date" class="form-control" id="tgl_surat_masuk" name="tgl_surat_masuk"
                                value="<?= (old('tgl_surat_masuk')) ? old('tgl_surat_masuk') : $surat_masuk['tgl_surat_masuk']; ?>"
                                disabled placeholder="Tanggal Surat">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="ket_surat_masuk" class="form-label ">Keterangan Surat</label>
                        <textarea class="form-control" id="ket_surat_masuk" name="ket_surat_masuk" disabled
                            rows="3"><?= (old('ket_surat_masuk')) ? old('ket_surat_masuk') : $surat_masuk['ket_surat_masuk']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" id="tipe_file_surat_masuk" name="tipe_file_surat_masuk" hidden>
                            <option value="img"
                                <?= $surat_masuk['tipe_file_surat_masuk'] == 'img' ? 'selected' : ''; ?>>IMG</option>
                            <option value="pdf"
                                <?= $surat_masuk['tipe_file_surat_masuk'] == 'pdf' ? 'selected' : ''; ?>>PDF</option>
                        </select>
                    </div>
                    <div class="mb-3" id="file_surat_masuk_container" style="display: none;">
                        <input type="file" class="form-control" id="file_surat_masuk" name="file_surat_masuk" hidden
                            value="<?= old('file_surat_masuk'); ?>" placeholder="File Surat">
                    </div>
                    <!-- preview  -->
                    <div class="mb-3" id="preview" style="display: none;">
                        <label for="preview" class="form-label">Preview</label>
                        <img src="" id="img-preview" class="img-fluid" alt="preview" style="display: none;">
                        <embed src="" id="pdf-preview" type="application/pdf" width="100%" height="600px"
                            style="display: none;">
                    </div>

                    <hr style="border-top: 1px solid; width: 100%; margin: 1rem 0;" class="mt-4">
                    <!-- acordion -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="no_surat_masuk" class="form-label">Keterangan Disposisi</label>
                            <input type="text" class="form-control" id="ket_disposisi" name="ket_disposisi"
                                value="<?= (old('ket_disposisi')) ? old('ket_disposisi') : $surat_masuk['ket_disposisi']; ?>"
                                disabled placeholder="Keterangan Disposisi">
                        </div>
                        <input type="hidden" name="id_disposisi"
                            value="<?= (old('id_disposisi')) ? old('id_disposisi') : $surat_masuk['id_disposisi']; ?>">
                        <div class="col-md-6">
                            <label for="tgl_surat_masuk" class="form-label">Jawaban Disposisi</label>
                            <input type="text" class="form-control" id="jawaban_disposisi" name="jawaban_disposisi"
                                value="<?= (old('jawaban_disposisi')) ? old('jawaban_disposisi') : $surat_masuk['jawaban_disposisi']; ?>"
                                placeholder="Jawaban Disposisi"
                                <?= ($surat_masuk['status_disposisi'] == '1') ? 'disabled' : ''; ?>>
                        </div>
                    </div>
                    <div class="text-start mt-4">
                        <?= ($surat_masuk['status_disposisi'] == '0') ? '<button type="submit" class="btn btn-primary">Balas</button>' : ''; ?>
                        <a href="<?= base_url('Disposisi'); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<script style="text/javascript">
$(document).ready(function() {
    changePreview('<?= base_url('Assets/file_surat_masuk/' . $surat_masuk['file_surat_masuk']); ?>',
        '<?= $surat_masuk['tipe_file_surat_masuk']; ?>');
});


// fungsi mengubah tampilan file
function changePreview(file, tipe) {
    console.log(file, tipe);
    $('#preview').attr('style', 'display: block');
    if (tipe == 'img') {
        $('#img-preview').attr('src', file);
        $('#img-preview').attr('style', 'display: block');
        $('#pdf-preview').attr('style', 'display: none');
    } else if (tipe == 'pdf') {
        $('#pdf-preview').attr('src', file);
        $('#pdf-preview').attr('style', 'display: block');
        $('#img-preview').attr('style', 'display: none');
    }
}
</script>
<?= $this->endSection('script'); ?>