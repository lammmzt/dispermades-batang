<?php 
namespace App\Controllers;

use App\Models\pegawaiModel;
use App\Models\usersModel;
use Ramsey\Uuid\Uuid;

class Pegawai extends BaseController
{
    public function index() // menampilkan data pegawai
    {
        $PegawaiModel = new pegawaiModel(); // membuat objek model pegawai
        $data['title'] = 'Data Pegawai'; // set judul halaman
        $data['active'] = 'Pegawai';    // set active menu
        $data['pegawai'] = $PegawaiModel->getPegawai(); // mengambil semua data pegawai
        $data['validation'] = \Config\Services::validation(); // set validasi
        
        return view('Admin/Pegawai/index', $data); // tampilkan view pegawai
    }

    public function save() // menyimpan data pegawai
    {
        $model = new pegawaiModel(); // membuat objek model pegawai
        $userModel = new usersModel(); // membuat objek model user
        $validation = \Config\Services::validation(); // membuat objek validasi
        // dd($this->request->getPost());
        $validation->setRules([ // set rules validasi
            'nama_pegawai' => 'required',
            'tempat_lahir_pegawai' => 'required',
            'tgl_lahir_pegawai' => 'required',
            'alamat_pegawai' => 'required',
            'no_tlp_pegawai' => 'required',
            'jabatan_pegawai' => 'required',
        ]);
        if (!$validation->run($this->request->getPost())) { // jika validasi tidak terpenuhi
            // session()->setFlashdata('errors', $validation->getErrors());  
            session()->setFlashdata('errors', 'Data Pegawai gagal ditambahkan'); // set flashdata error
            return redirect()->to('/Pegawai')->withInput(); // redirect ke halaman pegawai
        }
        $nip = $this->request->getPost('nip_pegawai'); // mengambil data nip pegawai
        $nama_pegawai = $this->request->getPost('nama_pegawai'); // mengambil data nama pegawai
        if($nip == null || $nip == '' || $nip == '-'){ // jika nip kosong
            // clean nama pegawai for username
            $username = str_replace(' ', '_', $nama_pegawai); // replace spasi dengan _
            $username = strtolower($username); // set username menjadi huruf kecil
            $username = str_replace('.', '', $username); // hapus titik
            $username = str_replace("'", '', $username); // hapus petik
            $username = $username . rand(10, 100); // tambahkan angka random
        }else{ // jika nip tidak kosong
           $check = $model->where('nip_pegawai', $nip)->countAllResults(); // cek nip sudah digunakan
            if ($check > 0) { // jika nip sudah digunakan
                session()->setFlashdata('errors', 'NIP sudah digunakan');
                return redirect()->to('/Pegawai')->withInput(); // redirect ke halaman pegawai
            }
            $check_usernames = $userModel->where('username', $nip)  ->countAllResults(); // cek username sudah digunakan
            if ($check_usernames > 0) { // jika username sudah digunakan
                session()->setFlashdata('errors', 'Username sudah digunakan');  // set flashdata error
                return redirect()->to('/Pegawai')->withInput(); // redirect ke halaman pegawai
            }
            $username = $nip; // set username dengan nip
            
        }
        $id_user = Uuid::uuid4()->toString(); // generate id user
        // save user
        $data_user = [ // set data user
            'id_user' => $id_user,
            'username' => $username,
            'password' => password_hash($username, PASSWORD_DEFAULT),
            'nama_user' => ucwords($nama_pegawai),
            'status_user' => '1',
            'role' => 'Pegawai',
            'created_at' => date('Y-m-d H:i:s')
        ];
        // dd($data_user);
        $userModel->insert($data_user); // insert data user
        // save pegawai
        $data = [ // set data pegawai
            'id_pegawai' => Uuid::uuid4()->toString(),
            'id_user' => $id_user,
            'nama_pegawai' => ucwords($this->request->getPost('nama_pegawai')),
            'nip_pegawai' => $nip,
            'tempat_lahir_pegawai' => $this->request->getPost('tempat_lahir_pegawai'),
            'tgl_lahir_pegawai' => $this->request->getPost('tgl_lahir_pegawai'),
            'alamat_pegawai' => $this->request->getPost('alamat_pegawai'),
            'no_tlp_pegawai' => $this->request->getPost('no_tlp_pegawai'),
            'jabatan_pegawai' => $this->request->getPost('jabatan_pegawai'),
            'status_pegawai' => '1',
            'created_at' => date('Y-m-d H:i:s')
        ];
        // dd($data);
        $model->insert($data); // insert data pegawai

        session()->setFlashdata('success', 'Data Pegawai berhasil ditambahkan'); // set flashdata success
        return redirect()->to('/Pegawai'); // redirect ke halaman pegawai
    }

