<?php

namespace App\Controllers\Absensi;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\AbsensiGuruModel;
use App\Models\PengaturanModel;
use App\Models\KehadiranModel;

class AbsensiGuru extends BaseController
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

        $guruModel = new GuruModel();
        $absensiModel = new AbsensiGuruModel();
        $pengaturanModel = new PengaturanModel();
        $kehadiranModel = new KehadiranModel();

        // Tentukan tanggal berdasarkan GET atau default ke tanggal hari ini
        $tanggal = $this->request->getGet('tanggal') ?: session()->get('keep_tanggal') ?: date('Y-m-d');
        session()->remove('keep_tanggal');

        $keyword = $this->request->getGet('keyword');
        $data['keyword'] = $keyword;
        $data['tanggal'] = $tanggal;

        // Query absensi
        $absensiQuery = $absensiModel
            ->select('absensi_guru.*, guru.nuptk, guru.nama_guru')
            ->join('guru', 'guru.id = absensi_guru.guru_id');

        if ($tanggal) {
            $absensiQuery->where('absensi_guru.tanggal', $tanggal);
        }

        if ($keyword) {
            $absensiQuery->groupStart()
                ->like('guru.nuptk', $keyword)
                ->orLike('guru.nama_guru', $keyword)
                ->groupEnd();
        }

        $data['absensi_guru'] = $absensiQuery->findAll();
        $data['guru'] = !$keyword ? $guruModel->findAll() : $guruModel->like('nuptk', $keyword)
            ->orLike('nama_guru', $keyword)
            ->findAll();
        $data['tahun_ajaran'] = $pengaturanModel->first()['tahun_ajaran'];
        $data['kehadiran'] = $kehadiranModel->findAll();

        // Tambahkan logika untuk memeriksa status kehadiran
        foreach ($data['absensi_guru'] as &$absensi) {
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

        return view('absensi_guru/index', $data);
    }

    public function edit($id)
    {
        $absensiModel = new AbsensiGuruModel();

        $absensi = $absensiModel->find($id);

        if (!$absensi) {
            return redirect()->to('/absensi_guru')->with('error', 'Data absensi tidak ditemukan.');
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

        // Simpan tanggal yang sedang diedit agar tetap muncul setelah "Simpan"
        session()->set('keep_tanggal', $this->request->getPost('tanggal'));

        return redirect()->to('/absensi_guru')->with('success', 'Data absensi berhasil diperbarui.');
    }


    public function tambah()
    {
        $jamMasuk = $this->request->getPost('jam_masuk');
        $jamPulang = $this->request->getPost('jam_pulang');

        // Validasi: Jam Pulang tidak boleh diisi jika Jam Masuk kosong
        if (empty($jamMasuk) && !empty($jamPulang)) {
            session()->setFlashdata('error', 'Jam Masuk tidak boleh kosong jika Jam Pulang diisi.');
            session()->setFlashdata('modalError', 'tambahModal' . $this->request->getPost('guru_id')); // Simpan ID modal
            return redirect()->back()->withInput(); // Kembali ke halaman sebelumnya
        }
        $data = [
            'guru_id' => $this->request->getPost('guru_id'),
            'tanggal' => $this->request->getPost('tanggal'),
            'kehadiran_id' => $this->request->getPost('kehadiran'),
            'jam_masuk' => !empty($jamMasuk) ? $jamMasuk : NULL,
            'jam_pulang' => !empty($jamPulang) ? $jamPulang : NULL,
            'keterangan' => !empty($this->request->getPost('keterangan')) ? $this->request->getPost('keterangan') : NULL
        ];

        $absensiModel = new AbsensiGuruModel();
        $absensiModel->insert($data);

        session()->set('keep_tanggal', $this->request->getPost('tanggal'));


        return redirect()->to('/absensi_guru')->with('success', 'Absensi berhasil ditambahkan.');
    }
}
