<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Background Gradasi Mirip dengan login.php */
        body {
            background: linear-gradient(to right, #4a90e2, #9013fe);
            font-family: 'Poppins', sans-serif;
            color: white;
            height: 100vh;
            margin: 0;
        }

        /* Navbar */
        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .navbar .navbar-brand {
            color: #ffffff;
        }

        .navbar .d-flex.align-items-center {
            flex-direction: row;
            margin-right: 20px;
            /* Atur nilai ini untuk menggeser elemen ke kiri */
        }

        /* Menggeser elemen QR Code ke kanan */
        .navbar .dropdown:first-child {
            transform: translateX(25px);
            /* Sesuaikan nilai ini untuk mengatur jarak geser */
        }

        .dropdown-menu {
            width: auto;
            /* Menyesuaikan lebar dropdown dengan panjang konten */
            min-width: 120px;
            /* Menambahkan lebar minimum agar tidak terlalu sempit */
        }

        /* Efek hover pada dropdown */
        .navbar .dropdown-menu {
            background-color: #333;
            /* Background dropdown lebih gelap */
            border-radius: 8px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            /* Shadow pada dropdown */
            transition: opacity 0.3s ease, visibility 0.3s ease;
            /* Transisi halus */
            padding: 5px;
        }

        /* Menampilkan dropdown dengan transisi */
        .navbar .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
        }

        /* Hover pada item dropdown */
        .dropdown-item {
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #0072ff;
            /* Warna saat hover */
            transform: scale(1.05);
            /* Sedikit memperbesar ukuran item saat hover */
        }

        .dropdown-item:active {
            background-color: #9013fe;
            transform: scale(0.9);
            font-weight: bold;
        }

        .navbar .dropdown .user-info {
            display: flex;
            align-items: center;
            font-weight: bold;
            color: #ffffff !important;
        }

        /* Hamburger Button */
        #hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            height: 29px;
            /* Tingkatkan tinggi untuk memberi ruang lebih banyak */
            width: 35px;
            /* Lebar lebih besar */
            position: absolute;
            top: 14px;
            /* Menjaga jarak dari atas */
            left: 14px;
            /* Menjaga posisi hamburger di kiri */
            justify-content: space-between;
            /* Spasi antar garis hamburger */
            transition: all 0.3s ease;
        }


        #hamburger div {
            height: 4px;
            background: white;
            border-radius: 5px;
            margin: 3px 0;
            transition: all 0.3s ease;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #2d2d2d;
            padding-top: 20px;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            overflow-y: auto;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar .nav-link {
            color: #fff;
            font-size: 0.9rem;
            padding: 10px 20px;
            border-radius: 8px;
            margin-bottom: 1px;
            transition: all 0.4s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #0072ff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transform: scale(0.9);
        }

        .sidebar .nav-link.active {
            background-color: #9013fe;
            transform: scale(0.9);
            font-weight: bold;
        }

        .sidebar .nav-item {
            margin-bottom: 20px;
        }

        .sidebar .nav-item i {
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .sidebar .sidebar-heading {
            color: #bbb;
            text-transform: uppercase;
            padding: 10px 20px;
            font-weight: bold;
            letter-spacing: 2px;
            font-size: 1.2rem;
            text-align: center;
        }

        .menu-divider {
            border: 0;
            height: 1px;
            background: #bbb;
            margin: 10px 20px;
        }

        /* Content */
        .content {
            margin-left: 250px;
            padding: 30px;
            transition: margin-left 0.1s ease-out;

        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .table th:nth-child(1),
        .table td:nth-child(1) {
            text-align: center;
            max-width: 10px;
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            text-align: center;
            max-width: 50px;
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            max-width: 105px;
            white-space: nowrap;
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            max-width: 180px;
            word-wrap: break-word;
            white-space: normal;
        }

        .table th:nth-child(5),
        .table td:nth-child(5) {
            max-width: 110px;
            white-space: nowrap;
        }

        .table th:nth-child(6),
        .table td:nth-child(6) {
            max-width: 50px;
            /* Mengatur batas maksimal lebar kolom */
            white-space: nowrap;
        }

        .table th:nth-child(7),
        .table td:nth-child(7) {
            max-width: 100px;
            /* Mengatur batas maksimal lebar kolom */
            white-space: normal;
        }

        .table th:nth-child(8),
        .table td:nth-child(8) {
            max-width: 130px;
            /* Mengatur batas maksimal lebar kolom */
            white-space: normal;
        }

        .table th:nth-child(9),
        .table td:nth-child(9) {
            max-width: 120px;
            /* Mengatur batas maksimal lebar kolom */
            white-space: nowrap;
        }

        .table-striped {
            color: #ffffff;
        }

        /* Mengatur warna border untuk tabel */
        .table thead th,
        .table td {
            border-color: #2d2d2d;
            /* Warna garis border */
        }

        /* Efek hover pada baris tabel dengan latar belakang abu-abu transparan */
        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.1);
            /* Warna hitam transparan */
        }

        /* Menjaga teks header tabel di tengah secara horizontal */
        .table thead th {
            vertical-align: middle;
            /* Menjaga agar teks tetap di tengah secara vertikal */
        }

        /* Mengatur warna garis border di header */
        .table thead th {
            border-top: 2px solid #2d2d2d;
            border-bottom: 2px solid #2d2d2d;
            /* Warna garis bawah header */
        }

        /* Mengatur warna garis horizontal antara baris */
        .table-striped tbody tr {
            border-bottom: 1px solid #2d2d2d;
            /* Warna garis antar baris */
        }

        /* Gaya Konsisten untuk Card */
        .card {
            background: rgba(255, 255, 255, 0.1);
            /* Background transparan dengan sedikit opasitas */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        /* Efek Hover pada Card */
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        /* Gaya untuk Judul Card */
        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #ffffff;
            /* Warna teks putih */
        }

        /* Gaya untuk Text dalam Card */
        .card-text {
            color: #fff;
            margin-bottom: 20px;
        }

        /* Gaya untuk Footer Card */
        .card-footer {
            background: transparent;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            text-align: right;
        }

        .btn {
            background-color: #9013fe !important;
            color: white !important;
            border-radius: 5px !important;
            transition: background-color 0.3s ease !important;
            border: none !important;

        }

        .btn:hover {
            background-color: #0072ff !important;
        }

        .btn:focus,
        .btn:active {
            outline: none !important;
            border: none !important;
            box-shadow: none !important;
        }

        .btn-primary {
            height: auto;
            /* Mengatur agar tinggi mengikuti konten */
            vertical-align: middle;
            /* Untuk menyelaraskan vertikal */
            text-align: center;
        }

        .btn-primary:hover {
            background-color: #000000B3 !important;
        }

        .btn-success:hover {
            background-color: #000000B3 !important;
        }

        .btn-info:hover {
            background-color: #2d2d2d !important;
        }

        .btn-danger:hover {
            background-color: #dc3545 !important;
        }

        .card-body {
            padding: 20px;
            overflow-x: auto;
            /* Menambahkan scroll horizontal jika diperlukan */
        }

        .custom-input {
            border: none;
            border-bottom: 2px solid #ffffff;
            /* Warna garis bawah */
            background: transparent;
            border-radius: 0;
            color: #ffffff;
            /* Warna teks */
            outline: none;
            width: 100%;
            /* Opsional, untuk membuat input penuh */
        }

        .custom-input:hover {
            border-bottom-color: #2d2d2d;
            /* Warna garis saat input aktif */
            outline: none;
            color: #ffffff;
            box-shadow: none;

        }

        .custom-input:focus {
            border-bottom-color: #2d2d2d;
            /* Warna garis saat input aktif */
            outline: none;
            color: #ffffff;
            box-shadow: none;
            background: transparent;
        }

        .custom-input::placeholder {
            color: #cccccc;
            /* Ganti dengan warna yang Anda inginkan */
            opacity: 1;
            /* Pastikan opacity 1 untuk menghindari transparansi default */
        }

        .custom-input option {
            background-color: #2d2d2d;
            color: white;

        }

        .btn-secondary {
            background-color: #9013fe !important;
            /* Warna tombol */
            color: white;
            /* Warna teks */
            border: none;
            /* Hilangkan border */
            border-radius: 8px;
            /* Sesuaikan radius */
            padding: 10px 20px;
            /* Sesuaikan ukuran */
            font-size: 1rem;
            /* Ukuran font */
            transition: background-color 0.3s ease;
            /* Animasi saat hover */
            width: 100%;
        }

        .btn-secondary:hover {
            background-color: #000000B3 !important;
            /* Warna saat hover */
        }

        .btn-secondary:focus {
            outline: none;
            box-shadow: 0 0 8px rgba(255, 87, 51, 0.5);
            /* Efek fokus */
        }

        .modal-header {
            display: flex;
            flex-direction: column;
            /* Susun elemen secara vertikal */
            align-items: flex-start;
            /* Rapatkan ke kiri */
            background-color: #9013fe;
        }

        .modal-content {
            background-color: #2d2d2d;
            color: white;
        }

        .modal-header h5 {
            margin-bottom: 5px;
            /* Tambahkan jarak antara judul dan teks tahun ajaran */
        }

        .modal-body {
            max-height: 490px;
            /* Atur tinggi sesuai kebutuhan */
            overflow-y: scroll;
            scrollbar-width: none;
            /* Untuk browser modern */
            -ms-overflow-style: none;
            /* Untuk IE dan Edge */
        }

        .modal-body::-webkit-scrollbar {
            display: none;
            /* Sembunyikan scrollbar pada Webkit (Chrome, Safari) */
        }

        /* Atur ulang border */
        #invalidDataModal .table-bordered th,
        #invalidDataModal .table-bordered td {
            border: 1px solid white;
            /* Warna garis tabel putih */
        }

        .table-bordered thead th {
            border-bottom: 2px solid white !important;
            /* Border bawah header lebih tebal */
        }

        /* Hilangkan efek hover hanya pada tabel di modal */
        #invalidDataModal .table tr:hover,
        #invalidDataModal .table-bordered tr:hover {
            background-color: transparent !important;
            /* Hilangkan perubahan warna saat hover */
            cursor: default !important;
            /* Kursor tetap default */
        }

        /* Pastikan teks di tabel membungkus dengan baik */
        #invalidDataModal .table td,
        #invalidDataModal .table th {
            word-wrap: break-word;
            /* Membagi kata panjang */
            word-break: break-word;
            /* Pecah kata bila terlalu panjang */
            white-space: normal;
            /* Izinkan teks membungkus */
            max-width: 1px;
            /* Atur batas maksimum kolom agar membungkus */
        }

        /* Atur padding dan margin di kolom kesalahan agar lebih rapat ke kiri */
        #invalidDataModal .table td ul {
            padding-left: 15px;
            /* Menambahkan ruang antara bullet dan garis tabel */
            margin-left: 0;
            /* Menghapus margin kiri yang tidak perlu */
            list-style-position: outside;
            /* Memastikan bullet berada di luar, bukan di dalam */
        }

        #invalidDataModal .table td li {
            padding-left: 0;
            /* Menghapus padding kiri pada <li> untuk meminimalkan jarak */
        }

        .text-custom {
            color: #ffffff;
            /* Ganti dengan warna yang diinginkan */
            font-style: italic;
        }

        .kelas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            /* Menyesuaikan kolom */
            gap: 10px;
            /* Jarak antar tombol */
        }

        .kelas-grid .btn-kelas {
            width: 100%;
            /* Mengatur lebar tombol agar sesuai dengan grid */
            text-align: center;
            /* Menyelaraskan teks ke tengah */
            padding: 10px;
            /* Menambahkan padding agar tombol lebih besar */
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: all 0.3s ease !important;
            /* Efek transisi yang halus */
            cursor: pointer;
            border: 2px solid #fff !important;
            /* Warna border */
            background-color: transparent !important;
            /* Tidak ada background */
        }

        /* Hover effect */
        .btn-kelas:hover {
            background-color: #9013fe !important;
            /* Warna background saat hover */
            transform: scale(1.02);
        }

        /* Menandai tombol yang dipilih dengan hover tetap aktif */
        .btn-kelas.selected {
            background-color: #9013fe !important;
            /* Warna background saat hover */
            transform: scale(1.02);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            #hamburger {
                display: flex !important;
                position: absolute;
                left: 14px;
                /* Memindahkan hamburger ke kiri */
                top: 14px;
                /* Menjaga jarak dari atas */
                transition: all 0.4s ease;
            }

            .navbar .d-flex.align-items-center {
                flex-direction: row;
                /* Pastikan elemen dalam satu baris */
            }

            .sidebar {
                width: 200px;
                left: -250px;
                transition: all 0.6s ease;
            }

            .sidebar .nav-link {
                font-size: 0.9rem;
                padding: 10px 15px;

            }

            .content {
                margin-left: 0;
                padding: 20px;
                transition: margin-left 0.3s ease-in;
            }

            .sidebar.active {
                left: 0;
                /* Menggeser sidebar ke kiri ketika aktif */
            }

            .navbar .navbar-brand {
                font-size: 1.5rem;
            }

            .content h1 {
                font-size: 2rem;
            }

            .sidebar.active~.content {
                margin-left: 200px;
                /* Konten bergeser saat sidebar aktif */
            }

            #hamburger.active {
                transform: translateX(210px);
                /* Geser hamburger ke kanan saat sidebar terbuka */
            }

            #hamburger.active div:nth-child(1) {
                transform: rotate(45deg) translate(6px, 6px);
            }

            #hamburger.active div:nth-child(2) {
                opacity: 0;
            }

            #hamburger.active div:nth-child(3) {
                transform: rotate(-45deg) translate(8px, -8px);
            }

        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-between">
        <div class="d-flex align-items-center ml-auto"> <!-- Elemen pembungkus d-flex -->
            <div class="dropdown mr-3"> <!-- Dropdown QR code -->
                <a class="nav-link dropdown-toggle user-info" href="#" id="qrDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-qrcode fa-lg text-white"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="qrDropdown">
                    <a class="dropdown-item" href="<?= base_url('scan/absen_masuk') ?>">Absen Masuk</a>
                    <a class="dropdown-item" href="<?= base_url('scan/absen_pulang') ?>">Absen Pulang</a>
                </div>
            </div>
            <div class="dropdown"> <!-- Dropdown Username -->
                <a class="nav-link dropdown-toggle user-info" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user">&nbsp;</i> <?= session()->get('username'); ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
        <div id="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-heading">Main Menu</div>
        <hr class="menu-divider">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('absensi_siswa') ?>"><i class="fas fa-user-check"></i> Absensi Siswa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('absensi_guru') ?>"><i class="fas fa-user-tie"></i> Absensi Guru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?= base_url('data_siswa') ?>"><i class="fas fa-users"></i> Data Siswa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('data_guru') ?>"><i class="fas fa-chalkboard-teacher"></i> Data Guru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('data_kelas') ?>"><i class="fas fa-school"></i> Data Kelas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('generate_qr') ?>"><i class="fas fa-qrcode"></i> Generate QR</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('generate_laporan') ?>"><i class="fas fa-file-alt"></i> Generate Laporan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('data_petugas') ?>"><i class="fas fa-users-cog"></i> Data Petugas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('pengaturan') ?>"><i class="fas fa-cogs"></i> Pengaturan</a>
            </li>
        </ul>
    </div>

    <div class="content">
        <h1>Data Siswa</h1>
        <!-- Card Daftar Kelas -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Kelas</h4>
                </div>
                <p class="card-text">Silakan pilih kelas:</p>

                <div class="kelas-grid">
                    <?php foreach ($kelas as $k): ?>
                        <button
                            type="button"
                            class="btn btn-kelas <?= ($kelasId == $k['id']) ? 'selected' : '' ?>"
                            onclick="window.location.href='<?= base_url('data_siswa') .
                                                                ($kelasId == $k['id'] ?
                                                                    ('?' . ($keyword ? 'keyword=' . $keyword : '')) : ('?kelas=' . $k['id'] . ($keyword ? '&keyword=' . $keyword : ''))) ?>'">
                            <?= $k['nama_kelas'] ?> - <?= $k['jurusan'] ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Siswa</h4>
                    <div class="d-flex align-items-center">
                        <form action="<?= base_url('data_siswa') ?>" method="get" class="form-inline">
                            <input type="text" name="keyword" class="form-control custom-input mr-2" placeholder="Nama/NIS" value="<?= $keyword ? $keyword : '' ?>">
                            <input type="hidden" name="kelas" value="<?= $kelasId ? $kelasId : '' ?>">
                            <button type="submit" class="btn btn-primary mr-2">Cari</button>
                        </form>
                        <a href="<?= base_url('data_siswa/import') ?>" class="btn btn-success mr-2">Import Data</a>
                        <a href="<?= base_url('data_siswa/tambah') . '?kelas=' . $kelasId . '&keyword=' . $keyword ?>" class="btn btn-success">Tambah Siswa</a>
                    </div>
                </div>

                <p class="card-text">Tahun Ajaran: <?= $tahun_ajaran ?></p>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <form id="deleteSelectedForm" action="<?= base_url('data_siswa/delete_selected') ?>" method="post">
                    <input type="hidden" name="kelas" value="<?= $kelasId ? $kelasId : '' ?>">
                    <input type="hidden" name="keyword" value="<?= $keyword ? $keyword : '' ?>">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll()"></th>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Kelamin</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($siswa)): ?>
                                <tr>
                                    <td colspan="9" class="text-center text-custom">Tidak ada data siswa ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; ?>
                                <?php foreach ($siswa as $s): ?>
                                    <tr>
                                        <td><input type="checkbox" name="selected_siswa[]" value="<?= $s['id'] ?>" class="checkbox-item" onchange="toggleDeleteButton()"></td>
                                        <td><?= $no++ ?></td>
                                        <td><?= $s['nis'] ?></td>
                                        <td><?= $s['nama_siswa'] ?></td>
                                        <td><?= $s['jenis_kelamin'] ?></td>
                                        <td><?= $s['nama_kelas'] ?></td>
                                        <td><?= $s['jurusan'] ?></td>
                                        <td><?= $s['no_hp'] ?></td>
                                        <td>
                                            <a href="<?= base_url('data_siswa/edit/' . $s['id'] . '?' . ($kelasId ? 'kelas=' . $kelasId : '') . ($keyword ? '&keyword=' . $keyword : '')) ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            </a>
                                            <a href="<?= base_url('data_siswa/delete/' . $s['id'] . '?' . ($kelasId ? 'kelas=' . $kelasId : '') . ($keyword ? '&keyword=' . $keyword : '')) ?>" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>

                                            <a href="<?= base_url('data_siswa/generate_qr/' . $s['id']) ?>" class="btn btn-info btn-sm">
                                                <i class="fas fa-qrcode"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-custom" id="deleteButton" style="display: none;" onclick="confirmDelete(event)">Hapus yang Terpilih</button>
                </form>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('invalidData')): ?>
        <div class="modal fade" id="invalidDataModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Siswa Bermasalah</h5>
                        <p>
                            Data tidak valid ditemukan. Perbaiki file Anda dan coba lagi.
                        </p>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered text-white">
                            <thead>
                                <tr>
                                    <th>Baris</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kesalahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (session()->getFlashdata('invalidData') as $data): ?>
                                    <tr>
                                        <td><?= $data['row'] ?></td>
                                        <td><?= $data['nis'] ?></td>
                                        <td><?= $data['nama_siswa'] ?></td>
                                        <td>
                                            <ul>
                                                <?php foreach ($data['errors'] as $error): ?>
                                                    <li><?= $error ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Skrip JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

    <script>
        $(document).ready(function() {
            function adjustSidebar() {
                if ($(window).width() > 768) {
                    $('#hamburger').hide();
                    $('#hamburger').css('display', 'none');
                    $('.sidebar').addClass('active'); // Sidebar ditampilkan
                    $('.content').css('full-width', '250px'); // Konten dipindahkan
                } else {
                    $('#hamburger').show();
                    $('#hamburger').css('display', 'flex');
                    // Sidebar hanya ditutup jika hamburger tidak aktif
                    if (!$('#hamburger').hasClass('active')) {
                        $('.sidebar').removeClass('active'); // Sidebar ditutup
                        $('.content').css('full-width', '0'); // Konten kembali normal
                    }
                }
            }

            // Initial check on page load
            adjustSidebar();

            // Adjust on window resize
            $(window).resize(adjustSidebar);

            $('#hamburger').click(function() {
                $(this).toggleClass('active');
                $('.sidebar').toggleClass('active');

                if ($('.sidebar').hasClass('active')) {
                    $('.content').css('full-width', '250px'); // Jika sidebar dibuka
                } else {
                    $('.content').css('full-width', '0'); // Jika sidebar ditutup
                }
            });
        });

        // Mengatur event listener untuk konfirmasi delete
        $(document).on('click', '.btn-danger', function(e) {
            e.preventDefault(); // Mencegah pengalihan default
            const href = $(this).attr('href'); // Ambil link dari tombol

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href; // Redirect ke URL delete jika dikonfirmasi
                }
            });
        });

        $(document).ready(function() {
            $('#invalidDataModal').modal('show');
        });

        function toggleSelectAll() {
            var checkboxes = document.querySelectorAll('input[name="selected_siswa[]"]');
            var selectAllCheckbox = document.getElementById('selectAll');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
            toggleDeleteButton(); // Update the delete button visibility when selecting all
        }

        function toggleDeleteButton() {
            var checkboxes = document.querySelectorAll('input[name="selected_siswa[]"]:checked');
            var deleteButton = document.getElementById('deleteButton');

            // Show or hide the delete button based on whether any checkbox is selected
            if (checkboxes.length > 0) {
                deleteButton.style.display = 'inline-block'; // Show the button
            } else {
                deleteButton.style.display = 'none'; // Hide the button
            }
        }

        function confirmDelete(event) {
            event.preventDefault(); // Mencegah pengiriman form secara langsung

            // Menampilkan konfirmasi menggunakan SweetAlert2
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim form jika dikonfirmasi
                    document.getElementById('deleteSelectedForm').submit();
                }
            });
        }
    </script>
</body>

</html>