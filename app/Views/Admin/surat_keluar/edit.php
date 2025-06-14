<?= $this->extend('Templates/index') ?>
<?= $this->section('konten') ?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Edit Surat Keluar</h4>
            </div>
            <a href="<?= base_url('Surat_keluar'); ?>" class="btn btn-secondary btn-sm">
                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
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
                <!-- <div class="row mb-3">
                    <form action="<?= base_url('Surat_keluar/tambah'); ?>" method="post" enctype="multipart/form-data"
                        class="needs-validation" novalidate id="form_filter">
                        <div class="col-md-6">
                            <label for="id_jenis_surat" class="form-label">Jenis Surat</label>
                            <select class="form-select select2" id="id_jenis_surat" name="id_jenis_surat" required
                                style="width: 100%;">
                                <option selected>Pilih Jenis Surat</option>
                                <?php foreach($jenis_surat as $js): ?>
                                <option value="<?= $js['id_jenis_surat']; ?>" <?= $id_jenis_surat == $js['id_jenis_surat'] ?
                                    'selected' : ''; ?>><?= $js['nama_jenis_surat']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div> -->
                <hr style="border-top: 1px solid; width: 100%; margin: 1rem 0;">
                <form action="<?= base_url('Surat_keluar/updateDataIsian'); ?>" method="post"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="judul_surat_keluar" class="form-label">Judul Surat</label>
                            <input type="text" class="form-control" id="judul_surat_keluar" name="judul_surat_keluar"
                                value="<?= $surat_keluar['judul_surat_keluar']; ?>" required placeholder="Judul Surat">
                        </div>
                        <?php 
                        if($dataDetailJenisSurat != null):
                            
                            foreach($dataDetailJenisSurat as $djs): 
                        ?>
                        <?php 
                        // hapus {} di kode_referensi_jenis_surat
                        $id_kode_referensi_jenis_surat = str_replace(['{', '}'], '', $djs['kode_referensi_jenis_surat']);
                        // dd($id_kode_referensi_jenis_surat);
                        if($djs['tipe_referensi_jenis_surat'] == 'input'):
                        ?>
                        <div class="col-md-6 mt-3">
                            <label for="<?= $djs['kode_referensi_jenis_surat']; ?>" class="form-label">
                                <?= $djs['nama_referensi_jenis_surat']; ?></label>
                            <input type="text" class="form-control" id="<?= $id_kode_referensi_jenis_surat ?>"
                                name="<?= $djs['kode_referensi_jenis_surat']; ?>"
                                value="<?= old($djs['kode_referensi_jenis_surat']); ?>" required
                                placeholder="<?= $djs['nama_referensi_jenis_surat']; ?>">
                        </div>
                        <?php
                        elseif($djs['tipe_referensi_jenis_surat'] == 'number'):
                        ?>
                        <div class="col-md-6 mt-3">
                            <label for="<?= $djs['kode_referensi_jenis_surat']; ?>" class="form-label">
                                <?= $djs['nama_referensi_jenis_surat']; ?></label>
                            <input type="number" class="form-control" id="<?= $id_kode_referensi_jenis_surat ?>"
                                name="<?= $djs['kode_referensi_jenis_surat']; ?>"
                                value="<?= old($djs['kode_referensi_jenis_surat']); ?>" required
                                placeholder="<?= $djs['nama_referensi_jenis_surat']; ?>">
                        </div>
                        <?php
                        elseif($djs['tipe_referensi_jenis_surat'] == 'textarea'):
                        ?>
                        <div class="col-md-6 mt-3">
                            <label for="<?= $djs['kode_referensi_jenis_surat']; ?>" class="form-label">
                                <?= $djs['nama_referensi_jenis_surat']; ?></label>
                            <textarea class="form-control" id="<?= $id_kode_referensi_jenis_surat ?>"
                                name="<?= $djs['kode_referensi_jenis_surat']; ?>" required
                                placeholder="<?= $djs['nama_referensi_jenis_surat']; ?>"><?= old($djs   ['kode_referensi_jenis_surat']); ?></textarea>
                        </div>
                        <?php
                        elseif($djs['tipe_referensi_jenis_surat'] == 'date'):
                        ?>
                        <div class="col-md-6 mt-3">
                            <label for="<?= $djs['kode_referensi_jenis_surat']; ?>" class="form-label">
                                <?= $djs['nama_referensi_jenis_surat']; ?></label>
                            <input type="date" class="form-control" id="<?= $id_kode_referensi_jenis_surat ?>"
                                name="<?= $djs['kode_referensi_jenis_surat']; ?>"
                                value="<?= old($djs['kode_referensi_jenis_surat']); ?>" required
                                placeholder="<?= $djs['nama_referensi_jenis_surat']; ?>">
                        </div>
                        <?php
                        elseif($djs['tipe_referensi_jenis_surat'] == 'datetime'):
                        ?>
                        <div class="col-md-6 mt-3">
                            <label for="<?= $djs['kode_referensi_jenis_surat']; ?>" class="form-label">
                                <?= $djs['nama_referensi_jenis_surat']; ?></label>
                            <input type="datetime-local" class="form-control" id="<?= $id_kode_referensi_jenis_surat ?>"
                                name="<?= $djs['kode_referensi_jenis_surat']; ?>"
                                value="<?= old($djs['kode_referensi_jenis_surat']); ?>" required
                                placeholder="<?= $djs['nama_referensi_jenis_surat']; ?>">
                        </div>
                        <?php
                        elseif($djs['tipe_referensi_jenis_surat'] == 'time'):
                        ?>
                        <div class="col-md-6 mt-3">
                            <label for="<?= $djs['kode_referensi_jenis_surat']; ?>" class="form-label">
                                <?= $djs['nama_referensi_jenis_surat']; ?></label>
                            <input type="time" class="form-control" id="<?= $id_kode_referensi_jenis_surat ?>"
                                name="<?= $djs['kode_referensi_jenis_surat']; ?>"
                                value="<?= old($djs['kode_referensi_jenis_surat']); ?>" required
                                placeholder="<?= $djs['nama_referensi_jenis_surat']; ?>">
                        </div>
                        <?php
                        elseif($djs['tipe_referensi_jenis_surat'] == 'ckeditor'):
                        ?>
                        <div class="col-md-6 mt-3">
                            <label for="<?= $djs['kode_referensi_jenis_surat']; ?>" class="form-label">
                                <?= $djs['nama_referensi_jenis_surat']; ?></label>
                            <textarea class="form-control" id="<?= $id_kode_referensi_jenis_surat ?>"
                                name="<?= $djs['kode_referensi_jenis_surat']; ?>" required
                                placeholder="<?= $djs['nama_referensi_jenis_surat']; ?>"><?= old($djs   ['kode_referensi_jenis_surat']); ?></textarea>
                            <script>
                            CKEDITOR.replace('<?= $djs['kode_referensi_jenis_surat']; ?>');
                            </script>
                        </div>
                        <?php
                        else:
                            continue;
                        endif;
                        endforeach;
                    
                    ?>
                    </div>
                    <input type="hidden" name="id_surat_keluar" value="<?= $surat_keluar['id_surat_keluar']; ?>"
                        id="id_surat_keluar">
                    <div class="col-md-12">
                        <label for="keterangan_surat_keluar" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan_surat_keluar" name="keterangan_surat_keluar"
                            placeholder="Keterangan Surat"><?= $surat_keluar['keterangan_surat_keluar']; ?></textarea>
                    </div>
                    <input type="hidden" name="id_jenis_surat" value="<?= $id_jenis_surat; ?>">
                    <div class="mt-3">
                        <label for="tipe_lampiran_surat_keluar" class="form-label">Lampiran</label>
                        <select class="form-select" id="tipe_lampiran_surat_keluar" name="tipe_lampiran_surat_keluar">
                            <option selected>Pilih Tipe File</option>
                            <option value="img"
                                <?= $surat_keluar['tipe_lampiran_surat_keluar'] == 'img' ? 'selected' : ''; ?>>Gambar
                            </option>
                            <option value="pdf"
                                <?= $surat_keluar['tipe_lampiran_surat_keluar'] == 'pdf' ? 'selected' : ''; ?>>PDF
                            </option>
                        </select>
                    </div>
                    <div class="mt-3" id="file_lampiran_container" style="display: none;">
                        <label for="file_lampiran" class="form-label">File Lampiran</label>
                        <input type="file" class="form-control" id="file_lampiran" name="file_lampiran"
                            value="<?= old('file_lampiran'); ?>" placeholder="File Lampiran">
                    </div>
                    <!-- preview  -->
                    <div class="mt-3" id="preview" style="display: none;">
                        <label for="preview" class="form-label">Preview Lampiran</label>
                        <img src="" id="img-preview" class="img-fluid" alt="preview" style="display: none;">
                        <embed src="" id="pdf-preview" type="application/pdf" width="100%" height="600px"
                            style="display: none;">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
                <hr style="border-top: 1px solid; width: 100%; margin: 1rem 0;" class="mt-4">
                <!-- acordion -->
                <div class="accordion accordion-flush bg-white" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h5 class="card-title">Penerima Surat</h5>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse bg-white" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body bg-white">
                                <div class="row mb-3">
                                    <div class="col-md-3 mt-3">
                                        <label for="jenis_penerima" class="form-label">Jenis Penerima</label>
                                        <select class="form-select" id="jenis_penerima" name="jenis_penerima" required
                                            style="width: 100%;">
                                            <option selected>Pilih penerima</option>
                                            <option value="Pegawai">Internal</option>
                                            <option value="External">External</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="id_penerima" class="form-label">Penerima</label>
                                        <select class="form-select select2" id="id_penerima" name="id_penerima" required
                                            style="width: 100%;">
                                            <option selected>Pilih penerima</option>
                                        </select>
                                    </div>
                                    <!-- button plus -->
                                    <div class="col-md-3 mt-3 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary " id="tambahPenerima">
                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M7.33 2H16.66C20.06 2 22 3.92 22 7.33V16.67C22 20.06 20.07 22 16.67 22H7.33C3.92 22 2 20.06 2 16.67V7.33C2 3.92 3.92 2 7.33 2ZM12.82 12.83H15.66C16.12 12.82 16.49 12.45 16.49 11.99C16.49 11.53 16.12 11.16 15.66 11.16H12.82V8.34C12.82 7.88 12.45 7.51 11.99 7.51C11.53 7.51 11.16 7.88 11.16 8.34V11.16H8.33C8.11 11.16 7.9 11.25 7.74 11.4C7.59 11.56 7.5 11.769 7.5 11.99C7.5 12.45 7.87 12.82 8.33 12.83H11.16V15.66C11.16 16.12 11.53 16.49 11.99 16.49C12.45 16.49 12.82 16.12 12.82 15.66V12.83Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <!-- table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="5%" class="text-center">#</th>
                                                <th scope="col">penerima</th>
                                                <th scope="col">Ket</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="penerima">
                                            <tr class="text-center" id="belum_penerima">
                                                <td colspan="4" class="text-center">Belum ada penerima</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- preview  -->
                <div class="mt-2" id="preview" style="display: none;">
                    <label for="preview" class="form-label">Preview Lampiran</label>
                    <img src="" id="img-preview" class="img-fluid" alt="preview" style="display: none;">
                    <embed src="" id="pdf-preview" type="application/pdf" width="100%" height="600px"
                        style="display: none;">
                </div>

                <hr style="border-top: 1px solid; width: 100%; margin: 1rem 0;" class="mt-4">
                <!-- acordion -->
                <div class="accordion accordion-flush bg-white" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse"
                                data-bs-target="#prevHasilSurat" aria-expanded="true" aria-controls="prevHasilSurat">
                                <h5 class="card-title">Preview Hasil</h5>
                            </button>
                        </h2>
                        <div id="prevHasilSurat" class="accordion-collapse collapse bg-white"
                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body bg-white">
                                <div class="row mb-3">
                                    <div class="col-md-12 mt-1">
                                        <label for="preview_hasil_surat" class="form-label">Preview Hasil
                                            Surat</label>
                                        <textarea class="form-control" id="preview_hasil_surat"
                                            name="preview_hasil_surat" required
                                            placeholder="Preview Hasil Surat"><?= $template; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border-top: 1px solid; width: 100%; margin: 1rem 0;" class="mt-4">
                <!-- kiri slect status kanan update -->
                <form action="<?= base_url('Surat_keluar/updateStatusSuratKeluar'); ?>" method="post"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_surat_keluar" value="<?= $surat_keluar['id_surat_keluar']; ?>">
                    <div class="row mb-3">
                        <div class="col-md-3 mt-3">
                            <label for="status_surat_keluar" class="form-label">Proses Surat</label>
                            <select class="form-select" name="status_surat_keluar" required style="width: 100%;">
                                <option selected>Pilih Proses
                                <option value="1" <?= $surat_keluar['status_surat_keluar'] == '1' ? 'selected' : ''; ?>>
                                    Draft
                                </option>
                                <option value="2" <?= $surat_keluar['status_surat_keluar'] == '2' ? 'selected' : ''; ?>>
                                    Persetujuan & TTD
                                </option>
                                <?php 
                                if($surat_keluar['status_surat_keluar'] == '0'):
                                ?>
                                <option value="0" <?= $surat_keluar['status_surat_keluar'] == '0' ? 'selected' : ''; ?>>
                                    Revisi
                                </option>
                                <?php 
                                endif;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-9 mt-3">
                            <button type="submit" class="btn btn-primary mt-4 float-end">Update</button>
                        </div>
                    </div>
                </form>
                <?php 
                    else:
                    ?>
                <p class="">Tidak ada data detail jenis surat</p>
                <?php 
                    endif;
                    ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('konten'); ?>
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
var data_penerima_penerima = [];

