<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title fw-bold">Daftar Disposisi Surat Masuk</h4>
            </div>
            <div class="header-title">

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
                            <th>Pengirim</th>
                            <th>Perihal</th>
                            <th>Kode</th>
                            <th>Ket</th>
                            <th style="min-width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        ?>
                        <?php foreach($surat_masuk as $jns): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $jns['pengirim_surat_masuk']; ?></td>
                            <td><?= $jns['perihal_surat_masuk']; ?></td>
                            <td><?= $jns['no_surat_masuk']; ?></td>
                            <td><?= $jns['ket_surat_masuk']; ?></td>
                            <td>
                                <div class="flex align-items-center list-user-action">

                                    <!-- detail -->
                                    <a class="btn btn-sm btn-icon btn-info"
                                        href="<?= base_url('Disposisi/detail/'.$jns['id_disposisi']); ?>">
                                        Detail <i class="bi bi-eye-fill"></i>
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
<?= $this->endSection('content'); ?>