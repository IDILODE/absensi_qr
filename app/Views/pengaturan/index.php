<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan</title>
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

        /* Menghilangkan border dan outline pada semua state tombol */
        button:focus,
        button:active {
            outline: none !important;
            /* Menghapus outline dengan prioritas tinggi */
            border: none !important;
            /* Menghapus border dengan prioritas tinggi */
            box-shadow: none !important;
            /* Menghapus efek bayangan dengan prioritas tinggi */
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

        /* Styling Form Input */
        .form-group {
            position: relative;
            margin-bottom: 30px;
        }

        .form-control {
            background-color: transparent;
            border: none;
            border-bottom: 2px solid #fff;
            /* Menyimpan border bawah putih */
            color: #000000B3;
            font-size: 1rem;
            padding: 10px 0;
            padding-left: 10px;
            width: 100%;
            transition: all 0.3s ease;
            border-radius: 0;

        }


        .form-control:focus {
            outline: none;
            border-bottom-color: #000000B3;
            box-shadow: none;
            color: white;
        }

        .form-control:hover {
            border-bottom-color: #000000B3;
            /* Border bawah berwarna biru saat hover */
            color: white;
        }

        /* Styling Label */
        label {
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s ease;

        }

        .form-control:focus~label,
        .form-control:not(:focus):valid~label {
            top: -30px;
            left: 0;
            font-size: 0.9rem;
            color: #000000B3
                /* Warna label berubah saat fokus */
        }

        .form-group::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0%;
            height: 2px;
            background-color: #000000B3;
            transition: width 0.3s ease, left 0.3s ease;
        }

        .form-control:focus~.form-group::before,
        .form-control:hover~.form-group::before {
            width: 100%;
            left: 0;
        }

        /* Menghilangkan efek kotak putih pada saat fokus */
        .form-control:focus {
            background-color: transparent;
            border-color: #000000B3;
        }


        /* Mengubah label tombol Choose File */
        input[type="file"] {
            display: none;
        }

        input[type="file"]+label,
        .t {
            display: inline-block;
            background-color: #9013fe;
            color: white;
            padding: 5px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 0px !important;
        }

        input[type="file"]:hover+label {
            background-color: #000000B3;
        }

        /* Transisi Efek Hover pada Gambar */
        img {
            transition: all 0.3s ease;
            max-width: 100%;
            max-height: 300px;
            height: auto;
            border-radius: 10px;
        }

        img:hover {
            transform: scale(1.05);
        }

        .form-row {
            display: flex;
            align-items: stretch;
        }

        .col-md-4,
        .col-md-8 {
            display: flex;
            flex-direction: column;
        }

        .card {
            min-height: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* Menjaga konten dalam card tetap proporsional */
            flex: 1;
            /* Membuat semua card memiliki tinggi yang sama */
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .col-md-4 .card {
            padding: 0px !important;
            /* Atur padding yang lebih kecil */
            margin-bottom: 0;
            /* Menghapus margin bawah */
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }


        .btn {
            background-color: #9013fe !important;
            color: white !important;
            border-radius: 5px !important;
            transition: background-color 0.3s ease !important;
            border: none !important;
            /* Menghilangkan border */
        }

        .btn-container {
            display: flex;
            justify-content: flex-start;
        }

        .btn:hover {
            background-color: #0072ff !important;
        }

        .change-logo {
            font-weight: normal;
            /* Hanya "Ganti Logo" yang tidak bold */
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

        /* Mengubah warna tombol saat hover dan fokus */
        .btn-secondary:hover,
        .btn-secondary:active {
            background-color: #000000B3 !important;
            /* Warna saat hover dan fokus */
            color: white;
            /* Ubah warna teks jika diperlukan */
        }

        .btn-secondary:focus {
            outline: none;
            box-shadow: 0 0 8px rgba(255, 87, 51, 0.5);
            /* Efek fokus */
        }

        .btn-secondary {
            width: 100%;
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

            .sidebar.active {
                left: 0;
                /* Menggeser sidebar ke kiri ketika aktif */
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
                <a class="nav-link" href="<?= base_url('generate_laporan') ?>"><i class="fas fa-file-alt"></i> Generate Laporan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('data_petugas') ?>"><i class="fas fa-users-cog"></i> Data Petugas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?= base_url('pengaturan') ?>"><i class="fas fa-cogs"></i> Pengaturan</a>
            </li>

        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Pengaturan</h1>
        <form action="<?= base_url('pengaturan/update') ?>" method="post" enctype="multipart/form-data">
            <!-- Bagian Kiri: Nama Sekolah, Tahun Ajaran, Copyright -->
            <div class="form-row">
                <!-- Bagian Kiri -->
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- Konten form -->
                            <div class="form-group">
                                <label for="nama_sekolah">Nama Sekolah:</label>
                                <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" value="<?= isset($pengaturan['nama_sekolah']) ? esc($pengaturan['nama_sekolah']) : '' ?>" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="tahun_ajaran">Tahun Ajaran:</label>
                                <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" value="<?= isset($pengaturan['tahun_ajaran']) ? esc($pengaturan['tahun_ajaran']) : '' ?>" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="copyright">Copyright:</label>
                                <input type="text" name="copyright" id="copyright" class="form-control" value="<?= isset($pengaturan['copyright']) ? esc($pengaturan['copyright']) : '' ?>">
                            </div>
                        </div>
                        <div class="btn-container">
                            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                        </div>
                    </div>
                </div>
                <!-- Bagian Kanan -->
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <?php if (!empty($pengaturan['logo'])): ?>
                                <div class="form-group">
                                    <img src="<?= base_url('uploads/' . $pengaturan['logo']) ?>" alt="Logo Sekolah">
                                </div>
                            <?php endif; ?>
                            <!-- Input untuk mengganti logo -->
                            <div class="form-group">
                                <input type="file" name="logo" id="logo" class="form-control-file" accept=".png, .jpg, .jpeg, .gif, .svg">
                                <label for="logo" class="change-logo">Ganti Logo</label> <span class="file-types">&nbsp;*(.png, .jpg, .jpeg, .gif, .svg)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Pop-up -->
    <div class="modal fade" id="invalidFileModal" tabindex="-1" role="dialog" aria-labelledby="invalidFileModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invalidFileModalLabel">Format File Tidak Valid</h5>
                </div>
                <div class="modal-body">
                    Hanya file dengan format .png, .jpg, .jpeg, .gif, .svg yang diperbolehkan. Silakan pilih file dengan format yang sesuai.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        $(document).ready(function() {
            document.getElementById('logo').addEventListener('change', function() {
                const allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'svg'];
                const filePath = this.value;
                const fileExtension = filePath.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(fileExtension)) {
                    // Tampilkan modal pop-up jika format file tidak valid
                    $('#invalidFileModal').modal('show');
                    this.value = ''; // Reset input file
                }
            });
        });
    </script>
</body>

</html>