<?php

namespace App\Controllers;
use App\Models\usersModel;
use App\Models\pegawaiModel;
use App\Models\externalModel;
use App\Models\suratKeluarModel;
use App\Models\suratMasukModel;
class Home extends BaseController
{  
    public function index(): string // menampilkan halaman dashboard
    { 
        $usersModel = new usersModel(); // inisialisasi model users
        $pegawaiModel = new pegawaiModel(); // inisialisasi model pegawai
        $externalModel = new externalModel(); // inisialisasi model external
        $suratKeluarModel = new suratKeluarModel(); // inisialisasi model surat keluar
        $suratMasukModel = new suratMasukModel(); // inisialisasi model surat masuk
        if($this->request->getPost('tahun')){ // if year is selected
            $year = $this->request->getPost('tahun'); // get selected year
        }else{
            $year = date('Y'); // get current year
        }
        $data_surat = [];
        for ($i = 1; $i <= 12; $i++) {
            $data_surat_masuk = $suratMasukModel->where('YEAR(created_at)', $year)
                ->where('MONTH(created_at)', $i)
                ->countAllResults(); // hitung jumlah surat masuk per bulan
            $data_surat_keluar = $suratKeluarModel->where('YEAR(tanggal_surat_keluar)', $year)
                ->where('MONTH(tanggal_surat_keluar)', $i)
                ->where('status_surat_keluar', '3') // hanya ambil surat keluar yang sudah diverifikasi
                ->countAllResults(); // hitung jumlah surat keluar per bulan
            $data_surat[] = [
                'bulan' => $i,
                'surat_masuk' => $data_surat_masuk, // jumlah surat masuk per bulan
                'surat_keluar' => $data_surat_keluar // jumlah surat keluar per bulan
            ];
        }
        // dd($data_surat); // debug output untuk data surat per bulan
        $data['total_users'] = $usersModel->countAll(); // hitung total users
        $data['total_pegawai'] = $pegawaiModel->countAll(); // hitung total pegawai
        $data['total_external'] = $externalModel->countAll(); // hitung total external
        $data['total_surat_keluar'] = $suratKeluarModel->where('status_surat_keluar', '3')->countAllResults(); // hitung total surat keluar
        $data['total_surat_masuk'] = $suratMasukModel->countAll(); // hitung total surat masuk
        $data['data_surat'] = $data_surat; // set data surat per bulan ke data array
        $data['tahun'] = $year; // set year in data array
        $data['total_surat'] = $suratKeluarModel->countAll() + $suratMasukModel->countAll(); // hitung total surat
        $data['total_surat_keluar'] = $suratKeluarModel->countAll(); // hitung total surat keluar
        $data['total_surat_masuk'] = $suratMasukModel->countAll(); // hitung total surat masuk
        $data['title'] = 'Dashboard'; // set judul halaman
        $data['active'] = 'dashboard'; // set active menu
        $data['breadcrumb'] = [
            ['label' => 'Dashboard', 'url' => ''], // set breadcrumb parent
        ]; // set breadcrumb
        return view('Admin/Dashboard/index', $data); // tampilkan view dashboard
    }
}