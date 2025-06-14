<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title fw-bold">Daftar Surat Masuk</h4>
            </div>
            <div class="card-tools">
                <?php 
                if(session()->get('role') == 'Admin') :
                ?>
                <a href="<?= base_url('Surat_masuk/tambah'); ?>"
                    class="btn btn-primary btn-md align-items-center float-end">
                    Tambah Surat Masuk
                </a>
                <?php 
                endif;
                ?>
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
                            <th>Nomor Surat</th>
                            <th>Tanggal Surat</th>
                            <?php 
                            if(session()->get('role') == 'Kadin') :
                            ?>
                            <th>Status</th>
                            <?php 
                            endif;
                            ?>
                            <th>Pengirim</th>
                            <th>Perihal</th>
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
                            <td><?= $jns['no_surat_masuk']; ?></td>
                            <td><?= date('d-m-Y', strtotime($jns['tgl_surat_masuk'])); ?></td>
                            <?php
                            if(session()->get('role') == 'Kadin') :
                            ?>
                            <td>
                                <?php if($jns['status_surat_masuk'] == '0'): ?>
                                <span class="badge bg-danger">Belum dibaca</span>
                                <?php else: ?>
                                <span class="badge bg-success">Sudah dibaca</span>
                                <?php endif; ?>
                            </td>
                            <?php
                            endif;
                            ?>
                            <td><?= $jns['pengirim_surat_masuk']; ?></td>
                            <td><?= $jns['perihal_surat_masuk']; ?></td>
                            <td><?= $jns['ket_surat_masuk']; ?></td>
                            <td>
                                <div class="flex align-items-center list-user-action">
                                    <?php 
                                        if(session()->get('role') == 'Admin') :
                                    ?>
                                    <a class="btn btn-sm btn-icon btn-warning"
                                        href="<?= base_url('Surat_masuk/edit/'.$jns['id_surat_masuk']); ?>">
                                        Edit
                                    </a>
                                    <?php
                                    endif;
                                    ?>
                                    <!-- detail -->
                                    <a class="btn btn-sm btn-icon btn-info"
                                        href="<?= base_url('Surat_masuk/detail/'.$jns['id_surat_masuk']); ?>">
                                        Detail
                                    </a>
                                    <!-- <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete"
                                        href="<?= base_url('Surat_masuk/delete/'.$jns['id_surat_masuk']); ?>">
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
<?= $this->endSection('content'); ?>