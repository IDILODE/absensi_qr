<?php

namespace App\Controllers\Absensi;

use App\Controllers\BaseController;
use App\Models\AbsensiSiswaModel;
use App\Models\PengaturanModel;
use App\Models\KehadiranModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;

class AbsensiSiswa extends BaseController
{

    public function __construct()
    {
        helper('form'); // Memuat helper form
    }

    public function index()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }

        $absensiModel = new AbsensiSiswaModel();
        $pengaturanModel = new PengaturanModel();
        $kehadiranModel = new KehadiranModel();
        $kelasModel = new KelasModel();
        $siswaModel = new SiswaModel();

        // Ambil kelas_id, jurusan, tanggal, dan keyword dari parameter GET
        $kelas_id = $this->request->getGet('kelas_id') ?? session()->get('kelas_id');
        $jurusan = $this->request->getGet('jurusan') ?? session()->get('jurusan');
        $tanggal = $this->request->getGet('tanggal') ?: session()->get('keep_tanggal') ?: date('Y-m-d');
        $keyword = $this->request->getGet('keyword');

        // Simpan kelas_id dan jurusan ke dalam sesi hanya jika ada parameter
        if ($kelas_id || $jurusan) {
            session()->set('kelas_id', $kelas_id);
            session()->set('jurusan', $jurusan);
        }

        // Siapkan data untuk view
        $data = [
            'kelas_id' => $kelas_id,
            'jurusan' => $jurusan,
            'tanggal' => $tanggal,
            'keyword' => $keyword,
        ];

        // Query untuk mendapatkan semua siswa yang terdaftar di kelas
        $siswaQuery = $siswaModel->select('siswa.id, siswa.nis, siswa.nama_siswa')
            ->where('siswa.kelas_id', $kelas_id);

        // Filter berdasarkan keyword jika ada
        if ($keyword) {
            $siswaQuery->like('siswa.nis', $keyword)
                ->orLike('siswa.nama_siswa', $keyword);
        }

        // Ambil data siswa yang terdaftar di kelas
        $data['siswa'] = $siswaQuery->findAll();

        // Query absensi dengan beberapa filter
        $absensiQuery = $absensiModel
            ->select('absensi_siswa.*, siswa.nis, siswa.nama_siswa')
            ->join('siswa', 'siswa.id = absensi_siswa.siswa_id')
            ->where('absensi_siswa.tanggal', $tanggal);  // Filter berdasarkan tanggal

        if ($kelas_id) {
            $absensiQuery->where('siswa.kelas_id', $kelas_id);  // Filter berdasarkan kelas
        }

        // Ambil data absensi yang sudah difilter
        $data['absensi_siswa'] = $absensiQuery->findAll();

        // Ambil data lainnya yang dibutuhkan (misalnya kelas, jurusan, dsb.)
        $data['tahun_ajaran'] = $pengaturanModel->first()['tahun_ajaran'];
        $data['kehadiran'] = $kehadiranModel->findAll();
        $data['kelas_jurusan'] = $kelasModel->getJurusan();

        // Tambahkan logika untuk memeriksa status kehadiran
        foreach ($data['absensi_siswa'] as &$absensi) {
            // Cek apakah Jam Masuk sudah ada tapi Jam Pulang kosong
            if (!empty($absensi['jam_masuk']) && empty($absensi['jam_pulang'])) {
                $tanggalHariIni = date('Y-m-d');
                // Jika tanggal absensi sudah lewat (hari ini atau lebih besar), ubah status ke Tanpa Keterangan
                if ($absensi['tanggal'] < $tanggalHariIni) {
                    // Cari ID kehadiran Tanpa Keterangan
                    $tanpaKeteranganId = 4; // ID untuk Tanpa Keterangan
                    $absensi['kehadiran_id'] = $tanpaKeteranganId; // Set kehadiran jadi Tanpa Keterangan
                    $absensi['keterangan'] = 'Absensi jam pulang belum dilakukan'; // Set keterangan
                }
            }
        }
        return view('absensi_siswa/index', $data);
    }

    public function edit($id)
    {
        $absensiModel = new AbsensiSiswaModel();
        $absensi = $absensiModel->find($id);

        if (!$absensi) {
            return redirect()->to('/absensi_siswa')->with('error', 'Data absensi tidak ditemukan.');
        }

        $jamMasuk = $this->request->getPost('jam_masuk');
        $jamPulang = $this->request->getPost('jam_pulang');

        // Validasi: Jam Pulang tidak boleh diisi jika Jam Masuk kosong
        if (empty($jamMasuk) && !empty($jamPulang)) {
            session()->setFlashdata('error', 'Jam Masuk tidak boleh kosong jika Jam Pulang diisi.');
            session()->setFlashdata('modalError', 'editModal' . $id); // Simpan ID modal
            return redirect()->back()->withInput(); // Kembali ke halaman sebelumnya
        }

        $data = [
            'kehadiran_id' => $this->request->getPost('kehadiran'),
            'jam_masuk' => !empty($jamMasuk) ? $jamMasuk : NULL,
            'jam_pulang' => !empty($jamPulang) ? $jamPulang : NULL,
            'keterangan' => !empty($this->request->getPost('keterangan')) ? $this->request->getPost('keterangan') : NULL
        ];

        $absensiModel->update($id, $data);

        session()->set('keep_tanggal', $this->request->getPost('tanggal'));
        session()->set('kelas_id', $this->request->getPost('kelas_id'));
        session()->set('jurusan', $this->request->getPost('jurusan'));

        return redirect()->to('/absensi_siswa')->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function tambah()
    {
        $jamMasuk = $this->request->getPost('jam_masuk');
        $jamPulang = $this->request->getPost('jam_pulang');

        // Validasi: Jam Pulang tidak boleh diisi jika Jam Masuk kosong
        if (empty($jamMasuk) && !empty($jamPulang)) {
            session()->setFlashdata('error', 'Jam Masuk tidak boleh kosong jika Jam Pulang diisi.');
            session()->setFlashdata('modalError', 'tambahModal' . $this->request->getPost('siswa_id')); // Simpan ID modal
            return redirect()->back()->withInput(); // Kembali ke halaman sebelumnya
        }
        $data = [
            'siswa_id' => $this->request->getPost('siswa_id'),
            'tanggal' => $this->request->getPost('tanggal'),
            'kelas_id' => $this->request->getPost('kelas_id'),
            'jurusan' => $this->request->getPost('jurusan'),
            'kehadiran_id' => $this->request->getPost('kehadiran'),
            'jam_masuk' => !empty($jamMasuk) ? $jamMasuk : NULL,
            'jam_pulang' => !empty($jamPulang) ? $jamPulang : NULL,
            'keterangan' => !empty($this->request->getPost('keterangan')) ? $this->request->getPost('keterangan') : NULL
        ];

        $absensiModel = new AbsensiSiswaModel();
        $absensiModel->insert($data);

        session()->set('keep_tanggal', $this->request->getPost('tanggal'));
        session()->set('kelas_id', $this->request->getPost('kelas_id'));
        session()->set('jurusan', $this->request->getPost('jurusan'));

        return redirect()->to('/absensi_siswa')->with('success', 'Absensi berhasil ditambahkan.');
    }
}
