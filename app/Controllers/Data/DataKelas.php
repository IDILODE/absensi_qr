<?php

namespace App\Controllers\Data;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\JurusanModel;
use App\Models\PengaturanModel;
use App\Models\SiswaModel;

class DataKelas extends BaseController
{
    public function index()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }
        $kelasModel = new KelasModel();
        $data['kelas'] = $kelasModel->getJurusan(); // Mengambil data kelas

        $jurusanModel = new JurusanModel();
        $data['jurusan'] = $jurusanModel->getAllJurusan(); // Mengambil data jurusan

        // Membuat instance PengaturanModel untuk mengambil data tahun ajaran
        $pengaturanModel = new PengaturanModel();
        $tahunAjaran = $pengaturanModel->first(); // Mengambil data tahun ajaran pertama
        $data['tahun_ajaran'] = $tahunAjaran['tahun_ajaran']; // Menyimpan tahun ajaran ke dalam data

        return view('data_kelas/index', $data);
    }

    public function tambah()
    {
        $jurusanModel = new JurusanModel();
        $data['jurusan'] = $jurusanModel->getAllJurusan();
        return view('data_kelas/tambah', $data);
    }

    public function simpan()
    {
        $namaKelas = $this->request->getPost('nama_kelas');
        $jurusanId = $this->request->getPost('jurusan_id');

        // Validasi: pastikan jurusan dipilih
        if (empty($jurusanId)) {
            return redirect()->back()->with('error', 'Mohon pilih jurusan!')->withInput();
        }

        // Validasi: pastikan kelas diinput
        if (empty($namaKelas)) {
            return redirect()->back()->with('error', 'Mohon menginput kelas!')->withInput();
        }

        $data = [
            'nama_kelas' => $namaKelas,
            'jurusan_id' => $jurusanId
        ];

        $kelasModel = new KelasModel();
        $kelasModel->addKelas($data); // Pastikan ada metode addKelas di model

        return redirect()->to(base_url('data_kelas'));
    }

    public function edit($id)
    {
        $kelasModel = new KelasModel();
        $jurusanModel = new JurusanModel();

        $data['kelas'] = $kelasModel->find($id);
        $data['jurusan'] = $jurusanModel->getAllJurusan();

        return view('data_kelas/edit', $data);
    }

    public function update($id)
    {
        $kelasModel = new KelasModel();

        $data = [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'jurusan_id' => $this->request->getPost('jurusan_id')
        ];

        $kelasModel->update($id, $data);
        return redirect()->to(base_url('data_kelas'));
    }

    public function delete($id)
    {
        // Memeriksa apakah masih ada siswa yang terdaftar di kelas ini
        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->where('kelas_id', $id)->first(); // Mencari siswa yang terkait dengan kelas

        if ($siswa) {
            // Jika ada siswa yang terdaftar, kembalikan pesan error
            return redirect()->to(base_url('data_kelas'))->with('error', 'Kelas ini tidak dapat dihapus karena masih memiliki siswa!');
        }

        // Jika tidak ada siswa yang terdaftar, lanjutkan penghapusan kelas
        $kelasModel = new KelasModel();
        $kelasModel->delete($id); // Hapus kelas

        return redirect()->to(base_url('data_kelas'));
    }
}