function generatePenerima() {
    // ajax from fetchDetialSuratKeluar
    $.ajax({
        url: '<?= base_url('Surat_keluar/fetchDetialSuratKeluar'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            id_surat_keluar: $('#id_surat_keluar').val()
        },
        success: function(data) {
            // console.log(data);
            if (data.error == false) {
                // alert('data penerima berhasil di ambil');
                data_penerima_penerima = data.data;
                render_penerima();
                // console.log(data_penerima_penerima);
            } else {
                alert(data.message);
            }
        }
    });
}

generatePenerima();

// fungsi untuk meampilkan data penerima yang akan di penerima
function render_penerima() {
    // console.log(data_penerima_penerima);
    $('#penerima').empty();
    if (data_penerima_penerima.length == 0) {
        $('#penerima').append('<tr class="text-center" id="belum_penerima">' +
            '<td colspan="4" class="text-center">Belum ada penerima</td>' +
            '</tr>');
    } else {
        $('#belum_penerima').remove();
        for (var i = 0; i < data_penerima_penerima.length; i++) {
            // console.log(data_penerima_penerima[i].id_detail_surat_keluar);
            $('#penerima').append('<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' + data_penerima_penerima[i].nama_user +
                '<input type="hidden" style="min-width: 100px" name="id_user[]" value="' +
                data_penerima_penerima[i].id_detail_surat_keluar +
                '"></td>' +
                '<td> <input type="text" style="min-width: 100px" class="form-control keterangan_detail_surat_keluar" name="keterangan_detail_surat_keluar[]" data-id="' +
                data_penerima_penerima[i].id_detail_surat_keluar + '" value="' + data_penerima_penerima[i]
                .keterangan_detail_surat_keluar +
                '"></td>' +
                '<td><button type="button" class="btn btn-danger hapus_penerima" data-id="' +
                data_penerima_penerima[i].id_detail_surat_keluar + '">Hapus</button></td>' +
                '</tr>');
        }
    }
}

