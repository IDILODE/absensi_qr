<?php

namespace App\Controllers\Data;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\PengaturanModel;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use App\Models\KelasModel;
use App\Models\JurusanModel;

class DataSiswa extends BaseController
{
    public function __construct()
    {
        helper('form'); // Memuat helper form
    }

    // Menampilkan daftar siswa
    public function index()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }
        $siswaModel = new SiswaModel();
        $kelasModel = new KelasModel();
        $jurusanModel = new JurusanModel();
        $pengaturanModel = new PengaturanModel();

        // Ambil data kelas dan jurusan
        $data['kelas'] = $kelasModel->findAll();
        $data['jurusan'] = $jurusanModel->findAll();
        $tahunAjaran = $pengaturanModel->first();
        $data['tahun_ajaran'] = $tahunAjaran['tahun_ajaran'];

        // Ambil data kelas dan jurusan
        $data['kelas'] = $kelasModel->findAll();
        $data['jurusan'] = $jurusanModel->findAll();


        $data['kelas'] = $kelasModel->select('kelas.id, kelas.nama_kelas, jurusan.jurusan as jurusan')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
            ->findAll();
        // Mengambil parameter 'kelas' dan 'keyword' dari GET request
        $kelasId = $this->request->getGet('kelas');
        $keyword = $this->request->getGet('keyword');
        $data['kelasId'] = $kelasId; // Simpan nilai kelasId untuk dikirim ke view
        $data['keyword'] = $keyword; // Simpan nilai keyword untuk dikirim ke view

        // Periksa apakah kelasId dan keyword ada, dan atur query pencarian berdasarkan keduanya
        if ($kelasId && $keyword) {
            // Menyaring berdasarkan kelas dan keyword
            $data['siswa'] = $siswaModel->select('siswa.*, kelas.nama_kelas, jurusan.jurusan')
                ->where('kelas_id', $kelasId)
                ->groupStart()
                ->like('nama_siswa', $keyword)
                ->orLike('nis', $keyword)
                ->groupEnd()
                ->join('kelas', 'kelas.id = siswa.kelas_id', 'left')
                ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
                ->orderBy('nis', 'ASC')
                ->findAll();
        } elseif ($kelasId) {
            // Menyaring hanya berdasarkan kelas
            $data['siswa'] = $siswaModel->select('siswa.*, kelas.nama_kelas, jurusan.jurusan')
                ->where('kelas_id', $kelasId)
                ->join('kelas', 'kelas.id = siswa.kelas_id', 'left')
                ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
                ->orderBy('nis', 'ASC')
                ->findAll();
        } elseif ($keyword) {
            // Menyaring hanya berdasarkan keyword
            $data['siswa'] = $siswaModel->select('siswa.*, kelas.nama_kelas, jurusan.jurusan')
                ->groupStart()
                ->like('nama_siswa', $keyword)
                ->orLike('nis', $keyword)
                ->groupEnd()
                ->join('kelas', 'kelas.id = siswa.kelas_id', 'left')
                ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
                ->orderBy('nis', 'ASC')
                ->findAll();
        } else {
            // Menampilkan semua siswa jika tidak ada filter
            $data['siswa'] = $siswaModel->orderBy('nis', 'ASC')->getSiswaWithKelasJurusan();
        }

        return view('data_siswa/index', $data);
    }
    // Menampilkan form untuk menambah data siswa
    public function tambah()
    {
        $kelasModel = new KelasModel();
        $data['kelas'] = $kelasModel->getJurusan();
        // Menyimpan kelasId dan keyword ke dalam data yang dikirim ke view
        $data['kelasId'] = $this->request->getGet('kelas');
        $data['keyword'] = $this->request->getGet('keyword');
        return view('data_siswa/tambah', $data);
    }

    // Validasi NIS
    private function validateNis($nis)
    {
        if (!is_numeric($nis)) {
            return 'NIS hanya boleh terdiri dari angka.';
        }

        if (strlen($nis) < 5) {
            return 'NIS harus terdiri dari 5 digit. Mohon periksa kembali input Anda.';
        }

        if (strlen($nis) > 10) {
            return 'NIS yang dimasukkan lebih dari 10 digit. Harap periksa dan coba lagi.';
        }

        return null; // Valid
    }

    public function simpan()
    {
        $siswaModel = new SiswaModel();
        $nis = $this->request->getPost('nis');
        $jenisKelamin = $this->request->getPost('jenis_kelamin');
        $kelasId = $this->request->getPost('kelas_id'); // Ambil input kelas_id

        // Validasi NIS
        $validationError = $this->validateNis($nis);
        if ($validationError) {
            return redirect()->back()->with('error', $validationError)->withInput();
        }

        // Memeriksa apakah NIS sudah terdaftar
        $existingSiswa = $siswaModel->where('nis', $nis)->first();
        if ($existingSiswa) {
            // Menyusun nomor tabel dari posisi dalam daftar siswa
            $allSiswa = $siswaModel->orderBy('nis', 'ASC')->findAll();
            $index = array_search($existingSiswa, $allSiswa) + 1; // Menghitung posisi tabel (1-based index)

            return redirect()->back()->with('error', 'NIS ini sudah terdaftar pada nomor tabel: ' . $index)->withInput();
        }

        // Validasi jenis kelamin
        if (empty($jenisKelamin)) {
            return redirect()->back()->with('error', 'Mohon pilih jenis kelamin!')->withInput();
        }

        // Validasi kelas
        if (empty($kelasId)) {
            return redirect()->back()->with('error', 'Mohon pilih kelas!')->withInput();
        }

        // Data yang akan disimpan
        $data = [
            'nama_siswa' => esc($this->request->getPost('nama_siswa')),
            'nis' => $nis,
            'jenis_kelamin' => $jenisKelamin,
            'no_hp' => esc($this->request->getPost('no_hp')),
            'kelas_id' => $kelasId  // Pastikan ada input kelas_id
        ];

        // Menyimpan data ke database
        $siswaModel->save($data);

        // Redirect setelah berhasil
        return redirect()->to(base_url('data_siswa') .
            '?kelas=' . $this->request->getPost('kelas') .
            '&keyword=' . $this->request->getPost('keyword'))
            ->with('success', 'Data siswa berhasil disimpan.');
    }


    public function update($id)
    {
        $siswaModel = new SiswaModel();
        $nis = $this->request->getPost('nis');

        // Validasi NIS
        $validationError = $this->validateNis($nis);
        if ($validationError) {
            return redirect()->back()->with('error', $validationError)->withInput();
        }

        // Memeriksa apakah NIS sudah terdaftar kecuali untuk siswa yang sedang diupdate
        $existingSiswa = $siswaModel->where('nis', $nis)->first();
        if ($existingSiswa && $existingSiswa['id'] != $id) {
            // Menyusun nomor tabel dari posisi dalam daftar siswa
            $allSiswa = $siswaModel->findAll();
            $index = array_search($existingSiswa, $allSiswa) + 1; // Menghitung posisi tabel (1-based index)

            return redirect()->back()->with('error', 'NIS ini sudah terdaftar pada nomor tabel: ' . $index)->withInput();
        }

        // Data yang akan diupdate
        $data = [
            'nama_siswa' => esc($this->request->getPost('nama_siswa')),
            'nis' => $nis,
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'no_hp' => esc($this->request->getPost('no_hp')),
            'kelas_id' => $this->request->getPost('kelas_id')
        ];

        // Update data di database
        $siswaModel->update($id, $data);

        // Redirect setelah berhasil update
        return redirect()->to(base_url('data_siswa') .
            '?kelas=' . $this->request->getPost('kelas') .
            '&keyword=' . $this->request->getPost('keyword'))
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    // Menampilkan form untuk mengedit data siswa
    public function edit($id)
    {
        $siswaModel = new SiswaModel();
        $data['siswa'] = $siswaModel->find($id);
        $kelasModel = new KelasModel();
        $data['kelas'] = $kelasModel->getJurusan();
        // Menyimpan kelasId dan keyword ke dalam data yang dikirim ke view
        $data['kelasId'] = $this->request->getGet('kelas');
        $data['keyword'] = $this->request->getGet('keyword');
        return view('data_siswa/edit', $data);
    }

    public function delete($id)
    {
        $siswaModel = new SiswaModel();
        $siswaModel->delete($id);

        // Mengarahkan kembali ke halaman dengan kelas dan keyword yang terpilih
        return redirect()->to(
            base_url('data_siswa') . '?' .
                ($this->request->getGet('kelas') ? 'kelas=' . $this->request->getGet('kelas') : '') .
                ($this->request->getGet('keyword') ? '&keyword=' . $this->request->getGet('keyword') : '')
        )->with('success', 'Data siswa berhasil dihapus.');
    }

    public function delete_selected()
    {
        $siswaModel = new SiswaModel();
        $selectedIds = $this->request->getPost('selected_siswa');

        if ($selectedIds) {
            $siswaModel->delete($selectedIds);
            return redirect()->to(
                base_url('data_siswa') . '?' .
                    ($this->request->getPost('kelas') ? 'kelas=' . $this->request->getPost('kelas') : '') .
                    ($this->request->getPost('keyword') ? '&keyword=' . $this->request->getPost('keyword') : '')
            )->with('success', 'Data siswa yang dipilih berhasil dihapus.');
        }

        return redirect()->to(base_url('data_siswa'))->with('error', 'Tidak ada data siswa yang dipilih untuk dihapus.');
    }


    // Generate QR code dengan label
    public function generate_qr($id)
    {
        $siswaModel = new SiswaModel();
        $pengaturanModel = new PengaturanModel();

        // Fetch siswa data by ID
        $siswa = $siswaModel->find($id);

        if (!$siswa) {
            return redirect()->to(base_url('data_siswa'))->with('error', 'Siswa tidak ditemukan.');
        }

        // Check if the siswa already has a unique code
        if (empty($siswa['kode_unik'])) {
            // If no unique code, generate a new one
            $uniqueCode = bin2hex(random_bytes(32)); // Generate a new unique code
            $siswaModel->update($id, ['kode_unik' => $uniqueCode]); // Save the code in the database
        } else {
            // Use the existing unique code
            $uniqueCode = $siswa['kode_unik'];
        }

        $foregroundColor = new Color(0, 110, 0); // Green color (for siswa)
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
            ->setHeader('Content-Disposition', 'attachment; filename="QRCode_' . $siswa['nama_siswa'] . '_' . $siswa['nis'] . '.png"')
            ->setBody($result->getString());
    }




    // DataSiswa Controller
    public function import()
    {
        $pengaturanModel = new PengaturanModel();
        $kelasModel = new KelasModel();
        $jurusanModel = new JurusanModel();

        $tahunAjaran = $pengaturanModel->first();
        $data['kelas'] = $kelasModel->findAll(); // Ambil semua data kelas
        $data['jurusan'] = $jurusanModel->findAll(); // Ambil semua data jurusan
        $data['tahun_ajaran'] = $tahunAjaran['tahun_ajaran'];

        // Gabungkan data kelas dengan jurusan
        foreach ($data['kelas'] as &$k) {
            // Cari jurusan berdasarkan id yang sesuai
            $jurusan = array_filter($data['jurusan'], function ($j) use ($k) {
                return $j['id'] == $k['jurusan_id']; // Pastikan ada relasi antara kelas dan jurusan
            });

            // Jika jurusan ditemukan, gabungkan data jurusan ke kelas
            if (!empty($jurusan)) {
                $k['jurusan'] = array_values($jurusan)[0]['jurusan']; // Menambahkan nama jurusan
            } else {
                $k['jurusan'] = 'Tidak ada jurusan'; // Fallback jika tidak ada jurusan
            }
        }

        return view('data_siswa/import', $data); // Kirim data yang sudah digabungkan ke view
    }



    public function importData()
    {
        $file = $this->request->getFile('file');
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid!')->withInput();
        }

        $fileExtension = $file->getExtension();
        $siswaModel = new SiswaModel();
        $kelasModel = new KelasModel();

        // Validasi format file (CSV atau XLSX)
        if (!in_array($fileExtension, ['csv', 'xlsx'])) {
            return redirect()->back()->with('error', 'Format file tidak valid. Hanya file dengan format CSV/XLSX yang diperbolehkan.')->withInput();
        }

        $invalidData = []; // Menyimpan data siswa bermasalah
        $validData = [];   // Menyimpan data siswa yang valid

        // Jika file CSV
        if ($fileExtension === 'csv') {
            $filePath = $file->getTempName();
            $rows = array_map('str_getcsv', file($filePath));
            array_shift($rows); // Lewati header
        }
        // Jika file XLSX
        elseif ($fileExtension === 'xlsx') {
            $filePath = $file->getTempName();
            $rows = (new \PhpOffice\PhpSpreadsheet\Reader\Xlsx())->load($filePath)->getActiveSheet()->toArray();
            array_shift($rows); // Lewati header
        }

        foreach ($rows as $rowNumber => $row) {
            if (count($row) < 5) continue;

            $nis = $row[0];
            $namaSiswa = $row[1];
            $jenisKelamin = $row[2];
            $kelasId = $row[3];
            $noHp = $row[4];

            // Validasi data siswa
            $errors = $this->validateSiswa($nis, $jenisKelamin, $kelasId, $siswaModel, $kelasModel);

            if ($errors) {
                $invalidData[] = [
                    'row' => $rowNumber + 2, // Tambahkan 2 karena header diabaikan
                    'nis' => $nis,
                    'nama_siswa' => $namaSiswa,
                    'errors' => $errors
                ];
            } else {
                $validData[] = [
                    'nis' => $nis,
                    'nama_siswa' => $namaSiswa,
                    'jenis_kelamin' => $jenisKelamin,
                    'kelas_id' => $kelasId,
                    'no_hp' => $noHp
                ];
            }
        }

        // Jika ada data yang tidak valid
        if (!empty($invalidData)) {
            session()->setFlashdata('invalidData', $invalidData);
            return redirect()->to(base_url('data_siswa'));
        }

        // Simpan data valid jika semua data valid
        foreach ($validData as $data) {
            $siswaModel->save($data);
        }

        return redirect()->to(base_url('data_siswa'))->with('success', count($validData) . " data siswa berhasil diimport.");
    }


    private function validateSiswa($nis, $jenisKelamin, $kelasId, $siswaModel, $kelasModel)
    {
        $errors = [];

        // Validasi NIS
        if (!preg_match('/^\d{5,10}$/', $nis)) {
            $errors[] = "NIS tidak valid (harus angka 5-10 karakter).";
        }
        if ($siswaModel->where('nis', $nis)->first()) {
            $errors[] = "NIS duplikat.";
        }

        // Validasi jenis kelamin
        if (!in_array(strtolower($jenisKelamin), ['laki-laki', 'perempuan'])) {
            $errors[] = "Jenis kelamin harus 'Laki-laki' atau 'Perempuan'.";
        }

        // Validasi kelas ID
        if (!$kelasModel->find($kelasId)) {
            $errors[] = "Kelas ID tidak valid.";
        }

        return $errors;
    }

    public function downloadTemplate($type)
    {
        $filePath = '';
        if ($type === 'csv') {
            $filePath = ROOTPATH . 'public/assets/templates/template_csv_siswa.csv';
        } elseif ($type === 'xlsx') {
            $filePath = ROOTPATH . 'public\assets\templates\template_xlsx_siswa.xlsx';
        }

        // Pastikan file ada
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File template tidak ditemukan!');
        }

        // Kirim file untuk diunduh
        return $this->response->download($filePath, null);
    }
}
