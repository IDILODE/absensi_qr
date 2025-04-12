<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\AbsensiGuruModel;
use App\Models\AbsensiSiswaModel;
use App\Models\PengaturanModel;
use Dompdf\Dompdf;
use Dompdf\Options;


class GenerateLaporan extends BaseController
{

    public function index()
    {
        // Memeriksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login'); // Arahkan ke halaman login jika belum login
        }

        $siswaModel = new SiswaModel();
        $guruModel = new GuruModel();
        $pengaturanModel = new PengaturanModel();


        // Set locale ke Bahasa Indonesia
        setlocale(LC_TIME, 'id_ID.UTF-8', 'id_ID');

        // Hitung jumlah siswa dan guru
        $data['jumlah_siswa'] = $siswaModel->countSiswa();
        $data['jumlah_guru'] = $guruModel->countGuru();

        // Ambil data kelas beserta jumlah siswa
        $data['kelas_list'] = $siswaModel->getKelasWithJumlahSiswa(); // Mengambil data kelas dan jumlah siswa

        // Ambil pengaturan
        $pengaturan = $pengaturanModel->find(1);
        $data['nama_sekolah'] = $pengaturan['nama_sekolah'] ?? '';
        $data['tahun_ajaran'] = $pengaturan['tahun_ajaran'] ?? '';
        $data['copyright'] = $pengaturan['copyright'] ?? '';
        // Menambahkan logo (pastikan ada logo yang tersimpan di folder uploads)
        $data['logo'] = isset($pengaturan['logo']) ? base_url('uploads/' . $pengaturan['logo']) : ''; // Mengambil URL logo

        // Bulan array untuk mapping bulan dalam Bahasa Indonesia
        $data['bulanArray'] = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        // Pastikan bulan_tahun tersedia, atau gunakan bulan saat ini jika tidak ada
        $data['bulan_tahun_siswa'] = $this->request->getGet('bulan_tahun_siswa') ?? date('Y-m');
        $data['bulan_tahun_guru'] = $this->request->getGet('bulan_tahun_guru') ?? date('Y-m');

