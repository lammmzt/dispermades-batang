<?php 
namespace App\Controllers;

use App\Models\externalModel;
use App\Models\usersModel;
use Ramsey\Uuid\Uuid;

class External extends BaseController
{
    public function index() // menampilkan data external
    {
        $externalModel = new externalModel(); // membuat objek model external
        $data['title'] = 'External'; // set judul halaman
        $data['active'] = 'External';    // set active menu
        $data['external'] = $externalModel->getexternal(); // mengambil semua data external
        $data['validation'] = \Config\Services::validation(); // set validasi
        
        return view('Admin/External/index', $data); // tampilkan view external
    }

    public function save() // menyimpan data external
    {
        $model = new externalModel(); // membuat objek model external
        $userModel = new usersModel(); // membuat objek model user
        $validation = \Config\Services::validation(); // membuat objek validasi
        // dd($this->request->getPost());
        $validation->setRules([ // set rules validasi
            'nama_external' => 'required',
            'kota_external' => 'required',
            'alamat_external' => 'required',
            'kota_external' => 'required',
            'no_tlp_external' => 'required',
        ]);
        if (!$validation->run($this->request->getPost())) { // jika validasi tidak terpenuhi
            // session()->setFlashdata('errors', $validation->getErrors());  
            session()->setFlashdata('errors', 'Data external gagal ditambahkan'); // set flashdata error
            return redirect()->to('/External')->withInput(); // redirect ke halaman external
        }
        $nama_external = $this->request->getPost('nama_external'); // mengambil data nama external
        $checkNama = $model->where('nama_external', $nama_external)->countAllResults(); // cek nama external sudah digunakan
        if ($checkNama > 0) { // jika nama external sudah digunakan
            session()->setFlashdata('errors', 'Nama external sudah digunakan'); // set flashdata error
            return redirect()->to('/External')->withInput(); // redirect ke halaman external
        }
        $id_user = Uuid::uuid4()->toString(); // generate id user
        $username = $this->request->getPost('username'); // mengambil data username
        // save user
        $data_user = [ // set data user
            'id_user' => $id_user,
            'username' => $username,
            'password' => password_hash($username, PASSWORD_DEFAULT),
            'nama_user' => ucwords($nama_external),
            'status_user' => '1',
            'role' => 'External',
            'created_at' => date('Y-m-d H:i:s')
        ];
        // dd($data_user);
        $userModel->insert($data_user); // insert data user
        // save external
        $data = [ // set data external
            'id_external' => Uuid::uuid4()->toString(),
            'id_user' => $id_user,
            'nama_external' => ucwords($this->request->getPost('nama_external')),
            'kota_external' => $this->request->getPost('kota_external'),
            'kota_external' => $this->request->getPost('kota_external'),
            'alamat_external' => $this->request->getPost('alamat_external'),
            'no_tlp_external' => $this->request->getPost('no_tlp_external'),
            'status_external' => '1',
            'created_at' => date('Y-m-d H:i:s')
        ];
        // dd($data);
        $model->insert($data); // insert data external

        session()->setFlashdata('success', 'Data external berhasil ditambahkan'); // set flashdata success
        return redirect()->to('/External'); // redirect ke halaman external
    }

    public function update() // mengupdate data external
    {
        $model = new externalModel(); // membuat objek model external
        $id = $this->request->getPost('id_external'); // mengambil data id external
        $validation = \Config\Services::validation(); // membuat objek validasi
        $validation->setRules([ // set rules validasi
            'nama_external' => 'required', // nama external wajib diisi
            'kota_external' => 'required',
            'kota_external' => 'required',
            'alamat_external' => 'required',
            'no_tlp_external' => 'required',
        ]);
        if (!$validation->run($this->request->getPost())) { // jika validasi tidak terpenuhi
            session()->setFlashdata('errors', 'Data external gagal diubah'); // set flashdata error
            return redirect()->to('/External')->withInput(); // redirect ke halaman external
        }
        $data_external = $model->where('id_external', $id)->first(); // mengambil data external berdasarkan id
        // update nama external
        $data_user['nama_user'] = ucwords($this->request->getPost('nama_external')); // set nama user
        if ($this->request->getPost('nama_external') != $data_external['nama_external']) { // jika nama external diubah
            $checkNama = $model->where('nama_external', $this->request->getPost('nama_external'))->countAllResults(); // cek nama external sudah digunakan
            if ($checkNama > 0) { // jika nama external sudah digunakan
                session()->setFlashdata('errors', 'Nama external sudah digunakan'); // set flashdata error
                return redirect()->to('/External')->withInput(); // redirect ke halaman external
            }
        }
        $userModel = new usersModel(); // membuat objek model user
        $detail_user = $userModel->where('id_user', $data_external['id_user'])->first(); // mengambil data user berdasarkan id
        if ($this->request->getPost('password') != '' || $this->request->getPost('password') != null) { // jika password diubah
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT); // hash password
        }else { // jika password tidak diubah
            $password = $detail_user['password']; // ambil password lama
        }
        
        $data_user['status_user'] = $this->request->getPost('status_external'); // set status user
        $userModel->update($data_external['id_user'], $data_user); // update data user
        $data = [   // set data external
            'nama_external' => ucwords($this->request->getPost('nama_external')),
            'kota_external' => $this->request->getPost('kota_external'),
            'kota_external' => $this->request->getPost('kota_external'),
            'alamat_external' => $this->request->getPost('alamat_external'),
            'no_tlp_external' => $this->request->getPost('no_tlp_external'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status_external' => $this->request->getPost('status_external'),
            'password' => $password,
            'updated_at' => date('Y-m-d H:i:s')
        ];  
        $model->update($id, $data); // update data external
        session()->setFlashdata('success', 'Data external berhasil diubah'); // set flashdata success
        return redirect()->to('/External');  // redirect ke halaman external
    }

    public function delete($id) // menghapus data external
    { 
        $model = new externalModel();     // membuat objek model external
        $userModel = new usersModel();   // membuat objek model user
        $data_external = $model->where('id_external', $id)->first() ; // mengambil data external berdasarkan id
        $userModel->delete($data_external['id_user']);   // hapus data user
        $model->delete($id);    // hapus data external
        session()->setFlashdata('success', 'Data User berhasil dihapus');   // set flashdata success
        return redirect()->to('/External');  // redirect ke halaman external
    }
}
?>