    public function update() // mengupdate data pegawai
    {
        $model = new pegawaiModel(); // membuat objek model pegawai
        $userModel = new usersModel(); // membuat objek model user
        $id = $this->request->getPost('id_pegawai'); // mengambil data id pegawai
        $validation = \Config\Services::validation(); // membuat objek validasi
        $validation->setRules([ // set rules validasi
            'nama_pegawai' => 'required', // nama pegawai wajib diisi
            'tempat_lahir_pegawai' => 'required',
            'tgl_lahir_pegawai' => 'required',
            'alamat_pegawai' => 'required',
            'no_tlp_pegawai' => 'required',
            'jabatan_pegawai' => 'required',
        ]);
        if (!$validation->run($this->request->getPost())) { // jika validasi tidak terpenuhi
            session()->setFlashdata('errors', 'Data Pegawai gagal diubah'); // set flashdata error
            return redirect()->to('/Pegawai')->withInput(); // redirect ke halaman pegawai
        }
        $data_pegawai = $model->where('id_pegawai', $id)->first(); // mengambil data pegawai berdasarkan id
        $nip = $this->request->getPost('nip_pegawai'); // mengambil data nip pegawai
        if($nip != $data_pegawai['nip_pegawai']){ // jika nip berbeda dengan nip sebelumnya
            $check = $model->where('nip_pegawai', $nip)->countAllResults(); // cek nip sudah digunakan
            if ($check > 0) { // jika nip sudah digunakan
                session()->setFlashdata('errors', 'NIP sudah digunakan');  // set flashdata error
                return redirect()->to('/Pegawai')->withInput(); // redirect ke halaman pegawai
            }
            // update username 
            $data_user = $userModel->where('id_user', $data_pegawai['id_user'])->first(); // mengambil data user berdasarkan id
            $check_usernames = $userModel->where('username', $nip)  ->countAllResults(); // cek username sudah digunakan
            if ($check_usernames > 0) { // jika username sudah digunakan
                session()->setFlashdata('errors', 'Username sudah digunakan'); // set flashdata error
                return redirect()->to('/Pegawai')->withInput(); // redirect ke halaman pegawai
            }   
            $data_user['username'] = $nip;  // set username dengan nip
            $data_user['nama_user'] = ucwords($this->request->getPost('nama_pegawai')); // set nama user
            $userModel->update($data_pegawai['id_user'], $data_user);   // update data user
        }
        $detail_user = $userModel->where('id_user', $data_pegawai['id_user'])->first(); // mengambil data user berdasarkan id
        // update nama pegawai
        if($this->request->getPost('password') != null || $this->request->getPost('password') != ''){ // jika password tidak kosong
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT); // set password dengan password baru
        }else{ // jika password kosong
            $password = $detail_user['password']; // set password dengan password sebelumnya
        }
        $data_user['nama_user'] = ucwords($this->request->getPost('nama_pegawai')); // set nama user
        $data_user['status_user'] = $this->request->getPost('status_pegawai'); // set status user
        $userModel->update($data_pegawai['id_user'], $data_user); // update data user
        $data = [   // set data pegawai
            'nama_pegawai' => ucwords($this->request->getPost('nama_pegawai')),
            'nip_pegawai' => $this->request->getPost('nip_pegawai'),
            'tempat_lahir_pegawai' => $this->request->getPost('tempat_lahir_pegawai'),
            'tgl_lahir_pegawai' => $this->request->getPost('tgl_lahir_pegawai'),
            'alamat_pegawai' => $this->request->getPost('alamat_pegawai'),
            'no_tlp_pegawai' => $this->request->getPost('no_tlp_pegawai'),
            'jabatan_pegawai' => $this->request->getPost('jabatan_pegawai'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status_pegawai' => $this->request->getPost('status_pegawai'),
            'password' => $password,
            'updated_at' => date('Y-m-d H:i:s')
        ];  
        $model->update($id, $data); // update data pegawai
        session()->setFlashdata('success', 'Data Pegawai berhasil diubah'); // set flashdata success
        return redirect()->to('/Pegawai');  // redirect ke halaman pegawai
    }

    public function delete($id) // menghapus data pegawai
    { 
        $model = new pegawaiModel();     // membuat objek model pegawai
        $userModel = new usersModel();   // membuat objek model user
        $data_pegawai = $model->where('id_pegawai', $id)->first() ; // mengambil data pegawai berdasarkan id
        $userModel->delete($data_pegawai['id_user']);   // hapus data user
        $model->delete($id);    // hapus data pegawai
        session()->setFlashdata('success', 'Data User berhasil dihapus');   // set flashdata success
        return redirect()->to('/Pegawai');  // redirect ke halaman pegawai
    }
}
?>