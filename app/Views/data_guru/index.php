<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
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
            max-width: 125px;
            white-space: nowrap;
        }

        .table th:nth-child(5),
        .table td:nth-child(5) {
            max-width: 175px;
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
            max-width: 145px;
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

        .text-custom {
            color: #ffffff;
            /* Ganti dengan warna yang diinginkan */
            font-style: italic;
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

        .btn-custom {
            background-color: #9013fe;
            color: white;
            width: 36%;
            /* Menyesuaikan ukuran tombol agar seimbang */
        }

        .btn-custom:hover {
            background-color: #000000B3 !important;
        }

        .btn-secondary:focus,
        .btn-custom:focus {
            outline: none;
            box-shadow: 0 0 8px rgba(255, 87, 51, 0.5);
        }

        .btn-rec:hover {
            background-color: green !important;
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
                <a class="nav-link" href="<?= base_url('data_siswa') ?>"><i class="fas fa-users"></i> Data Siswa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?= base_url('data_guru') ?>"><i class="fas fa-chalkboard-teacher"></i> Data Guru</a>
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
        <h1>Data Guru</h1>
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Guru</h4>
                    <div class="d-flex align-items-center">
                        <form action="<?= base_url('data_guru') ?>" method="get" class="form-inline">
                            <!-- Isi nilai input dengan PHP jika ada parameter 'keyword' di URL -->
                            <input type="text" name="keyword" class="form-control custom-input mr-2" placeholder="Nama/NUPTK" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                            <button type="submit" class="btn btn-primary mr-2">Cari</button>
                        </form>
                        <a href="<?= base_url('data_guru/tambah') ?>" class="btn btn-success">Tambah Guru</a>
                    </div>
                </div>


                <p class="card-text">Tahun Ajaran: <?= $tahun_ajaran ?></p>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- Tabel Data Guru -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NUPTK</th>
                            <th>Nama Guru</th>
                            <th>Jenis Kelamin</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($guru)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-custom">Tidak ada data guru ditemukan.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($guru as $g): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $g['nuptk'] ?></td>
                                    <td><?= $g['nama_guru'] ?></td>
                                    <td><?= $g['jenis_kelamin'] ?></td>
                                    <td><?= $g['no_hp'] ?></td>
                                    <td><?= $g['alamat'] ?></td>
                                    <td>
                                        <a href="<?= base_url('data_guru/edit/' . $g['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('data_guru/delete/' . $g['id']) ?>" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        <a href="<?= base_url('data_guru/generate_qr/' . $g['id']) ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-qrcode"></i>
                                        </a>
                                        <a href="#" class="btn btn-rec btn-sm recordButton" data-id="<?= $g['id'] ?>">
                                            <i class="fas fa-microphone"></i>
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal untuk Rekaman Suara -->
        <div class="modal fade" id="recordModal" tabindex="-1" aria-labelledby="recordModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="recordModalLabel">Rekam Suara</h5>
                        <!-- Alert untuk status -->
                        <div id="alertMessage" class="alert" style="display: none;"></div>
                    </div>
                    <div class="modal-body">
                        <div>
                            <button id="startRecord" class="btn btn-rec">Rekam Suara</button>
                            <button id="stopRecord" class="btn btn-danger" disabled>Stop Rekaman</button>
                        </div>
                        <!-- Tampilkan elemen audio jika suara ada -->
                        <audio id="audioPreview" controls style="width:100%; margin-top: 10px;">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="saveAudio" disabled>Simpan</button>
                        <button type="button" class="btn btn-custom" data-dismiss="modal">Tutup</button>
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



            let mediaRecorder;
            let audioChunks = [];
            let audioBlob = null;
            let audioUrl = null;
            let audio = new Audio();
            let isRecording = false; // Flag untuk mencatat status rekaman

            $(document).ready(function() {
                let guruData = <?= json_encode($guru); ?>; // Data guru dari PHP
                let currentGuruId = null; // Variabel untuk menyimpan ID guru yang sedang diproses

                // Inisialisasi Event Listener untuk tombol rekam
                $('.recordButton').click(function() {
                    currentGuruId = $(this).data('id'); // Simpan ID guru yang diklik
                    const guru = guruData.find(g => g.id == currentGuruId); // Cari data guru berdasarkan ID
                    const suaraPath = guru && guru.suara ? '<?= base_url('uploads/suara/') ?>' + guru.suara : null;

                    // Reset modal setiap kali dibuka
                    $('#alertMessage').hide().removeClass('alert-success alert-danger').text('');
                    $('#audioPreview').hide(); // Sembunyikan audio preview awal
                    $('#saveAudio').prop('disabled', true); // Nonaktifkan tombol simpan awal

                    if (suaraPath) {
                        // Jika ada suara, tampilkan preview dengan timestamp
                        const newAudioUrl = suaraPath + '?t=' + new Date().getTime(); // Menambahkan query parameter untuk cache busting
                        $('#audioPreview').show().attr('src', newAudioUrl);
                        $('#saveAudio').prop('disabled', false); // Aktifkan tombol simpan
                    }

                    // Tampilkan modal
                    $('#recordModal').modal('show');
                });

                // Inisialisasi Event Listener untuk tombol mulai rekam
                $('#startRecord').click(function() {
                    if (isRecording) {
                        mediaRecorder.stop();
                        $('#startRecord').prop('disabled', false);
                        $('#stopRecord').prop('disabled', true);
                        isRecording = false;
                    }

                    navigator.mediaDevices.getUserMedia({
                            audio: true
                        })
                        .then(stream => {
                            audioChunks = [];
                            audioBlob = null;
                            audioUrl = null;

                            mediaRecorder = new MediaRecorder(stream);
                            mediaRecorder.start();

                            mediaRecorder.ondataavailable = function(event) {
                                audioChunks.push(event.data);
                            };

                            mediaRecorder.onstop = function() {
                                audioBlob = new Blob(audioChunks, {
                                    type: 'audio/wav'
                                });
                                audioUrl = URL.createObjectURL(audioBlob);
                                audio.src = audioUrl;
                                $('#audioPreview').show().attr('src', audioUrl); // Tampilkan preview audio
                                $('#saveAudio').prop('disabled', false); // Aktifkan tombol simpan
                            };

                            $('#stopRecord').prop('disabled', false);
                            $('#startRecord').prop('disabled', true);
                            isRecording = true;
                        })
                        .catch(error => {
                            $('#alertMessage').show().addClass('alert-danger').text('Gagal mengakses mikrofon.');
                        });
                });

                // Inisialisasi Event Listener untuk tombol stop rekam
                $('#stopRecord').click(function() {
                    if (isRecording) {
                        mediaRecorder.stop();
                        $('#stopRecord').prop('disabled', true);
                        $('#startRecord').prop('disabled', false);
                    }
                });

                // Inisialisasi Event Listener untuk tombol simpan suara
                $('#saveAudio').click(function() {
                    if (!audioBlob) {
                        $('#alertMessage').show().addClass('alert-danger').text('Tidak ada rekaman untuk disimpan.');
                        return;
                    }

                    // Periksa ukuran file sebelum mengirim
                    const fileSize = audioBlob.size / 1024 / 1024; // Ukuran dalam MB
                    if (fileSize > 2) { // Jika ukuran file lebih dari 2MB
                        $('#alertMessage').show().addClass('alert-danger').text('Ukuran file terlalu besar. Maksimal 2MB.');
                        return;
                    }

                    if (currentGuruId === null) {
                        $('#alertMessage').show().addClass('alert-danger').text('ID guru tidak valid.');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('suara', audioBlob, 'suara_' + currentGuruId + '.wav'); // Gunakan ID guru yang benar

                    $.ajax({
                        url: '<?= base_url('data_guru/saveSuara') ?>/' + currentGuruId, // Kirim ID guru yang benar
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#alertMessage').show().addClass('alert-success').text('Suara berhasil disimpan!');

                            const suaraPath = response.suaraPath; // Path suara baru dari respons
                            if (suaraPath) {
                                // Update data lokal guruData
                                const guru = guruData.find(g => g.id == currentGuruId);
                                if (guru) {
                                    guru.suara = suaraPath.replace('uploads/suara/', ''); // Hanya simpan nama file
                                }

                                // Tambahkan timestamp ke URL untuk mencegah cache
                                const newAudioUrl = suaraPath + '?t=' + new Date().getTime();
                                $('#audioPreview').show().attr('src', newAudioUrl);
                                $('#audioPreview')[0].load(); // Memuat ulang audio
                                $('#saveAudio').prop('disabled', false);
                            }
                        },
                        error: function(error) {
                            $('#alertMessage').show().addClass('alert-danger').text('Gagal menyimpan suara');
                        }
                    });
                });

                // Reset modal saat ditutup
                $('#recordModal').on('hidden.bs.modal', function() {
                    const audioElement = $('#audioPreview');

                    // Ambil data guru terbaru dari guruData
                    const guru = guruData.find(g => g.id == currentGuruId);
                    const suaraPath = guru && guru.suara ? '<?= base_url('uploads/suara/') ?>' + guru.suara : null;

                    if (suaraPath) {
                        // Perbarui URL audio dengan timestamp
                        const newAudioUrl = suaraPath + '?t=' + new Date().getTime();
                        audioElement.show().attr('src', newAudioUrl);
                        audioElement[0].load(); // Muat ulang audio
                    } else {
                        audioElement.hide();
                        $('#saveAudio').prop('disabled', true);
                    }

                    // Jika rekaman sedang aktif dan modal ditutup, hentikan rekaman
                    if (isRecording) {
                        mediaRecorder.stop();
                        $('#stopRecord').prop('disabled', true);
                        $('#startRecord').prop('disabled', false);
                        isRecording = false; // Set flag rekaman selesai
                    }
                });
            });
        </script>


</body>

</html>