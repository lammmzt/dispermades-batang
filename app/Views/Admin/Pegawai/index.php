<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title fw-bold">Daftar Pegawai</h4>
            </div>
            <div class="card-tools">
                <a href="#" class="btn btn-primary btn-md align-items-center float-end" data-bs-toggle="modal"
                    data-bs-target="#addpegawai">
                    Tambah Pegawai
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
                            <th>Username</th>
                            <th>Nama Pegawai</th>
                            <th>NIP</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th style="min-width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        ?>
                        <?php foreach($pegawai as $pgw): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $pgw['username']; ?></td>
                            <td><?= $pgw['nama_pegawai']; ?></td>
                            <td><?= $pgw['nip_pegawai']; ?></td>
                            <td><?= $pgw['jabatan_pegawai']; ?></td>
                            <td>
                                <?php if($pgw['status_pegawai'] == 1): ?>
                                <span class="badge bg-success  p-2">Aktif</span>
                                <?php else: ?>
                                <span class="badge bg-danger  p-2">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="flex align-items-center list-user-action">
                                    <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal" href="#"
                                        data-bs-target="#editpegawai<?= $pgw['id_pegawai']; ?>">
                                        Edit
                                        </span>
                                    </a>
                                    <!-- <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete"
                                        href="<?= base_url('Pegawai/delete/'.$pgw['id_pegawai']); ?>">
                                        <span class="btn-inner">
                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                <path
                                                    d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path
                                                    d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                                    stroke="currentColor" stroke-width="1 5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                    </a> -->
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
<div class="modal fade" id="addpegawai" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addpegawaiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addpegawaiLabel">Tambah Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Pegawai/save'); ?>" method="post" class="needs-validation" novalidate>
                    <div class="form-group mb-2">
                        <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai"
                            placeholder="Nama Pegawai" required value="<?= old('nama_pegawai'); ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="nip_pegawai" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip_pegawai" name="nip_pegawai" placeholder="NIP"
                            required value="<?= old('nip_pegawai'); ?>">
                        <label for="nip_pegawai" class="form-label">Kosongkan jika tidak ada NIP</label>
                    </div>
                    <div class="form-group mb-2">
                        <label for="jabatan_pegawai" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan_pegawai" name="jabatan_pegawai"
                            placeholder="Jabatan" required value="<?= old('jabatan_pegawai'); ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="tempat_lahir_pegawai" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir_pegawai" name="tempat_lahir_pegawai"
                            placeholder="Tempat Lahir" required value="<?= old('tempat_lahir_pegawai'); ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="tgl_lahir_pegawai" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir_pegawai" name="tgl_lahir_pegawai"
                            placeholder="Tanggal Lahir" required value="<?= old('tgl_lahir_pegawai'); ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="alamat_pegawai" class="form-label">Alamat Pegawai</label>
                        <textarea class="form-control" id="alamat_pegawai" name="alamat_pegawai" rows="3"
                            placeholder="Alamat Pegawai" required><?= old('alamat_pegawai'); ?></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="no_tlp_pegawai" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" id="no_tlp_pegawai" name="no_tlp_pegawai"
                            placeholder="No Telepon" required value="<?= old('no_tlp_pegawai'); ?>" maxlength="13">
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
<?php foreach($pegawai as $pgw): ?>
<div class="modal fade" id="editpegawai<?= $pgw['id_pegawai']; ?>" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="editpegawaiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editpegawaiLabel">Edit Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Pegawai/update'); ?>" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="id_pegawai" value="<?= $pgw['id_pegawai']; ?>">
                    <div class="form-group mb-2
                        <?= ($validation->hasError('nama_pegawai')) ? 'has-error' : ''; ?>">
                        <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai"
                            placeholder="Nama Pegawai" required value="<?= $pgw['nama_pegawai']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_pegawai'); ?>
                        </div>
                    </div>
                    <div class="form-group mb-2 <?= ($validation->hasError('nip_pegawai')) ? 'has-error' : ''; ?>">
                        <label for="nip_pegawai" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip_pegawai" name="nip_pegawai" placeholder="NIP"
                            required value="<?= $pgw['nip_pegawai']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nip_pegawai'); ?>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for=" password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            value="<?= old('password'); ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="jabatan_pegawai" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan_pegawai" name="jabatan_pegawai"
                            placeholder="Jabatan" required value="<?= $pgw['jabatan_pegawai']; ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="tempat_lahir_pegawai" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir_pegawai" name="tempat_lahir_pegawai"
                            placeholder="Tempat Lahir" required value="<?= $pgw['tempat_lahir_pegawai']; ?>">
                    </div>
                    <div class="form-group  mb-3">
                        <label for="tgl_lahir_pegawai" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir_pegawai" name="tgl_lahir_pegawai"
                            placeholder="Tanggal Lahir" required value="<?= $pgw['tgl_lahir_pegawai']; ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="alamat_pegawai" class="form-label">Alamat Pegawai</label>
                        <textarea class="form-control" id="alamat_pegawai" name="alamat_pegawai" rows="3"
                            placeholder="Alamat Pegawai" required><?= $pgw['alamat_pegawai']; ?></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="no_tlp_pegawai" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" id="no_tlp_pegawai" name="no_tlp_pegawai"
                            placeholder="No Telepon" required value="<?= $pgw['no_tlp_pegawai']; ?>" maxlength="13">
                    </div>
                    <div class="form-group mb-2">
                        <label for="status_pegawai" class="form-label">Status</label>
                        <select class="form-select" id="status_pegawai" name="status_pegawai" required>
                            <option value="">Pilih Status</option>
                            <option value="1" <?= ($pgw['status_pegawai'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                            <option value="0" <?= ($pgw['status_pegawai'] == 0) ? 'selected' : ''; ?>>Tidak Aktif
                            </option>
                        </select>
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
<?php endforeach; ?>


<?= $this->endSection('konten'); ?>