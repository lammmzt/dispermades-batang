<?php 
namespace App\Controllers;

use App\Models\suratMasukModel;
use App\Models\usersModel;
use App\Models\pegawaiModel;
use App\Models\disposisiModel;
use Ramsey\Uuid\Uuid;

class Surat_masuk extends BaseController
{ 
    public function index() // menampilkan data surat masuk
    { 
        $suratMasukModel = new suratMasukModel(); // membuat objek model surat masuk
        $data['surat_masuk'] = $suratMasukModel->getSuratMasuk(); // mengambil semua data surat masuk
        $data['title'] = 'Surat Masuk'; // set judul halaman 
        $data['active'] = 'surat_masuk'; // set active menu
        $data['validation'] = \Config\Services::validation(); // set validasi
        
        return view('Admin/surat_masuk/index', $data); // tampilkan view surat masuk
    }

    public function tambah() // menampilkan form tambah surat masuk
    { 
        $pegawaiModel = new pegawaiModel(); // membuat objek model pegawai
        $data['title'] = 'Tambah Surat Masuk'; // untuk set judul halaman
        $data['active'] = 'surat_masuk'; // set active menu  
        $data['validation'] = \Config\Services::validation(); // set validasi
        $data['pegawai'] = $pegawaiModel->where('status_pegawai', '1')->findAll(); // mengambil semua data pegawai yang statusnya aktif

        return view('Admin/surat_masuk/tambah', $data); // tampilkan view tambah surat masuk
    }

    public function save() // menyimpan data surat masuk
    {
        $model = new suratMasukModel(); // membuat objek model surat masuk
        $disposisiModel = new disposisiModel(); // membuat objek model disposisi
        $validation = \Config\Services::validation(); // membuat objek validasi
        // dd($this->request->getPost());
        $validation->setRules([ // set rules validasi
            'pengirim_surat_masuk' => 'required',
            'perihal_surat_masuk' => 'required',
            'no_surat_masuk' => 'required',
            'tgl_surat_masuk' => 'required',
            'ket_surat_masuk' => 'required',
            'tipe_file_surat_masuk' => 'required',
            'file_surat_masuk' => 'uploaded[file_surat_masuk]|ext_in[file_surat_masuk,pdf,doc,docx,jpg,jpeg,png]'
        ]);

        if (!$validation->withRequest($this->request)->run()) { // jika validasi tidak terpenuhi
            session()->setFlashdata('errors', $validation->getErrors()); // set flashdata error
            return redirect()->to('/Surat_masuk/tambah')->withInput(); // redirect ke halaman tambah surat masuk
        }
        // upload file surat 
        $fileSurat = $this->request->getFile('file_surat_masuk'); // mengambil file surat
        $newName = $fileSurat->getRandomName(); // generate nama file random
        $fileSurat->move('Assets/file_surat_masuk', $newName); // pindahkan file surat ke folder file_surat_masuk
        $id_surat_masuk = 'SM-' . date('YmdHis') . '-' . rand(10, 100); // generate id surat masuk
        $model->insert([ // insert data surat masuk
            'id_surat_masuk' => $id_surat_masuk, // set id surat masuk
            'id_user' => session()->get('id_user'), // set id users
            'pengirim_surat_masuk' => $this->request->getPost('pengirim_surat_masuk'), // mengambil data pengirim surat
            'perihal_surat_masuk' => $this->request->getPost('perihal_surat_masuk'), // mengambil data perihal surat
            'no_surat_masuk' => $this->request->getPost('no_surat_masuk'), // mengambil data no surat
            'tgl_surat_masuk' => $this->request->getPost('tgl_surat_masuk'), // mengambil data tanggal surat
            'ket_surat_masuk' => $this->request->getPost('ket_surat_masuk'), // mengambil data keterangan surat
            'tipe_file_surat_masuk' => $this->request->getPost('tipe_file_surat_masuk'), // mengambil data tipe file surat
            'file_surat_masuk' => $newName, // set nama file surat
            'created_at' => date('Y-m-d H:i:s') // set tanggal dibuat
        ]);

        // jika ada id pegawai yang dipilih
        if ($this->request->getPost('id_pegawai')) {
            $id_pegawai = $this->request->getPost('id_pegawai'); // mengambil id pegawai
            $ket_disposisi = $this->request->getPost('ket_disposisi'); // mengambil keterangan disposisi
            
            foreach ($id_pegawai as $key => $value) { // loop data pegawai
                $disposisiModel->insert([ // insert data disposisi
                    'id_disposisi' => 'DISPO-' . date('YmdHis') . '-' . rand(10, 100), // generate id disposisi
                    'id_surat_masuk' => $id_surat_masuk, // set id surat masuk 
                    'id_pegawai' => $value, // set id pegawai
                    'status_disposisi' => '0', // set status disposisi
                    'ket_disposisi' => $ket_disposisi[$key], // set keterangan disposisi
                    'created_at' => date('Y-m-d H:i:s') // set tanggal dibuat
                ]);
            }
        }
        
        session()->setFlashdata('success', 'Data Surat Masuk berhasil ditambahkan'); // set flashdata success
        return redirect()->to('/surat_masuk'); // redirect ke halaman surat masuk
    }

