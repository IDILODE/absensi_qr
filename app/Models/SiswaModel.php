<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nis', 'nama_siswa',  'jenis_kelamin', 'kelas_id', 'no_hp', 'kode_unik'];
    protected $useTimestamps = false;

    public function getSiswaWithKelasJurusan()
    {
        return $this->select('siswa.*, kelas.nama_kelas, jurusan.jurusan')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
            ->findAll();
    }


    // SiswaModel.php
    public function getKelasWithJumlahSiswa()
    {
        return $this->select('kelas.id, kelas.nama_kelas, jurusan.jurusan, COUNT(siswa.id) as jumlah_siswa')
            ->join('kelas', 'kelas.id = siswa.kelas_id', 'right')  // Menggunakan right join untuk memastikan semua kelas muncul
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
            ->groupBy('kelas.id, jurusan.id') // Group by kelas dan jurusan untuk menghitung jumlah siswa
            ->findAll();
    }


    // Menambahkan data siswa
    public function addSiswa($data)
    {
        return $this->insert($data);
    }
    public function countSiswa()
    {
        return $this->countAllResults();
    }
}
