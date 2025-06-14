<?php 
namespace App\Controllers;

use App\Models\suratKeluarModel;
use App\Models\usersModel;
use App\Models\jenisSuratModel;
use App\Models\detailJenisSuratModel;
use App\Models\detailSuratKeluarModel;
use App\Models\externalModel;
use App\Models\Data_instansiModel;
use Ramsey\Uuid\Uuid;
use Mpdf\Mpdf; 
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;

class Surat_keluar extends BaseController
{ 
    public function index() // menampilkan data surat keluar
    { 
        $suratKeluarModel = new suratKeluarModel(); // membuat objek model surat keluar
        if(session()->get('role') == 'Kadin') { // jika session role kosong
            $data_surat_keluar = $suratKeluarModel->getSuratkeluar()->where('surat_keluar.status_surat_keluar !=', '1')->findAll(); // mengambil data surat keluar
            
        }else {
            $data_surat_keluar = $suratKeluarModel->getSuratkeluar()->findAll(); // mengambil data surat keluar
            
        }
        // dd($jml_surat_keluar);
        $data['surat_keluar'] = $data_surat_keluar; // mengambil semua data surat keluar
        $data['title'] = 'Surat keluar'; // set judul halaman 
        $data['active'] = 'Surat_keluar'; // set active menu
        $data['validation'] = \Config\Services::validation(); // set validasi
        
        return view('Admin/surat_keluar/index', $data); // tampilkan view surat keluar
    }

    public function tambah() // menampilkan form tambah surat keluar
    { 
        $jenisSuratModel = new jenisSuratModel(); // membuat objek model jenis surat
        $detailJenisSuratModel = new detailJenisSuratModel(); // membuat objek model detail jenis surat
        if($this->request->getPost('id_jenis_surat')){
            $id_jenis_surat = $this->request->getPost('id_jenis_surat'); // mengambil id jenis surat keluar
            $data_jenis_surat = $jenisSuratModel->find($id_jenis_surat); // mengambil data jenis surat keluar berdasarkan id
            $dataDetailJenisSurat = $detailJenisSuratModel->geDetailByJenisSurat($id_jenis_surat); // mengambil data detail jenis surat keluar berdasarkan id
            // dd($dataDetailJenisSurat, $data_jenis_surat, $id_jenis_surat);
        }else{
            $id_jenis_surat = ''; // set id jenis surat keluar
            $data_jenis_surat = ''; // set jenis surat keluar
            $dataDetailJenisSurat = ''; // set data detail jenis surat keluar
        }
        $pegawaiModel = new jenissuratModel(); // membuat objek model jenis surat
        $data['title'] = 'Tambah Surat keluar'; // untuk set judul halaman
        $data['active'] = 'Surat_keluar'; // set active menu  
        $data['jenis_surat'] = $jenisSuratModel->findAll(); // mengambil semua data jenis surat yang statusnya aktif
        $data['data_jenis_surat'] = $data_jenis_surat; // set jenis surat keluar
        $data['dataDetailJenisSurat'] = $dataDetailJenisSurat; // set data detail jenis surat keluar
        $data['id_jenis_surat'] = $id_jenis_surat; // set id jenis surat keluar
        $data['validation'] = \Config\Services::validation(); // set validasi
        
        return view('Admin/surat_keluar/tambah', $data); // tampilkan view tambah surat keluar
    }

    public function getJenisPenerima() // menampilkan data jenis penerima
    {   
        $userModel = new usersModel(); // membuat objek model users
        $jenis_penerima = $this->request->getPost('jenis_penerima'); // mengambil jenis penerima
        $data = $userModel->where('role', $jenis_penerima)->where('status_user', '1')->findAll(); // mengambil data users berdasarkan role dan status
        if ($data) { // jika data ada
            return $this->response->setJSON([ // set response json
                'error' => false, // set error
                'status' => 200, // set status
                'data' => $data // set data
            ]);
        } else {
            return $this->response->setJSON([ // set response json
                'error' => true, // set error
                'status' => 404, // set status
                'message' => 'Data tidak ditemukan' // set message
            ]);
        }
    }
    