        return view('generate_laporan/index', $data);
    }


    public function generate_guru_pdf()
    {
        $guruModel = new GuruModel();
        $absensiGuruModel = new AbsensiGuruModel(); // Tambahkan model AbsensiGuru
        $pengaturanModel = new PengaturanModel();

        // Ambil bulan dari parameter URL
        $bulanTahun = $this->request->getGet('bulan_tahun_guru') ?? date('Y-m');

        // Hitung jumlah guru
        $jumlah_guru = $guruModel->countGuru();

        if ($jumlah_guru == 0) {
            // Jika jumlah guru kosong, arahkan ke halaman dengan pesan error
            return redirect()->to('/generate_laporan')->with('error', 'Data Guru Kosong');
        }

        // Mapping bulan dalam Bahasa Indonesia
        $bulanArray = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        // Mengambil nama bulan dalam Bahasa Indonesia
        $date = new \DateTime($bulanTahun . "-01");
        $bulan = $bulanArray[$date->format('F')];

        // Mengambil tanggal dalam bulan tersebut, kecuali Minggu
        $tanggalList = [];
        $hariList = [];
        $firstDay = new \DateTime($bulanTahun . "-01");
        $lastDay = new \DateTime($bulanTahun . "-01");
        $lastDay->modify('last day of this month');

        $hariArray = ['Sun' => 'Minggu', 'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab'];

        for ($currentDate = $firstDay; $currentDate <= $lastDay; $currentDate->modify('+1 day')) {
            if ($currentDate->format('w') != 0) { // Mengabaikan hari Minggu
                $tanggalList[] = $currentDate->format('Y-m-d');
                $hariList[] = $hariArray[$currentDate->format('D')];
            }
        }

        // Data Guru
        $data['guru_list'] = $guruModel->findAll();

        // Hitung jumlah Laki-Laki dan Perempuan
        $laki_laki = 0;
        $perempuan = 0;
        foreach ($data['guru_list'] as $guru) {
            if ($guru['jenis_kelamin'] == 'Laki-Laki') {
                $laki_laki++;
            } elseif ($guru['jenis_kelamin'] == 'Perempuan') {
                $perempuan++;
            }
        }

        // Kirim data ke view
        $data['laki_laki'] = $laki_laki;
        $data['perempuan'] = $perempuan;

        // Ambil data absensi berdasarkan tanggal dan guru_id
        foreach ($data['guru_list'] as &$guru) {
            $guru['absensi'] = [];
            foreach ($tanggalList as $tanggal) {
                $absensi = $absensiGuruModel->where('guru_id', $guru['id'])->where('tanggal', $tanggal)->first();
                $guru['absensi'][$tanggal] = $absensi ? $absensi['kehadiran_id'] : null; // Menyimpan kehadiran_id jika ada, null jika tidak ada
            }
        }

        // Kirim data ke view
        $data['bulan'] = $bulan;
        $data['tanggal_list'] = $tanggalList;
        $data['hari_list'] = $hariList;

        // Data pengaturan
        $pengaturan = $pengaturanModel->find(1);
        $data['tahun_ajaran'] = $pengaturan['tahun_ajaran'] ?? '';
        $data['copyright'] = $pengaturan['copyright'] ?? '';
        $data['nama_sekolah'] = $pengaturan['nama_sekolah'] ?? '';
        $data['logo'] = isset($pengaturan['logo']) ? base_url('uploads/' . $pengaturan['logo']) : '';

        // Load View untuk layout PDF
        $html = view('generate_laporan/guru', $data);

        // Konfigurasi DOMPDF
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Outputkan sebagai PDF
        $dompdf->stream("Laporan_Absen_Guru_{$bulan}_{$date->format('Y')}.pdf", ["Attachment" => 1]);
    }

    public function generate_guru_doc()
    {
        $guruModel = new GuruModel();
        $absensiGuruModel = new AbsensiGuruModel(); // Tambahkan model AbsensiGuru
        $pengaturanModel = new PengaturanModel();

        // Ambil bulan dari parameter URL
        $bulanTahun = $this->request->getGet('bulan_tahun_guru') ?? date('Y-m');

        // Hitung jumlah guru
        $jumlah_guru = $guruModel->countGuru();

        if ($jumlah_guru == 0) {
            // Jika jumlah guru kosong, arahkan ke halaman dengan pesan error
            return redirect()->to('/generate_laporan')->with('error', 'Data Guru Kosong');
        }

        // Mapping bulan dalam Bahasa Indonesia
        $bulanArray = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        // Mengambil nama bulan dalam Bahasa Indonesia
        $date = new \DateTime($bulanTahun . "-01");
        $bulan = $bulanArray[$date->format('F')];

        // Mengambil tanggal dalam bulan tersebut, kecuali Minggu
        $tanggalList = [];
        $hariList = [];
        $firstDay = new \DateTime($bulanTahun . "-01");
        $lastDay = new \DateTime($bulanTahun . "-01");
        $lastDay->modify('last day of this month');

        $hariArray = ['Sun' => 'Minggu', 'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab'];

        for ($currentDate = $firstDay; $currentDate <= $lastDay; $currentDate->modify('+1 day')) {
            if ($currentDate->format('w') != 0) { // Mengabaikan hari Minggu
                $tanggalList[] = $currentDate->format('Y-m-d');
                $hariList[] = $hariArray[$currentDate->format('D')];
            }
        }

        // Data Guru
        $data['guru_list'] = $guruModel->findAll();

        // Hitung jumlah Laki-Laki dan Perempuan
        $laki_laki = 0;
        $perempuan = 0;
        foreach ($data['guru_list'] as $guru) {
            if ($guru['jenis_kelamin'] == 'Laki-Laki') {
                $laki_laki++;
            } elseif ($guru['jenis_kelamin'] == 'Perempuan') {
                $perempuan++;
            }
        }

        // Kirim data ke view
        $data['laki_laki'] = $laki_laki;
        $data['perempuan'] = $perempuan;

        // Ambil data absensi berdasarkan tanggal dan guru_id
        foreach ($data['guru_list'] as &$guru) {
            $guru['absensi'] = [];
            foreach ($tanggalList as $tanggal) {
                $absensi = $absensiGuruModel->where('guru_id', $guru['id'])->where('tanggal', $tanggal)->first();
                $guru['absensi'][$tanggal] = $absensi ? $absensi['kehadiran_id'] : null; // Menyimpan kehadiran_id jika ada, null jika tidak ada
            }
        }

        // Kirim data ke view
        $data['bulan'] = $bulan;
        $data['tanggal_list'] = $tanggalList;
        $data['hari_list'] = $hariList;

        // Data pengaturan
        $pengaturan = $pengaturanModel->find(1);
        $data['tahun_ajaran'] = $pengaturan['tahun_ajaran'] ?? '';
        $data['copyright'] = $pengaturan['copyright'] ?? '';
        $data['nama_sekolah'] = $pengaturan['nama_sekolah'] ?? '';
        $data['logo'] = isset($pengaturan['logo']) ? base_url('uploads/' . $pengaturan['logo']) : '';

        // Load View untuk layout DOC
        $html = view('generate_laporan/guru', $data);

        // Menyiapkan untuk menghasilkan file DOC
        $this->response->setHeader('Content-Type', 'application/msword');
        $this->response->setHeader(
            'Content-Disposition',
            'attachment; filename=Laporan_Absen_Guru_' . $bulan . '_' . $date->format('Y') . '.doc'
        );

        echo $html;
    }

    public function generate_siswa_pdf()
    {
        $siswaModel = new SiswaModel();
        $absensiSiswaModel = new AbsensiSiswaModel();
        $pengaturanModel = new PengaturanModel();

        // Ambil bulan dari parameter URL
        $bulanTahun = $this->request->getGet('bulan_tahun_siswa') ?? date('Y-m');

        // Ambil kelas_id dari parameter URL
        $kelas_id = $this->request->getGet('kelas_id');
        if (!$kelas_id) {
            return redirect()->to('/generate_laporan')->with('error', 'Kelas tidak dipilih');
        }

        // Ambil informasi kelas dan jurusan
        $kelasData = $siswaModel->getKelasWithJumlahSiswa();
        $selectedKelas = null;
        foreach ($kelasData as $kelas) {
            if ($kelas['id'] == $kelas_id) {
                $selectedKelas = $kelas;
                break;
            }
        }

        if (!$selectedKelas) {
            return redirect()->to('/generate_laporan')->with('error', 'Data kelas tidak ditemukan');
        }
        // Jika jumlah siswa di kelas tertentu adalah 0
        if ($selectedKelas['jumlah_siswa'] == 0) {
            return redirect()->to('/generate_laporan')->with('error', 'Data Siswa Kelas Kosong');
        }
        $namaKelas = $selectedKelas['nama_kelas'];
        $jurusan = $selectedKelas['jurusan'];

        // Hitung jumlah siswa keseluruhan
        $jumlah_siswa = $siswaModel->countSiswa();

        if ($jumlah_siswa == 0) {
            // Jika jumlah siswa keseluruhankosong, arahkan ke halaman dengan pesan error
            return redirect()->to('/generate_laporan')->with('error', 'Data Siswa Kosong');
        }

        // Mengambil nama bulan dalam Bahasa Indonesia
        $bulanArray = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        $date = new \DateTime($bulanTahun . "-01");
        $bulan = $bulanArray[$date->format('F')];

        // Mengambil tanggal dalam bulan tersebut, kecuali Minggu
        $tanggalList = [];
        $hariList = [];
        $firstDay = new \DateTime($bulanTahun . "-01");
        $lastDay = new \DateTime($bulanTahun . "-01");
        $lastDay->modify('last day of this month');

        $hariArray = ['Sun' => 'Minggu', 'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab'];

        for ($currentDate = $firstDay; $currentDate <= $lastDay; $currentDate->modify('+1 day')) {
            if ($currentDate->format('w') != 0) { // Mengabaikan hari Minggu
                $tanggalList[] = $currentDate->format('Y-m-d');
                $hariList[] = $hariArray[$currentDate->format('D')];
            }
        }

        // Mengambil daftar siswa berdasarkan kelas_id yang dipilih
        $data['siswa_list'] = $siswaModel->where('kelas_id', $kelas_id)->findAll();


        // Hitung jumlah Laki-Laki dan Perempuan
        $laki_laki = 0;
        $perempuan = 0;
        foreach ($data['siswa_list'] as $siswa) {
            if ($siswa['jenis_kelamin'] == 'Laki-Laki') {
                $laki_laki++;
            } elseif ($siswa['jenis_kelamin'] == 'Perempuan') {
                $perempuan++;
            }
        }

        // Kirim data ke view
        $data['laki_laki'] = $laki_laki;
        $data['perempuan'] = $perempuan;

        // Kirim data absensi berdasarkan tanggal dan siswa_id
        foreach ($data['siswa_list'] as &$siswa) {
            $siswa['absensi'] = [];
            foreach ($tanggalList as $tanggal) {
                $absensi = $absensiSiswaModel->where('siswa_id', $siswa['id'])->where('tanggal', $tanggal)->first();
                $siswa['absensi'][$tanggal] = $absensi ? $absensi['kehadiran_id'] : null;
            }
        }

        // Data pengaturan
        $pengaturan = $pengaturanModel->find(1);
        $data['bulan'] = $bulan;
        $data['tanggal_list'] = $tanggalList;
        $data['hari_list'] = $hariList;
        $data['tahun_ajaran'] = $pengaturan['tahun_ajaran'] ?? '';
        $data['copyright'] = $pengaturan['copyright'] ?? '';
        $data['nama_sekolah'] = $pengaturan['nama_sekolah'] ?? '';
        $data['logo'] = isset($pengaturan['logo']) ? base_url('uploads/' . $pengaturan['logo']) : '';
        $data['namaKelas'] = $namaKelas;
        $data['jurusan'] = $jurusan;

        // Load View untuk layout PDF
        $html = view('generate_laporan/siswa', $data);

        // Konfigurasi DOMPDF
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Outputkan sebagai PDF dengan nama yang sesuai
        $dompdf->stream("Laporan_Absen_{$namaKelas}_{$jurusan}_{$bulan}_{$date->format('Y')}.pdf", ["Attachment" => 1]);
    }

    public function generate_siswa_doc()
    {
        $siswaModel = new SiswaModel();
        $absensiSiswaModel = new AbsensiSiswaModel();
        $pengaturanModel = new PengaturanModel();

        // Ambil bulan dari parameter URL
        $bulanTahun = $this->request->getGet('bulan_tahun_siswa') ?? date('Y-m');

        // Ambil kelas_id dari parameter URL
        $kelas_id = $this->request->getGet('kelas_id');
        if (!$kelas_id) {
            return redirect()->to('/generate_laporan')->with('error', 'Kelas tidak dipilih');
        }

        // Ambil informasi kelas dan jurusan
        $kelasData = $siswaModel->getKelasWithJumlahSiswa();
        $selectedKelas = null;
        foreach ($kelasData as $kelas) {
            if ($kelas['id'] == $kelas_id) {
                $selectedKelas = $kelas;
                break;
            }
        }

        if (!$selectedKelas) {
            return redirect()->to('/generate_laporan')->with('error', 'Data kelas tidak ditemukan');
        }
        // Jika jumlah siswa di kelas tertentu adalah 0
        if ($selectedKelas['jumlah_siswa'] == 0) {
            return redirect()->to('/generate_laporan')->with('error', 'Data Siswa Kelas Kosong');
        }
        $namaKelas = $selectedKelas['nama_kelas'];
        $jurusan = $selectedKelas['jurusan'];

        // Hitung jumlah siswa keseluruhan
        $jumlah_siswa = $siswaModel->countSiswa();

        if ($jumlah_siswa == 0) {
            // Jika jumlah siswa keseluruhankosong, arahkan ke halaman dengan pesan error
            return redirect()->to('/generate_laporan')->with('error', 'Data Siswa Kosong');
        }

        // Mengambil nama bulan dalam Bahasa Indonesia
        $bulanArray = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        $date = new \DateTime($bulanTahun . "-01");
        $bulan = $bulanArray[$date->format('F')];

        // Mengambil tanggal dalam bulan tersebut, kecuali Minggu
        $tanggalList = [];
        $hariList = [];
        $firstDay = new \DateTime($bulanTahun . "-01");
        $lastDay = new \DateTime($bulanTahun . "-01");
        $lastDay->modify('last day of this month');

        $hariArray = ['Sun' => 'Minggu', 'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab'];

        for ($currentDate = $firstDay; $currentDate <= $lastDay; $currentDate->modify('+1 day')) {
            if ($currentDate->format('w') != 0) { // Mengabaikan hari Minggu
                $tanggalList[] = $currentDate->format('Y-m-d');
                $hariList[] = $hariArray[$currentDate->format('D')];
            }
        }

        // Mengambil daftar siswa berdasarkan kelas_id yang dipilih
        $data['siswa_list'] = $siswaModel->where('kelas_id', $kelas_id)->findAll();


        // Hitung jumlah Laki-Laki dan Perempuan
        $laki_laki = 0;
        $perempuan = 0;
        foreach ($data['siswa_list'] as $siswa) {
            if ($siswa['jenis_kelamin'] == 'Laki-Laki') {
                $laki_laki++;
            } elseif ($siswa['jenis_kelamin'] == 'Perempuan') {
                $perempuan++;
            }
        }

        // Kirim data ke view
        $data['laki_laki'] = $laki_laki;
        $data['perempuan'] = $perempuan;

        // Kirim data absensi berdasarkan tanggal dan siswa_id
        foreach ($data['siswa_list'] as &$siswa) {
            $siswa['absensi'] = [];
            foreach ($tanggalList as $tanggal) {
                $absensi = $absensiSiswaModel->where('siswa_id', $siswa['id'])->where('tanggal', $tanggal)->first();
                $siswa['absensi'][$tanggal] = $absensi ? $absensi['kehadiran_id'] : null;
            }
        }

        // Data pengaturan
        $pengaturan = $pengaturanModel->find(1);
        $data['bulan'] = $bulan;
        $data['tanggal_list'] = $tanggalList;
        $data['hari_list'] = $hariList;
        $data['tahun_ajaran'] = $pengaturan['tahun_ajaran'] ?? '';
        $data['copyright'] = $pengaturan['copyright'] ?? '';
        $data['nama_sekolah'] = $pengaturan['nama_sekolah'] ?? '';
        $data['logo'] = isset($pengaturan['logo']) ? base_url('uploads/' . $pengaturan['logo']) : '';
        $data['namaKelas'] = $namaKelas;
        $data['jurusan'] = $jurusan;
        // Load View untuk layout DOC
        $html = view('generate_laporan/siswa', $data);

        // Menyiapkan untuk menghasilkan file DOC
        $this->response->setHeader('Content-Type', 'application/msword');
        $this->response->setHeader(
            'Content-Disposition',
            'attachment; filename=Laporan_Absen' . '_' . $namaKelas . '_' . $jurusan . '_' . $bulan . '_' . $date->format('Y') . '.doc'
        );

        echo $html;
    }
}
