<?php

namespace App\Controllers\Scan;

use App\Controllers\BaseController;
use App\Models\AbsensiSiswaModel;
use App\Models\SiswaModel;
use App\Models\AbsensiGuruModel;
use App\Models\GuruModel;
use CodeIgniter\API\ResponseTrait;

class AbsenPulangController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }
        return view('scan/absen_pulang');
    }

    public function processQR()
    {
        $request = $this->request->getJSON();
        $qrData = $request->qrData; // Data QR Code yang dipindai
        $currentTime = $request->currentTime; // Waktu yang dikirimkan dari client

        // Cek apakah kode QR valid
        if (empty($qrData)) {
            return $this->respond(['status' => 'errorr', 'message' => 'QR Code tidak valid.'], 400);
        }

        // Cari siswa atau guru berdasarkan kode unik (QR code)
        $siswaModel = new SiswaModel();
        $guruModel = new GuruModel();

        $siswa = $siswaModel->where('kode_unik', $qrData)->first();
        $guru = $guruModel->where('kode_unik', $qrData)->first();

        if (!$siswa && !$guru) {
            return $this->respond(['status' => 'errorr', 'message' => 'QR Code tidak valid.'], 404);
        }

        // Logika untuk siswa
        if ($siswa) {
            $siswaWithKelasJurusan = $siswaModel->getSiswaWithKelasJurusan();
            $siswaData = null;

            foreach ($siswaWithKelasJurusan as $siswaItem) {
                if ($siswaItem['id'] == $siswa['id']) {
                    $siswaData = $siswaItem;
                    break;
                }
            }

            $absensiModel = new AbsensiSiswaModel();
            $tanggal = date('Y-m-d');
            $existingAbsensi = $absensiModel->where('siswa_id', $siswaData['id'])->where('tanggal', $tanggal)->first();

            if (!$existingAbsensi) {
                return $this->respond(['status' => 'errorr', 'message' => 'Absensi masuk belum dilakukan.'], 400);
            }

            if (empty($existingAbsensi['jam_masuk'])) {
                return $this->respond([
                    'status' => 'errorr',
                    'message' => 'Absensi masuk belum dilakukan.',
                    'siswa' => $siswaData
                ], 400);
            }

            if (!empty($existingAbsensi['jam_pulang'])) {
                return $this->respond([
                    'status' => 'error',
                    'message' => 'Anda sudah absen pulang.',
                    'siswa' => $siswaData,
                    'absensi' => $existingAbsensi
                ], 400);
            }

            // Simpan absensi pulang
            $absensiData = [
                'jam_pulang' => $currentTime
            ];

            $absensiModel->update($existingAbsensi['id'], $absensiData);

            return $this->respond([
                'status' => 'success',
                'message' => 'Absensi Pulang Berhasil',
                'siswa' => $siswaData,
                'absensi' => [
                    'jam_masuk' => $existingAbsensi['jam_masuk'],
                    'jam_pulang' => $currentTime
                ],
            ], 200);
        }

        // Logika untuk guru
        if ($guru) {
            $absensiModel = new AbsensiGuruModel();
            $tanggal = date('Y-m-d');
            $existingAbsensi = $absensiModel->where('guru_id', $guru['id'])->where('tanggal', $tanggal)->first();

            if (!$existingAbsensi) {
                return $this->respond(['status' => 'errorr', 'message' => 'Absensi masuk belum dilakukan.'], 400);
            }

            if (empty($existingAbsensi['jam_masuk'])) {
                return $this->respond([
                    'status' => 'errorr',
                    'message' => 'Absensi masuk belum dilakukan.',
                    'guru' => $guru
                ], 400);
            }

            if (!empty($existingAbsensi['jam_pulang'])) {
                return $this->respond([
                    'status' => 'error',
                    'message' => 'Anda sudah absen pulang.',
                    'guru' => $guru,
                    'absensi' => $existingAbsensi
                ], 400);
            }

            // Simpan absensi pulang
            $absensiData = [
                'jam_pulang' => $currentTime
            ];

            $absensiModel->update($existingAbsensi['id'], $absensiData);

            return $this->respond([
                'status' => 'success',
                'message' => 'Absensi Pulang Berhasil',
                'guru' => $guru,
                'absensi' => [
                    'jam_masuk' => $existingAbsensi['jam_masuk'],
                    'jam_pulang' => $currentTime
                ],
            ], 200);
        }
    }
}
