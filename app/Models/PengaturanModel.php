<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_sekolah', 'tahun_ajaran', 'copyright', 'logo'];
    protected $useTimestamps = false;
}
