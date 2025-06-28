<!DOCTYPE html>
<html lang="en">
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Keluar Periode <?= date('d-m-Y', strtotime($tanggal_awal)) ?> s/d
        <?= date('d-m-Y', strtotime($tanggal_akhir)) ?></title>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    h2 {
        text-align: center;
    }

    p {
        margin-top: 0;
        margin-bottom: 5px;
    }

    .table-header {
        width: 100%;
        margin-top: 0px;
    }

    .table-header tr:nth-child(even) {
        background-color: white;
    }

    .table-header td {
        padding: 5px;
    }

    .table-header td:first-child {
        padding-top: 0;
    }

    .table-header td:last-child {
        padding-bottom: 2px;
    }

    table {
        width: 99%;
        border-collapse: collapse;
    }

    table th {
        background-color: #f2f2f2;
        color: black;
    }

    table th,
    table td {
        padding: 8px;
        text-align: left;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }


    /* repeat .kop surat */
    .kop_surat {
        text-align: center;
        margin-bottom: 20px;
    }

    .kop_surat img {
        width: 100%;
        height: 150px;
    }

    /* table td auto fit  */
    table td {
        word-wrap: break-word;
        max-width: 200px;
        /* Set a max width for the cells */
    }

    /* media a4 */
    @page {
        size: 297mm 210mm;
    }
    </style>
    <script>
    window.print();

    window.onafterprint = function() {
        window.close();
    }
    </script>

<body>

    <div class="kop_surat">
        <img src="<?= base_url('Assets/img/KOP SURAT DISPERMADES BATANG.png') ?>" alt=""
            style="width: 100%; height: 130px;">
        <table border="0" cellpadding="5" cellspacing="0" class="table-header">
            <tr>
                <td colspan="2">
                    <h2>Laporan Surat Keluar Periode <?= date('d-m-Y', strtotime($tanggal_awal)) ?> s/d
                        <?= date('d-m-Y', strtotime($tanggal_akhir)) ?></h2>
                </td>
            </tr>

        </table>
    </div>
    <table border="1" cellpadding="5" cellspacing="0" style="margin: 0 auto; width: 95%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Nomor Surat</th>
                <th style="text-align: center">Tanggal</th>
                <th style="text-align: center">Tujuan</th>
                <th style="text-align: center">Prihal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            ?>
            <?php foreach($surat_keluar as $jns): ?>
            <tr>
                <td style="text-align: center"><?= $no++; ?></td>
                <td style="text-align: center">
                    <?= formatNomorSuratKeluar($jns['nomor_surat_keluar'], $jns['kode_surat'], $jns['tanggal_surat_keluar']); ?>
                </td>
                <td style="text-align: center">
                    <?= ($jns['tanggal_surat_keluar'] != null) ? formatiIndonesia($jns['tanggal_surat_keluar']) : '-'; ?>
                </td>
                <td>
                    <?php if($detail = $detailSuratKeluarModel->getDetailSuratKeluarByIdSuratKeluar($jns['id_surat_keluar'])): ?>
                    <ul style="list-style-type: none; padding: 0; margin: 0;">
                        <?php foreach($detail as $d): ?>
                        <li style="margin-bottom: 5px;">
                            <?= $d['nama_user']; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <span class="text-muted">Tidak ada tujuan</span>
                    <?php endif; ?>
                </td>
                <td><?= ($jns['judul_surat_keluar'] != null) ? $jns['judul_surat_keluar'] : '-'; ?></td>

            </tr>

            <?php endforeach; ?>

        </tbody>
    </table>


</body>

</html>