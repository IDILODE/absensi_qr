<?php

namespace App\Controllers\Data;

use App\Controllers\BaseController;
use App\Models\PetugasModel;

class DataPetugas extends BaseController
{
    public function index()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }
        $model = new PetugasModel();
        $data['petugas'] = $model->findAll(); // Ambil semua data petugas
        return view('data_petugas/index', $data);
    }
}
