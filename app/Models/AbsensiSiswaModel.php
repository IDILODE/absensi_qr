<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiSiswaModel extends Model
{
    protected $table = 'absensi_siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['siswa_id', 'kehadiran_id', 'tanggal', 'jam_masuk', 'jam_pulang', 'keterangan'];
    protected $useTimestamps = false;

    // Fungsi untuk menambahkan data absensi
    public function addAbsensiSiswa($data)
    {
        return $this->insert($data);
    }

    // Fungsi untuk mengambil data absensi berdasarkan siswa_id
    public function getAbsensiBySiswaId($siswa_id)
    {
        return $this->where('siswa_id', $siswa_id)->findAll();
    }
}
