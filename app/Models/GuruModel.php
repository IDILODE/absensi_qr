<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nuptk', 'nama_guru', 'jenis_kelamin', 'no_hp', 'alamat', 'kode_unik', 'suara'];
    protected $useTimestamps = false;
    // Menambahkan data guru
    public function addGuru($data)
    {
        return $this->insert($data);
    }
    public function countGuru()
    {
        return $this->countAllResults();
    }
}
