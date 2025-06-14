<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Tambah Surat Masuk</h4>
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
                <form action="<?= base_url('Surat_masuk/save'); ?>" method="post" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    <?= csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="pengirim_surat_masuk" class="form-label">Pengirim Surat</label>
                            <input type="text" class="form-control" id="pengirim_surat_masuk"
                                name="pengirim_surat_masuk" value="<?= old('pengirim_surat_masuk'); ?>" required
                                autofocus placeholder="Pengirim Surat">
                        </div>
                        <div class="col-md-6">
                            <label for="perihal_surat_masuk" class="form-label">Perihal Surat</label>
                            <input type="text" class="form-control" id="perihal_surat_masuk" name="perihal_surat_masuk"
                                value="<?= old('perihal_surat_masuk'); ?>" required placeholder="Perihal Surat">
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="no_surat_masuk" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" id="no_surat_masuk" name="no_surat_masuk"
                                value="<?= old('no_surat_masuk'); ?>" required placeholder="Nomor Surat">
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_surat_masuk" class="form-label">Tanggal Surat</label>
                            <input type="date" class="form-control" id="tgl_surat_masuk" name="tgl_surat_masuk"
                                value="<?= old('tgl_surat_masuk'); ?>" required placeholder="Tanggal Surat">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="ket_surat_masuk" class="form-label ">Keterangan Surat</label>
                        <textarea class="form-control" id="ket_surat_masuk" name="ket_surat_masuk" required
                            rows="3"><?= old('ket_surat_masuk'); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tipe_file_surat_masuk" class="form-label">Tipe File</label>
                        <select class="form-select" id="tipe_file_surat_masuk" name="tipe_file_surat_masuk" required>
                            <option selected>Pilih Tipe File</option>
                            <option value="img" <?= old('tipe_file_surat_masuk') == 'img' ? 'selected' : ''; ?>>IMG
                            </option>
                            <option value="pdf" <?= old('tipe_file_surat_masuk') == 'pdf' ? 'selected' : ''; ?>>PDF
                            </option>
                        </select>
                    </div>
                    <div class="mb-3" id="file_surat_masuk_container" style="display: none;">
                        <label for="file_surat_masuk" class="form-label">File Surat</label>
                        <input type="file" class="form-control" id="file_surat_masuk" name="file_surat_masuk"
                            value="<?= old('file_surat_masuk'); ?>" required placeholder="File Surat">
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
                    <div class="accordion accordion-flush bg-white border-0" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed bg-white border-0" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <h4 class="card-title">Disposisi</h4>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse bg-white border-0"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body bg-white">
                                    <div class="row mb-3">
                                        <div class="col-md-9">
                                            <label for="pegawai_disposisi" class="form-label">Pegawai Disposisi</label>
                                            <select class="form-select select2" id="pegawai_disposisi"
                                                name="pegawai_disposisi" required style="width: 100%;">
                                                <option selected>Pilih Pegawai</option>
                                                <?php foreach($pegawai as $p): ?>
                                                <option value="<?= $p['id_pegawai']; ?>" <?= old('pegawai_disposisi') == $p['id_pegawai'] ?
                                    'selected' : ''; ?>><?= $p['nama_pegawai']; ?>(<?= $p['jabatan_pegawai']; ?>)
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- button plus -->
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary " id="tambah_disposisi">
                                                <i class="bi-plus-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- table -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="5%" class="text-center">#</th>
                                                    <th scope="col">Pegawai</th>
                                                    <th scope="col">Ket</th>
                                                    <th scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="disposisi">
                                                <tr class="text-center" id="belum_disposisi">
                                                    <td colspan="4" class="text-center">Belum ada disposisi</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-start mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('Surat_masuk'); ?>" class="btn btn-secondary">Kembali</a>
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
    $('#tipe_file_surat_masuk').change(function() {
        var tipe = $(this).val();
        // alert(tipe);
        if (tipe == 'img') {
            $('#file_surat_masuk_container').attr('style', 'display: block');
            $('#file_surat_masuk').attr('type', 'file');
            $('#file_surat_masuk').attr('accept', 'image/*');
            $('#file_surat_masuk').attr('name', 'file_surat_masuk');
            $('#file_surat_masuk').attr('required', 'required');
            $('#file_surat_masuk').attr('value', '');
            $('#file_surat_masuk').attr('class', 'form-control');
            $('#file_surat_masuk').attr('placeholder', 'File Surat');
            $('#file_surat_masuk').attr('style', 'display: block');
            $('#preview').attr('style', 'display: none');
            $('#pdf-preview').attr('src', '');
            $('#img-preview').attr('src', '');
        } else if (tipe == 'pdf') {
            $('#file_surat_masuk_container').attr('style', 'display: block');
            $('#file_surat_masuk').attr('type', 'file');
            $('#file_surat_masuk').attr('accept', 'application/pdf');
            $('#file_surat_masuk').attr('name', 'file_surat_masuk');
            $('#file_surat_masuk').attr('required', 'required');
            $('#file_surat_masuk').attr('value', '');
            $('#file_surat_masuk').attr('class', 'form-control');
            $('#file_surat_masuk').attr('placeholder', 'File Surat');
            $('#file_surat_masuk').attr('style', 'display: block');
            $('#preview').attr('style', 'display: none');
            $('#pdf-preview').attr('src', '');
            $('#img-preview').attr('src', '');
        } else {
            $('#file_surat_masuk_container').attr('style', 'display: none');
            $('#file_surat_masuk').attr('type', 'hidden');
            $('#file_surat_masuk').attr('name', '');
            $('#file_surat_masuk').attr('required', '');
            $('#file_surat_masuk').attr('value', '');
            $('#file_surat_masuk').attr('class', '');
            $('#file_surat_masuk').attr('placeholder', '');
            $('#file_surat_masuk').attr('style', 'display: none');
            $('#preview').attr('style', 'display: none');
            $('#img-preview').attr('src', '');
            $('#pdf-preview').attr('src', '');
        }
    });
    $('#file_surat_masuk').change(function() {
        var file = $(this).val();
        var tipe = $('#tipe_file_surat_masuk').val();
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
var data_disposisi_pegawai = [];

// fungsi untuk meampilkan data pegawai yang akan di disposisi
function render_disposisi_pegawai() {
    console.log(data_disposisi_pegawai);
    $('#disposisi').empty();
    if (data_disposisi_pegawai.length == 0) {
        $('#disposisi').append('<tr class="text-center" id="belum_disposisi">' +
            '<td colspan="4" class="text-center">Belum ada disposisi</td>' +
            '</tr>');
    } else {
        $('#belum_disposisi').remove();
        for (var i = 0; i < data_disposisi_pegawai.length; i++) {
            $('#disposisi').append('<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' + data_disposisi_pegawai[i].nama_pegawai +
                '<input type="hidden" style="min-width: 100px" name="id_pegawai[]" value="' +
                data_disposisi_pegawai[i].id_pegawai +
                '"></td>' +
                '<td> <input type="text" style="min-width: 100px" class="form-control ket_disposisi" name="ket_disposisi[]" data-id="' +
                data_disposisi_pegawai[i].id_pegawai + '" value="' + data_disposisi_pegawai[i].ket_disposisi +
                '"></td>' +
                '<td><button type="button" class="btn btn-danger hapus_disposisi" data-id="' +
                data_disposisi_pegawai[i].id_pegawai + '">Hapus</button></td>' +
                '</tr>');
        }
    }
}

render_disposisi_pegawai();

// fungsi untuk menambahkan data pegawai yang akan di disposisi
$('#tambah_disposisi').click(function() {
    var id_pegawai = $('#pegawai_disposisi').val();
    var nama_pegawai = $('#pegawai_disposisi option:selected').text();
    if (id_pegawai == 'Pilih Pegawai') {
        alert('Pilih Pegawai');
    } else {
        // jika data pegawai sudah ada
        for (var i = 0; i < data_disposisi_pegawai.length; i++) {
            if (data_disposisi_pegawai[i].id_pegawai == id_pegawai) {
                alert('Pegawai sudah ada');
                return false;
            }
        }
        var data = {
            id_pegawai: id_pegawai,
            nama_pegawai: nama_pegawai,
            ket_disposisi: ''
        };
        data_disposisi_pegawai.push(data);
        render_disposisi_pegawai();
    }
});


// fungsi untuk menghapus data pegawai yang akan di disposisi
$(document).on('click', '.hapus_disposisi', function() {
    var id_pegawai = $(this).data('id');
    for (var i = 0; i < data_disposisi_pegawai.length; i++) {
        if (data_disposisi_pegawai[i].id_pegawai == id_pegawai) {
            data_disposisi_pegawai.splice(i, 1);
        }
    }
    render_disposisi_pegawai();
});

// fungsi untuk menguabah daa ket disposisi
$(document).on('focusout', '.ket_disposisi', function() {
    var id_pegawai = $(this).data('id');
    // alert(id_pegawai);
    var ket_disposisi = $(this).val();
    for (var i = 0; i < data_disposisi_pegawai.length; i++) {
        if (data_disposisi_pegawai[i].id_pegawai == id_pegawai) {
            data_disposisi_pegawai[i].ket_disposisi = ket_disposisi;
        }
    }
    render_disposisi_pegawai();
});
</script>
<?= $this->endSection('script'); ?>