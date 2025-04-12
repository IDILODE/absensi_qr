<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiGuruModel extends Model
{
    protected $table = 'absensi_guru';
    protected $primaryKey = 'id';
    protected $allowedFields = ['guru_id', 'kehadiran_id', 'tanggal', 'jam_masuk', 'jam_pulang', 'keterangan'];
    protected $useTimestamps = false;

    // Fungsi untuk menambahkan data absensi
    public function addAbsensiGuru($data)
    {
        return $this->insert($data);
    }

    // Fungsi untuk mengambil data absensi berdasarkan guru_id
    public function getAbsensiByGuruId($guru_id)
    {
        return $this->where('guru_id', $guru_id)->findAll();
    }
}
