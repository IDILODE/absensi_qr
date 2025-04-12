<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kelas', 'jurusan_id'];

    // Relasi ke model Jurusan
    public function getJurusan()
    {
        return $this->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
            ->select('kelas.*, jurusan.jurusan')
            ->findAll();
    }

    // Menambahkan data kelas
    public function addKelas($data)
    {
        return $this->insert($data);
    }

    public function countKelas()
    {
        return $this->countAllResults();
    }
}