    public function save() // menyimpan data surat keluar
    {
        $model = new suratKeluarModel(); // membuat objek model surat keluar
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail jenis surat
        $validation = \Config\Services::validation(); // membuat objek validasi
        // dd($this->request->getPost());
        // upload file surat 
        $fileSurat = $this->request->getFile('file_lampiran'); // mengambil file surat
        if($fileSurat->getError() == 4) { // jika tidak ada file surat yang diupload
            $newName = ''; // set nama file surat
        } else {
            $newName = $fileSurat->getRandomName(); // generate nama file random
            $fileSurat->move('Assets/file_lampiran_surat_keluar/', $newName); // pindahkan file surat ke folder lampiran_surat_keluar
        }
        
        $isian_surat_keluar = [];
        foreach ($this->request->getPost() as $key => $value) { // loop data surat keluar
            // jika ada {} maka masukan ke dalam array
            if (strpos($key, '{') !== false) { // jika ada {} pada key
                $key = str_replace(['{', '}'], '', $key); // hapus karakter { dan }
                $isian_surat_keluar[$key] = $value; // masukkan ke dalam array
            }
        }
        // dd($isian_surat_keluar);
        $id_surat_keluar = 'SK-' . date('YmdHis') . '-' . rand(10, 100); // generate id surat keluar

        $data_surat_keluar = [ // data surat keluar
            'id_surat_keluar' => $id_surat_keluar, // set id surat keluar
            'id_user' => session()->get('id_user'), // set id user
            'id_jenis_surat' => $this->request->getPost('id_jenis_surat'), // set id jenis surat keluar
            'isian_surat_keluar' => json_encode($isian_surat_keluar), // set isian surat keluar
            'judul_surat_keluar' => $this->request->getPost('judul_surat_keluar'), // set judul surat keluar
            'no_surat_keluar' => $this->request->getPost('no_surat_keluar'), // set no surat keluar
            'status_surat_keluar' => '1', // set status surat keluar
            'keterangan_surat_keluar' => $this->request->getPost('keterangan_surat_keluar'), // set keterangan surat keluar
            'lampiran_surat_keluar' => $newName, // set nama file lampiran surat
            'tipe_lampiran_surat_keluar' => $this->request->getPost('tipe_lampiran_surat_keluar'), // set tipe lampiran surat
            'created_at' => date('Y-m-d H:i:s') // set tanggal dibuat
        ];
        
        $model->insert($data_surat_keluar); // insert data surat keluar
        
        // jika ada id pegawai yang dipilih
        if ($this->request->getPost('id_user')) {
            $id_user = $this->request->getPost('id_user'); // mengambil id pegawai
            if($id_user != null || $id_user != ''){ // jika id pegawai tidak kosong
                $keterangan_detail_surat_keluar = $this->request->getPost('keterangan_detail_surat_keluar'); // mengambil keterangan disposisi
            
                foreach ($id_user as $key => $value) { // loop data pegawai
                    $detailSuratKeluar->save([ // insert data detail surat keluar
                        'id_surat_keluar' => $id_surat_keluar, // set id surat keluar 
                        'id_user' => $value, // set id pegawai
                        'status_detail_surat_keluar' => '0', // set status disposisi
                        'keterangan_detail_surat_keluar' => $keterangan_detail_surat_keluar[$key], // set keterangan disposisi
                        'created_at' => date('Y-m-d H:i:s') // set tanggal dibuat
                    ]);
                }
            }
        }
        
        session()->setFlashdata('success', 'Data Surat keluar berhasil ditambahkan'); // set flashdata success
        return redirect()->to('/surat_keluar'); // redirect ke halaman surat keluar
    }

    public function proses($id) // menampilkan form edit surat keluar
    {
        $jenisSuratModel = new jenisSuratModel(); // membuat objek model jenis surat
        $detailJenisSuratModel = new detailJenisSuratModel(); // membuat objek model detail jenis surat
        $suratKeluarModel = new suratKeluarModel(); // membuat objek model surat keluar
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail jenis surat
        $dataInstansiModel = new Data_instansiModel();
        $data_surat_keluar = $suratKeluarModel->getSuratkeluar($id)->first(); // mengambil data surat keluar berdasarkan id
        
        $id_jenis_surat = $data_surat_keluar['id_jenis_surat']; // set id jenis surat keluar
        $data_jenis_surat = $jenisSuratModel->find($id_jenis_surat); // mengambil data jenis surat keluar berdasarkan id
        $dataDetailJenisSurat = $detailJenisSuratModel->geDetailByJenisSurat($id_jenis_surat); // mengambil data detail jenis surat keluar berdasarkan id
        
    
        $dataInstansi = $dataInstansiModel->first();
    
        // Ambil template surat
        $template = $data_surat_keluar['template_jenis_surat'];
    
        // Ambil isian surat keluar (format JSON)
        $isian = json_decode($data_surat_keluar['isian_surat_keluar'], true);
    
        // Gabungkan dengan data instansi
        $isian['nama_instansi'] = $dataInstansi['nama_instansi'];
        $isian['nama_kepala_instansi'] = $dataInstansi['nama_kepala_instansi'];
        $isian['nip_kepala_instansi'] = $dataInstansi['nip_kepala_instansi'];
        // $isian['ttd_kepala'] = '<img src="' . base_url('Assets/ttd_surat/coba_ttd.png') . '" width="150px">';
    
        // Ganti {placeholder} di template
        foreach ($isian as $key => $val) {
            $template = str_replace('{' . $key . '}', $val, $template);
        }

        $data['title'] = 'Proses Surat keluar'; // untuk set judul halaman
        $data['active'] = 'Surat_keluar'; // set active menu  
        $data['jenis_surat'] = $jenisSuratModel->findAll(); // mengambil semua data jenis surat yang statusnya aktif
        $data['data_jenis_surat'] = $data_jenis_surat; // set jenis surat keluar
        $data['surat_keluar'] = $data_surat_keluar; // set data surat keluar
        $data['data_instansi'] = $dataInstansi; // set data instansi
        $data['template'] = $template; // set template surat
        $data['detail_surat_keluar'] = $detailSuratKeluar->getDetailSuratKeluar($id); // mengambil data detail surat keluar berdasarkan id
        $data['dataDetailJenisSurat'] = $dataDetailJenisSurat; // set data detail jenis surat keluar
        $data['id_jenis_surat'] = $id_jenis_surat; // set id jenis surat keluar
        $data['validation'] = \Config\Services::validation(); // set validasi
        // dd($data);
        // dd($data);
        return view('Admin/surat_keluar/edit', $data); // tampilkan view edit surat keluar
    }
    
