<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<?php 
function formatiIndonesia($tanggal)
{
    $hari = [
        'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
    ];
    $bulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $tanggal = strtotime($tanggal);
    $hariIndo = $hari[date('w', $tanggal)];
    $tanggalIndo = date('j', $tanggal);
    $bulanIndo = $bulan[date('n', $tanggal) - 1];
    $tahunIndo = date('Y', $tanggal);
    return "$tanggalIndo $bulanIndo $tahunIndo";
}

function formatNomorSuratKeluar($nomor_surat_keluar, $kode_surat, $tanggal_surat_keluar)
{
    $romawi = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
        6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
        11 => 'XI', 12 => 'XII'
    ];
    $bulan = date('n', strtotime($tanggal_surat_keluar));
    $tahun = date('Y', strtotime($tanggal_surat_keluar));
    if ($nomor_surat_keluar) {
        return $kode_surat . '/' . $nomor_surat_keluar . '/' . $romawi[$bulan] . '/' . $tahun;
    } else {
        return '-';
    }
}
?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title fw-bold">Daftar Surat Keluar</h4>
            </div>
            <div class="header-title">
                <?php 
               if(session()->get('role') == 'Admin') :
                ?>
                <a href="<?= base_url('Surat_keluar/tambah'); ?>"
                    class="btn btn-primary btn-md align-items-center float-end">
                    Tambah
                </a>
                <?php endif; ?>
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
                <table id="user-list-table" class="table table-striped data_tables my-2" role="grid"
                    data-bs-toggle="data-table">
                    <thead>
                        <tr class="ligth">
                            <th>#</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Nomor</th>
                            <th>Pembuat</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th style="min-width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        ?>
                        <?php foreach($surat_keluar as $jns): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= ($jns['judul_surat_keluar'] != null) ? $jns['judul_surat_keluar'] : '-'; ?></td>
                            <td><?= ($jns['tanggal_surat_keluar'] != null) ?  formatiIndonesia($jns['tanggal_surat_keluar']) : '-'; ?>
                            </td>
                            <td><?=  ($jns['nomor_surat_keluar'] != null) ? formatNomorSuratKeluar($jns['nomor_surat_keluar'], $jns['kode_surat'], $jns['tanggal_surat_keluar']) : '-'; ?>
                            </td>
                            <td><?= $jns['nama_user']; ?></td>
                            <td><?= ($jns['keterangan_surat_keluar'] != null) ? $jns['keterangan_surat_keluar'] : '-'; ?>
                            <td>
                                <?php if($jns['status_surat_keluar'] == '1'): ?>
                                <span class="badge bg-secondary">Draf</span>
                                <?php elseif($jns['status_surat_keluar'] == '2'): ?>
                                <span class="badge bg-warning">Persetujuan & TTD</span>
                                <?php elseif($jns['status_surat_keluar'] == '3'): ?>
                                <span class="badge bg-success">Final</span>
                                <?php elseif($jns['status_surat_keluar'] == '4'): ?>
                                <span class="badge bg-danger">Revisi</span>
                                <?php else: ?>
                                <span class="badge bg-danger">Revisi</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="flex align-items-center list-user-action">
                                    <?php 
                                    if(session()->get('role') == 'Admin') :
                                        if($jns['status_surat_keluar'] == '1' || $jns['status_surat_keluar'] == '0') :
                                    ?>
                                    <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Proses Draf"
                                        href="<?= base_url('Surat_keluar/proses/'.$jns['id_surat_keluar']); ?>">
                                        Edit <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <?php 
                                    endif; 
                                    else:
                                        if($jns['status_surat_keluar'] == '2') :
                                    ?>
                                    <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Proses Persetujuan"
                                        href="<?= base_url('Surat_keluar/proses_persetujuan/'.$jns['id_surat_keluar']); ?>">
                                        Proses <i class="bi bi-check2-square"></i>
                                    </a>
                                    <?php 
                                    endif;
                                    endif;
                                    ?>
                                    <!-- detail -->
                                    <a class="btn btn-sm btn-icon btn-info" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Detail"
                                        href="<?= base_url('Surat_keluar/detail/'.$jns['id_surat_keluar']); ?>">
                                        Detail <i class="bi bi-eye"></i>
                                    </a>
                                    <!-- preview -->
                                    <a class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Preview Surat"
                                        href="<?= base_url('Surat_keluar/preview/'.$jns['id_surat_keluar']); ?>"
                                        target="_blank">
                                        Preview <i class="bi bi-file-earmark-text"></i>
                                    </a>
                                    <!-- <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete"
                                        href="<?= base_url('Surat_keluar/delete/'.$jns['id_surat_keluar']); ?>">
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