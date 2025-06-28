<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<?php 
use App\Models\disposisiModel;

$disposisiModel = new disposisiModel();

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


?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h5 class="card-title">Laporan Surat Masuk</h5>
            </div>
            <div class="header-title">

            </div>
        </div>
        <div class="card-body px-0">
            <div class="row m-2 mb-3">
                <div class="col-12">
                    <form action="<?= base_url('Laporan/Surat_masuk'); ?>" method="post" class="d-flex">
                        <div class="input-group">
                            <label for="tanggal_awal" class="input-group-text">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" class="form-control" value="<?= $tanggal_awal; ?>">
                            <span class="input-group-text">s/d</span>
                            <label for="tanggal_akhir" class="input-group-text">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control" value="<?= $tanggal_akhir; ?>">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row m-2">
                <?php 
            if(!empty($tanggal_awal) && !empty($tanggal_akhir)): ?>
                <div class="col-12">
                    <a href="<?= base_url('Laporan/cetakSuratMasuk/' . $tanggal_awal . '/' . $tanggal_akhir); ?>"
                        class="btn btn-primary mb-3" target="_blank">Cetak Laporan</a>
                </div>
                <?php
            endif;
            ?>
            </div>

            <div class="table-responsive">
                <table id="user-list-table" class="table table-striped data_tables my-2" role="grid"
                    data-bs-toggle="data-table">
                    <thead>
                        <tr class="ligth">
                            <th>#</th>
                            <th>Tanggal diterima</th>
                            <th>Tanggal Surat</th>
                            <th style="text-align: center;">Nomor Surat</th>
                            <th>Perihal</th>
                            <th>Pengirim</th>
                            <th>Ket</th>
                            <th>Disposisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        ?>
                        <?php foreach($surat_masuk as $jns): 
                        $dataDisposisi = $disposisiModel->getDisposisiBySurat($jns['id_surat_masuk']); 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= formatiIndonesia($jns['created_at']); ?></td>
                            <td><?=  ($jns['tgl_surat_masuk'] != null) ? formatiIndonesia($jns['tgl_surat_masuk']) : '-'; ?>
                            <td style="text-align: center;">
                                <?= ($jns['no_surat_masuk'] != null) ? $jns['no_surat_masuk'] : '-'; ?>
                            </td>

                            <td><?= ($jns['perihal_surat_masuk'] != null) ? $jns['perihal_surat_masuk'] : '-'; ?></td>
                            <td><?= ($jns['pengirim_surat_masuk'] != null) ? $jns['pengirim_surat_masuk'] : '-'; ?></td>
                            <td><?= ($jns['ket_surat_masuk'] != null) ? $jns['ket_surat_masuk'] : '-'; ?>
                            </td>
                            <td>
                                <?php if($dataDisposisi): ?>
                                <ul class="list-group">
                                    <?php foreach($dataDisposisi as $disposisi): ?>
                                    <li>
                                        <?= $disposisi['nama_pegawai']; ?> (<?= $disposisi['jabatan_pegawai']; ?>)
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else: ?>
                                <span class="text-muted">Tidak ada disposisi</span>
                                <?php endif; ?>
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