    public function updateDataIsian() // menyimpan data surat keluar
    {
        $model = new suratKeluarModel(); // membuat objek model surat keluar
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail jenis surat
        $validation = \Config\Services::validation(); // membuat objek validasi
        // dd($this->request->getPost());
        // upload file surat 
        $id_surat_keluar = $this->request->getPost('id_surat_keluar'); // mengambil id surat keluar
        $fileSurat = $this->request->getFile('file_lampiran'); // mengambil file surat
        $data_surat_keluar = $model->find($id_surat_keluar); // mengambil data surat keluar berdasarkan id
        if($fileSurat->getError() == 4) { // jika tidak ada file surat yang diupload
            $newName = $data_surat_keluar['lampiran_surat_keluar']; // set nama file surat
        } else {
            if($data_surat_keluar['lampiran_surat_keluar'] != null || $data_surat_keluar['lampiran_surat_keluar'] != ''){ // jika ada file surat yang diupload
                unlink('Assets/file_lampiran_surat_keluar/' . $data_surat_keluar['lampiran_surat_keluar']); // hapus file surat yang lama
            }
            $newName = $fileSurat->getRandomName(); // generate nama file random
            $fileSurat->move('Assets/file_lampiran_surat_keluar/', $newName); // pindahkan file surat ke folder lampiran_surat_keluar
        }
        
        $isian_surat_keluar = [];
        foreach ($this->request->getPost() as $key => $value) { // loop data surat keluar
            // jika ada {} maka masukan ke dalam array
            if (strpos($key, '{') !== false) { // jika ada {} pada key
                $key = str_replace(['{', '}'], '', $key); // hapus karakter { dan }
                $isian_surat_keluar[$key] = $value; // masukkan ke dalam array
            }
        }
        // dd($isian_surat_keluar);

        $data_surat_keluar = [ // data surat keluar
            'id_user' => session()->get('id_user'), // set id user
            'id_jenis_surat' => $this->request->getPost('id_jenis_surat'), // set id jenis surat keluar
            'isian_surat_keluar' => json_encode($isian_surat_keluar), // set isian surat keluar
            'no_surat_keluar' => $this->request->getPost('no_surat_keluar'), // set no surat keluar
            'status_surat_keluar' => '1', // set status surat keluar
            'judul_surat_keluar' => $this->request->getPost('judul_surat_keluar'), // set judul surat keluar
            'keterangan_surat_keluar' => $this->request->getPost('keterangan_surat_keluar'), // set keterangan surat keluar
            'lampiran_surat_keluar' => $newName, // set nama file lampiran surat
            'tipe_lampiran_surat_keluar' => $this->request->getPost('tipe_lampiran_surat_keluar'), // set tipe lampiran surat
            'created_at' => date('Y-m-d H:i:s') // set tanggal dibuat
        ];
        
        $model->update($id_surat_keluar, $data_surat_keluar); // insert data surat keluar
        
        
        session()->setFlashdata('success', 'Data Surat keluar berhasil diubah'); // set flashdata success
        return redirect()->to('surat_keluar/proses/' . $id_surat_keluar); // redirect ke halaman surat keluar
    }

    public function updateStatusSuratKeluar(){
        $id_surat_keluar = $this->request->getPost('id_surat_keluar'); // mengambil id surat keluar
        $model = new suratKeluarModel(); // membuat objek model surat keluar
        $data = [
            'status_surat_keluar' => $this->request->getPost('status_surat_keluar'), // set status surat keluar
            'updated_at' => date('Y-m-d H:i:s') // set tanggal diubah
        ];
        $model->update($id_surat_keluar, $data); // update data surat keluar
        session()->setFlashdata('success', 'Status Surat keluar berhasil diubah'); // set flashdata success
        return redirect()->to('surat_keluar'); // redirect ke halaman surat keluar
    }

    public function preview($id) // menampilkan preview surat keluar
    {
        $jenisSuratModel = new jenisSuratModel(); // membuat objek model jenis surat
        $detailJenisSuratModel = new detailJenisSuratModel(); // membuat objek model detail jenis surat
        $suratKeluarModel = new suratKeluarModel(); // membuat objek model surat keluar
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail jenis surat
        $dataInstansiModel = new Data_instansiModel();
        $data_surat_keluar = $suratKeluarModel->getSuratkeluar($id)->first(); // mengambil data surat keluar berdasarkan id
        
        $id_jenis_surat = $data_surat_keluar['id_jenis_surat']; // set id jenis surat keluar
        $data_jenis_surat = $jenisSuratModel->find($id_jenis_surat); // mengambil data jenis surat keluar berdasarkan id
        $dataDetailJenisSurat = $detailJenisSuratModel->geDetailByJenisSurat($id_jenis_surat); // mengambil data detail jenis surat keluar berdasarkan id
        $bulan_indo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; // array bulan indo
            
    
        $dataInstansi = $dataInstansiModel->first();
    
        // Ambil template surat
        $template = $data_surat_keluar['template_jenis_surat'];
    
        // Ambil isian surat keluar (format JSON)
        $isian = json_decode($data_surat_keluar['isian_surat_keluar'], true);
    
        // Gabungkan dengan data instansi
        $isian['nama_instansi'] = $dataInstansi['nama_instansi'];
        $isian['nama_kepala_instansi'] = $dataInstansi['nama_kepala_instansi'];
        $isian['nip_kepala_instansi'] = $dataInstansi['nip_kepala_instansi'];
    
        // Ganti {placeholder} di template
        foreach ($isian as $key => $val) {
            if (strpos($key, 'tanggal') !== false) { // jika ada {} pada key
                    $val = date('d', strtotime($val)) . ' ' . $bulan_indo[date('n', strtotime($val)) - 1] . ' ' . date('Y', strtotime($val)); // format tanggal surat keluar
            }
            $template = str_replace('{' . $key . '}', $val, $template);
        }
        if($data_surat_keluar['final_dokumen_surat_keluar'] != null ){
            $template = $data_surat_keluar['final_dokumen_surat_keluar'];
        }
        $data['title'] = 'Detail Surat keluar'; // untuk set judul halaman
        $data['active'] = 'Surat_keluar'; // set active menu  
        $data['jenis_surat'] = $jenisSuratModel->findAll(); // mengambil semua data jenis surat yang statusnya aktif
        $data['data_jenis_surat'] = $data_jenis_surat; // set jenis surat keluar
        $data['surat_keluar'] = $data_surat_keluar; // set data surat keluar
        $data['data_instansi'] = $dataInstansi; // set data instansi
        $data['template'] = $template; // set template surat
        $data['detail_surat_keluar'] = $detailSuratKeluar->getDetailSuratKeluarByIdSuratKeluar($id); // mengambil data detail surat keluar berdasarkan id
        $data['dataDetailJenisSurat'] = $dataDetailJenisSurat; // set data detail jenis surat keluar
        $data['id_jenis_surat'] = $id_jenis_surat; // set id jenis surat keluar
        $data['validation'] = \Config\Services::validation(); // set validasi
        // dd($data);
        return view('Admin/surat_keluar/print_prev', $data); // tampilkan view edit surat keluar
    }
    
