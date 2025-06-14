<?php 
namespace App\Models;

use CodeIgniter\Model;

class externalModel extends Model
{
    protected $table = 'external';
    protected $primaryKey = 'id_external';
    protected $allowedFields = ['id_external', 'id_user', 'nama_external', 'kota_external', 'alamat_external', 'status_external', 'no_tlp_external','created_at', 'updated_at'];

    public function getexternal($id = false)
    {
        if($id === false){
            return $this
                ->select('external.*, users.username')
                ->join('users', 'users.id_user = external.id_user')
                ->findAll();
        } else {
            return $this
                ->select('external.*, users.username')
                ->join('users', 'users.id_user = external.id_user')
                ->where(['id_external' => $id])
                ->first();
        }   
    }
}

?>