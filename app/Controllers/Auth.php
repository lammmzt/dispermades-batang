<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\usersModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        $data['title'] = 'LOGIN | Dispermades Batang'; // set judul halaman
        $data['active'] = 'AUTH'; // set active menu
        if(session()->get('logged_in')){
            return redirect()->to(base_url('/'));
        }else{
            return view('Auth/index', $data);
        }
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        // dd($username, $password);
        $model = new usersModel();
        $user = $model->where('username', $username)->first();

        if($user){
            if(password_verify($password, $user['password'])){
                $ses_data = [
                    'id_user' => $user['id_user'],
                    'nama_user' => $user['nama_user'],
                    'role' => $user['role'],
                    'logged_in' => TRUE,
                ];
                session()->set($ses_data);
                return $this->response->setJSON([
                    'error' => false,   
                    'status' => '200',
                    'data' => 'Login Berhasil',
                ]);
            }else{
                return $this->response->setJSON([
                    'error' => true,
                    'status' => 401,
                    'data' => 'Password Salah',
                ]);
            }
        }else{
            return $this->response->setJSON([
                'error' => true,
                'status' => 401,
                'data' => 'Username Tidak Ditemukan',
            ]);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('Auth'));
    }
}


?>