<?php

namespace App\Models;

use CodeIgniter\Model;

class KehadiranModel extends Model
{
    protected $table = 'kehadiran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['status'];
    protected $useTimestamps = false;

    // Fungsi untuk mengambil semua status kehadiran
    public function getAllKehadiran()
    {
        return $this->findAll();
    }

    // Fungsi untuk mendapatkan status kehadiran berdasarkan id
    public function getKehadiranById($id)
    {
        return $this->find($id);
    }
}