render_penerima();

// change select jenis_penerima
$('#jenis_penerima').change(function() {
    var jenis_penerima = $(this).val();
    if (jenis_penerima == 'Pegawai' || jenis_penerima == 'External') {
        $('#id_penerima').empty();
        $('#id_penerima').append('<option selected>Pilih penerima</option>');
        $.ajax({
            url: '<?= base_url('Surat_keluar/getJenisPenerima'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                jenis_penerima: jenis_penerima
            },
            success: function(data) {
                // console.log(data);
                if (data.error == false) {
                    // alert('data penerima berhasil di ambil');
                    for (var i = 0; i < data.data.length; i++) {
                        $('#id_penerima').append('<option value="' + data.data[i].id_user +
                            '">' + data.data[i].nama_user + '</option>');
                    }
                } else {
                    alert(data.message);
                }
            }
        });
    } else {
        $('#id_penerima').empty();
        $('#id_penerima').append('<option selected>Pilih penerima</option>');
    }
});

// fungsi untuk menambahkan data penerima yang akan di penerima
$('#tambahPenerima').click(function() {
    var id_penerima = $('#id_penerima').val();
    var nama_penerima = $('#id_penerima option:selected').text();
    // console.log(id_penerima, nama_penerima, id_surat_keluar);
    if (id_penerima == 'Pilih penerima') {
        alert('Pilih penerima');
    } else {
        // jika data penerima sudah ada
        for (var i = 0; i < data_penerima_penerima.length; i++) {
            if (data_penerima_penerima[i].id_user == id_penerima) {
                alert('penerima sudah ada');
                return false;
            }
        }
        $.ajax({
            url: '<?= base_url('Surat_keluar/addDetailSurat'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id_surat_keluar: $('#id_surat_keluar').val(),
                id_user: id_penerima,
                keterangan_detail_surat_keluar: '',
            },
            success: function(data) {
                // console.log(data);
                if (data.error == false) {
                    generatePenerima();
                    sweetalert('success', 'Berhasil', 'Penerima berhasil ditambahkan');
                    $('#id_penerima').val('Pilih penerima');
                } else {
                    alert(data.message);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan');
            }
        });
    }
});


