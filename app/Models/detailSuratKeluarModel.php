<?php 
namespace App\Models;

use CodeIgniter\Model;

class detailSuratKeluarModel extends Model
{
    protected $table = 'detail_surat_keluar';
    protected $primaryKey = 'id_detail_surat_keluar';
    protected $allowedFields = ['id_surat_keluar', 'id_user', 'keterangan_detail_surat_keluar', 'status_detail_surat_keluar','created_at', 'updated_at'];

    public function getDetailSuratKeluar($id_detail_surat_keluar = false)
    {
        if ($id_detail_surat_keluar == false) {
            return $this
                ->select('detail_surat_keluar.*, surat_keluar.nomor_surat_keluar, surat_keluar.keterangan_surat_keluar, surat_keluar.isian_surat_keluar, surat_keluar.tanggal_surat_keluar, users.nama_user, surat_keluar.status_surat_keluar, surat_keluar.tanggal_surat_keluar, surat_keluar.judul_surat_keluar, jenis_surat.kode_surat')
                ->join('surat_keluar', 'detail_surat_keluar.id_surat_keluar = surat_keluar.id_surat_keluar')
                ->join('users', 'users.id_user = detail_surat_keluar.id_user')  
                ->join('jenis_surat', 'jenis_surat.id_jenis_surat = surat_keluar.id_jenis_surat')
                ->findAll();
        }
        return $this
            ->select('detail_surat_keluar.*, surat_keluar.nomor_surat_keluar, surat_keluar.keterangan_surat_keluar, surat_keluar.isian_surat_keluar, surat_keluar.tanggal_surat_keluar, users.nama_user, surat_keluar.status_surat_keluar, surat_keluar.tanggal_surat_keluar, surat_keluar.judul_surat_keluar, jenis_surat.kode_surat')
            ->join('surat_keluar', 'detail_surat_keluar.id_surat_keluar = surat_keluar.id_surat_keluar')
            ->join('users', 'users.id_user = detail_surat_keluar.id_user')  
            ->join('jenis_surat', 'jenis_surat.id_jenis_surat = surat_keluar.id_jenis_surat')
            ->where(['detail_surat_keluar.id_detail_surat_keluar' => $id_detail_surat_keluar])
            ->first();
    }

    public function getDetailSuratKeluarByIdSuratKeluar($id_surat_keluar)
    {
        return $this
            ->select('detail_surat_keluar.*, surat_keluar.nomor_surat_keluar, surat_keluar.keterangan_surat_keluar, surat_keluar.isian_surat_keluar, surat_keluar.tanggal_surat_keluar, users.nama_user,jenis_surat.nama_jenis_surat, jenis_surat.kode_surat,')
            ->join('surat_keluar', 'detail_surat_keluar.id_surat_keluar = surat_keluar.id_surat_keluar')
            ->join('users', 'users.id_user = detail_surat_keluar.id_user')
            ->join('jenis_surat', 'jenis_surat.id_jenis_surat = surat_keluar.id_jenis_surat')
            ->where(['detail_surat_keluar.id_surat_keluar' => $id_surat_keluar])
            ->findAll();
    }

    public function getSuratKeluarByUser($id_user)
    {
        return $this
            ->select('detail_surat_keluar.*, surat_keluar.nomor_surat_keluar, surat_keluar.keterangan_surat_keluar, surat_keluar.isian_surat_keluar, surat_keluar.tanggal_surat_keluar, users.nama_user, surat_keluar.status_surat_keluar, surat_keluar.tanggal_surat_keluar, surat_keluar.judul_surat_keluar, jenis_surat.kode_surat')
            ->join('surat_keluar', 'detail_surat_keluar.id_surat_keluar = surat_keluar.id_surat_keluar')
            ->join('users', 'users.id_user = detail_surat_keluar.id_user')  
            ->join('jenis_surat', 'jenis_surat.id_jenis_surat = surat_keluar.id_jenis_surat')
            ->where(['detail_surat_keluar.id_user' => $id_user])
            ->where(['surat_keluar.status_surat_keluar' => '3']);
    }
}

?>