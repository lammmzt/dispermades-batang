<?php 
namespace App\Models;

use CodeIgniter\Model;

class jenisSuratModel extends Model
{
    protected $table = 'jenis_surat';
    protected $primaryKey = 'id_jenis_surat';
    protected $allowedFields = ['id_jenis_surat','nama_jenis_surat', 'kode_surat','ket_jenis_surat', 'template_jenis_surat', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getJenisSurat($id = false)
    {
        if($id == false){
            return $this->findAll();
        }
        return $this->where(['id_jenis_surat' => $id])->first();
    }
}
?>