    public function previewPDF($id)
    {
        $jenisSuratModel = new jenisSuratModel();
        $detailJenisSuratModel = new detailJenisSuratModel();
        $suratKeluarModel = new suratKeluarModel();
        $detailSuratKeluar = new detailSuratKeluarModel();
        $dataInstansiModel = new Data_instansiModel();
    
        $dataInstansi = $dataInstansiModel->first();
        $data_surat_keluar = $suratKeluarModel->getSuratkeluar($id)->first();
        $id_jenis_surat = $data_surat_keluar['id_jenis_surat'];
        $dataDetailJenisSurat = $detailJenisSuratModel->geDetailByJenisSurat($id_jenis_surat); // mengambil data detail jenis surat keluar berdasarkan id
        
        // Ambil template surat
        $template = $data_surat_keluar['template_jenis_surat'];
    
        // Ambil isian surat keluar (format JSON)
        $isian = json_decode($data_surat_keluar['isian_surat_keluar'], true);
    
        // Gabungkan dengan data instansi
        $isian['nama_instansi'] = $dataInstansi['nama_instansi'];
        $isian['nama_kepala_instansi'] = $dataInstansi['nama_kepala_instansi'];
        $isian['nip_kepala_instansi'] = $dataInstansi['nip_kepala_instansi'];
    
        // Ganti {placeholder} di template
        foreach ($isian as $key => $val) {
            $template = str_replace('{' . $key . '}', $val, $template);
        }
        
        $template = str_replace('<style>', '<style>body{font-family: "Times New Roman", Times, serif !important; font-size: 12px !important;}', $template);
        
        if($dataDetailSurat != null || $dataDetailSurat != ''){ // jika ada data detail surat keluar
            $list = '<ol style="margin: 0px; padding: 0px;">';
            foreach ($dataDetailSurat as $key => $value) { // loop data detail surat keluar
                $list .= '<li style="padding: 1px;">' . $value['nama_user'] . '</li>'; // masukkan ke dalam list
            }
            $list .= '</ol>';
            $template = str_replace('{' . 'nama_penerima' . '}', $list, $template); // ganti {nama_penerima} dengan list
        }else{
            $template = str_replace('{' . 'nama_penerima' . '}', '', $template); // ganti {nama_penerima} dengan kosong
        }
        // Buat PDF dari HTML
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($template);
    
        // Tampilkan langsung di browser
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="preview_surat.pdf"')
            ->setBody($mpdf->Output('', 'S'));
    }

    public function detail($id) // menampilkan form edit surat keluar
    {
        $jenisSuratModel = new jenisSuratModel(); // membuat objek model jenis surat
        $detailJenisSuratModel = new detailJenisSuratModel(); // membuat objek model detail jenis surat
        $suratKeluarModel = new suratKeluarModel(); // membuat objek model surat keluar
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail jenis surat
        $dataInstansiModel = new Data_instansiModel();
        $data_surat_keluar = $suratKeluarModel->getSuratkeluar($id)->first(); // mengambil data surat keluar berdasarkan id
        
        $id_jenis_surat = $data_surat_keluar['id_jenis_surat']; // set id jenis surat keluar
        $data_jenis_surat = $jenisSuratModel->find($id_jenis_surat); // mengambil data jenis surat keluar berdasarkan id
        $dataDetailJenisSurat = $detailJenisSuratModel->geDetailByJenisSurat($id_jenis_surat); // mengambil data detail jenis surat keluar berdasarkan id
        
    
        $dataInstansi = $dataInstansiModel->first();
    
        // Ambil template surat
        $template = $data_surat_keluar['template_jenis_surat'];
    
        // Ambil isian surat keluar (format JSON)
        $isian = json_decode($data_surat_keluar['isian_surat_keluar'], true);
        $dataDetailSurat =$detailSuratKeluar->getDetailSuratKeluarByIdSuratKeluar($id);
        // Gabungkan dengan data instansi
        $isian['nama_instansi'] = $dataInstansi['nama_instansi'];
        $isian['nama_kepala_instansi'] = $dataInstansi['nama_kepala_instansi'];
        $isian['nip_kepala_instansi'] = $dataInstansi['nip_kepala_instansi'];
    
        // Ganti {placeholder} di template
        foreach ($isian as $key => $val) {
            $template = str_replace('{' . $key . '}', $val, $template);
        }
        if($data_surat_keluar['final_dokumen_surat_keluar'] != null ){
            $template = $data_surat_keluar['final_dokumen_surat_keluar'];
        }


        // tambahkan data tersebut kedalam template surat
        if($dataDetailSurat != null || $dataDetailSurat != ''){ // jika ada data detail surat keluar
            $list = '<ol style="margin: 0px; padding: 0px;">';
            foreach ($dataDetailSurat as $key => $value) { // loop data detail surat keluar
                $list .= '<li style="padding: 1px;">' . $value['nama_user'] . '</li>'; // masukkan ke dalam list
            }
            $list .= '</ol>';
            $template = str_replace('{' . 'nama_penerima' . '}', $list, $template); // ganti {nama_penerima} dengan list
        }else{
            $template = str_replace('{' . 'nama_penerima' . '}', '', $template); // ganti {nama_penerima} dengan kosong
        }
        
        $template = str_replace('{' . 'tempat_penerima' . '}', 'Tempat', $template); // ganti {tempat_penerima} dengan kosong
        $data['title'] = 'Detail Surat keluar'; // untuk set judul halaman
        $data['active'] = 'Surat_keluar'; // set active menu  
        $data['jenis_surat'] = $jenisSuratModel->findAll(); // mengambil semua data jenis surat yang statusnya aktif
        $data['data_jenis_surat'] = $data_jenis_surat; // set jenis surat keluar
        $data['surat_keluar'] = $data_surat_keluar; // set data surat keluar
        $data['data_instansi'] = $dataInstansi; // set data instansi
        $data['template'] = $template; // set template surat
        $data['detail_surat_keluar'] = $dataDetailSurat; // mengambil data detail surat keluar berdasarkan id
        $data['dataDetailJenisSurat'] = $dataDetailJenisSurat; // set data detail jenis surat keluar
        $data['id_jenis_surat'] = $id_jenis_surat; // set id jenis surat keluar
        $data['validation'] = \Config\Services::validation(); // set validasi
        // dd($data);
        // dd($data);
        return view('Admin/surat_keluar/detail', $data); // tampilkan view edit surat keluar
    }
    
