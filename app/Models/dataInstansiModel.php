<?php 
namespace App\Models;

use CodeIgniter\Model;

class dataInstansiModel extends Model
{
    protected $table = 'data_instansi';
    protected $primaryKey = 'id_data_instansi';
    protected $allowedFields = ['id_data_instansi','nama_alias_insansi','nama_instansi', 'alamat_instansi','no_tlp_instansi', 'email_instansi', 'nama_kepala_instansi', 'nip_kepala_instansi','logo_instansi', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getDataInstansi($id = false)
    {
        if($id == false){
            return $this->findAll();
        }
        return $this->where(['id_instansi' => $id])->first();
    }
}
?>