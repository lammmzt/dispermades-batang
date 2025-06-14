<?php 
namespace App\Models;

use CodeIgniter\Model;

class referensiJenisSuratModel extends Model
{
    protected $table = 'referensi_jenis_surat';
    protected $primaryKey = 'id_referensi_jenis_surat';
    protected $allowedFields = ['nama_referensi_jenis_surat','tipe_referensi_jenis_surat', 'kode_referensi_jenis_surat','ket_referensi_jenis_surat', 'id_referensi_jenis_surat','created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getRefereni($id_referensi_jenis_surat = false)
    {
        if ($id_referensi_jenis_surat == false) {
            return $this
            ->select('*')
            ->orderBy('created_at', 'ASC')
            ->findAll();
        }
        return $this->where(['id_referensi_jenis_surat' => $id_referensi_jenis_surat])->first();
    }
}

?>