<?php

namespace App\Controllers\Scan;

use App\Controllers\BaseController;
use App\Models\AbsensiSiswaModel;
use App\Models\SiswaModel;
use App\Models\AbsensiGuruModel;
use App\Models\GuruModel;
use CodeIgniter\API\ResponseTrait;

class AbsenMasukController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }
        return view('scan/absen_masuk');
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



            if ($existingAbsensi && !empty($existingAbsensi['jam_pulang'])) {
                return $this->respond([
                    'status' => 'error',
                    'message' => 'Absensi hari ini sudah terdaftar, istirahat yang cukup ya! Sampai besok.',
                    'siswa' => $siswaData,
                    'absensi' => $existingAbsensi
                ], 400);
            }

            if ($existingAbsensi && empty($existingAbsensi['jam_masuk'])) {
                // Update jam masuk jika NULL
                $absensiModel->update($existingAbsensi['id'], ['jam_masuk' => $currentTime]);

                return $this->respond([
                    'status' => 'success',
                    'message' => 'Absensi masuk berhasil.',
                    'siswa' => $siswaData,
                    'absensi' => [
                        'id' => $existingAbsensi['id'],
                        'jam_masuk' => $currentTime,
                        'jam_pulang' => $existingAbsensi['jam_pulang']
                    ]
                ], 400);
            }


            if ($existingAbsensi && empty($existingAbsensi['jam_pulang'])) {
                return $this->respond([
                    'status' => 'error',
                    'message' => 'Anda sudah absen masuk.',
                    'siswa' => $siswaData,
                    'absensi' => $existingAbsensi
                ], 400);
            }

            $absensiData = [
                'siswa_id' => $siswaData['id'],
                'kehadiran_id' => 1,
                'tanggal' => $tanggal,
                'jam_masuk' => $currentTime,
                'jam_pulang' => NULL,
            ];

            $absensiModel->save($absensiData);

            return $this->respond([
                'status' => 'success',
                'message' => 'Absensi masuk berhasil.',
                'siswa' => $siswaData,
                'absensi' => $absensiData
            ], 200);
        }

        // Logika untuk guru
        if ($guru) {
            $absensiModel = new AbsensiGuruModel();
            $tanggal = date('Y-m-d');
            $existingAbsensi = $absensiModel->where('guru_id', $guru['id'])->where('tanggal', $tanggal)->first();

            if ($existingAbsensi && !empty($existingAbsensi['jam_pulang'])) {
                return $this->respond([
                    'status' => 'error',
                    'message' => 'Absensi hari ini sudah terdaftar, istirahat yang cukup ya! Sampai besok.',
                    'guru' => $guru,
                    'absensi' => $existingAbsensi
                ], 400);
            }

            if ($existingAbsensi && empty($existingAbsensi['jam_masuk'])) {
                // Update jam masuk jika NULL
                $absensiModel->update($existingAbsensi['id'], ['jam_masuk' => $currentTime]);

                return $this->respond([
                    'status' => 'success',
                    'message' => 'Absensi masuk berhasil.',
                    'guru' => $guru,
                    'absensi' => [
                        'id' => $existingAbsensi['id'],
                        'jam_masuk' => $currentTime,
                        'jam_pulang' => $existingAbsensi['jam_pulang']
                    ]
                ], 400);
            }

            if ($existingAbsensi && empty($existingAbsensi['jam_pulang'])) {
                return $this->respond([
                    'status' => 'error',
                    'message' => 'Anda sudah absen masuk.',
                    'guru' => $guru,
                    'absensi' => $existingAbsensi
                ], 400);
            }

            $absensiData = [
                'guru_id' => $guru['id'],
                'kehadiran_id' => 1,
                'tanggal' => $tanggal,
                'jam_masuk' => $currentTime,
                'jam_pulang' => NULL,
            ];

            $absensiModel->save($absensiData);

            return $this->respond([
                'status' => 'success',
                'message' => 'Absensi masuk berhasil.',
                'guru' => $guru,
                'absensi' => $absensiData
            ], 200);
        }
    }
}
