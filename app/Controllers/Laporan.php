<?php 
namespace App\Controllers;

use App\Models\suratKeluarModel;
use App\Models\usersModel;
use App\Models\jenisSuratModel;
use App\Models\detailJenisSuratModel;
use App\Models\detailSuratKeluarModel;
use App\Models\externalModel;
use App\Models\Data_instansiModel;
use App\Models\suratMasukModel;
use App\Models\pegawaiModel;
use App\Models\disposisiModel;
use Ramsey\Uuid\Uuid;

class Laporan extends BaseController
{
    public function Surat_keluar(): string
    {
        $suratKeluarModel = new suratKeluarModel();

        $tanggalAwal = ''; // Inisialisasi tanggal awal
        $tanggalAkhir = ''; // Inisialisasi tanggal akhir
        if($this->request->getPost('tanggal_awal') && $this->request->getPost('tanggal_akhir')) {
            // Ambil tanggal awal dan akhir dari input
            $tanggalAwal = $this->request->getPost('tanggal_awal');
            $tanggalAkhir = $this->request->getPost('tanggal_akhir');

            // Ambil data surat keluar berdasarkan rentang tanggal
            $data['surat_keluar'] = $suratKeluarModel->getSuratByDateRange($tanggalAwal, $tanggalAkhir);
        } else {
            // Jika tidak ada filter tanggal, ambil semua surat keluar
            $data['surat_keluar'] = $suratKeluarModel->getSuratByDateRange('1990-01-01', '1999-12-31');
        }
        $data['title'] = 'Laporan Surat Keluar'; // Set judul halaman
        $data['active'] = 'Laporan_surat_keluar'; // Set menu aktif
        $data['tanggal_awal'] = $tanggalAwal; // Set tanggal awal ke data array
        $data['tanggal_akhir'] = $tanggalAkhir; // Set tanggal akhir ke data array

        return view('Admin/Laporan/Surat_keluar', $data);
    } 

    public function cetakSuratKeluar($tanggalAwal, $tanggalAkhir): string
    {
        $suratKeluarModel = new suratKeluarModel();

        // Ambil data surat keluar berdasarkan rentang tanggal
        if ($tanggalAwal && $tanggalAkhir) {
            $data['surat_keluar'] = $suratKeluarModel->getSuratByDateRange($tanggalAwal, $tanggalAkhir);
        } else {
            // Jika tidak ada filter tanggal, ambil semua surat keluar
            return redirect()->to('/Laporan/Surat_keluar')->with('errors', 'Tanggal awal dan akhir tidak boleh kosong.');
        }
        $data['tanggal_awal'] = $tanggalAwal; // Set tanggal awal ke data array
        $data['tanggal_akhir'] = $tanggalAkhir; // Set tanggal akhir ke data array

        return view('Admin/Laporan/Cetak_Surat_keluar', $data);
    }

    public function Surat_masuk(): string
    {
        $suratMasukModel = new suratMasukModel();

        $tanggalAwal = ''; // Inisialisasi tanggal awal
        $tanggalAkhir = ''; // Inisialisasi tanggal akhir
        if($this->request->getPost('tanggal_awal') && $this->request->getPost('tanggal_akhir')) {
            // Ambil tanggal awal dan akhir dari input
            $tanggalAwal = $this->request->getPost('tanggal_awal');
            $tanggalAkhir = $this->request->getPost('tanggal_akhir');

            // Ambil data surat masuk berdasarkan rentang tanggal
            $data['surat_masuk'] = $suratMasukModel->getSuratByDateRange($tanggalAwal, $tanggalAkhir);
            // dd($data['surat_masuk']); // Debug output untuk data surat masuk
        } else {
            // Jika tidak ada filter tanggal, ambil semua surat masuk
            $data['surat_masuk'] = $suratMasukModel->getSuratByDateRange('1990-01-01', '1999-12-31');
        }
        $data['title'] = 'Laporan Surat Masuk'; // Set judul halaman
        $data['active'] = 'Laporan_surat_masuk'; // Set menu aktif
        $data['tanggal_awal'] = $tanggalAwal; // Set tanggal awal ke data array
        $data['tanggal_akhir'] = $tanggalAkhir; // Set tanggal akhir ke data array

        return view('Admin/Laporan/Surat_masuk', $data);
    }

    public function cetakSuratMasuk($tanggalAwal, $tanggalAkhir): string
    {
        $suratMasukModel = new suratMasukModel();

        // Ambil data surat masuk berdasarkan rentang tanggal
        if ($tanggalAwal && $tanggalAkhir) {
            $data['surat_masuk'] = $suratMasukModel->getSuratByDateRange($tanggalAwal, $tanggalAkhir);
        } else {
            // Jika tidak ada filter tanggal, ambil semua surat masuk
            return redirect()->to('/Laporan/Surat_masuk')->with('errors', 'Tanggal awal dan akhir tidak boleh kosong.');
        }
        $data['tanggal_awal'] = $tanggalAwal; // Set tanggal awal ke data array
        $data['tanggal_akhir'] = $tanggalAkhir; // Set tanggal akhir ke data array

        return view('Admin/Laporan/Cetak_Surat_masuk', $data);
    }
}