    public function fetchDetialSuratKeluar() // menampilkan data detail surat keluar
    {
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail surat keluar
        $id_surat_keluar = $this->request->getPost('id_surat_keluar'); // mengambil id surat keluar
        $data = $detailSuratKeluar->getDetailSuratKeluarByIdSuratKeluar($id_surat_keluar); // mengambil data detail surat keluar berdasarkan id
        return $this->response->setJSON([ // set response json
            'error' => false, // set error
            'status' => 200, // set status
            'data' => $data // set data
        ]);
    }

    public function addDetailSurat(){
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail surat keluar
        $data = [
            'id_surat_keluar' => $this->request->getPost('id_surat_keluar'), // mengambil id surat keluar
            'id_user' => $this->request->getPost('id_user'), // mengambil id user
            'status_detail_surat_keluar' => '0', // set status detail surat keluar
            'keterangan_detail_surat_keluar' => $this->request->getPost('keterangan_detail_surat_keluar'), // mengambil keterangan detail surat keluar
            'created_at' => date('Y-m-d H:i:s') // set tanggal dibuat
        ];
        $detailSuratKeluar->save($data); // simpan data detail surat keluar
        return $this->response->setJSON([ // set response json
            'error' => false, // set error
            'status' => 200, // set status
            'message' => 'Data detail surat keluar berhasil ditambahkan' // set message
        ]);
    }
    
    public function updateKeteranganDetailSuratKeluar(){
        $id_detail_surat_keluar = $this->request->getPost('id_detail_surat_keluar'); // mengambil id detail surat keluar
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail surat keluar
        $data = [
            'keterangan_detail_surat_keluar' => $this->request->getPost('keterangan_detail_surat_keluar'), // mengambil keterangan detail surat keluar
            'updated_at' => date('Y-m-d H:i:s') // set tanggal diubah
        ];
        $detailSuratKeluar->update($id_detail_surat_keluar, $data); // update data detail surat keluar
        return $this->response->setJSON([ // set response json
            'error' => false, // set error
            'status' => 200, // set status
            'message' => 'Data detail surat keluar berhasil diubah' // set message
        ]);
    }

    public function deleteDetailSuratKeluar() // menghapus data detail surat keluar
    {
        $id_detail_surat_keluar = $this->request->getPost('id_detail_surat_keluar'); // mengambil id detail surat keluar
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail surat keluar
        $detailSuratKeluar->delete($id_detail_surat_keluar); // hapus data detail surat keluar berdasarkan id
        return $this->response->setJSON([ // set response json
            'error' => false, // set error
            'status' => 200, // set status
            'message' => 'Data detail surat keluar berhasil dihapus' // set message
        ]);
    }

