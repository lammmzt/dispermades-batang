<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="header-title">
                    <h4 class="card-title fw-bold">Daftar Referensi</h4>
                </div>
                <div class="card-tools">
                    <a href="#" class=" btn btn-primary btn-md align-items-center float-end" data-bs-toggle="modal"
                        data-bs-target="#addreferensi">
                        Tambah Referensi
                    </a>
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

                <div class="table-responsive">
                    <table id="user-list-table" class="table table-striped data_tables py-2" role="grid"
                        data-bs-toggle="data-table">
                        <thead>
                            <tr class="ligth">
                                <th class="text-center">#</th>
                                <th>Nama Referensi</th>
                                <th>Kode</th>
                                <th>Tipe Inputan</th>
                                <th>Keterangan</th>
                                <th style="min-width: 100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                        $no = 1;
                        ?>
                            <?php foreach($referensi as $rf): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $rf['nama_referensi_jenis_surat']; ?></td>
                                <td><?= $rf['kode_referensi_jenis_surat']; ?></td>
                                <td>
                                    <?php if($rf['tipe_referensi_jenis_surat'] != ''): ?>
                                    <?= $rf['tipe_referensi_jenis_surat']; ?>
                                    <?php else: ?>
                                    Tanpa Inputan
                                    <?php endif; ?>
                                </td>
                                <td><?= $rf['ket_referensi_jenis_surat']; ?></td>

                                <td>
                                    <div class="flex align-items-center list-user-action">
                                        <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal" href="#"
                                            data-bs-target="#editreferensi<?= $rf['id_referensi_jenis_surat']; ?>">
                                            Edit
                                            </span>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addreferensi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addreferensiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addreferensiLabel">Tambah referensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('Referensi/saveReferensi'); ?>" method="post" class="needs-validation"
                        novalidate>
                        <div class="form-group mb-2">
                            <label for="kode_referensi_jenis_surat" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="kode_referensi_jenis_surat"
                                name="kode_referensi_jenis_surat" placeholder="Kode" required
                                value="<?= old('kode_referensi_jenis_surat'); ?>">

                        </div>
                        <div class="form-group mb-2">
                            <label for="nama_referensi_jenis_surat" class="form-label">Nama Referensi</label>
                            <input type="text" class="form-control" id="nama_referensi_jenis_surat"
                                name="nama_referensi_jenis_surat" placeholder="Nama Referensi" required
                                value="<?= old('nama_referensi_jenis_surat'); ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="tipe_referensi_jenis_surat" class="form-label">Tipe Inputan</label>
                            <select class="form-select" id="tipe_referensi_jenis_surat"
                                name="tipe_referensi_jenis_surat">

                                <option value="" <?= (old('tipe_referensi_jenis_surat') == '') ? 'selected' : ''; ?>>
                                    Tanpa
                                    Inputan
                                </option>
                                <option value="input"
                                    <?= (old('tipe_referensi_jenis_surat') == 'input') ? 'selected' : ''; ?>>Input
                                </option>
                                <option value="textarea"
                                    <?= (old('tipe_referensi_jenis_surat') == 'textarea') ? 'selected' : ''; ?>>Textarea
                                </option>
                                <option value="date"
                                    <?= (old('tipe_referensi_jenis_surat') == 'date') ? 'selected' : ''; ?>>Date
                                </option>
                                <option value="datetime"
                                    <?= (old('tipe_referensi_jenis_surat') == 'datetime') ? 'selected' : ''; ?>>Datetime
                                </option>
                                <option value="time"
                                    <?= (old('tipe_referensi_jenis_surat') == 'time') ? 'selected' : ''; ?>>Time
                                </option>
                                <option value="number"
                                    <?= (old('tipe_referensi_jenis_surat') == 'number') ? 'selected' : ''; ?>>Number
                                </option>
                                <option value="ckeditor"
                                    <?= (old('tipe_referensi_jenis_surat') == 'ckeditor') ? 'selected' : ''; ?>>ckeditor
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('tipe_referensi_jenis_surat'); ?>
                            </div>
                        </div>

                        <div class="form-group mb-2 mb-3">
                            <label for="ket_referensi_jenis_surat" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="ket_referensi_jenis_surat"
                                name="ket_referensi_jenis_surat" placeholder="Keterangan" required
                                value="<?= old('ket_referensi_jenis_surat'); ?>"></textarea>
                        </div>

                        <div class="text-start mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- edit -->
    <?php foreach($referensi as $rf): ?>
    <div class="modal fade" id="editreferensi<?= $rf['id_referensi_jenis_surat']; ?>" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="editreferensiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editreferensiLabel">Edit referensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('Referensi/updateReferensi'); ?>" method="post" class="needs-validation"
                        novalidate>
                        <div
                            class="form-group mb-2 <?= ($validation->hasError('kode_referensi_jenis_surat')) ? 'has-error' : ''; ?>">
                            <label for="kode_referensi_jenis_surat" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="kode_referensi_jenis_surat"
                                name="kode_referensi_jenis_surat" placeholder="Kode" required
                                value="<?= $rf['kode_referensi_jenis_surat']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('kode_referensi_jenis_surat'); ?>
                            </div>
                        </div>
                        <input type="hidden" name="id_referensi_jenis_surat"
                            value="<?= $rf['id_referensi_jenis_surat']; ?>">
                        <div class="form-group mb-2
                        <?= ($validation->hasError('nama_referensi_jenis_surat')) ? 'has-error' : ''; ?>">
                            <label for="nama_referensi_jenis_surat" class="form-label">Nama Referensi</label>
                            <input type="text" class="form-control" id="nama_referensi_jenis_surat"
                                name="nama_referensi_jenis_surat" placeholder="Nama Referensi" required
                                value="<?= $rf['nama_referensi_jenis_surat']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_referensi_jenis_surat'); ?>
                            </div>
                        </div>
                        <div class="form-group mb-2
                        <?= ($validation->hasError('tipe_referensi_jenis_surat')) ? 'has-error' : ''; ?>">
                            <label for="tipe_referensi_jenis_surat" class="form-label">Tipe Inputan</label>
                            <select class="form-select" id="tipe_referensi_jenis_surat"
                                name="tipe_referensi_jenis_surat">
                                <option value="" <?= ($rf['tipe_referensi_jenis_surat'] == '') ? 'selected' : ''; ?>>
                                    Tanpa Inputan </option>
                                <option value="input"
                                    <?= ($rf['tipe_referensi_jenis_surat'] == 'input') ? 'selected' : ''; ?>>Input
                                </option>
                                <option value="textarea"
                                    <?= ($rf['tipe_referensi_jenis_surat'] == 'textarea') ? 'selected' : ''; ?>>Textarea
                                </option>
                                <option value="date"
                                    <?= ($rf['tipe_referensi_jenis_surat'] == 'date') ? 'selected' : ''; ?>>Date
                                </option>
                                <option value="datetime"
                                    <?= ($rf['tipe_referensi_jenis_surat'] == 'datetime') ? 'selected' : ''; ?>>Datetime
                                </option>
                                <option value="time"
                                    <?= ($rf['tipe_referensi_jenis_surat'] == 'time') ? 'selected' : ''; ?>>Time
                                </option>
                                <option value="number"
                                    <?= ($rf['tipe_referensi_jenis_surat'] == 'number') ? 'selected' : ''; ?>>Number
                                </option>
                                <option value="ckeditor"
                                    <?= ($rf['tipe_referensi_jenis_surat'] == 'ckeditor') ? 'selected' : ''; ?>>ckeditor
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('tipe_referensi_jenis_surat'); ?>
                            </div>
                        </div>

                        <div class="form-group mb-2 mb-3">
                            <label for="ket_referensi_jenis_surat" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="ket_referensi_jenis_surat"
                                name="ket_referensi_jenis_surat" placeholder="Keterangan" required
                                value="<?= $rf['ket_referensi_jenis_surat']; ?>"><?= $rf['ket_referensi_jenis_surat']; ?></textarea>
                        </div>
                        <div class="text-start mt-3">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

</div>

<?= $this->endSection('content'); ?>