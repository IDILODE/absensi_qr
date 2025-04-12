<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Logo\Logo;
use App\Models\PengaturanModel;
use Endroid\QrCode\Color\Color;

class GenerateQR extends BaseController
{
    public function index()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }

        $siswaModel = new SiswaModel();
        $guruModel = new GuruModel();
        $kelasModel = new KelasModel();

        // Hitung jumlah siswa dan guru
        $data['jumlah_siswa'] = $siswaModel->countSiswa();
        $data['jumlah_guru'] = $guruModel->countGuru();

        // Ambil data kelas
        $kelasList = $kelasModel->getJurusan();
        $data['kelas_list'] = $kelasList;

        return view('generate_qr/index', $data);
    }


    public function generate_all_siswa()
    {
        $siswaModel = new SiswaModel();
        $pengaturanModel = new PengaturanModel();
        $siswaList = $siswaModel->getSiswaWithKelasJurusan();

        // Ambil pengaturan logo
        $pengaturan = $pengaturanModel->first();
        $logoPath = !empty($pengaturan['logo']) ? FCPATH . 'uploads/' . $pengaturan['logo'] : null;
        $logo = ($logoPath && file_exists($logoPath)) ? new Logo($logoPath, 50) : null;

        // Warna QR
        $foregroundColor = new Color(0, 110, 0); // Hijau
        $backgroundColor = new Color(255, 255, 255); // Putih

        // Simpan QR codes ke dalam array
        $qrFiles = [];

        foreach ($siswaList as $siswa) {
            // Generate kode unik jika belum ada
            if (!$siswa['kode_unik']) {
                $uniqueCode = bin2hex(random_bytes(32));
                $siswaModel->update($siswa['id'], ['kode_unik' => $uniqueCode]);
                $siswa['kode_unik'] = $uniqueCode;
            }

            // Buat QR code dengan setting yang sesuai
            $qrCode = new QrCode(
                data: $siswa['kode_unik'],
                errorCorrectionLevel: ErrorCorrectionLevel::High,
                size: 300,
                margin: 10,
                foregroundColor: $foregroundColor,
                backgroundColor: $backgroundColor
            );

            // Gunakan logo jika ada
            $writer = new PngWriter();
            $result = $writer->write($qrCode, $logo);

            // Simpan file QR ke dalam memori
            $fileName = $siswa['nama_kelas'] . ' - ' . $siswa['jurusan'] . '/QRCode_' . $siswa['nama_siswa'] . '_' . $siswa['nis'] . '.png';
            $qrFiles[$fileName] = $result->getString();
        }

        // Simpan data QR codes ke session untuk digunakan di download_all
        session()->set('qr_files', $qrFiles);

        return redirect()->to(base_url('generate_qr'))->with('success', 'QR codes generated for all students.');
    }

    public function download_all_siswa()
    {
        // Ambil QR files dari session
        $qrFiles = session()->get('qr_files');
        if (!$qrFiles) {
            return redirect()->to(base_url('generate_qr'))->with('error', 'Generate QR codes first before downloading.');
        }

        // Buat file ZIP di lokasi sementara
        $zip = new \ZipArchive();
        $tempZipPath = sys_get_temp_dir() . '/qr_codes_' . uniqid() . '.zip'; // File sementara

        if ($zip->open($tempZipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($qrFiles as $filePath => $fileContent) {
                // Tambahkan setiap file ke ZIP
                $zip->addFromString($filePath, $fileContent);
            }
            $zip->close();

            // Hapus session setelah file ZIP dibuat
            session()->remove('qr_files');

            // Kirim file ZIP ke pengguna
            return $this->response
                ->download($tempZipPath, null)
                ->setFileName('qr_codes_siswa.zip')
                ->setHeader('Content-Type', 'application/zip')
                ->setHeader('Content-Disposition', 'attachment; filename="qr_codes_siswa.zip"')
                ->setHeader('Content-Length', filesize($tempZipPath))
                ->setBody(file_get_contents($tempZipPath))
                ->setHeader('Connection', 'close');
        }

        // Gagal membuat ZIP
        unlink($tempZipPath); // Hapus file sementara jika ada
        return redirect()->to(base_url('generate_qr'))->with('error', 'Failed to create ZIP file.');
    }

    public function generate_per_kelas()
    {
        $kelasId = $this->request->getGet('kelas_id');
        if (!$kelasId) {
            return redirect()->to(base_url('generate_qr'))->with('error', 'Silahkan pilih kelas terlebih dahulu.');
        }

        $siswaModel = new SiswaModel();
        $pengaturanModel = new PengaturanModel();

        // Ambil siswa berdasarkan kelas
        $siswaList = $siswaModel->where('kelas_id', $kelasId)->getSiswaWithKelasJurusan();

        // Ambil pengaturan logo
        $pengaturan = $pengaturanModel->first();
        $logoPath = !empty($pengaturan['logo']) ? FCPATH . 'uploads/' . $pengaturan['logo'] : null;
        $logo = ($logoPath && file_exists($logoPath)) ? new Logo($logoPath, 50) : null;

        // Warna QR
        $foregroundColor = new Color(0, 110, 0); // Hijau
        $backgroundColor = new Color(255, 255, 255); // Putih

        // Simpan QR codes ke dalam array
        $qrFiles = [];
        $kelasJurusan = ''; // Menyimpan nama kelas dan jurusan

        foreach ($siswaList as $siswa) {
            // Set nama kelas dan jurusan hanya sekali
            if (empty($kelasJurusan)) {
                $kelasJurusan = $siswa['nama_kelas'] . '_' . str_replace(' ', '_', $siswa['jurusan']);
            }

            // Generate kode unik jika belum ada
            if (!$siswa['kode_unik']) {
                $uniqueCode = bin2hex(random_bytes(32));
                $siswaModel->update($siswa['id'], ['kode_unik' => $uniqueCode]);
                $siswa['kode_unik'] = $uniqueCode;
            }

            // Buat QR code dengan setting yang sesuai
            $qrCode = new QrCode(
                data: $siswa['kode_unik'],
                errorCorrectionLevel: ErrorCorrectionLevel::High,
                size: 300,
                margin: 10,
                foregroundColor: $foregroundColor,
                backgroundColor: $backgroundColor
            );

            // Gunakan logo jika ada
            $writer = new PngWriter();
            $result = $writer->write($qrCode, $logo);

            // Simpan file QR ke dalam memori
            $fileName = 'QRCode_' . $siswa['nama_siswa'] . '_' . $siswa['nis'] . '.png';
            $qrFiles[$fileName] = $result->getString();
        }

        // Simpan data QR codes dan nama kelas ke session untuk digunakan di download_per_kelas
        session()->set('qr_files_per_kelas', $qrFiles);
        session()->set('kelas_jurusan', $kelasJurusan);

        return redirect()->to(base_url('generate_qr'))->with('success', 'QR codes generated for the selected class.');
    }
    public function download_per_kelas()
    {
        // Ambil QR files per kelas dan nama kelas dari session
        $qrFiles = session()->get('qr_files_per_kelas');
        $kelasJurusan = session()->get('kelas_jurusan');

        if (!$qrFiles || !$kelasJurusan) {
            return redirect()->to(base_url('generate_qr'))->with('error', 'Generate QR codes first before downloading.');
        }

        // Buat file ZIP di lokasi sementara
        $zip = new \ZipArchive();
        $tempZipPath = sys_get_temp_dir() . '/qr_codes_' . $kelasJurusan . '.zip'; // Nama file zip sesuai kelas dan jurusan

        if ($zip->open($tempZipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($qrFiles as $fileName => $fileContent) {
                // Tambahkan setiap file langsung ke ZIP tanpa folder
                $zip->addFromString($fileName, $fileContent);
            }
            $zip->close();

            session()->remove('qr_files_per_kelas');
            session()->remove('kelas_jurusan');

            // Kirim file ZIP ke pengguna
            return $this->response
                ->download($tempZipPath, null)
                ->setFileName('qr_codes_' . $kelasJurusan . '.zip') // Nama file ZIP yang didownload
                ->setHeader('Content-Type', 'application/zip')
                ->setHeader('Content-Disposition', 'attachment; filename="qr_codes_' . $kelasJurusan . '.zip"')
                ->setHeader('Content-Length', filesize($tempZipPath))
                ->setBody(file_get_contents($tempZipPath))
                ->setHeader('Connection', 'close');
        }

        // Gagal membuat ZIP
        unlink($tempZipPath); // Hapus file sementara jika ada
        return redirect()->to(base_url('generate_qr'))->with('error', 'Failed to create ZIP file.');
    }



    public function generate_all_guru()
    {
        $guruModel = new GuruModel();
        $pengaturanModel = new PengaturanModel();
        $guruList = $guruModel->findAll(); // Ambil data guru dari database

        // Ambil pengaturan logo
        $pengaturan = $pengaturanModel->first();
        $logoPath = !empty($pengaturan['logo']) ? FCPATH . 'uploads/' . $pengaturan['logo'] : null;
        $logo = ($logoPath && file_exists($logoPath)) ? new Logo($logoPath, 50) : null;

        // Warna QR
        $foregroundColor = new Color(0, 100, 255); // Light Blue RGB (173, 216, 230)
        $backgroundColor = new Color(255, 255, 255); // White background (RGB)

        // Simpan QR codes ke dalam array
        $qrFiles = [];

        foreach ($guruList as $guru) {
            // Generate kode unik jika belum ada
            if (!$guru['kode_unik']) {
                $uniqueCode = bin2hex(random_bytes(32));
                $guruModel->update($guru['id'], ['kode_unik' => $uniqueCode]);
                $guru['kode_unik'] = $uniqueCode;
            }

            // Buat QR code dengan setting yang sesuai
            $qrCode = new QrCode(
                data: $guru['kode_unik'],
                errorCorrectionLevel: ErrorCorrectionLevel::High,
                size: 300,
                margin: 10,
                foregroundColor: $foregroundColor,
                backgroundColor: $backgroundColor
            );

            // Gunakan logo jika ada
            $writer = new PngWriter();
            $result = $writer->write($qrCode, $logo);

            // Simpan file QR ke dalam memori
            $fileName = 'QRCode_' . $guru['nama_guru'] . '_' . $guru['nuptk'] . '.png';
            $qrFiles[$fileName] = $result->getString();
        }

        // Simpan data QR codes ke session untuk digunakan di download_all_guru
        session()->set('qr_files_guru', $qrFiles);

        return redirect()->to(base_url('generate_qr'))->with('success', 'QR codes generated for all teachers.');
    }

    public function download_all_guru()
    {
        // Ambil QR files dari session
        $qrFiles = session()->get('qr_files_guru');
        if (!$qrFiles) {
            return redirect()->to(base_url('generate_qr'))->with('error', 'Generate QR codes first before downloading.');
        }

        // Buat file ZIP di lokasi sementara
        $zip = new \ZipArchive();
        $tempZipPath = sys_get_temp_dir() . '/qr_codes_guru_' . uniqid() . '.zip'; // File sementara

        if ($zip->open($tempZipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($qrFiles as $filePath => $fileContent) {
                // Tambahkan setiap file ke ZIP
                $zip->addFromString($filePath, $fileContent);
            }
            $zip->close();

            session()->remove('qr_files_guru');

            // Kirim file ZIP ke pengguna
            return $this->response
                ->download($tempZipPath, null)
                ->setFileName('qr_codes_guru.zip')
                ->setHeader('Content-Type', 'application/zip')
                ->setHeader('Content-Disposition', 'attachment; filename="qr_codes_guru.zip"')
                ->setHeader('Content-Length', filesize($tempZipPath))
                ->setBody(file_get_contents($tempZipPath))
                ->setHeader('Connection', 'close');
        }

        // Gagal membuat ZIP
        unlink($tempZipPath); // Hapus file sementara jika ada
        return redirect()->to(base_url('generate_qr'))->with('error', 'Failed to create ZIP file.');
    }
}
