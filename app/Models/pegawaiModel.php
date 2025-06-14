<?php 
namespace App\Models;

use CodeIgniter\Model;

class pegawaiModel extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    protected $allowedFields = ['id_pegawai','id_user', 'nama_pegawai', 'nip_pegawai', 'tempat_lahir_pegawai', 'tgl_lahir_pegawai', 'alamat_pegawai', 'no_tlp_pegawai', 'jabatan_pegawai','status_pegawai','created_at', 'updated_at'];

    public function getPegawai($id = false)
    {
        if($id === false){
            return $this
                ->select('pegawai.*, users.username')
                ->join('users', 'users.id_user = pegawai.id_user')
                ->findAll();
        } else {
            return $this
                ->select('pegawai.*, users.username')
                ->join('users', 'users.id_user = pegawai.id_user')
                ->where(['id_pegawai' => $id])
                ->first();
        }   
    }

    public function getPegwaiByIdUser($id_user)
    {
        return $this
            ->select('pegawai.*, users.username')
            ->join('users', 'users.id_user = pegawai.id_user')
            ->where(['pegawai.id_user' => $id_user])
            ->first();
    }
}

?>