<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\dataInstansiModel;
use Ramsey\Uuid\Uuid;

class Data_instansi extends Controller
{
    public function index() // menampilkan data instansi
    {
        $dataInstansiModel = new dataInstansiModel(); // membuat objek model data instansi
        $data['title'] = 'Data Instansi'; // set judul halaman
        $data['active'] = 'Data_instansi'; // set active menu
        $data['breadcrumb'] = [
            ['label' => 'Dashboard', 'url' => '/'], // set breadcrumb home
            ['label' => '/ Profile Instansi', 'url' => ''], // set breadcrumb parent
        ]; // set breadcrumb
        $data['data_instansi'] = $dataInstansiModel->first(); // mengambil data instansi
        $data['validation'] = \Config\Services::validation(); // set validasi
         
        return view('Admin/Data_instansi/index', $data); // tampilkan view data instansi
    }

    public function save() // adalah fungsi untuk menyimpan data
    {
        // dd($this->request->getVar());
        if(!$this->validate([ // validasi inputan
            'nama_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Instansi harus diisi'
                ]
            ],
            'nama_alias_insansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alias Nama Instansi harus diisi'
                ]
            ],
            'alamat_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Instansi harus diisi'
                ]
            ],
            'no_tlp_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No. Telp Instansi harus diisi'
                ]
            ],
            'email_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email Instansi harus diisi'
                ]
            ],
            'nama_kepala_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kepala Instansi harus diisi'
                ]
            ],
            'nip_kepala_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP Kepala Instansi harus diisi'
                ]
            ]
        ])){ // jika validasi tidak terpenuhi
            session()->setFlashdata('errors', 'Data gagal diubah'); // set flashdata error
            return redirect()->to('/Data_instansi')->withInput(); // redirect ke halaman data instansi
        }

        $dataInstansiModel = new dataInstansiModel(); // membuat objek model data instansi
        $check = $dataInstansiModel->first(); // mengambil data instansi
        // dd($check);  
        $logo_instansi = $this->request->getFile('logo_instansi'); // mengambil file logo instansi
    
        if($check){ // jika data instansi sudah ada
            if($logo_instansi->getError() == 4){ // jika file logo instansi tidak diubah
                $nama_logo_instansi = $check['logo_instansi']; // set nama logo instansi
            }else{  // jika file logo instansi diubah
                $nama_logo_instansi = $logo_instansi->getRandomName(); // set nama logo instansi
                unlink('Assets/img/data_instansi/'.$check['logo_instansi']); // hapus file logo instansi
                $logo_instansi->move('Assets/img/data_instansi', $nama_logo_instansi); // upload file logo instansi
            } 
            $dataInstansiModel->update($check['id_data_instansi'], [ // update data instansi
                'nama_instansi' => $this->request->getVar('nama_instansi'),
                'nama_alias_insansi' => $this->request->getVar('nama_alias_insansi'),
                'alamat_instansi' => $this->request->getVar('alamat_instansi'),
                'no_tlp_instansi' => $this->request->getVar('no_tlp_instansi'),
                'email_instansi' => $this->request->getVar('email_instansi'),
                'nama_kepala_instansi' => $this->request->getVar('nama_kepala_instansi'),
                'nip_kepala_instansi' => $this->request->getVar('nip_kepala_instansi'),
                'logo_instansi' => $nama_logo_instansi,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }else{
            if($logo_instansi->getError() == 4){ // jika file logo instansi tidak diupload
                $nama_logo_instansi = ''; // set nama logo instansi
            }else{
                $nama_logo_instansi = $logo_instansi->getRandomName(); // set nama logo instansi
                $logo_instansi->move('Assets/img/data_instansi', $nama_logo_instansi); // upload file logo instansi
            }
            $id_data_instansi = Uuid::uuid4()->toString(); // generate id data instansi
            $dataInstansiModel->insert([ // insert data instansi
                'id_data_instansi' => $id_data_instansi,
                'nama_instansi' => $this->request->getVar('nama_instansi'),
                'nama_alias_insansi' => $this->request->getVar('nama_alias_insansi'),
                'alamat_instansi' => $this->request->getVar('alamat_instansi'),
                'no_tlp_instansi' => $this->request->getVar('no_tlp_instansi'),
                'email_instansi' => $this->request->getVar('email_instansi'),
                'nama_kepala_instansi' => $this->request->getVar('nama_kepala_instansi'),
                'nip_kepala_instansi' => $this->request->getVar('nip_kepala_instansi'),
                'logo_instansi' => $nama_logo_instansi,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        
        session()->setFlashdata('success', 'Data berhasil diubah'); // set flashdata success
        return redirect()->to('/Data_instansi'); // redirect ke halaman data instansi

    }

}
?>