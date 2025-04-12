<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        /* Gaya Konsisten untuk Card */
        .card {
            background: rgba(255, 255, 255, 0.1);
            /* Background transparan dengan sedikit opasitas */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        /* Efek Hover Border untuk Card */
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        /* Card Siswa (warna hijau) */
        .card.siswa-card:hover {
            border: 1px solid #28a745;
            /* Hijau untuk Siswa */
        }

        /* Card Guru (warna biru) */
        .card.guru-card:hover {
            border: 1px solid #0072ff;
            /* Biru untuk Guru */
        }

        /* Card Kelas (warna kuning) */
        .card.kelas-card:hover {
            border: 1px solid #ffc107;
            /* Kuning untuk Kelas */
        }

        /* Card Petugas (warna merah) */
        .card.petugas-card:hover {
            border: 1px solid #dc3545;
            /* Merah untuk Petugas */
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

        .custom-card {
            margin-top: 30px;
            /* Menurunkan card ke bawah */
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            /* To allow icon to be positioned relative to card */
        }

        .custom-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);

        }

        .icon-box {
            width: 65px;
            /* Adjust width of the icon */
            height: 65px;
            /* Adjust height of the icon */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #0072ff;
            border-radius: 5px;
            position: absolute;
            /* Position it absolutely within the card */
            top: -60px;
            /* Move the icon 50% outside the card */
            left: -20px;
            z-index: 1000;
            /* Ensure icon appears above the card */
            transition: all 0.3s ease;
        }

        .icon-box i {
            font-size: 2rem;
        }

        .icon-box:hover {
            transform: scale(1.1);
        }

        .number-box {
            padding-top: 10px;
            width: 100%;
            font-size: 3rem;
            font-weight: bold;
            color: #fff;
        }

        .card-label {
            font-size: 0.9rem;
            font-weight: normal;
            color: #fff;
        }

        .card-footer {
            background-color: rgba(0, 0, 0, 0.1);
            color: #888;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .footer-text {
            color: #ddd;

        }

        .card-footer.text-center {
            font-size: 0.8rem;
            color: #fff;
            border-bottom-left-radius: 10px;
            /* Membuat border radius pada kiri bawah */
            border-bottom-right-radius: 10px;
            /* Membuat border radius pada kanan bawah */
        }

        .card-footer.text-center:hover {
            border-top: 1px solid #9013fe;
        }

        .row {
            display: flex;
            justify-content: space-around;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-body h5 {
            margin: 0;
            /* Menghilangkan margin pada angka */
            padding: 0;
            /* Menghilangkan padding jika ada */
        }

        .number-box h2 {
            margin: 0;
            /* Menghilangkan margin pada angka */
            padding: 0;
            /* Menghilangkan padding jika ada */
        }

        .gur {
            color: rgb(0, 70, 240);
        }

        .sis {
            color: #28a745;
        }

        .footer-text i {
            margin-right: 2px;
            /* Memberikan jarak sedikit antara ikon dan teks */
        }

        .fa-house-user {
            color: #ffc107;
        }

        .fa-tools {
            color: #dc3545;
        }

        /* CSS untuk menebalkan garis horizontal di atas */
        .garis-pemisah {
            border: 0;
            border-top: 3px solid #333;
            /* Warna dan ketebalan garis */
            margin: 10px 0;
        }

        /* CSS untuk memberikan garis pemisah pada kolom absensi */
        .row.text-center .col-3 {
            border-right: 2px solid #ddd;
            /* Garis pemisah antar kolom */
            display: flex;
            flex-direction: column;
            /* Menampilkan isi kolom secara vertikal */
            align-items: center;
            justify-content: center;
            padding-top: 5px;
        }

        .row.text-center .col-3 p {
            font-size: 1.5rem;
            /* Ukuran font angka */
            font-weight: bold;
        }

        .row.text-center .col-3 strong {
            font-size: 1rem;
            /* Ukuran font judul status absensi */
        }

        .row.text-center .col-3:last-child {
            border-right: none;
            /* Menghilangkan border pada kolom terakhir */
        }

        .siswa-ini {

            color: #28a745;
        }

        .guru-ini {
            color: rgb(0, 70, 240);
        }

        /* Warna untuk status absensi */
        .status-hadir {
            color: #28a745;
            /* Hijau */
        }

        .status-izin {
            color: #17a2b8;
            /* Biru */
        }

        .status-sakit {
            color: #ffc107;
            /* Kuning */
        }

        .status-alfa {
            color: red;
            /* Merah */
        }

        /* Gaya untuk angka absensi */
        .absensi-count {
            margin-top: 10px;
            margin-bottom: 0;
        }

        .card .sisgur {
            margin-bottom: 40px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .row.text-center .col-3 {
                width: 100%;
                /* Membuat setiap status absensi menempati seluruh lebar layar */
                margin-bottom: 20px;
                /* Memberikan jarak antar status */
            }

            /* Menjaga agar status tetap terlihat baik dengan margin */
            .row.text-center .col-3 strong {
                margin-bottom: 10px;
                /* Memberikan jarak lebih besar antara label dan angka */
            }

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
                <a class="nav-link active" href="<?= base_url('/') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('absensi_siswa') ?>"><i class="fas fa-user-check"></i> Absensi Siswa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('absensi_guru') ?>"><i class="fas fa-user-tie"></i> Absensi Guru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('data_siswa') ?>"><i class="fas fa-users"></i> Data Siswa</a>
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
        <h1>Absensi QR Code</h1>
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Dashboard QR Code</h4>
                </div>
                <p class="card-text">Tahun Ajaran: <?= $tahun_ajaran ?></p>

                <!-- Start of the new Cards with Icon, Number, and Labels -->
                <div class="row">
                    <!-- Card 1 - Siswa (Hijau) -->
                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                        <div class="card custom-card siswa-card">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                                    <div class="icon-box bg-success text-white">
                                        <a href="<?= base_url('data_siswa') ?>" class="text-white">
                                            <i class="fas fa-users fa-2x"></i>
                                        </a>
                                    </div>
                                    <div class="number-box">
                                        <h2><?= $jumlah_siswa ?></h2>
                                    </div>
                                </div>
                                <h5 class="card-label">Jumlah Siswa</h5>
                            </div>
                            <div class="card-footer text-center">
                                <span class="footer-text">
                                    <i class="fas fa-check sis"></i> Terdaftar
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 - Guru (Biru) -->
                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                        <div class="card custom-card guru-card">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                                    <div class="icon-box bg-primary text-white">
                                        <a href="<?= base_url('data_guru') ?>" class="text-white">
                                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                        </a>
                                    </div>
                                    <div class="number-box">
                                        <h2><?= $jumlah_guru ?></h2>
                                    </div>
                                </div>
                                <h5 class="card-label">Jumlah Guru</h5>
                            </div>
                            <div class="card-footer text-center">
                                <span class="footer-text">
                                    <i class="fas fa-check gur"></i> Terdaftar
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 - Kelas (Kuning) -->
                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                        <div class="card custom-card kelas-card">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                                    <div class="icon-box bg-warning text-white">
                                        <a href="<?= base_url('data_kelas') ?>" class="text-white">
                                            <i class="fas fa-school fa-2x"></i>
                                        </a>
                                    </div>
                                    <div class="number-box">
                                        <h2><?= $jumlah_kelas ?></h2>
                                    </div>
                                </div>
                                <h5 class="card-label">Jumlah Kelas</h5>
                            </div>
                            <div class="card-footer text-center">
                                <span class="footer-text">
                                    <i class="fas fa-house-user"></i> <?= $nama_sekolah ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 - Petugas (Merah) -->
                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                        <div class="card custom-card petugas-card">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                                    <div class="icon-box bg-danger text-white">
                                        <a href="<?= base_url('data_petugas') ?>" class="text-white">
                                            <i class="fas fa-users-cog fa-2x"></i>
                                        </a>
                                    </div>
                                    <div class="number-box">
                                        <h2><?= $jumlah_petugas ?></h2>
                                    </div>
                                </div>
                                <h5 class="card-label">Jumlah Petugas</h5>
                            </div>
                            <div class="card-footer text-center">
                                <span class="footer-text">
                                    <i class="fas fa-tools"></i> Administrator
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title siswa-ini">Absensi Siswa Hari Ini</h4>
                        </div>
                        <!-- Tampilkan tanggal hari ini -->
                        <p class="card-text" id="absensiSiswaTanggal">
                            Tanggal: <?php echo date('l, d F Y'); ?>
                        </p>

                        <!-- Garis Horizontal Pembatas Tanggal dan Status -->
                        <hr class="garis-pemisah">

                        <!-- Status Absensi Siswa -->
                        <div class="row text-center">
                            <div class="col-3">
                                <strong class="status-hadir">HADIR</strong>
                                <p id="siswaHadir" class="absensi-count"><?php echo $hadir_count_siswa; ?></p>
                            </div>
                            <div class="col-3">
                                <strong class="status-izin">IZIN</strong>
                                <p id="siswaIzin" class="absensi-count"><?php echo $izin_count_siswa; ?></p>
                            </div>
                            <div class="col-3">
                                <strong class="status-sakit">SAKIT</strong>
                                <p id="siswaSakit" class="absensi-count"><?php echo $sakit_count_siswa; ?></p>
                            </div>
                            <div class="col-3">
                                <strong class="status-alfa">ALFA</strong>
                                <p id="siswaAlfa" class="absensi-count"><?php echo $alfa_count_siswa; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 6 (Absensi Guru Hari Ini) -->
            <div class="col-md-6 col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title guru-ini">Absensi Guru Hari Ini</h4>
                        </div>
                        <!-- Tampilkan tanggal hari ini -->
                        <p class="card-text" id="absensiGuruTanggal">
                            Tanggal: <?php echo date('l, d F Y'); ?>
                        </p>

                        <!-- Garis Horizontal Pembatas Tanggal dan Status -->
                        <hr class="garis-pemisah">

                        <!-- Status Absensi Guru -->
                        <div class="row text-center">
                            <div class="col-3">
                                <strong class="status-hadir">HADIR</strong>
                                <p id="guruHadir" class="absensi-count"><?php echo $hadir_count_guru; ?></p>
                            </div>
                            <div class="col-3">
                                <strong class="status-izin">IZIN</strong>
                                <p id="guruIzin" class="absensi-count"><?php echo $izin_count_guru; ?></p>
                            </div>
                            <div class="col-3">
                                <strong class="status-sakit">SAKIT</strong>
                                <p id="guruSakit" class="absensi-count"><?php echo $sakit_count_guru; ?></p>
                            </div>
                            <div class="col-3">
                                <strong class="status-alfa">ALFA</strong>
                                <p id="guruAlfa" class="absensi-count"><?php echo $alfa_count_guru; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <!-- Card 7 - Grafik Absensi Siswa dan Guru -->
            <div class="col-md-12 col-12 mb-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title sisgur">Grafik Absensi Siswa dan Guru (7 Hari Terakhir)</h4>
                        </div>
                        <canvas id="grafikAbsensi" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Skrip JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('grafikAbsensi').getContext('2d');
        const grafikAbsensi = new Chart(ctx, {
            type: 'line', // Grafik jenis line
            data: {
                labels: <?= json_encode($last7Days) ?>, // Tanggal-tanggal 7 hari terakhir
                datasets: [{
                        label: 'Absensi Siswa - Hadir',
                        data: <?= json_encode($siswaHadir) ?>,
                        borderColor: 'rgba(40, 167, 69, 1)',
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Absensi Siswa - Izin',
                        data: <?= json_encode($siswaIzin) ?>,
                        borderColor: 'rgba(23, 162, 184, 1)',
                        backgroundColor: 'rgba(23, 162, 184, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Absensi Siswa - Sakit',
                        data: <?= json_encode($siswaSakit) ?>,
                        borderColor: 'rgba(255, 193, 7, 1)',
                        backgroundColor: 'rgba(255, 193, 7, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Absensi Siswa - Alfa',
                        data: <?= json_encode($siswaAlfa) ?>,
                        borderColor: 'rgba(220, 53, 69, 1)',
                        backgroundColor: 'rgba(220, 53, 69, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Absensi Guru - Hadir',
                        data: <?= json_encode($guruHadir) ?>,
                        borderColor: 'rgba(40, 167, 69, 1)',
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Absensi Guru - Izin',
                        data: <?= json_encode($guruIzin) ?>,
                        borderColor: 'rgba(23, 162, 184, 1)',
                        backgroundColor: 'rgba(23, 162, 184, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Absensi Guru - Sakit',
                        data: <?= json_encode($guruSakit) ?>,
                        borderColor: 'rgba(255, 193, 7, 1)',
                        backgroundColor: 'rgba(255, 193, 7, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Absensi Guru - Alfa',
                        data: <?= json_encode($guruAlfa) ?>,
                        borderColor: 'rgba(220, 53, 69, 1)',
                        backgroundColor: 'rgba(220, 53, 69, 0.2)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        align: 'center', // Menyelaraskan legend di tengah
                        labels: {
                            color: 'white', // Warna teks legend menjadi putih
                            padding: 20, // Memberikan jarak antar item legend
                            boxWidth: 20, // Menentukan lebar kotak warna di legend
                            font: {
                                weight: 'bold' // Menebalkan teks legend
                            }
                        },
                        padding: 30 // Menambah jarak antara legend dan chart
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            title: (tooltipItems) => {
                                return tooltipItems[0].label; // Warna judul tooltip menjadi putih
                            },
                            label: (tooltipItem) => {
                                return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`; // Warna label tooltip menjadi putih
                            }
                        },
                        backgroundColor: 'rgba(0, 0, 0, 0.7)', // Background tooltip gelap
                        titleColor: 'white', // Warna judul tooltip menjadi putih
                        bodyColor: 'white', // Warna teks isi tooltip menjadi putih
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal',
                            color: 'white', // Warna teks sumbu X menjadi putih
                            font: {
                                weight: 'bold', // Mengatur font menjadi bold
                            }
                        },
                        ticks: {
                            color: 'white' // Warna angka sumbu X menjadi putih
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah Absensi',
                            color: 'white', // Warna teks sumbu Y menjadi putih
                            font: {
                                weight: 'bold', // Mengatur font menjadi bold
                            }
                        },
                        ticks: {
                            color: 'white' // Warna angka sumbu Y menjadi putih
                        }
                    }
                }
            }
        });
    </script>


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


        // Mendapatkan tanggal saat ini
        const tanggalSekarang = new Date().toLocaleDateString("id-ID", {
            weekday: 'long', // Hari dalam minggu
            year: 'numeric', // Tahun
            month: 'long', // Bulan
            day: 'numeric' // Tanggal
        });

        // Menampilkan tanggal di dalam elemen yang sesuai
        document.getElementById('absensiSiswaTanggal').textContent = `${tanggalSekarang}`;
        document.getElementById('absensiGuruTanggal').textContent = `${tanggalSekarang}`;


        // Grafik Absensi Siswa
        var ctxSiswa = document.getElementById('grafikAbsensiSiswa').getContext('2d');
        var grafikAbsensiSiswa = new Chart(ctxSiswa, {
            type: 'bar', // Jenis grafik, bisa disesuaikan
            data: {
                labels: ['Hadir', 'Izin', 'Sakit', 'Alfa'], // Label status absensi
                datasets: [{
                    label: 'Jumlah Absensi Siswa',
                    data: [<?php echo $hadir_count_siswa; ?>, <?php echo $izin_count_siswa; ?>, <?php echo $sakit_count_siswa; ?>, <?php echo $alfa_count_siswa; ?>], // Data dari PHP
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d'], // Warna untuk masing-masing kategori
                    borderColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d'], // Warna border
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>