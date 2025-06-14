<?php 
namespace App\Models;

use CodeIgniter\Model;

class detailJenisSuratModel extends Model
{
    protected $table = 'detail_jenis_surat';
    protected $primaryKey = 'id_detail_jenis_surat';
    protected $allowedFields = ['id_jenis_surat', 'id_jenis_surat', 'id_referensi_jenis_surat', 'created_at', 'updated_at'];

    public function getDetailJenisSurat($id_jenis_surat = false)
    {
        if ($id_jenis_surat == false) {
            return $this
                ->select('detail_jenis_surat.*, jenis_surat.nama_jenis_surat, jenis_surat.kode_surat, jenis_surat.ket_jenis_surat, jenis_surat.template_jenis_surat, jenis_surat.created_at, jenis_surat.updated_at')
                ->join('jenis_surat', 'detail_jenis_surat.id_jenis_surat = jenis_surat.id_jenis_surat')
                ->join('referensi_jenis_surat', 'detail_jenis_surat.id_referensi_jenis_surat = referensi_jenis_surat.id_referensi_jenis_surat')
                ->findAll();
        }
        return $this
            ->select('detail_jenis_surat.*, jenis_surat.nama_jenis_surat, jenis_surat.kode_surat, jenis_surat.ket_jenis_surat, jenis_surat.template_jenis_surat, jenis_surat.created_at, jenis_surat.updated_at')
            ->join('jenis_surat', 'detail_jenis_surat.id_jenis_surat = jenis_surat.id_jenis_surat')
            ->join('referensi_jenis_surat', 'detail_jenis_surat.id_referensi_jenis_surat = referensi_jenis_surat.id_referensi_jenis_surat')
            ->first();
    }

    public function geDetailByJenisSurat($id_jenis_surat)
    {
        return $this
            ->select('detail_jenis_surat.*, jenis_surat.id_jenis_surat, jenis_surat.nama_jenis_surat, jenis_surat.kode_surat, jenis_surat.ket_jenis_surat, jenis_surat.template_jenis_surat, jenis_surat.created_at, jenis_surat.updated_at, referensi_jenis_surat.nama_referensi_jenis_surat, referensi_jenis_surat.kode_referensi_jenis_surat, referensi_jenis_surat.ket_referensi_jenis_surat, referensi_jenis_surat.created_at, referensi_jenis_surat.tipe_referensi_jenis_surat')
            ->join('jenis_surat', 'detail_jenis_surat.id_jenis_surat = jenis_surat.id_jenis_surat')
            ->join('referensi_jenis_surat', 'detail_jenis_surat.id_referensi_jenis_surat = referensi_jenis_surat.id_referensi_jenis_surat')
            ->where(['detail_jenis_surat.id_jenis_surat' => $id_jenis_surat])
            ->findAll();
    }
}

?>