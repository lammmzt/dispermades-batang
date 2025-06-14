<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title fw-bold">Daftar Jenis Surat</h4>
            </div>
            <div class="card-tools">
                <a href="<?= base_url('Jenis_surat/tambah'); ?>" class="btn btn-primary align-items-center float-end">
                    Tambah Jenis Surat
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
                            <th class="text-left">Nama Jenis Surat</th>
                            <th class="text-center">Kode Surat</th>
                            <th>Ket</th>
                            <th style="min-width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        ?>
                        <?php foreach($jenis_surat as $jns): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-left"><?= $jns['nama_jenis_surat']; ?></td>
                            <td class="text-center"><?= $jns['kode_surat']; ?></td>
                            <td><?= $jns['ket_jenis_surat']; ?></td>
                            <td>
                                <div class="flex align-items-center list-user-action">
                                    <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Edit"
                                        href="<?= base_url('Jenis_surat/edit/'.$jns['id_jenis_surat']); ?>">
                                        Proses <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="btn btn-sm btn-icon btn-secondary" title="Copy" data-bs-toggle="modal"
                                        href="#" data-bs-target="#copyModal<?= $jns['id_jenis_surat']; ?>">
                                        Copy <i class="bi bi-files"></i>
                                    </a>
                                    <!-- <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete"
                                        href="<?= base_url('Jenis_surat/delete/'.$jns['id_jenis_surat']); ?>">
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
<!-- modal copyy template -->
<?php 
foreach($jenis_surat as $jns): ?>
<div class="modal fade" id="copyModal<?= $jns['id_jenis_surat']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Copy Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin ingin menyalin template ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="<?= base_url('Jenis_surat/Duplicated/'.$jns['id_jenis_surat']); ?>"
                    class="btn btn-primary">Copy</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?= $this->endSection('content'); ?>