    public function edit($id) // menampilkan form edit surat masuk
    {
        $model = new suratMasukModel(); // membuat objek model surat masuk
        $disposisiModel = new disposisiModel(); // membuat objek model disposisi
        $pegawaiModel = new pegawaiModel(); // membuat objek model pegawai
        $data['title'] = 'Edit Surat Masuk'; // set judul halaman
        $data['surat_masuk'] = $model->find($id); // mengambil data surat masuk berdasarkan id
        $data['pegawai'] = $pegawaiModel->where('status_pegawai', '1')->findAll(); // mengambil semua data pegawai yang statusnya aktif
        $data['disposisi'] = $disposisiModel->getDisposisiBySurat($id); // mengambil data disposisi berdasarkan id surat masuk
        $data['active'] = 'surat_masuk'; // set active menu
        $data['validation'] = \Config\Services::validation(); // set validasi
        // dd($data);
        return view('Admin/surat_masuk/edit', $data); // tampilkan view edit surat masuk
    }
    
    public function update()
    {
        $model = new suratMasukModel(); // membuat objek model surat masuk
        $disposisiModel = new disposisiModel(); // membuat objek model disposisi
        $validation = \Config\Services::validation(); // membuat objek validasi
        // dd($this->request->getPost());
        $validation->setRules([ // set rules validasi
            'pengirim_surat_masuk' => 'required',
            'perihal_surat_masuk' => 'required',
            'no_surat_masuk' => 'required',
            'tgl_surat_masuk' => 'required',
            'ket_surat_masuk' => 'required',
            'tipe_file_surat_masuk' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) { // jika validasi tidak terpenuhi
            session()->setFlashdata('errors', $validation->getErrors()); // set flashdata error
            return redirect()->to('/Surat_masuk/tambah')->withInput(); // redirect ke halaman tambah surat masuk
        }
        $id_surat_masuk = $this->request->getPost('id_surat_masuk'); // mengambil id surat masuk
        $dataSurat = $model->find($id_surat_masuk); // mengambil data surat masuk berdasarkan id
        // upload file surat 
        $fileSurat = $this->request->getFile('file_surat_masuk'); // mengambil file surat
        // jika tidak ada file surat yang diupload
        if ($fileSurat->getError() == 4) {
            $newName = $dataSurat['file_surat_masuk']; // set nama file surat
        } else {
            if ($dataSurat['file_surat_masuk']) {
                unlink('Assets/file_surat_masuk/' . $dataSurat['file_surat_masuk']); // hapus file surat lama
            }
            $newName = $fileSurat->getRandomName(); // generate nama file random
            $fileSurat->move('Assets/file_surat_masuk', $newName); // pindahkan file surat ke folder file_surat_masuk
        }
        $model->update($id_surat_masuk, [ // update data surat masuk
            'pengirim_surat_masuk' => $this->request->getPost('pengirim_surat_masuk'), // mengambil data pengirim surat
            'perihal_surat_masuk' => $this->request->getPost('perihal_surat_masuk'), // mengambil data perihal surat
            'no_surat_masuk' => $this->request->getPost('no_surat_masuk'), // mengambil data no surat
            'tgl_surat_masuk' => $this->request->getPost('tgl_surat_masuk'), // mengambil data tanggal surat
            'ket_surat_masuk' => $this->request->getPost('ket_surat_masuk'), // mengambil data keterangan surat
            'tipe_file_surat_masuk' => $this->request->getPost('tipe_file_surat_masuk'), // mengambil data tipe file surat
            'file_surat_masuk' => $newName, // set nama file surat
            'created_at' => date('Y-m-d H:i:s') // set tanggal dibuat
        ]);
        // hapus semua data disposisi berdasarkan id surat masuk
        $disposisiModel->where('id_surat_masuk', $id_surat_masuk)->delete();
        // jika ada id pegawai yang dipilih
        if ($this->request->getPost('id_pegawai')) {
            $id_pegawai = $this->request->getPost('id_pegawai'); // mengambil id pegawai
            $ket_disposisi = $this->request->getPost('ket_disposisi'); // mengambil keterangan disposisi
            
            foreach ($id_pegawai as $key => $value) { // loop data pegawai
                $disposisiModel->insert([ // insert data disposisi
                    'id_disposisi' => 'DISPO-' . date('YmdHis') . '-' . rand(10, 100), // generate id disposisi
                    'id_surat_masuk' => $id_surat_masuk, // set id surat masuk 
                    'id_pegawai' => $value, // set id pegawai
                    'status_disposisi' => '0', // set status disposisi
                    'ket_disposisi' => $ket_disposisi[$key], // set keterangan disposisi
                    'created_at' => date('Y-m-d H:i:s') // set tanggal dibuat
                ]);
            }
        }
        
        session()->setFlashdata('success', 'Data Surat Masuk berhasil diubah'); // set flashdata success
        return redirect()->to('/surat_masuk'); // redirect ke halaman surat masuk
    }

    public function detail($id) // menampilkan form edit surat masuk
    {
        $model = new suratMasukModel(); // membuat objek model surat masuk
        $disposisiModel = new disposisiModel(); // membuat objek model disposisi
        $pegawaiModel = new pegawaiModel(); // membuat objek model pegawai
        $data_surat_masuk = $model->find($id); // mengambil data surat masuk berdasarkan id
        // dd($data_surat_masuk);
        if($data_surat_masuk == null) { // jika data surat masuk tidak ada
            session()->setFlashdata('errors', 'Data Surat Masuk tidak ditemukan'); // set flashdata error
            return redirect()->to('/surat_masuk'); // redirect ke halaman surat masuk
        }
        
        if(session()->get('role') == 'Kadin') { // jika role user dan data surat masuk tidak ada
            if($data_surat_masuk['status_surat_masuk'] == '0') { // jika status surat masuk belum dibaca
                // dd($data_surat_masuk);
                $model->update($id, [ // update status surat masuk
                    'status_surat_masuk' => '1', // set status surat masuk
                    'updated_at' => date('Y-m-d H:i:s') // set tanggal diubah
                ]);
            }
        }
        
        $data['title'] = 'Edit Surat Masuk'; // set judul halaman
        $data['surat_masuk'] = $data_surat_masuk;
        $data['pegawai'] = $pegawaiModel->where('status_pegawai', '1')->findAll(); // mengambil semua data pegawai yang statusnya aktif
        $data['disposisi'] = $disposisiModel->getDisposisiBySurat($id); // mengambil data disposisi berdasarkan id surat masuk
        $data['active'] = 'surat_masuk'; // set active menu
        $data['validation'] = \Config\Services::validation(); // set validasi
        // dd($data);
        return view('Admin/surat_masuk/detail', $data); // tampilkan view edit surat masuk
    }

    public function suratUSer() // menampilkan data surat masuk
    { 
        $suratMasukModel = new suratMasukModel(); // membuat objek model surat masuk
        $disposisiModel = new disposisiModel(); // membuat objek model disposisi
        $pegawaiModel = new pegawaiModel(); // membuat objek model pegawai
        $data_pegawai = $pegawaiModel->getPegwaiByIdUser(session()->get('id_user')); // mengambil data pegawai berdasarkan id user
        if($data_pegawai != null) { // jika data pegawai tidak kosong
            $id_pegawai = $data_pegawai['id_pegawai']; // set id pegawai
        } else {
            $id_pegawai = 0; // set id pegawai 0
        }
        $data_disposisi = $disposisiModel->getDisposisiByIdPegawai($id_pegawai)->orderBy('disposisi.created_at', 'DESC')->findAll(); // mengambil data disposisi berdasarkan id pegawai
        // dd($jml_surat_keluar);
        $data['surat_masuk'] = $data_disposisi; // mengambil semua data surat masuk
        $data['title'] = 'Disposisi'; // set judul halaman 
        $data['active'] = 'Disposisi'; // set active menu
        $data['validation'] = \Config\Services::validation(); // set validasi
        
        return view('User/Disposisi/index', $data); // tampilkan view surat masuk
    }

    public function detailUser($id) // menampilkan form edit surat masuk
    {
        $model = new suratMasukModel(); // membuat objek model surat masuk
        $disposisiModel = new disposisiModel(); // membuat objek model disposisi
        $pegawaiModel = new pegawaiModel(); // membuat objek model pegawai
        $data_disposisi = $disposisiModel->getDisposisiById($id); // mengambil data disposisi berdasarkan id
        if($data_disposisi == null) { // jika data disposisi tidak ada
            session()->setFlashdata('errors', 'Data Disposisi tidak ditemukan'); // set flashdata error
            return redirect()->to('/Disposisi'); // redirect ke halaman surat masuk
        }
        // if($data_disposisi['status_disposisi'] == '0') { // jika status disposisi sudah dibaca
        //     $disposisiModel->update($id, [ // update status disposisi
        //         'status_disposisi' => '1', // set status disposisi
        //         'updated_at' => date('Y-m-d H:i:s') // set tanggal diubah
        //     ]);
        // }
        $data['title'] = 'Edit Surat Masuk'; // set judul halaman
        $data['surat_masuk'] = $data_disposisi; // mengambil data surat masuk berdasarkan id
        $data['active'] = 'Disposisi'; // set active menu
        $data['validation'] = \Config\Services::validation(); // set validasi
        // dd($data);
        return view('User/Disposisi/detail', $data); // tampilkan view edit surat masuk
    }

    public function Balasan() // menyimpan data surat masuk
    {
        $model = new suratMasukModel(); // membuat objek model surat masuk
        $disposisiModel = new disposisiModel(); // membuat objek model disposisi
        $validation = \Config\Services::validation(); // membuat objek validasi
        // dd($this->request->getPost());
        $validation->setRules([ // set rules validasi
            'jawaban_disposisi' => 'required',
        ]);
        
        if (!$validation->withRequest($this->request)->run()) { // jika validasi tidak terpenuhi
            session()->setFlashdata('errors', $validation->getErrors()); // set flashdata error
            return redirect()->to('/Disposisi/detail/'.$this->request->getPost('id_disposisi'))->withInput(); // redirect ke halaman tambah surat masuk
        }
        $id_disposisi = $this->request->getPost('id_disposisi'); // mengambil id disposisi
        $disposisiModel->update($id_disposisi, [ // update data disposisi
            'jawaban_disposisi' => $this->request->getPost('jawaban_disposisi'), // set jawaban disposisi
            'status_disposisi' => '1', // set status disposisi
            'updated_at' => date('Y-m-d H:i:s') // set tanggal diubah
        ]);
        
        session()->setFlashdata('success', 'Balasan Disposisi berhasil dikirim'); // set flashdata success
        return redirect()->to('/Disposisi/detail/'.$id_disposisi); // redirect ke halaman surat masuk
    }
}
?>