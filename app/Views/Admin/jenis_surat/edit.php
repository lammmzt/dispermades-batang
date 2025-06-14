<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<style>
#cke_editor1 {
    max-width: 1150px;
    /* Lebar F4 dalam px */
    /* Biar editor selalu di tengah */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    /* Opsional: biar kayak lembar dokumen */
}
</style>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Edit Jenis Surat</h4>
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
                <form action="<?= base_url('Jenis_surat/update'); ?>" method="post" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_jenis_surat" value="<?= $jenis_surat['id_jenis_surat']; ?>">
                    <div class="mb-3">
                        <label for="nama_jenis_surat" class="form-label">Nama Jenis Surat</label>
                        <input type="text" class="form-control" id="nama_jenis_surat" name="nama_jenis_surat"
                            value="<?= $jenis_surat['nama_jenis_surat']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="ket_jenis_surat" class="form-label">Keterangan Jenis Surat</label>
                        <textarea class="form-control" name="ket_jenis_surat"
                            rows="3"><?= $jenis_surat['ket_jenis_surat']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kode_surat" class="form-label">Kode Surat</label>
                        <input type="text" class="form-control" id="kode_surat" name="kode_surat"
                            value="<?= $jenis_surat['kode_surat']; ?>">
                        <div class="form-text">Contoh kode surat: 800</div>
                    </div>
                    <div class="mb-3">
                        <label for="kode_surat" class="form-label">Detail Jenis Surat</label>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne">
                                    <button class="accordion-button bg-transparent" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Referensi Data
                                    </button>
                                </h4>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                        foreach($referensi_jenis_surat as $referensi): ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                id="<?= $referensi['id_referensi_jenis_surat']; ?>"
                                                name="detail_jenis_surat[]"
                                                value="<?= $referensi['id_referensi_jenis_surat']; ?>"
                                                <?= ($detail_jenis_surat != null && in_array($referensi['id_referensi_jenis_surat'], $detail_jenis_surat)) ? 'checked' : ''; ?>>
                                            <label class="form-check-label"
                                                for="<?= $referensi['id_referensi_jenis_surat']; ?>"><?= $referensi['kode_referensi_jenis_surat']; ?></label>
                                        </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="template_jenis_surat" class="form-label">Template Jenis Surat</label>
                        <textarea id="editor1" name="template_jenis_surat" rows="10" cols="80"
                            placeholder="Masukkan template surat"><?= $jenis_surat['template_jenis_surat']; ?></textarea>
                    </div>
                    <!-- <hr> -->
                    <div class="text-start mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('Jenis_surat'); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script style="text/javascript">
CKEDITOR.replace('editor1', {
    // height: 250,
    width: '100%',
    baseFloatZIndex: 10005,
    fontSize: 20,
    fontNames: 'Times New Roman',
    fontNamesIgnoreCheck: 'Times New Roman',
    //clipboard_handleImages: false,
    extraPlugins: 'image2,uploadimage',
    // Configure your file manager integration. This example uses CKFinder 3 for PHP.
    filebrowserBrowseUrl: '<?= base_url(); ?>ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '<?= base_url(); ?>ckfinder/ckfinder.html?type=Images',
    filebrowserUploadUrl: '<?= base_url(); ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl: '<?= base_url(); ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    // Upload dropped or pasted images to the CKFinder connector (note that the response type is set to JSON).
    uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',

    // ckfinder delete image in server
    filebrowserImageDeleteUrl: '<?= base_url(); ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json',
    fontSize_defaultLabel: '20',
    font_defaultLabel: 'Times New Roman',
    // ckfinder delete file in server in demo mode

    // Reduce the list of block elements listed in the Format drop-down to the most commonly used.
    format_tags: 'p;h1;h2;h3;pre',
    // Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
    //removeDialogTabs: 'image:advanced;link:advanced',
    toolbarGroups: [{
            name: 'document',
            groups: ['mode', 'document', 'doctools']
        },
        {
            name: 'clipboard',
            groups: ['clipboard', 'undo']
        },
        {
            name: 'editing',
            groups: ['find', 'selection', 'spellchecker', 'editing']
        },
        {
            name: 'forms',
            groups: ['forms']
        },
        '/',
        {
            name: 'basicstyles',
            groups: ['basicstyles', 'cleanup']
        },
        {
            name: 'paragraph',
            groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
        },
        {
            name: 'links',
            groups: ['links']
        },
        {
            name: 'insert',
            groups: ['insert']
        },
        '/',
        {
            name: 'styles',
            groups: ['styles']
        },
        {
            name: 'colors',
            groups: ['colors']
        },
        {
            name: 'tools',
            groups: ['tools']
        },
        {
            name: 'others',
            groups: ['others']
        },
        {
            name: 'about',
            groups: ['about']
        }
    ],
    removeButtons: 'ExportPdf,Save,NewPage,Templates,About,Smiley,Iframe,Link,Anchor,Unlink,Blockquote,CreateDiv,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Scayt,PasteFromWord'
});
</script>
<?= $this->endSection('content'); ?>