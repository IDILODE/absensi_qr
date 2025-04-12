<?php

namespace App\Controllers\Data;

use App\Controllers\BaseController;
use App\Models\JurusanModel;
use App\Models\KelasModel;

class JurusanController extends BaseController
{

    public function tambah()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }
        $jurusanModel = new JurusanModel();

        // Ambil data jurusan
        $data['jurusan'] = $jurusanModel->findAll();
        return view('data_jurusan/tambah', $data);
    }

    public function simpan()
    {
        $jurusanModel = new JurusanModel();
        $namaJurusan = $this->request->getPost('jurusan');

        // Cek apakah jurusan sudah ada
        $existingJurusan = $jurusanModel->where('jurusan', $namaJurusan)->first();
        if ($existingJurusan) {
            // Jika sudah ada, beri pesan error dan kembalikan input
            return redirect()->back()->with('error', 'Nama jurusan sudah ada!')->withInput();
        }

        // Jika tidak ada, lanjutkan menyimpan data jurusan
        $data = [
            'jurusan' => $namaJurusan
        ];

        $jurusanModel->insert($data);
        return redirect()->to(base_url('jurusan'));
    }


    public function edit($id)
    {
        $jurusanModel = new JurusanModel();
        $data['jurusan'] = $jurusanModel->find($id);

        return view('data_jurusan/edit', $data);
    }

    public function update($id)
    {
        $jurusanModel = new JurusanModel();
        $namaJurusan = $this->request->getPost('jurusan');

        // Cek apakah nama jurusan sudah ada, kecuali untuk jurusan yang sedang diedit
        $existingJurusan = $jurusanModel->where('jurusan', $namaJurusan)->where('id !=', $id)->first();
        if ($existingJurusan) {
            // Jika sudah ada, beri pesan error
            return redirect()->back()->with('error', 'Nama jurusan sudah ada!');
        }

        // Jika tidak ada, lanjutkan update data jurusan
        $data = [
            'jurusan' => $namaJurusan
        ];

        $jurusanModel->update($id, $data);
        return redirect()->to(base_url('jurusan'));
    }

    public function delete($id)
    {
        $jurusanModel = new JurusanModel();
        $kelasModel = new KelasModel();

        // Cek apakah jurusan digunakan di kelas
        $kelas = $kelasModel->where('jurusan_id', $id)->first();
        if ($kelas) {
            // Jika jurusan digunakan di kelas, beri pesan error
            return redirect()->to(base_url('jurusan'))->with('error', 'Jurusan ini tidak dapat dihapus karena sedang digunakan di kelas!');
        }

        // Jika jurusan tidak digunakan di kelas, lanjutkan penghapusan
        $jurusanModel->delete($id);
        return redirect()->to(base_url('jurusan'));
    }
}
