<?php

namespace App\Controllers\Admin;

use App\Models\PengaturanModel;
use App\Controllers\BaseController;

class Pengaturan extends BaseController
{
    public function index()
    {

        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }
        // Mendapatkan data pengaturan yang sudah ada
        $model = new PengaturanModel();
        $pengaturan = $model->find(1); // Mengambil data dengan ID 1
        return view('pengaturan/index', ['pengaturan' => $pengaturan]);
    }

    public function update()
    {
        // Validasi inputan
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_sekolah' => 'required',
            'tahun_ajaran' => 'required',

        ])) {
            // Ambil data dari form
            $data = [
                'nama_sekolah' => $this->request->getPost('nama_sekolah'),
                'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
                'copyright' => $this->request->getPost('copyright'),
            ];

            // Cek apakah ada file logo yang diupload
            $file = $this->request->getFile('logo');
            if ($file && $file->isValid()) {
                // Mendapatkan ekstensi file
                $fileExtension = $file->getExtension();
                $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'svg'];

                // Cek apakah ekstensi file termasuk yang diizinkan
                if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                    // Pindahkan file logo ke folder 'uploads'
                    $file->move('uploads', $file->getName());
                    $data['logo'] = $file->getName();
                } else {
                    // Jika format tidak valid, kembalikan error
                    return redirect()->to(base_url('pengaturan'))->with('error', 'Format file logo tidak didukung. Hanya .png, .jpg, .jpeg, .gif, .svg yang diperbolehkan.');
                }
            }

            // Buat model
            $model = new PengaturanModel();

            // Cek apakah data pengaturan dengan ID 1 ada
            $existingData = $model->find(1);

            if ($existingData) {
                // Jika data ada, update data dengan ID 1
                $model->update(1, $data);
            } else {
                // Jika data tidak ada, insert data baru
                $model->insert($data);
            }

            // Redirect kembali ke halaman pengaturan
            return redirect()->to(base_url('pengaturan'))->with('success', 'Data berhasil diupdate.');
        } else {
            // Jika validasi gagal, kembalikan ke form dengan error
            return redirect()->to(base_url('pengaturan'))->withInput()->with('errors', $validation->getErrors());
        }
    }
}
