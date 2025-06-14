<?php 
namespace App\Controllers;

use App\Models\jenisSuratModel;
use App\Models\detailJenisSuratModel; // model untuk detail jenis surat
use App\Models\referensiJenisSuratModel; // model untuk referensi jenis surat
use Ramsey\Uuid\Uuid;

class Referensi extends BaseController
{
    
    public function index() // menampilkan data referensi jenis surat
    {
        $model = new referensiJenisSuratModel(); // membuat objek model referensi jenis surat
        $data['referensi'] = $model->getRefereni(); // mengambil semua data jenis surat
        $data['title'] = 'Referensi Jenis Surat'; // set judul halaman
        $data['active'] = 'referensi_jenis_surat'; // set active menu
        $data['validation'] = \Config\Services::validation(); // set validasi

        return view('Admin/jenis_surat/Referensi/index', $data); // tampilkan view referensi jenis surat
    }

    public function saveReferensi(){
        // dd($this->request->getPost()); // untuk menampilkan data post
        $model = new referensiJenisSuratModel(); // membuat objek model referensi jenis surat
        $validation = \Config\Services::validation(); // membuat objek validasi
        $validation->setRules([ // set rules validasi
            'kode_referensi_jenis_surat' => 'required|is_unique[referensi_jenis_surat.kode_referensi_jenis_surat]', // id referensi jenis surat wajib diisi dan harus unik
            'nama_referensi_jenis_surat' => 'required|is_unique[referensi_jenis_surat.nama_referensi_jenis_surat]', // nama referensi jenis surat wajib diisi dan harus unik
            'ket_referensi_jenis_surat' => 'required' // keterangan referensi jenis surat wajib diisi
        ]);
        if (!$validation->run($this->request->getPost())) { // jika validasi tidak terpenuhi
            session()->setFlashdata('errors', 'Data Referensi Jenis Surat gagal ditambahkan'); // set flashdata error
            return redirect()->to('/Jenis_surat/Referensi')->withInput(); // redirect ke halaman referensi jenis surat
        }
        $data = [  // set data referensi jenis surat
            'kode_referensi_jenis_surat' => $this->request->getPost('kode_referensi_jenis_surat'), // set id referensi jenis surat
            'nama_referensi_jenis_surat' => $this->request->getPost('nama_referensi_jenis_surat'), // mengambil data nama referensi jenis surat
            'tipe_referensi_jenis_surat' => $this->request->getPost('tipe_referensi_jenis_surat'), // mengambil data tipe referensi jenis surat
            'ket_referensi_jenis_surat' => $this->request->getPost('ket_referensi_jenis_surat'), // mengambil data keterangan referensi jenis surat
            'created_at' => date('Y-m-d H:i:s') // mengambil data template jenis surat
        ];
        $model->save($data); // insert data referensi jenis surat
        session()->setFlashdata('success', 'Data Referensi Jenis Surat berhasil ditambahkan'); // set flashdata success
        return redirect()->to('/Jenis_surat/Referensi'); // redirect ke halaman referensi jenis surat
    }

    public function updateReferensi() // mengupdate data referensi jenis surat
    {
        $model = new referensiJenisSuratModel(); // membuat objek model referensi jenis surat
        $validation = \Config\Services::validation(); // membuat objek validasi
        
        $id_referensi_jenis_surat = $this->request->getPost('id_referensi_jenis_surat'); // mengambil data id referensi jenis surat
        $data_referensi = $model->getRefereni($id_referensi_jenis_surat); // mengambil data referensi jenis surat berdasarkan id
        if ($this->request->getPost('kode_referensi_jenis_surat') == $data_referensi['kode_referensi_jenis_surat']) { // jika id referensi jenis surat sama
            $rule_kode_referensi_jenis_surat = 'required'; // set rule id referensi jenis surat wajib diisi
        } else {
            $rule_kode_referensi_jenis_surat = 'required|is_unique[referensi_jenis_surat.kode_referensi_jenis_surat]'; // set rule id referensi jenis surat wajib diisi dan harus unik
        }
        if ($this->request->getPost('nama_referensi_jenis_surat') == $data_referensi['nama_referensi_jenis_surat']) { // jika nama referensi jenis surat sama
            $rule_nama_referensi_jenis_surat = 'required'; // set rule nama referensi jenis surat wajib diisi
        } else {
            $rule_nama_referensi_jenis_surat = 'required|is_unique[referensi_jenis_surat.nama_referensi_jenis_surat]'; // set rule nama referensi jenis surat wajib diisi dan harus unik
        }
        $validation->setRules([ // set rules validasi
            'kode_referensi_jenis_surat' => $rule_kode_referensi_jenis_surat, // id referensi jenis surat wajib diisi dan harus unik
            'nama_referensi_jenis_surat' => $rule_nama_referensi_jenis_surat, // nama referensi jenis surat wajib diisi dan harus unik
            'ket_referensi_jenis_surat' => 'required' // keterangan referensi jenis surat wajib diisi
        ]);
        
        if (!$validation->run($this->request->getPost())) { // jika validasi tidak terpenuhi 
            session()->setFlashdata('errors', 'Data Referensi Jenis Surat gagal diubah'); // set flashdata error
            return redirect()->to('/Jenis_surat/Referensi')->withInput(); // redirect ke halaman referensi jenis surat
        }
        $data = [  // set data referensi jenis surat
            'kode_referensi_jenis_surat' => $this->request->getPost('kode_referensi_jenis_surat'), // set id referensi jenis surat
            'nama_referensi_jenis_surat' => $this->request->getPost('nama_referensi_jenis_surat'), // mengambil data nama referensi jenis surat
            'tipe_referensi_jenis_surat' => $this->request->getPost('tipe_referensi_jenis_surat'), // mengambil data tipe referensi jenis surat
            'ket_referensi_jenis_surat' => $this->request->getPost('ket_referensi_jenis_surat'), // mengambil data keterangan referensi jenis surat
            'updated_at' => date('Y-m-d H:i:s') // mengambil data template jenis surat
        ];
        $model->update($id_referensi_jenis_surat, $data); // update data referensi jenis surat
        session()->setFlashdata('success', 'Data Referensi Jenis Surat berhasil diubah'); // set flashdata success
        return redirect()->to('/Jenis_surat/Referensi'); // redirect ke halaman referensi jenis surat
    }
}