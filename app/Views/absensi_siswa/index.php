<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa</title>
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
            max-width: 50px;
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            max-width: 205px;
            word-wrap: break-word;
            white-space: nowrap;
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            max-width: 180px;
            word-wrap: break-word;
            white-space: normal;
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            max-width: 180px;
            white-space: nowrap;
        }

        .table th:nth-child(5),
        .table td:nth-child(5) {
            max-width: 200px;
            word-wrap: break-word;
            white-space: nowrap;
        }

        .table th:nth-child(6),
        .table td:nth-child(6) {
            max-width: 200px;
            /* Mengatur batas maksimal lebar kolom */
            word-wrap: break-word;
            white-space: normal;
        }

        .table th:nth-child(7),
        .table td:nth-child(7) {
            max-width: 130px;
            /* Mengatur batas maksimal lebar kolom */
            white-space: normal;
        }

        .table th:nth-child(8),
        .table td:nth-child(8) {
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

        .text-custom {
            color: #ffffff;
            /* Ganti dengan warna yang diinginkan */
            font-style: italic;
        }

        .label {
            display: inline-block;
            width: 100%;
            /* Pastikan panjangnya sama untuk semua label */
            padding: 6px 5px;
            /* Padding atas dan bawah */
            border-radius: 5px;
            font-size: 15px;
            color: #ffffff;
            text-align: center;
            /* Teks rata tengah */
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
            /* Animasi transisi */
        }

        .label-hadir {
            background-color: #28a745;
            /* Hijau */
        }

        .label-hadir:hover {
            background-color: #218838;
            /* Hijau lebih gelap */
            transform: scale(1.02);
            /* Sedikit membesar */
        }

        .label-sakit {
            background-color: #ffc107;
            /* Kuning */
        }

        .label-sakit:hover {
            background-color: #e0a800;
            /* Kuning lebih gelap */
            transform: scale(1.02);
            /* Sedikit membesar */
        }

        .label-izin {
            background-color: #007bff;
            /* Biru */
        }

        .label-izin:hover {
            background-color: #0056b3;
            /* Biru lebih gelap */
            transform: scale(1.02);
            /* Sedikit membesar */
        }

        .label-tanpa-keterangan {
            background-color: #dc3545;
            /* Merah */
        }

        .label-tanpa-keterangan:hover {
            background-color: #bd2130;
            /* Merah lebih gelap */
            transform: scale(1.02);
            /* Sedikit membesar */
        }

        .modal-content {
            background-color: #2d2d2d;
            color: white;
        }

        .modal-header {
            display: flex;
            flex-direction: column;
            /* Susun elemen secara vertikal */
            align-items: flex-start;
            /* Rapatkan ke kiri */
            background-color: #9013fe;
        }

        .modal-body {
            max-height: 500px;
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

        .modal-footer {
            display: flex;
            justify-content: space-between;
            /* Memastikan tombol berada di sisi yang berlawanan */
            padding: 1rem;
            /* Menambahkan padding agar tombol tidak terlalu rapat */
            border-top: 1px solid #ccc;
            /* Memberikan garis pemisah jika diperlukan */
        }

        .btn-secondary,
        .btn-custom {
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn-secondary {
            background-color: #9013fe;
            color: white;
            width: 60%;
            /* Menyesuaikan ukuran tombol agar seimbang */
        }

        .btn-secondary:focus,
        .btn-custom:focus {
            outline: none;
            box-shadow: 0 0 8px rgba(255, 87, 51, 0.5);
        }


        .btn-custom {
            background-color: #9013fe;
            color: white;
            width: 36%;
            /* Menyesuaikan ukuran tombol agar seimbang */
        }

        .btn-custom:hover {
            background-color: #000000B3 !important;
        }


        /* Grid Layout */
        .kehadiran-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* 2 kolom */
            gap: 10px;
        }

        /* Kotak Kehadiran */
        .kehadiran-box {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            border: 2px solid transparent;
            /* Border default */
            border-radius: 8px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        /* Warna Border dan Teks Awal */
        .kehadiran-box.hadir {
            border-color: #28a745;
            /* Hijau */
            color: #28a745;
        }

        .kehadiran-box.izin {
            border-color: #007bff;
            /* Biru */
            color: #007bff;
        }

        .kehadiran-box.sakit {
            border-color: #ffc107;
            /* Kuning */
            color: #ffc107;
        }

        .kehadiran-box.tanpa-keterangan {
            border-color: #dc3545;
            /* Merah */
            color: #dc3545;
        }

        /* Hover Efek */
        .kehadiran-box:hover {
            background-color: #fff;
            /* Putih saat hover */
            color: white;
            /* Teks putih */
            border-color: white;
            /* Border putih */
            transform: scale(1.02);
            /* Sedikit membesar */
        }

        /* Hover Efek Khusus Untuk Munculnya Background Warna Teks */
        .kehadiran-box.hadir:hover {
            background-color: #28a745;
            /* Hijau */
            color: white;
            /* Teks putih */
            border-color: white;
            /* Border putih */
            transform: scale(1.02);
            /* Sedikit membesar */
        }

        .kehadiran-box.izin:hover {
            background-color: #007bff;
            /* Biru */
            color: white;
            /* Teks putih */
            border-color: white;
            /* Border putih */
            transform: scale(1.02);
            /* Sedikit membesar */
        }

        .kehadiran-box.sakit:hover {
            background-color: #ffc107;
            /* Kuning */
            color: white;
            /* Teks putih */
            border-color: white;
            /* Border putih */
            transform: scale(1.02);
            /* Sedikit membesar */
        }

        .kehadiran-box.tanpa-keterangan:hover {
            background-color: #dc3545;
            /* Merah */
            color: white;
            /* Teks putih */
            border-color: white;
            /* Border putih */
            transform: scale(1.02);
            /* Sedikit membesar */
        }

        input[type="radio"] {
            display: none;
        }

        /* Status Pilihan Aktif */
        input[type="radio"]:checked+.kehadiran-box {
            background-color: var(--active-bg);
            /* Warna latar sesuai status */
            color: white;
            /* Teks putih */
            border-color: white;
            /* Border putih */
            transform: scale(1.02);
            /* Sedikit membesar */
        }

        /* Warna Latar Aktif Berdasarkan Status */
        input[type="radio"]:checked+.kehadiran-box.hadir {
            background-color: #28a745;
            /* Hijau */
        }

        input[type="radio"]:checked+.kehadiran-box.izin {
            background-color: #007bff;
            /* Biru */
        }

        input[type="radio"]:checked+.kehadiran-box.sakit {
            background-color: #ffc107;
            /* Kuning */
        }

        input[type="radio"]:checked+.kehadiran-box.tanpa-keterangan {
            background-color: #dc3545;
            /* Merah */
        }

        /* CSS untuk menata Jam Masuk dan Jam Pulang agar bersampingan */
        .jam-container {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .jam-item {
            flex: 1;
        }

        .jam-item label {
            display: block;
            margin-bottom: 5px;
            /* Memberikan jarak antara label dan input */
        }

        .jam-item input {
            color: #ffffff !important;
            background-color: transparent !important;
            border: 2px solid #ffffff;
            width: 100%;
            /* Membuat input mengisi lebar kontainer */
        }

        /* Ubah warna border saat input dalam keadaan fokus */
        .jam-item input:focus {
            border-color: #9013fe;
            /* Ganti dengan warna yang Anda inginkan */
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
            /* Efek bayangan sekitar input */
        }

        /* Merubah warna ikon untuk input type="time" */
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            /* Membalikkan warna menjadi putih */
        }

        /* Mengatur tampilan textarea */
        textarea.form-control {
            background-color: transparent !important;
            height: 100px;
            /* Menentukan tinggi tetap */

            color: #ffffff !important;
            border: 2px solid #ffffff;
            /* Warna border awal */
            border-radius: 5px;
            /* Sudut border yang lebih melengkung */
            padding: 10px;
            /* Memberikan jarak antara teks dan tepi */
            font-size: 14px;
            /* Ukuran font di dalam textarea */
            transition: border-color 0.3s, box-shadow 0.3s;
            /* Efek transisi halus */
        }

        /* Mengatur border dan efek saat textarea dalam keadaan fokus */
        textarea.form-control:focus {
            border-color: #9013fe;
            /* Ganti dengan warna yang diinginkan saat fokus */
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
            /* Efek bayangan saat fokus */
            outline: none;
            /* Menghilangkan outline default */
        }

        /* Mengatur tampilan placeholder */
        textarea.form-control::placeholder {
            color: #fff;
            /* Warna placeholder ketika tidak fokus */
            font-style: normal;
            /* Menambahkan gaya miring pada placeholder */
        }

        textarea.form-control::-webkit-scrollbar {
            display: none;
            /* Sembunyikan scrollbar pada Webkit (Chrome, Safari) */
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

        /* Untuk label "Belum Tersedia" */
        .label-belum-tersedia {
            background-color: #686D76 !important;
            /* Warna abu-abu */
            color: #fff !important;
            /* Warna teks abu-abu */
            pointer-events: none !important;
            /* Menonaktifkan interaksi dengan elemen */
        }

        /* Untuk tombol Edit yang dinonaktifkan */
        .btn-edit-disabled {
            background-color: #686D76 !important;
            /* Warna abu-abu untuk tombol */
            border-color: #d3d3d3 !important;
            cursor: not-allowed !important;
            /* Menampilkan kursor tidak aktif */
            pointer-events: none !important;
        }

        /* Matikan efek hover pada label dan tombol yang dinonaktifkan */
        .label-belum-tersedia:hover {
            background-color: #686D76 !important;
            /* Matikan efek hover pada label */
        }

        .btn-edit-disabled:hover {
            background-color: #686D76 !important;
            /* Matikan efek hover pada tombol */
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
                <a class="nav-link active" href="<?= base_url('absensi_siswa') ?>"><i class="fas fa-user-check"></i> Absensi Siswa</a>
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


    <!-- Content -->
    <div class="content">
        <h1>Absensi Siswa</h1>
        <!-- Card Daftar Kelas -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Kelas</h4>
                </div>
                <p class="card-text">Silakan pilih kelas:</p>
                <div class="kelas-grid">
                    <?php foreach ($kelas_jurusan as $kelas): ?>
                        <button type="button" class="btn btn-kelas <?= isset($kelas_id) && $kelas_id == $kelas['id'] ? 'selected' : '' ?>"
                            data-kelas-id="<?= $kelas['id'] ?>"
                            data-jurusan="<?= $kelas['jurusan'] ?>"
                            onclick="loadAbsensi(<?= $kelas['id'] ?>, '<?= $kelas['jurusan'] ?>')">
                            <strong><?= $kelas['nama_kelas'] ?></strong> - <strong><?= $kelas['jurusan'] ?> </strong>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Absen Siswa</h4>
                    <div class="d-flex align-items-center">
                        <form action="<?= base_url('absensi_siswa') ?>" method="get" class="form-inline">
                            <!-- Input Tanggal -->
                            <input type="date" name="tanggal" id="tanggal" class="form-control custom-input mr-2"
                                value="<?= isset($tanggal) ? $tanggal : date('Y-m-d') ?>">
                            <!-- Input Keyword -->
                            <input type="text" name="keyword" class="form-control custom-input mr-2" placeholder="Nama/NIS"
                                value="<?= isset($keyword) ? $keyword : '' ?>">
                            <button type="submit" class="btn btn-primary mr-2">Cari</button>
                        </form>
                    </div>
                </div>
                <p class="card-text">Tahun Ajaran: <?= $tahun_ajaran ?></p>

                <!-- Tabel Data Absensi Siswa -->
                <table class="table table-striped" id="absensiTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kehadiran</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;  ?>
                        <?php
                        $today = date('Y-m-d');
                        ?>

                        <?php if (empty($siswa)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-custom">
                                    <?php if ($tanggal && $keyword): ?>
                                        Tidak ada data absensi siswa untuk pencarian ini.
                                    <?php elseif ($tanggal): ?>
                                        Tidak ada data absensi siswa ditemukan.
                                    <?php else: ?>
                                        Tidak ada data absensi siswa ditemukan.
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            // Gabungkan data absensi siswa yang ada dan siswa yang belum absen
                            $absensiSiswaIds = array_map(function ($as) {
                                return $as['siswa_id'];
                            }, $absensi_siswa);
                            $allSiswa = $siswa; // Ambil semua data siswa

                            // Tampilkan siswa yang belum absen dengan status 'Tanpa Keterangan' jika belum ada absensi
                            foreach ($allSiswa as $s):
                                // Cek apakah siswa ini sudah ada di absensi
                                $absenDitemukan = false;
                                foreach ($absensi_siswa as $as) {
                                    if ($as['siswa_id'] == $s['id']) {
                                        $absenDitemukan = true;
                                        break;
                                    }
                                }

                                // Tampilkan status sesuai apakah sudah absen atau belum
                                if ($absenDitemukan): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $s['nis'] ?></td>
                                        <td><?= $s['nama_siswa'] ?></td>
                                        <td>
                                            <?php
                                            // Menampilkan status kehadiran dari absensi
                                            $statusKehadiran = null;
                                            foreach ($kehadiran as $k) {
                                                if ($k['id'] == $as['kehadiran_id']) {
                                                    $statusKehadiran = $k['status'];
                                                    break;
                                                }
                                            }

                                            // Tentukan kelas berdasarkan status
                                            $labelClass = '';
                                            switch ($statusKehadiran) {
                                                case 'Hadir':
                                                    $labelClass = 'label-hadir';
                                                    break;
                                                case 'Sakit':
                                                    $labelClass = 'label-sakit';
                                                    break;
                                                case 'Izin':
                                                    $labelClass = 'label-izin';
                                                    break;
                                                case 'Tanpa Keterangan':
                                                    $labelClass = 'label-tanpa-keterangan';
                                                    break;
                                                default:
                                                    $statusKehadiran = 'Tidak Diketahui';
                                                    break;
                                            }
                                            ?>
                                            <span class="label <?= $labelClass ?>">
                                                <?= $statusKehadiran ?? 'Tidak Diketahui' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= !empty($as['jam_masuk']) ? date('H:i', strtotime($as['jam_masuk'])) : '-- : --' ?>
                                        </td>

                                        <td><?= !empty($as['jam_pulang']) ? date('H:i', strtotime($as['jam_pulang'])) : '-- : --' ?></td>
                                        <td><?= $as['keterangan'] ?></td>
                                        <td>
                                            <a href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $as['id'] ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $s['nis'] ?></td>
                                        <td><?= $s['nama_siswa'] ?></td>
                                        <td>
                                            <?php
                                            // Jika siswa belum absen atau tanggal lebih besar dari hari ini
                                            if ($tanggal > $today): ?>
                                                <span class="label label-belum-tersedia">Belum Tersedia</span>
                                            <?php else:
                                                // Mencari status "Tanpa Keterangan" berdasarkan kehadiran_id
                                                $statusKehadiran = 'Tanpa Keterangan'; // Default jika tidak ada
                                                foreach ($kehadiran as $k) {
                                                    if ($k['status'] == 'Tanpa Keterangan') {
                                                        // Menemukan status "Tanpa Keterangan"
                                                        $statusKehadiran = $k['status'];
                                                        break;
                                                    }
                                                }
                                            ?>
                                                <span class="label label-tanpa-keterangan"><?= $statusKehadiran ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>-- : --</td>
                                        <td>-- : --</td>
                                        <td>-</td>
                                        <td>
                                            <!-- Tombol Tambah -->
                                            <a href="" class="btn btn-warning btn-sm <?= $tanggal > $today ? 'btn-edit-disabled' : '' ?>"
                                                data-toggle="modal" data-target="#tambahModal<?= $s['id'] ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>


                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <?php foreach ($siswa as $s): ?>
        <!-- Modal Tambah Absensi -->
        <div class="modal fade" id="tambahModal<?= $s['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel<?= $s['id'] ?>" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="<?= base_url('absensi_siswa/tambah') ?>" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title" id="tambahModalLabel<?= $s['id'] ?>">Edit Absensi Siswa</h4>
                            <?php if (session()->getFlashdata('error') && session()->getFlashdata('modalError') === 'tambahModal' . $s['id']): ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="modal-body">
                            <!-- Hidden Input untuk Tanggal -->
                            <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
                            <input type="hidden" name="kelas_id" value="<?= $kelas_id ?>">
                            <input type="hidden" name="jurusan" value="<?= $jurusan ?>">
                            <input type="hidden" name="siswa_id" value="<?= $s['id'] ?>">

                            <!-- Input Kehadiran -->
                            <div class="form-group">
                                <label for="kehadiran<?= $s['id'] ?>">Kehadiran</label>
                                <div class="kehadiran-grid">
                                    <?php foreach ($kehadiran as $k): ?>
                                        <input type="radio" id="kehadiran<?= $s['id'] ?>_<?= $k['id'] ?>" name="kehadiran" value="<?= $k['id'] ?>"
                                            <?php if ($k['status'] == "Tanpa Keterangan"): ?> checked <?php endif; ?>>
                                        <label class="kehadiran-box <?= strtolower(str_replace(' ', '-', $k['status'])) ?>" for="kehadiran<?= $s['id'] ?>_<?= $k['id'] ?>">
                                            <?= $k['status'] ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Input Jam Masuk -->
                            <div class="form-group jam-container">
                                <div class="jam-item">
                                    <label for="jamMasuk<?= $s['id'] ?>">Jam Masuk</label>
                                    <input type="time" class="form-control" id="jamMasuk<?= $s['id'] ?>" name="jam_masuk">
                                </div>
                                <div class="jam-item">
                                    <label for="jamPulang<?= $s['id'] ?>">Jam Pulang</label>
                                    <input type="time" class="form-control" id="jamPulang<?= $s['id'] ?>" name="jam_pulang">
                                </div>
                            </div>

                            <!-- Input Keterangan -->
                            <div class="form-group">
                                <label for="keterangan<?= $s['id'] ?>">Keterangan</label>
                                <textarea class="form-control" id="keterangan<?= $s['id'] ?>" placeholder="Tulis keterangan di sini..." name="keterangan"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="submit" class="btn btn-secondary">Simpan</button>
                            <button type="button" class="btn btn-custom" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>



    <?php foreach ($absensi_siswa as $as): ?>
        <!-- Modal Tambah/Edit Absensi -->
        <div class="modal fade" id="editModal<?= $as['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $as['id'] ?>" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="<?= base_url('absensi_siswa/edit/' . $as['id']) ?>" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title" id="editModalLabel<?= $as['id'] ?>">Edit Absensi Siswa</h4>
                            <?php if (session()->getFlashdata('error') && session()->getFlashdata('modalError') === 'editModal' . $as['id']): ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="modal-body">
                            <!-- Hidden Input untuk Tanggal -->
                            <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
                            <input type="hidden" name="kelas_id" id="kelas_id" value="<?= $kelas_id ?? '' ?>">
                            <input type="hidden" name="jurusan" id="jurusan" value="<?= $jurusan ?? '' ?>">

                            <!-- Input Kehadiran -->
                            <div class="form-group">
                                <label for="kehadiran<?= $as['id'] ?>" style="margin-top: 8px;">Kehadiran</label>
                                <div class="kehadiran-grid">
                                    <?php foreach ($kehadiran as $k): ?>
                                        <input type="radio" id="kehadiran<?= $as['id'] ?>_<?= $k['id'] ?>" name="kehadiran" value="<?= $k['id'] ?>" <?= $as['kehadiran_id'] == $k['id'] ? 'checked' : '' ?>>
                                        <label class="kehadiran-box <?= strtolower(str_replace(' ', '-', $k['status'])) ?>" for="kehadiran<?= $as['id'] ?>_<?= $k['id'] ?>">
                                            <?= $k['status'] ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Input Jam Masuk -->
                            <div class="form-group jam-container">
                                <div class="jam-item">
                                    <label for="jamMasuk<?= $as['id'] ?>">Jam Masuk</label>
                                    <input type="time" class="form-control" id="jamMasuk<?= $as['id'] ?>" name="jam_masuk" value="<?= $as['jam_masuk'] ?>">
                                </div>
                                <div class="jam-item">
                                    <label for="jamPulang<?= $as['id'] ?>">Jam Pulang</label>
                                    <input type="time" class="form-control" id="jamPulang<?= $as['id'] ?>" name="jam_pulang" value="<?= $as['jam_pulang'] ?>">
                                </div>
                            </div>

                            <!-- Input Keterangan -->
                            <div class="form-group">
                                <label for="keterangan<?= $as['id'] ?>">Keterangan</label>
                                <textarea class="form-control" id="keterangan<?= $as['id'] ?>" placeholder="Tulis keterangan di sini..." name="keterangan"><?= $as['keterangan'] ?></textarea>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="submit" class="btn btn-secondary">Simpan</button>
                            <button type="button" class="btn btn-custom" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

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
        document.getElementById('tanggal').addEventListener('change', function() {
            document.getElementById('formTanggal').submit();
        });
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('.kehadiran-box').forEach(box => {
                    box.classList.remove('active');
                });
                radio.nextElementSibling.classList.add('active');
            });
        });

        $(document).ready(function() {
            $('#editModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        function loadAbsensi(kelas_id, jurusan) {
            // Ambil tanggal dan keyword jika ada
            let tanggal = $('#tanggal').val();
            let keyword = $('input[name="keyword"]').val();

            // Cek apakah tombol yang ditekan sudah memiliki kelas 'selected'
            let isSelected = $(`button[data-kelas-id="${kelas_id}"][data-jurusan="${jurusan}"]`).hasClass('selected');

            if (isSelected) {
                // Jika sudah 'selected', hapus seleksi dan kosongkan kelas
                $('.btn-kelas').removeClass('selected');
                $('#kelas_id').val(''); // Hapus nilai kelas_id
                $('#jurusan').val(''); // Hapus nilai jurusan
                kelas_id = ''; // Pastikan kelas_id dikosongkan
                jurusan = ''; // Pastikan jurusan dikosongkan
            } else {
                // Jika belum 'selected', set tombol ini menjadi 'selected'
                $('.btn-kelas').removeClass('selected');
                $(`button[data-kelas-id="${kelas_id}"][data-jurusan="${jurusan}"]`).addClass('selected');

                // Simpan kelas_id dan jurusan yang dipilih
                $('#kelas_id').val(kelas_id);
                $('#jurusan').val(jurusan);
            }

            // Redirect ke URL baru dengan kelas_id dan jurusan yang dipilih
            window.location.href = `<?= site_url('absensi_siswa') ?>?kelas_id=${kelas_id}&jurusan=${jurusan}&tanggal=${tanggal}&keyword=${keyword}`;

        }
        $(document).ready(function() {
            let kelas_id = $('#kelas_id').val();
            let jurusan = $('#jurusan').val();

            // Tambahkan class 'selected' pada tombol yang sesuai berdasarkan kelas_id dan jurusan
            if (kelas_id && jurusan) {
                $(`button[data-kelas-id="${kelas_id}"][data-jurusan="${jurusan}"]`).addClass('selected');
            }
        });


        $(document).ready(function() {
            // Cek apakah ada modalError
            const modalError = "<?= session()->getFlashdata('modalError') ?>";
            if (modalError) {
                $('#' + modalError).modal('show'); // Buka modal dengan ID yang sesuai
            }
        });
    </script>
</body>

</html>