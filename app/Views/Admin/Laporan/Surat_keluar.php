<?= $this->extend('Template/index') ?>
<?= $this->section('content') ?>
<?php 
use App\Models\detailSuratKeluarModel;

$detailSuratKeluarModel = new detailSuratKeluarModel();

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
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h5 class="card-title">Laporan Surat Keluar</h5>
            </div>
            <div class="header-title">

            </div>
        </div>
        <div class="card-body px-0">
            <div class="row m-2 mb-3">
                <div class="col-12">
                    <form action="<?= base_url('Laporan/Surat_keluar'); ?>" method="post" class="d-flex">
                        <div class="input-group">
                            <label for="tanggal_awal" class="input-group-text">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" class="form-control" value="<?= $tanggal_awal; ?>"
                                required>
                            <span class="input-group-text">s/d</span>
                            <label for="tanggal_akhir" class="input-group-text">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control" value="<?= $tanggal_akhir; ?>"
                                required>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row m-2">
                <?php 
                if(!empty($tanggal_awal) && !empty($tanggal_akhir)): ?>
                <div class="col-12">
                    <a href="<?= base_url('Laporan/cetakSuratKeluar/' . $tanggal_awal . '/' . $tanggal_akhir); ?>"
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
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Tujuan</th>
                            <th>Prihal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        ?>
                        <?php 
                        foreach($surat_keluar as $jns): 
                        $detail = $detailSuratKeluarModel->getDetailSuratKeluarByIdSuratKeluar($jns['id_surat_keluar']);
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?=  formatNomorSuratKeluar($jns['nomor_surat_keluar'], $jns['kode_surat'], $jns['tanggal_surat_keluar']); ?>
                            </td>
                            <td><?= ($jns['tanggal_surat_keluar'] != null) ? formatiIndonesia($jns['tanggal_surat_keluar']) : '-'; ?>
                            </td>

                            <td>
                                <?php if($detail): ?>
                                <ul style="list-style-type: none; padding: 0; margin: 0;">
                                    <?php foreach($detail as $d): ?>
                                    <li style="margin-bottom: 5px;">
                                        <?= $d['nama_user']; ?>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else: ?>
                                <span class="text-muted ">Tidak ada tujuan</span>
                                <?php endif; ?>
                            </td>
                            <td><?= ($jns['judul_surat_keluar'] != null) ? $jns['judul_surat_keluar'] : '-'; ?></td>


                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>