    // ============================ KADIN ============================
    public function proses_persetujuan($id) // menampilkan form edit surat keluar
    {
        $jenisSuratModel = new jenisSuratModel(); // membuat objek model jenis surat
        $detailJenisSuratModel = new detailJenisSuratModel(); // membuat objek model detail jenis surat
        $suratKeluarModel = new suratKeluarModel(); // membuat objek model surat keluar
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail jenis surat
        $dataInstansiModel = new Data_instansiModel();
        $data_surat_keluar = $suratKeluarModel->getSuratkeluar($id)->first(); // mengambil data surat keluar berdasarkan id
        
        $id_jenis_surat = $data_surat_keluar['id_jenis_surat']; // set id jenis surat keluar
        $data_jenis_surat = $jenisSuratModel->find($id_jenis_surat); // mengambil data jenis surat keluar berdasarkan id
        $dataDetailJenisSurat = $detailJenisSuratModel->geDetailByJenisSurat($id_jenis_surat); // mengambil data detail jenis surat keluar berdasarkan id
        $dataDetailSurat =$detailSuratKeluar->getDetailSuratKeluarByIdSuratKeluar($id);
    
        $dataInstansi = $dataInstansiModel->first();
        $bulan_indo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; // array bulan indo
            
        // Ambil template surat
        $template = $data_surat_keluar['template_jenis_surat'];
    
        // Ambil isian surat keluar (format JSON)
        $isian = json_decode($data_surat_keluar['isian_surat_keluar'], true);
    
        // Gabungkan dengan data instansi
        $isian['nama_instansi'] = $dataInstansi['nama_instansi'];
        $isian['nama_kepala_instansi'] = $dataInstansi['nama_kepala_instansi'];
        $isian['nip_kepala_instansi'] = $dataInstansi['nip_kepala_instansi'];
    
        // Ganti {placeholder} di template
        foreach ($isian as $key => $val) {
            if (strpos($key, 'tanggal') !== false) { // jika ada {} pada key
                $val = date('d', strtotime($val)) . ' ' . $bulan_indo[date('n', strtotime($val)) - 1] . ' ' . date('Y', strtotime($val)); // format tanggal surat keluar
            }
            $template = str_replace('{' . $key . '}', $val, $template);
        }

        
        // tambahkan data tersebut kedalam template surat
        if($dataDetailSurat != null || $dataDetailSurat != ''){ // jika ada data detail surat keluar
            $list = '<ol style="margin: 0px; padding: 0px;">';
            foreach ($dataDetailSurat as $key => $value) { // loop data detail surat keluar
                $list .= '<li style="padding: 1px;">' . $value['nama_user'] . '</li>'; // masukkan ke dalam list
            }
            $list .= '</ol>';
            $template = str_replace('{' . 'nama_penerima' . '}', $list, $template); // ganti {nama_penerima} dengan list
        }else{
            $template = str_replace('{' . 'nama_penerima' . '}', '', $template); // ganti {nama_penerima} dengan kosong
        }
        
        $template = str_replace('{' . 'tempat_penerima' . '}', 'Tempat', $template); // ganti {tempat_penerima} dengan kosong
        $data['title'] = 'Persetujuan Surat Keluar'; // untuk set judul halaman
        $data['active'] = 'Surat_keluar'; // set active menu  
        $data['jenis_surat'] = $jenisSuratModel->findAll(); // mengambil semua data jenis surat yang statusnya aktif
        $data['data_jenis_surat'] = $data_jenis_surat; // set jenis surat keluar
        $data['surat_keluar'] = $data_surat_keluar; // set data surat keluar
        $data['data_instansi'] = $dataInstansi; // set data instansi
        $data['template'] = $template; // set template surat
        $data['detail_surat_keluar'] = $dataDetailSurat; // mengambil data detail surat keluar berdasarkan id
        $data['dataDetailJenisSurat'] = $dataDetailJenisSurat; // set data detail jenis surat keluar
        $data['id_jenis_surat'] = $id_jenis_surat; // set id jenis surat keluar
        $data['validation'] = \Config\Services::validation(); // set validasi
        // dd($data);
        // dd($data);
        return view('Admin/surat_keluar/proses_persetujuan', $data); // tampilkan view edit surat keluar
    }

    public function aproveSurat(){
        $suratKeluarModel = new suratKeluarModel(); // membuat objek model surat keluar
        $id_surat_keluar = $this->request->getPost('id_surat_keluar'); // mengambil id surat keluar
        $status_surat_keluar = $this->request->getPost('status_surat_keluar'); // mengambil status surat keluar
        if($status_surat_keluar != '3'){ // jika status surat keluar bukan 3
            $data = [
                'status_surat_keluar' => $status_surat_keluar, // set status surat keluar
                'catatan_persetujuan_surat_keluar' => $this->request->getPost('catatan_persetujuan_surat_keluar'), // set catatan persetujuan surat keluar
                'updated_at' => date('Y-m-d H:i:s') // set tanggal diubah
            ];
            $suratKeluarModel->update($id_surat_keluar, $data); // update data surat keluar
            session()->setFlashdata('success', 'Status Surat keluar berhasil diubah'); // set flashdata success
            return redirect()->to('surat_keluar'); // redirect ke halaman surat keluar
        }else{
            $jenisSuratModel = new jenisSuratModel(); // membuat objek model jenis surat
            $detailJenisSuratModel = new detailJenisSuratModel(); // membuat objek model detail jenis surat
            $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail jenis surat
            $dataInstansiModel = new Data_instansiModel();
            $bulan_indo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; // array bulan indo
            
            $data_surat_keluar = $suratKeluarModel->getSuratkeluar($id_surat_keluar)->first(); // mengambil data surat keluar berdasarkan id
            
            $id_jenis_surat = $data_surat_keluar['id_jenis_surat']; // set id jenis surat keluar
            $data_jenis_surat = $jenisSuratModel->find($id_jenis_surat); // mengambil data jenis surat keluar berdasarkan id
            $dataDetailJenisSurat = $detailJenisSuratModel->geDetailByJenisSurat($id_jenis_surat); // mengambil data detail jenis surat keluar berdasarkan id
            
            
            $dataInstansi = $dataInstansiModel->first();
            $no_surat_terbaru = $suratKeluarModel->getNoSuratTerbaru(); // mengambil no surat terbaru
            if($no_surat_terbaru == null){ // jika no surat terbaru tidak ada
                $no_urut = 1; // set no surat 1
            }else{
                $no_urut = $no_surat_terbaru['nomor_surat_keluar'] + 1; // set no surat terbaru
            }
            
            $no_surat_keluar = $data_surat_keluar['kode_surat'] . '/' . $no_urut;
            $template = $data_surat_keluar['template_jenis_surat'];
            $tanggal_surat_keluar = date('Y-m-d'); // set tanggal surat keluar
            // Ambil isian surat keluar (format JSON)
            $isian = json_decode($data_surat_keluar['isian_surat_keluar'], true);
            
            // Gabungkan dengan data instansi
            $isian['nama_instansi'] = $dataInstansi['nama_instansi'];
            $isian['nama_kepala_instansi'] = $dataInstansi['nama_kepala_instansi'];
            $isian['nip_kepala_instansi'] = $dataInstansi['nip_kepala_instansi'];
            $isian['nomor_surat'] = $no_surat_keluar; // set no surat keluar
            $isian['tanggal_surat'] = $tanggal_surat_keluar; // set tanggal surat keluar
            $isian['ttd_kepala'] = '<img src="' . base_url('Assets/ttd_surat/'. $id_surat_keluar . '.png') . '" width="120px">';
            $url = base_url('Surat_keluar/preview/' . $id_surat_keluar); // set url surat keluar
            // Ganti {placeholder} di template
            foreach ($isian as $key => $val) {
                // jika didalam key ada tulisan tanggal
                if (strpos($key, 'tanggal') !== false) { // jika ada {} pada key
                    $val = date('d', strtotime($val)) . ' ' . $bulan_indo[date('n', strtotime($val)) - 1] . ' ' . date('Y', strtotime($val)); // format tanggal surat keluar
                }
                
                $template = str_replace('{' . $key . '}', $val, $template);
            }
            // dd($template);
            $nama_file = 'Assets/ttd_surat/' . $id_surat_keluar . '.png'; // set nama file surat keluar
            if (file_exists($nama_file)) { // jika file sudah ada
                unlink($nama_file); // hapus file
            }
            $result = Builder::create()
                    ->writer(new PngWriter())
                    ->writerOptions([])
                    ->data($url)
                    ->encoding(new Encoding('UTF-8'))
                    ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                    ->size(300)
                    ->margin(10)
                    ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                    ->logoPath('Assets/img/data_instansi/' . $dataInstansi['logo_instansi'])
                    ->logoResizeToWidth(50)
                    ->logoPunchoutBackground(true)
                    // ->labelText('This is the label')
                    // ->labelFont(new NotoSans(20))
                    // ->labelAlignment(LabelAlignment::Center)
                    ->validateResult(false)
                    ->build();
                    
            $result->saveToFile('Assets/ttd_surat/' . $id_surat_keluar . '.png'); // simpan file qr code
            // dd($template);
            $data = [
                'status_surat_keluar' => $status_surat_keluar, // set status surat keluar
                'catatan_persetujuan_surat_keluar' => $this->request->getPost('catatan_persetujuan_surat_keluar'), // set catatan persetujuan surat keluar
                'nomor_surat_keluar' => $no_urut, // set no surat keluar
                'final_dokumen_surat_keluar' => $template, // set template surat keluar
                'tanggal_surat_keluar' => $tanggal_surat_keluar, // set tanggal surat keluar
                'updated_at' => date('Y-m-d H:i:s') // set tanggal diubah
            ];
            $suratKeluarModel->update($id_surat_keluar, $data); // update data surat keluar
            return $this->response->setJSON([ // set response json
                'error' => false, // set error
                'status' => 200, // set status
                'data' => 'Data surat keluar berhasil disetujui' // set message
            ]);
        }
    }


