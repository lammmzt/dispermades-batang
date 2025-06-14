<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title fw-bold">Daftar External</h4>
            </div>
            <div class="card-tools">
                <a href="#" class="btn btn-primary btn-md align-items-center float-end" data-bs-toggle="modal"
                    data-bs-target="#addexternal">
                    Tambah External
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
                            <th>#</th>
                            <th>Username</th>
                            <th>Nama external</th>
                            <th>Nama alias</th>
                            <th>Kota</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th style="min-width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        ?>
                        <?php foreach($external as $ext): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $ext['username']; ?></td>
                            <td><?= $ext['nama_external']; ?></td>
                            <td><?= $ext['nama_alias_external']; ?></td>
                            <td><?= $ext['kota_external']; ?></td>
                            <td><?= $ext['alamat_external']; ?></td>
                            <td>
                                <?php if($ext['status_external'] == 1): ?>
                                <span class="badge bg-success  p-2">Aktif</span>
                                <?php else: ?>
                                <span class="badge bg-danger  p-2">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="flex align-items-center list-user-action">
                                    <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal" href="#"
                                        data-bs-target="#editexternal<?= $ext['id_external']; ?>">
                                        Edit
                                    </a>
                                    <!-- <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete"
                                        href="<?= base_url('External/delete/'.$ext['id_external']); ?>">
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
<div class="modal fade" id="addexternal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addexternalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addexternalLabel">Tambah External</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('External/save'); ?>" method="post" class="needs-validation" novalidate>
                    <div class="form-group mb-2">
                        <label for="username" class="form-label">Username login</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                            required value="<?= old('username'); ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="nama_external" class="form-label">Nama external</label>
                        <input type="text" class="form-control" id="nama_external" name="nama_external"
                            placeholder="Nama external" required value="<?= old('nama_external'); ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="nama_alias_external" class="form-label">Nama alias external</label>
                        <input type="text" class="form-control" id="nama_alias_external" name="nama_alias_external"
                            placeholder="Nama alias external" required value="<?= old('nama_alias_external'); ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="kota_external" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="kota_external" name="kota_external"
                            placeholder="Asal kota exteral" required value="<?= old('kota_external'); ?>">
                    </div>

                    <div class="form-group mb-2">
                        <label for="alamat_external" class="form-label">Alamat external</label>
                        <textarea class="form-control" id="alamat_external" name="alamat_external" rows="3"
                            placeholder="Alamat external" required><?= old('alamat_external'); ?></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="no_tlp_external" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" id="no_tlp_external" name="no_tlp_external"
                            placeholder="No Telepon" required value="<?= old('no_tlp_external'); ?>">
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
<?php foreach($external as $ext): ?>
<div class="modal fade" id="editexternal<?= $ext['id_external']; ?>" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="editexternalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editexternalLabel">Edit external</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('External/update'); ?>" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="id_external" value="<?= $ext['id_external']; ?>">
                    <div class="form-group mb-2
                        <?= ($validation->hasError('nama_external')) ? 'has-error' : ''; ?>">
                        <label for="nama_external" class="form-label">Nama external</label>
                        <input type="text" class="form-control" id="nama_external" name="nama_external"
                            placeholder="Nama external" required value="<?= $ext['nama_external']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_external'); ?>
                        </div>
                    </div>
                    <div class="form-group mb-2
                        <?= ($validation->hasError('nama_alias_external')) ? 'has-error' : ''; ?>">
                        <label for="nama_alias_external" class="form-label">Nama alias external</label>
                        <input type="text" class="form-control" id="nama_alias_external" name="nama_alias_external"
                            placeholder="Nama alias external" required value="<?= $ext['nama_alias_external']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_alias_external'); ?>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for=" password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            value="<?= old('password'); ?>">
                    </div>
                    <div class="form-group mb-2<?= ($validation->hasError('kota_external')) ? 'has-error' : ''; ?>">
                        <label for="kota_external" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="kota_external" name="kota_external"
                            placeholder="Kota asal external" required value="<?= $ext['kota_external']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('kota_external'); ?>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="alamat_external" class="form-label">Alamat external</label>
                        <textarea class="form-control" id="alamat_external" name="alamat_external" rows="3"
                            placeholder="Alamat external" required><?= $ext['alamat_external']; ?></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="no_tlp_external" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" id="no_tlp_external" name="no_tlp_external"
                            placeholder="No Telepon" required value="<?= $ext['no_tlp_external']; ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="status_external" class="form-label">Status</label>
                        <select class="form-select" id="status_external" name="status_external" required>
                            <option value="">Pilih Status</option>
                            <option value="1" <?= ($ext['status_external'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                            <option value="0" <?= ($ext['status_external'] == 0) ? 'selected' : ''; ?>>Tidak Aktif
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


<?= $this->endSection('content'); ?>