<?php

namespace App\Controllers\Data;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\PengaturanModel;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

class DataGuru extends BaseController
{
    public function __construct()
    {
        helper('form'); // Memuat helper form
    }

    // Menampilkan daftar guru
    public function index()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }
        $guruModel = new GuruModel();
        $pengaturanModel = new PengaturanModel();

        // Ambil data tahun ajaran
        $tahunAjaran = $pengaturanModel->first();
        $data['tahun_ajaran'] = $tahunAjaran['tahun_ajaran'];

        // Ambil keyword pencarian jika ada
        $keyword = $this->request->getGet('keyword'); // Misalnya 'keyword' untuk pencarian nama atau nuptk

        if ($keyword) {
            // Menambahkan kondisi pencarian untuk nama atau NUPTK
            $data['guru'] = $guruModel->groupStart() // Mulai pencarian
                ->like('nama_guru', $keyword) // Mencari berdasarkan nama guru
                ->orLike('nuptk', $keyword) // Mencari berdasarkan NUPTK
                ->groupEnd() // Akhiri pencarian
                ->orderBy('nuptk', 'ASC') // Urutkan berdasarkan NUPTK secara ascending
                ->findAll();
        } else {
            // Jika tidak ada keyword, ambil semua data guru dan urutkan berdasarkan NUPTK
            $data['guru'] = $guruModel->orderBy('nuptk', 'ASC')->findAll();
        }

        return view('data_guru/index', $data);
    }


    // Menampilkan form untuk menambah data guru
    public function tambah()
    {
        return view('data_guru/tambah');
    }

    // Validasi NUPTK
    private function validateNuptk($nuptk)
    {
        if (!is_numeric($nuptk)) {
            return 'NUPTK hanya boleh terdiri dari angka.';
        }

        if (strlen($nuptk) < 16) {
            return 'NUPTK harus terdiri dari 16 digit. Mohon periksa kembali input Anda.';
        }

        if (strlen($nuptk) > 20) {
            return 'NUPTK yang dimasukkan lebih dari 20 digit. Harap periksa dan coba lagi.';
        }

        return null; // Valid
    }

    public function simpan()
    {
        $guruModel = new GuruModel();
        $nuptk = $this->request->getPost('nuptk');
        $jenisKelamin = $this->request->getPost('jenis_kelamin');

        // Validasi NUPTK
        $validationError = $this->validateNuptk($nuptk);
        if ($validationError) {
            return redirect()->back()->with('error', $validationError)->withInput();
        }

        // Memeriksa apakah NUPTK sudah terdaftar
        $existingGuru = $guruModel->where('nuptk', $nuptk)->first();
        if ($existingGuru) {
            // Menyusun nomor tabel dari posisi dalam daftar guru
            $allGuru = $guruModel->orderBy('nuptk', 'ASC')->findAll();

            $index = array_search($existingGuru, $allGuru) + 1; // Menghitung posisi tabel (1-based index)

            return redirect()->back()->with('error', 'NUPTK ini sudah terdaftar pada nomor tabel: ' . $index)->withInput();
        }

        // Validasi jenis kelamin
        if (empty($jenisKelamin)) {
            return redirect()->back()->with('error', 'Mohon pilih jenis kelamin!')->withInput();
        }

        // Data yang akan disimpan
        $data = [
            'nama_guru' => esc($this->request->getPost('nama_guru')),
            'nuptk' => $nuptk,
            'jenis_kelamin' => $jenisKelamin,
            'no_hp' => esc($this->request->getPost('no_hp')),
            'alamat' => esc($this->request->getPost('alamat')),
        ];

        // Menyimpan data ke database
        $guruModel->save($data);

        // Redirect setelah berhasil
        return redirect()->to(base_url('data_guru'))->with('success', 'Data guru berhasil disimpan.');
    }

    public function update($id)
    {
        $guruModel = new GuruModel();
        $nuptk = $this->request->getPost('nuptk');

        // Validasi NUPTK
        $validationError = $this->validateNuptk($nuptk);
        if ($validationError) {
            return redirect()->back()->with('error', $validationError)->withInput();
        }

        // Memeriksa apakah NUPTK sudah terdaftar kecuali untuk guru yang sedang diupdate
        $existingGuru = $guruModel->where('nuptk', $nuptk)->first();
        if ($existingGuru && $existingGuru['id'] != $id) {
            // Menyusun nomor tabel dari posisi dalam daftar guru
            $allGuru = $guruModel->findAll();
            $index = array_search($existingGuru, $allGuru) + 1; // Menghitung posisi tabel (1-based index)

            return redirect()->back()->with('error', 'NUPTK ini sudah terdaftar pada nomor tabel: ' . $index)->withInput();
        }

        // Data yang akan diupdate
        $data = [
            'nama_guru' => esc($this->request->getPost('nama_guru')),
            'nuptk' => $nuptk,
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'no_hp' => esc($this->request->getPost('no_hp')),
            'alamat' => esc($this->request->getPost('alamat')),
        ];

        // Update data di database
        $guruModel->update($id, $data);

        // Redirect setelah berhasil update
        return redirect()->to(base_url('data_guru'))->with('success', 'Data guru berhasil diperbarui.');
    }

    // Menampilkan form untuk mengedit data guru
    public function edit($id)
    {
        $guruModel = new GuruModel();
        $data['guru'] = $guruModel->find($id);
        return view('data_guru/edit', $data);
    }

    public function delete($id)
    {
        $guruModel = new GuruModel();

        // Cari data guru berdasarkan ID
        $guru = $guruModel->find($id);

        if ($guru) {
            // Tentukan path file suara berdasarkan path yang ada di database
            $uploadPath = ROOTPATH . 'public/uploads/suara/';
            $fileName = $guru['suara']; // Ambil nama file suara dari data guru
            $filePath = $uploadPath . $fileName;

            // Jika file suara ada, hapus file suara tersebut
            if (file_exists($filePath)) {
                unlink($filePath); // Menghapus file suara
            }

            // Hapus data guru dari database
            $guruModel->delete($id);

            // Redirect dengan pesan sukses
            return redirect()->to(base_url('data_guru'))->with('success', 'Data guru beserta suara berhasil dihapus.');
        }

        // Jika data guru tidak ditemukan
        return redirect()->to(base_url('data_guru'))->with('error', 'Guru tidak ditemukan.');
    }



    // Generate QR code dengan label
    public function generate_qr($id)
    {
        $guruModel = new GuruModel();
        $pengaturanModel = new PengaturanModel();

        // Fetch guru data by ID
        $guru = $guruModel->find($id);

        if (!$guru) {
            return redirect()->to(base_url('data_guru'))->with('error', 'Guru tidak ditemukan.');
        }

        // Check if the guru already has a unique code
        if (empty($guru['kode_unik'])) {
            // If no unique code, generate a new one
            $uniqueCode = bin2hex(random_bytes(32)); // Generate a new unique code
            $guruModel->update($id, ['kode_unik' => $uniqueCode]); // Save the code in the database
        } else {
            // Use the existing unique code
            $uniqueCode = $guru['kode_unik'];
        }

        $foregroundColor = new Color(0, 100, 255); // Light Blue RGB (173, 216, 230)
        $backgroundColor = new Color(255, 255, 255); // White background (RGB)

        // Create a QR code instance with error correction and customization
        $qrCode = new QrCode(
            data: $uniqueCode,
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            foregroundColor: $foregroundColor, // Apply the foreground color
            backgroundColor: $backgroundColor  // Apply the background color
        );

        // Load logo if available
        $pengaturan = $pengaturanModel->first();
        $logoPath = !empty($pengaturan['logo']) ? FCPATH . 'uploads/' . $pengaturan['logo'] : null;
        // Validate logo path
        if ($logoPath && file_exists($logoPath)) {
            $logo = new Logo($logoPath, 50); // Add logo if exists
        } else {
            $logo = null; // No logo if not found
        }

        // Create QR code writer
        $writer = new PngWriter();

        // Write the QR code to an image
        $result = $writer->write($qrCode, $logo);

        // Return the QR code image for download
        return $this->response
            ->setHeader('Content-Type', 'image/png')
            ->setHeader('Content-Disposition', 'attachment; filename="QRCode_' . $guru['nama_guru'] . '_' . $guru['nuptk'] . '.png"')
            ->setBody($result->getString());
    }

    public function saveSuara($id)
    {
        // Ambil model Guru
        $guruModel = new GuruModel();

        // Cari data guru berdasarkan id
        $guru = $guruModel->find($id);

        if ($guru) {
            // Cek apakah file suara ada di request
            if ($this->request->getFile('suara')) {
                $suaraFile = $this->request->getFile('suara');

                // Cek apakah file valid dan tipe file yang diterima
                if ($suaraFile->isValid() && !$suaraFile->hasMoved()) {
                    // Gunakan nama guru untuk nama file suara, sehingga unik
                    $fileName = 'suara_' . $guru['nama_guru'] . '_' . $guru['id'] . '.wav';

                    // Tentukan path untuk menyimpan file
                    $uploadPath = ROOTPATH . 'public/uploads/suara/';

                    // Hapus file suara lama jika ada
                    if ($guru['suara'] && file_exists($uploadPath . $guru['suara'])) {
                        unlink($uploadPath . $guru['suara']);
                    }

                    // Pindahkan file baru ke folder tujuan dengan nama yang baru
                    $suaraFile->move($uploadPath, $fileName);

                    // Simpan path file suara ke database
                    $guruModel->update($id, [
                        'suara' => $fileName, // Menyimpan path file suara berdasarkan nama guru dan ID
                    ]);

                    // Return path suara untuk update di frontend
                    return $this->response->setJSON([
                        'suaraPath' => 'uploads/suara/' . $fileName
                    ]);
                }
            }
        }

        // Jika guru tidak ditemukan atau terjadi error
        return $this->response->setJSON(['error' => 'Terjadi kesalahan saat menyimpan suara.']);
    }
}