    // ============================ USER ============================
    public function SuratUser(){
        $suratKeluarModel = new suratKeluarModel(); // membuat objek model surat keluar
        $detailSuratKeluarModel = new detailSuratKeluarModel(); // membuat objek model detail surat keluar

        $data_surat_keluar = $detailSuratKeluarModel->getSuratKeluarByUser(session()->get('id_user'))->orderBy('detail_surat_keluar.created_at', 'DESC')->findAll(); // mengambil data surat keluar
       
        $data['surat_keluar'] = $data_surat_keluar; // mengambil semua data surat keluar
        $data['title'] = 'Surat'; // set judul halaman 
        $data['active'] = 'Surat'; // set active menu
        $data['validation'] = \Config\Services::validation(); // set validasi
        
        return view('User/Surat/index', $data); // tampilkan view surat keluar
    }

    public function detailUser($id) // menampilkan form edit surat keluar
    {
        $jenisSuratModel = new jenisSuratModel(); // membuat objek model jenis surat
        $detailJenisSuratModel = new detailJenisSuratModel(); // membuat objek model detail jenis surat
        $suratKeluarModel = new suratKeluarModel(); // membuat objek model surat keluar
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail jenis surat
        $dataInstansiModel = new Data_instansiModel();
        $dataDetailSurat = $detailSuratKeluar->getDetailSuratKeluar($id); // mengambil data detail surat keluar berdasarkan id
        if($dataDetailSurat == null || $dataDetailSurat == ''){ // jika data detail surat keluar tidak ada
            return redirect()->to('Surat'); // redirect ke halaman surat keluar
        }
        
        $data_surat_keluar = $suratKeluarModel->getSuratkeluar($dataDetailSurat['id_surat_keluar'])->first(); // mengambil data surat keluar berdasarkan id
        if($dataDetailSurat['status_detail_surat_keluar'] == '0'){ // jika status detail surat keluar 1
            $detailSuratKeluar->update($id, ['status_detail_surat_keluar' => '1', 'updated_at' => date('Y-m-d H:i:s')]); // update status detail surat keluar
        }
        $id_jenis_surat = $data_surat_keluar['id_jenis_surat']; // set id jenis surat keluar
        $data_jenis_surat = $jenisSuratModel->find($id_jenis_surat); // mengambil data jenis surat keluar berdasarkan id
        $dataDetailJenisSurat = $detailJenisSuratModel->geDetailByJenisSurat($id_jenis_surat); // mengambil data detail jenis surat keluar berdasarkan id
        
    
        $dataInstansi = $dataInstansiModel->first();
    
        // Ambil template surat
        $template = $data_surat_keluar['template_jenis_surat'];
    
        // Ambil isian surat keluar (format JSON)
        $isian = json_decode($data_surat_keluar['isian_surat_keluar'], true);
        // Gabungkan dengan data instansi
        $isian['nama_instansi'] = $dataInstansi['nama_instansi'];
        $isian['nama_kepala_instansi'] = $dataInstansi['nama_kepala_instansi'];
        $isian['nip_kepala_instansi'] = $dataInstansi['nip_kepala_instansi'];
    
        // Ganti {placeholder} di template
        foreach ($isian as $key => $val) {
            $template = str_replace('{' . $key . '}', $val, $template);
        }
        if($data_surat_keluar['final_dokumen_surat_keluar'] != null ){
            $template = $data_surat_keluar['final_dokumen_surat_keluar'];
        }

        $template = str_replace('{' . 'nama_penerima' . '}', $dataDetailSurat['nama_user'], $template); // ganti {nama_penerima} dengan kosong
        $template = str_replace('{' . 'tempat_penerima' . '}', 'Tempat', $template); // ganti {tempat_penerima} dengan kosong
        
        $data['title'] = 'Detail Surat'; // untuk set judul halaman
        $data['active'] = 'Surat'; // set active menu  
        $data['jenis_surat'] = $jenisSuratModel->findAll(); // mengambil semua data jenis surat yang statusnya aktif
        $data['data_jenis_surat'] = $data_jenis_surat; // set jenis surat keluar
        $data['surat_keluar'] = $data_surat_keluar; // set data surat keluar
        $data['data_instansi'] = $dataInstansi; // set data instansi
        $data['template'] = $template; // set template surat
        $data['detail_surat_keluar'] = $dataDetailSurat; // mengambil data detail surat keluar berdasarkan id
        $data['dataDetailJenisSurat'] = $dataDetailJenisSurat; // set data detail jenis surat keluar
        $data['id_jenis_surat'] = $id_jenis_surat; // set id jenis surat keluar
        $data['validation'] = \Config\Services::validation(); // set validasi
        // dd($data);
        // dd($data);
        return view('User/Surat/detail', $data); // tampilkan view edit surat keluar
    }