// fungsi untuk menghapus data penerima yang akan di penerima
$(document).on('click', '.hapus_penerima', function() {
    var id_penerima = $(this).data('id');
    $.ajax({
        url: '<?= base_url('Surat_keluar/deleteDetailSuratKeluar'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            id_detail_surat_keluar: id_penerima
        },
        success: function(data) {
            // console.log(data);
            if (data.error == false) {
                sweetalert('success', 'Berhasil', 'Penerima berhasil dihapus');
                generatePenerima();
            } else {
                alert(data.message);
            }
        }
    });
    render_penerima();
});

// fungsi untuk menguabah daa ket penerima
$(document).on('focusout', '.keterangan_detail_surat_keluar', function() {
    var id_penerima = $(this).data('id');
    // alert(id_penerima);
    var keterangan_detail_surat_keluar = $(this).val();
    $.ajax({
        url: '<?= base_url('Surat_keluar/updateKeteranganDetailSuratKeluar'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            id_detail_surat_keluar: id_penerima,
            keterangan_detail_surat_keluar: keterangan_detail_surat_keluar
        },
        success: function(data) {
            // console.log(data);
            if (data.error == false) {
                sweetalert('success', 'Berhasil', 'Penerima berhasil diubah');
            } else {
                alert(data.message);
            }
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

CKEDITOR.replace('preview_hasil_surat', {
    height: '1000px',
    width: '100%',
    baseFloatZIndex: 10005,
    // tidak bisa mengedit
    readOnly: true,
    // hilangkan buttons
    removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,HorizontalRule,SpecialChar,PageBreak,Iframe,About,Save,',
});
</script>
<?= $this->endSection('script'); ?>