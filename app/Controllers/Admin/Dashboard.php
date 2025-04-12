<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\PengaturanModel;
use App\Models\KelasModel;
use App\Models\PetugasModel;
use App\Models\AbsensiSiswaModel;
use App\Models\AbsensiGuruModel;
use App\Models\KehadiranModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }

        // Mengambil data dari model
        $siswaModel = new SiswaModel();
        $guruModel = new GuruModel();
        $kelasModel = new KelasModel();
        $petugasModel = new PetugasModel();
        $pengaturanModel = new PengaturanModel();
        $kehadiranModel = new KehadiranModel();
        $absensiSiswaModel = new AbsensiSiswaModel();
        $absensiGuruModel = new AbsensiGuruModel();  // Model Absensi Guru

        // Hitung jumlah siswa dan guru
        $data['jumlah_siswa'] = $siswaModel->countSiswa();
        $data['jumlah_guru'] = $guruModel->countGuru();
        $data['jumlah_kelas'] = $kelasModel->countKelas();
        $data['jumlah_petugas'] = $petugasModel->countPetugas();

        // Ambil tanggal hari ini
        $tanggal = date('Y-m-d');

        // Mengambil data absensi untuk siswa hari ini
        $absensiSiswaHariIni = $absensiSiswaModel
            ->select('kehadiran_id')
            ->where('tanggal', $tanggal)
            ->findAll();

        // Menghitung jumlah siswa berdasarkan status kehadiran
        $hadirCountSiswa = 0;
        $sakitCountSiswa = 0;
        $izinCountSiswa = 0;
        $alfaCountSiswa = 0;

        foreach ($absensiSiswaHariIni as $absensi) {
            $kehadiran = $kehadiranModel->find($absensi['kehadiran_id']);
            if ($kehadiran) {
                switch ($kehadiran['status']) {
                    case 'Hadir':
                        $hadirCountSiswa++;
                        break;
                    case 'Sakit':
                        $sakitCountSiswa++;
                        break;
                    case 'Izin':
                        $izinCountSiswa++;
                        break;
                    case 'Tanpa Keterangan': // Alfa
                        $alfaCountSiswa++;
                        break;
                }
            }
        }

        // Mengambil data absensi untuk guru hari ini
        $absensiGuruHariIni = $absensiGuruModel
            ->select('kehadiran_id')
            ->where('tanggal', $tanggal)
            ->findAll();

        // Menghitung jumlah guru berdasarkan status kehadiran
        $hadirCountGuru = 0;
        $sakitCountGuru = 0;
        $izinCountGuru = 0;
        $alfaCountGuru = 0;

        foreach ($absensiGuruHariIni as $absensi) {
            $kehadiran = $kehadiranModel->find($absensi['kehadiran_id']);
            if ($kehadiran) {
                switch ($kehadiran['status']) {
                    case 'Hadir':
                        $hadirCountGuru++;
                        break;
                    case 'Sakit':
                        $sakitCountGuru++;
                        break;
                    case 'Izin':
                        $izinCountGuru++;
                        break;
                    case 'Tanpa Keterangan': // Alfa
                        $alfaCountGuru++;
                        break;
                }
            }
        }

        // Menyimpan data ke dalam view
        $data['hadir_count_siswa'] = $hadirCountSiswa;
        $data['sakit_count_siswa'] = $sakitCountSiswa;
        $data['izin_count_siswa'] = $izinCountSiswa;
        $data['alfa_count_siswa'] = $alfaCountSiswa;

        // Menyimpan data absensi guru
        $data['hadir_count_guru'] = $hadirCountGuru;
        $data['sakit_count_guru'] = $sakitCountGuru;
        $data['izin_count_guru'] = $izinCountGuru;
        $data['alfa_count_guru'] = $alfaCountGuru;

        // Menampilkan view dashboard
        $tahunAjaran = $pengaturanModel->first();
        $data['tahun_ajaran'] = $tahunAjaran['tahun_ajaran'];
        $data['nama_sekolah'] = $pengaturanModel->first()['nama_sekolah'];
        // Mendapatkan data absensi siswa selama 7 hari terakhir
        $last7Days = [];
        $siswaHadir = [];
        $siswaIzin = [];
        $siswaSakit = [];
        $siswaAlfa = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-$i days"));
            $absensiSiswaHariIni = $absensiSiswaModel->select('kehadiran_id')->where('tanggal', $tanggal)->findAll();

            $hadir = 0;
            $izin = 0;
            $sakit = 0;
            $alfa = 0;

            foreach ($absensiSiswaHariIni as $absensi) {
                $kehadiran = $kehadiranModel->find($absensi['kehadiran_id']);
                if ($kehadiran) {
                    switch ($kehadiran['status']) {
                        case 'Hadir':
                            $hadir++;
                            break;
                        case 'Izin':
                            $izin++;
                            break;
                        case 'Sakit':
                            $sakit++;
                            break;
                        case 'Tanpa Keterangan':
                            $alfa++;
                            break;
                    }
                }
            }
            $last7Days[] = $tanggal;
            $siswaHadir[] = $hadir;
            $siswaIzin[] = $izin;
            $siswaSakit[] = $sakit;
            $siswaAlfa[] = $alfa;
        }

        // Mendapatkan data absensi guru selama 7 hari terakhir
        $guruHadir = [];
        $guruIzin = [];
        $guruSakit = [];
        $guruAlfa = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-$i days"));
            $absensiGuruHariIni = $absensiGuruModel->select('kehadiran_id')->where('tanggal', $tanggal)->findAll();

            $hadir = 0;
            $izin = 0;
            $sakit = 0;
            $alfa = 0;

            foreach ($absensiGuruHariIni as $absensi) {
                $kehadiran = $kehadiranModel->find($absensi['kehadiran_id']);
                if ($kehadiran) {
                    switch ($kehadiran['status']) {
                        case 'Hadir':
                            $hadir++;
                            break;
                        case 'Izin':
                            $izin++;
                            break;
                        case 'Sakit':
                            $sakit++;
                            break;
                        case 'Tanpa Keterangan':
                            $alfa++;
                            break;
                    }
                }
            }
            $guruHadir[] = $hadir;
            $guruIzin[] = $izin;
            $guruSakit[] = $sakit;
            $guruAlfa[] = $alfa;
        }

        // Kirimkan data ke view
        $data['last7Days'] = $last7Days;
        $data['siswaHadir'] = $siswaHadir;
        $data['siswaIzin'] = $siswaIzin;
        $data['siswaSakit'] = $siswaSakit;
        $data['siswaAlfa'] = $siswaAlfa;

        $data['guruHadir'] = $guruHadir;
        $data['guruIzin'] = $guruIzin;
        $data['guruSakit'] = $guruSakit;
        $data['guruAlfa'] = $guruAlfa;

        return view('dashboard/index', $data);
    }
}
