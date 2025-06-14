<?php 
namespace App\Models;

use CodeIgniter\Model;

class suratMasukModel extends Model
{
    protected $table = 'surat_masuk';
    protected $primaryKey = 'id_surat_masuk';
    protected $allowedFields = ['id_surat_masuk','id_user', 'perihal_surat_masuk', 'ket_surat_masuk', 'pengirim_surat_masuk', 'no_surat_masuk', 'tipe_file_surat_masuk','tgl_surat_masuk', 'file_surat_masuk','status_surat_masuk', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
        
    public function getSuratMasuk($id = false)
    {
        if ($id === false) {
            return $this
            ->select('surat_masuk.*, users.nama_user')
            ->join('users', 'users.id_user = surat_masuk.id_user')
            ->orderBy('created_at', 'DESC')
            ->findAll();
        } else {
            return $this
            ->select('surat_masuk.*, users.nama_user')
            ->join('users', 'users.id_user = surat_masuk.id_user')
            ->where('surat_masuk.id_surat_masuk', $id);
        }
    }

    public function getSuratByDateRange($startDate, $endDate)
    {
        return $this
        ->select('surat_masuk.*, users.nama_user')
        ->join('users', 'users.id_user = surat_masuk.id_user')
        // where created_at is between startDate and endDate
        ->where('surat_masuk.created_at >=', $startDate)
        ->where('surat_masuk.created_at <=', $endDate)
        ->orderBy('surat_masuk.created_at', 'DESC')
        ->findAll();
    }
}

?>