    public function previewUser($id) // menampilkan preview surat keluar
    {
        $jenisSuratModel = new jenisSuratModel(); // membuat objek model jenis surat
        $detailJenisSuratModel = new detailJenisSuratModel(); // membuat objek model detail jenis surat
        $suratKeluarModel = new suratKeluarModel(); // membuat objek model surat keluar
        $detailSuratKeluar = new detailSuratKeluarModel(); // membuat objek model detail jenis surat
        $dataInstansiModel = new Data_instansiModel();
        $dataDetailSurat = $detailSuratKeluar->getDetailSuratKeluar($id); // mengambil data detail surat keluar berdasarkan id
        $data_surat_keluar = $suratKeluarModel->getSuratkeluar($dataDetailSurat['id_surat_keluar'])->first(); // mengambil data surat keluar berdasarkan id
        
        $id_jenis_surat = $data_surat_keluar['id_jenis_surat']; // set id jenis surat keluar
        $data_jenis_surat = $jenisSuratModel->find($id_jenis_surat); // mengambil data jenis surat keluar berdasarkan id
        $dataDetailJenisSurat = $detailJenisSuratModel->geDetailByJenisSurat($id_jenis_surat); // mengambil data detail jenis surat keluar berdasarkan id
        
        if($dataDetailSurat['status_detail_surat_keluar'] == '0'){ // jika status detail surat keluar 1
            $detailSuratKeluar->update($id, ['status_detail_surat_keluar' => '1', 'updated_at' => date('Y-m-d H:i:s')]); // update status detail surat keluar
        }
    
        $dataInstansi = $dataInstansiModel->first();
    
        // Ambil template surat
        $template = $data_surat_keluar['template_jenis_surat'];
    
        // Ambil isian surat keluar (format JSON)
        $isian = json_decode($data_surat_keluar['isian_surat_keluar'], true);
        // Gabungkan dengan data instansi
        $isian['nama_instansi'] = $dataInstansi['nama_instansi'];
        $isian['nama_kepala_instansi'] = $dataInstansi['nama_kepala_instansi'];
        $isian['nip_kepala_instansi'] = $dataInstansi['nip_kepala_instansi'];
    
        // Ganti {placeholder} di template
        foreach ($isian as $key => $val) {
            $template = str_replace('{' . $key . '}', $val, $template);
        }
        if($data_surat_keluar['final_dokumen_surat_keluar'] != null ){
            $template = $data_surat_keluar['final_dokumen_surat_keluar'];
        }

        $template = str_replace('{' . 'nama_penerima' . '}', $dataDetailSurat['nama_user'], $template); // ganti {nama_penerima} dengan kosong
        $template = str_replace('{' . 'tempat_penerima' . '}', 'Tempat', $template); // ganti {tempat_penerima} dengan kosong
        
        $data['title'] = 'Detail Surat Keluar'; // untuk set judul halaman
        $data['active'] = 'Surat_keluar'; // set active menu  
        $data['jenis_surat'] = $jenisSuratModel->findAll(); // mengambil semua data jenis surat yang statusnya aktif
        $data['data_jenis_surat'] = $data_jenis_surat; // set jenis surat keluar
        $data['surat_keluar'] = $data_surat_keluar; // set data surat keluar
        $data['data_instansi'] = $dataInstansi; // set data instansi
        $data['template'] = $template; // set template surat
        $data['detail_surat_keluar'] = $dataDetailSurat; // mengambil data detail surat keluar berdasarkan id
        $data['dataDetailJenisSurat'] = $dataDetailJenisSurat; // set data detail jenis surat keluar
        $data['id_jenis_surat'] = $id_jenis_surat; // set id jenis surat keluar
        $data['validation'] = \Config\Services::validation(); // set validasi
        // dd($data);
        return view('User/Surat/print_prev', $data); // tampilkan view edit surat keluar
    }
    
}
?>