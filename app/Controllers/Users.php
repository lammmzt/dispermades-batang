<?php 
namespace App\Controllers;

use App\Models\usersModel;
use Ramsey\Uuid\Uuid;

class Users extends BaseController
{
    public function index() // menampilkan data users
    {
        $usersModel = new usersModel();  // membuat objek model users
        if(session()->get('role') == 'Kadin') { // jika session role kosong
            $data_user = $usersModel->like('role', 'Kadin')->orlike('role', 'Admin')->findAll(); // mengambil data users
        }else {
            $data_user = $usersModel->like('role', 'Pegawai')->orlike('role', 'External')->findAll(); // mengambil data users
        }
        $data['title'] = 'Daftar Pengguna'; // set judul halaman
        $data['active'] = 'Users'; // set active menu
        $data['users'] =  $data_user; // set data users
        $data['validation'] = \Config\Services::validation(); // set validasi
        
        return view('Admin/Users/index', $data);
    }

    public function save() // menyimpan data users
    { 
        $model = new usersModel(); // membuat objek model users
        $validation = \Config\Services::validation(); // membuat objek validasi
        $validation->setRules([ // set rules validasi
            'username' => 'required|is_unique[users.username]',
            'password' => 'required',
            'nama_user' => 'required',
            'status_user' => 'required',
            'role' => 'required'
        ]);
        if (!$validation->run($this->request->getPost())) { // jika validasi tidak terpenuhi
            // session()->setFlashdata('errors', $validation->getErrors()); 
            session()->setFlashdata('errors', 'Data User gagal ditambahkan'); // set flashdata error
            return redirect()->to('/Users')->withInput(); // redirect ke halaman users
        }
        $data = [ // set data users
            'id_user' => Uuid::uuid4()->toString(),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_user' => ucwords($this->request->getPost('nama_user')),
            'status_user' => $this->request->getPost('status_user'),
            'role' => $this->request->getPost('role'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $model->insert($data); // insert data users
        session()->setFlashdata('success', 'Data User berhasil ditambahkan'); // set flashdata success
        return redirect()->to('/Users'); // redirect ke halaman users
    }

    public function update() // mengupdate data users
    {
        $model = new usersModel(); // membuat objek model users
        $id = $this->request->getPost('id_user');   // mengambil data id users
        $validation = \Config\Services::validation(); // membuat objek validasi
        $users = $model->find($id); // mengambil data users berdasarkan id
        if ($this->request->getPost('username') == $users['username']) { // jika username sama dengan username sebelumnya
            $validation->setRules([ // set rules validasi
                'username' => 'required',
                'nama_user' => 'required',
                'status_user' => 'required',
                'role' => 'required'
            ]);
        } else { // jika username berbeda dengan username sebelumnya
            $validation->setRules([
                'username' => 'required|is_unique[users.username]',
                'nama_user' => 'required',
                'status_user' => 'required',
                'role' => 'required'
            ]);
        }
        if (!$validation->run($this->request->getPost())) { // jika validasi tidak terpenuhi
            // session()->setFlashdata('errors', $validation->getErrors());
            session()->setFlashdata('errors', 'Data User gagal diubah');
            return redirect()->to('/Users')->withInput();
        }
        $password = $this->request->getPost('password'); // mengambil data password
        if ($password) { // jika password diisi
            $new_pass = password_hash($password, PASSWORD_DEFAULT); // enkripsi password
        } else { // jika password tidak diisi
            $new_pass = $users['password']; // password tetap sama
        }
        $data = [ // set data users
            'username' => $this->request->getPost('username'),
            'nama_user' => ucwords($this->request->getPost('nama_user')),
            'status_user' => $this->request->getPost('status_user'),
            'role' => $this->request->getPost('role'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $model->update($id, $data); // update data users
        session()->setFlashdata('success', 'Data User berhasil diubah'); // set flashdata success
        return redirect()->to('/Users'); // redirect ke halaman users
    }

    public function delete($id) // menghapus data users
    { 
        $model = new usersModel(); // membuat objek model users
        $model->delete($id); // delete data users
        session()->setFlashdata('success', 'Data User berhasil dihapus'); 
        return redirect()->to('/Users'); // redirect ke halaman users
    }

    public function verifPassword() // verifikasi password
    {
        $model = new usersModel(); // membuat objek model users
        $id = session()->get('id_user'); // mengambil data id user dari session
        $users = $model->find($id); // mengambil data users berdasarkan id
        if (password_verify($this->request->getPost('password'), $users['password'])) { // jika password sesuai
            return $this->response->setJSON([
                'error' => false,
                'status' => '200',
                'data' => 'Password sesuai',
            ]);
        } else { // jika password tidak sesuai
            return $this->response->setJSON([
                'error' => true,
                'status' => '400',
                'data' => 'Password tidak sesuai',
            ]);
        }
    }
}
?>