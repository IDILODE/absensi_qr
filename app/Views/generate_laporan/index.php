<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Laporan</title>
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

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Background semi-transparan */
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 9999;
            /* Pastikan berada di atas konten lainnya */
            backdrop-filter: blur(5px);
            /* Efek blur pada background */
        }

        .loading-overlay .spinner-border {
            width: 6rem;
            height: 6rem;
            border-width: 0.6rem;
            border-top-color: #4e9fd1;
            /* Warna biru terang */
            border-left-color: #ff64b5;
            /* Warna pink terang */
            border-bottom-color: #ff9e00;
            /* Warna oranye terang */
            border-right-color: transparent;
            /* Transparan pada sisi kanan */
            animation: spin 1.5s linear infinite;
            /* Animasi rotasi */
        }

        .loading-overlay p {
            color: white;
            margin-top: 1rem;
            font-size: 1.2rem;
        }

        .loading-overlay.fade-out {
            opacity: 0;
            transition: opacity 0.3s ease-out;
        }

        .btn {
            color: white !important;
            border-radius: 5px !important;
            transition: background-color 0.3s ease !important;
            border: none !important;
            width: 100% !important;

        }

        .btn:focus,
        .btn:active {
            outline: none !important;
            border: none !important;
            box-shadow: none !important;
        }

        .btn-success {
            background-color: #A02334 !important;
        }

        .btn-primary {
            background-color: #1E2A5E !important;
        }

        .siswa-title {
            font-size: 20px;
            color: rgb(0, 200, 0);
            /* Warna hijau untuk Siswa dan Guru */
            font-weight: bold;
            margin-bottom: 0px;
            /* Jarak bawah agar tidak terlalu rapat */
        }

        .guru-title {
            font-size: 20px;
            color: rgb(0, 200, 255);
            /* Warna hijau untuk Siswa dan Guru */
            font-weight: bold;
            margin-bottom: 0px;
            /* Jarak bawah agar tidak terlalu rapat */
        }

        /* Menambahkan Flex untuk menyusun Siswa dan Guru di baris yang sama */
        .row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .col-md-6 {
            flex: 1;
            /* Membuat elemen Siswa dan Guru memiliki ukuran yang sama */
        }

        .siswa-section {
            margin-bottom: 20px;
            /* Jarak bawah khusus untuk elemen siswa */
        }

        .d-flex-between button,
        .d-flex-between a {
            margin-bottom: 10px;
            /* Atur jarak bawah antar tombol */
        }



        input,
        .dropdownn {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid #dde2e7;
            border-radius: 8px;
            font-size: 1rem;
            color: #fff;
            transition: all 0.3s ease;
        }

        input:focus,
        .dropdownn:hover {
            outline: none;
            border-color: #9013fe;
            box-shadow: 0 0 8px rgba(144, 19, 254, 0.6);
        }

        /* Pastikan dropdown induk memiliki posisi relatif */
        .dropdownn {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: border-color 0.3s ease;
            position: relative;
            /* Tambahkan posisi relatif untuk menu absolute */
        }

        .dropdownn-menu {
            position: absolute;
            top: 109%;
            /* Posisikan menu langsung di bawah dropdownn */
            left: 0;
            right: 0;
            padding: 0px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            max-height: 200px;
            /* Batas maksimal tinggi dropdownn */
            overflow-y: scroll;
            /* Enable scroll tanpa scrollbar */
            width: 100%;
            z-index: 1000;
            /* Agar dropdownn berada di atas elemen lainnya */
        }

        .dropdownn-menu::-webkit-scrollbar {
            display: none;
        }

        .dropdownn-item {
            padding: 10px 15px;
            background-color: #2d2d2d;
            color: white;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            text-align: left;
        }

        .dropdownn-item:hover {
            background-color: #9013fe;
            color: white;
        }

        .dropdownn-icon {
            font-size: 1.5rem;
            transition: transform 0.3s;
            color: white;
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

        .custom-month-input {
            width: 80%;
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
                <a class="nav-link" href="<?= base_url('data_guru') ?>"><i class="fas fa-chalkboard-teacher"></i> Data Guru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('data_kelas') ?>"><i class="fas fa-school"></i> Data Kelas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('generate_qr') ?>"><i class="fas fa-qrcode"></i> Generate QR</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?= base_url('generate_laporan') ?>"><i class="fas fa-file-alt"></i> Generate Laporan</a>
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
        <h1>Generate Laporan</h1>
        <div class="card mb-4">
            <div class="card-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-between align-items-center">


                    <h4 class="card-title">Generate Laporan Absen</h4>
                </div>

                <div class="row">
                    <!-- Siswa -->
                    <div class="col-md-6 siswa-section">
                        <p class="card-text siswa-title">Laporan Absen Siswa</p>
                        <p>Jumlah Siswa: <?= $jumlah_siswa; ?></p>
                        <div class="form-group d-flex align-items-center">
                            <label for="bulan_tahun_siswa" class="mr-2">Bulan:</label>
                            <input type="month" name="bulan_tahun_siswa" id="bulan_tahun_siswa" class="form-control custom-input custom-month-input"
                                value="<?= isset($bulan_tahun_siswa) ? $bulan_tahun_siswa : date('Y-m'); ?>"
                                onchange="updateSiswaUrl(this)">
                        </div>
                        <div class="mt-4">
                            <form id="generatePerKelasForm" action="<?= base_url('generate_laporan/generate_siswa_pdf?bulan_tahun_siswa=' . $bulan_tahun_siswa); ?>" method="GET" onsubmit="return validateForm();">
                                <div class="form-group">
                                    <label for="kelas_id">Pilih Kelas:</label>
                                    <div class="dropdownn" id="dropdownn-kelas">
                                        <span id="selected-kelas">--Pilih Kelas--</span>
                                        <i class="fas fa-chevron-down dropdownn-icon"></i>
                                        <div class="dropdownn-menu" id="dropdownn-menu-kelas">
                                            <?php foreach ($kelas_list as $kelas): ?>
                                                <div class="dropdownn-item"
                                                    onclick="selectKelas('<?= $kelas['id']; ?>', '<?= $kelas['nama_kelas']; ?>', '<?= $kelas['jurusan']; ?>', '<?= $kelas['jumlah_siswa']; ?>')">
                                                    <?= $kelas['nama_kelas']; ?> <?= $kelas['jurusan']; ?> - <?= $kelas['jumlah_siswa']; ?> Siswa
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <input type="hidden" id="kelas_id" name="kelas_id" value="">
                                    <input type="hidden" id="bulan_tahun_siswa_hidden" name="bulan_tahun_siswa" value="<?= isset($bulan_tahun_siswa) ? $bulan_tahun_siswa : date('Y-m'); ?>">
                                </div>
                                <div class="d-flex-between">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-file-pdf"></i> Generate PDF
                                    </button>
                                    <button type="submit" class="btn btn-primary" formaction="<?= base_url('generate_laporan/generate_siswa_doc'); ?>">
                                        <i class="fas fa-file-word"></i> Generate DOC
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- Guru -->
                    <div class="col-md-6 guru-section">
                        <p class="card-text guru-title">Laporan Absen Guru</p>
                        <p>Jumlah Guru: <?= $jumlah_guru; ?></p>
                        <div class="form-group d-flex align-items-center">
                            <label for="bulan_tahun_guru" class="mr-2">Bulan:</label>
                            <input type="month" id="bulan_tahun_guru" class="form-control custom-input custom-month-input"
                                value="<?= isset($bulan_tahun_guru) ? $bulan_tahun_guru : date('Y-m'); ?>" onchange="updateGuruUrl(this.value)">
                        </div>
                        <div class="d-flex-between">
                            <!-- Tombol Generate PDF -->
                            <a id="generatePdfLink" href="<?= base_url('generate_laporan/generate_guru_pdf?bulan_tahun_guru=' . $bulan_tahun_guru); ?>" class="btn btn-success">
                                <i class="fas fa-file-pdf"></i> Generate PDF
                            </a>
                            <!-- Tombol Generate DOC -->
                            <a id="generateDocLink" href="<?= base_url('generate_laporan/generate_guru_doc?bulan_tahun_guru=' . $bulan_tahun_guru); ?>" class="btn btn-primary">
                                <i class="fas fa-file-word"></i> Generate DOC
                            </a>
                        </div>

                        <!-- Teks pemberitahuan setelah tombol -->
                        <p class="mt-3" style="color: white; padding: 5px;">
                            <i class="fas fa-exclamation-triangle" style="color: white;"></i> Gunakan PDF to Word Converter untuk hasil format Word yang lebih baik.
                        </p>
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


                    // dropdownn Kelas untuk Siswa
                    const dropdownnKelas = document.getElementById('dropdownn-kelas');
                    const dropdownnMenuKelas = document.getElementById('dropdownn-menu-kelas');
                    const dropdownnIconKelas = document.querySelector('#dropdownn-kelas .dropdownn-icon');

                    dropdownnKelas.addEventListener('click', function() {
                        dropdownnMenuKelas.style.display = dropdownnMenuKelas.style.display === 'block' ? 'none' : 'block';
                        dropdownnIconKelas.style.transform = dropdownnMenuKelas.style.display === 'block' ? 'rotate(180deg)' : 'rotate(0deg)';
                    });

                    window.addEventListener('click', function(event) {
                        if (!dropdownnKelas.contains(event.target)) {
                            dropdownnMenuKelas.style.display = 'none';
                            dropdownnIconKelas.style.transform = 'rotate(0deg)';
                        }
                    });

                    // Fungsi untuk memilih kelas
                    function selectKelas(id, namaKelas, jurusan, jumlahSiswa) {
                        // Menampilkan kelas dan jurusan yang dipilih di dropdown
                        document.getElementById('selected-kelas').innerText = `${namaKelas} ${jurusan} - ${jumlahSiswa} Siswa`;

                        // Menyimpan ID kelas yang dipilih pada input tersembunyi
                        document.getElementById('kelas_id').value = id;
                        document.getElementById('kelasError').style.display = 'none';

                        // Menutup dropdown setelah memilih kelas
                        dropdownnMenuKelas.style.display = 'none';
                        dropdownnIconKelas.style.transform = 'rotate(0deg)';
                    }

                    // Validasi Form
                    function validateForm() {
                        var kelasId = document.getElementById('kelas_id').value;

                        // Check if Kelas is selected
                        if (!kelasId) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Silahkan pilih kelas terlebih dahulu.',
                                icon: 'error',
                                showConfirmButton: true,
                                allowOutsideClick: false,
                            });
                            return false; // Prevent form submission
                        }

                        return true; // Allow form submission
                    }
                    // Fungsi untuk memperbarui URL ketika bulan dipilih (Siswa)
                    function updateSiswaUrl(inputElement) {
                        const form = document.getElementById('generatePerKelasForm');

                        // Ambil nilai bulan yang dipilih
                        const bulanTahun = inputElement.value;

                        // Perbarui nilai bulan di hidden input
                        document.getElementById('bulan_tahun_siswa_hidden').value = bulanTahun;

                        // Update action URL form
                        const newActionUrl = form.action.split('?')[0] + '?bulan_tahun_siswa=' + bulanTahun;
                        form.action = newActionUrl;
                    }


                    // Fungsi untuk memperbarui URL ketika bulan dipilih (Guru)
                    function updateGuruUrl(value) {
                        const generatePdfLink = document.getElementById('generatePdfLink');
                        const generateDocLink = document.getElementById('generateDocLink');

                        // Update URL pada link generate PDF
                        generatePdfLink.href = '<?= base_url('generate_laporan/generate_guru_pdf?bulan_tahun_guru='); ?>' + value;

                        // Update URL pada link generate DOC
                        generateDocLink.href = '<?= base_url('generate_laporan/generate_guru_doc?bulan_tahun_guru='); ?>' + value;
                    }
                </script>
</body>

</html>