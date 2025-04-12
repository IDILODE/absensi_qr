<!DOCTYPE html>
<html>

<head>
    <style>
        /* @page {
    size: A4 landscape;
} */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        /* Header dengan Flexbox */
        .header {
            display: flex;
            align-items: center;
            /* Menjaga agar logo dan teks sejajar vertikal */
            justify-content: center;
            /* Menjaga judul dan subtitle di tengah */
            margin-bottom: 20px;
            text-align: center;
            width: 100%;
        }

        /* Logo di kiri */
        .logo {
            position: absolute;
            left: 20px;
            /* Menempatkan logo di kiri */
            top: 36px;
            transform: translateY(-50%);
            /* Agar logo sejajar vertikal */
        }

        .logo img {
            max-width: 80px;
        }

        .subtitle {
            font-size: 14px;
            margin-top: 10px;
            /* Menambahkan jarak antara title dan subtitle */
        }

        /* Judul dan Subtitle di tengah */
        .text {
            text-align: center;
            /* Agar teks di tengah */
            margin-left: 80px;
            /* Memberikan ruang untuk logo agar tidak tertutup */
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
        }

        .content {
            margin: 20px;
        }

        /* Styling untuk No kolom */
        th,
        td {
            text-align: left;
            padding: 5px;
            font-size: 10px;
            /* Menurunkan ukuran font untuk seluruh tabel */
        }

        th:nth-child(1),
        td:nth-child(1) {
            text-align: center;
            /* Menyenterkan No */
        }

        /* Styling tabel absensi */
        .attendance-table {
            padding: 0;
            border-collapse: collapse;
            /* Menghilangkan jarak antar border */
            table-layout: fixed;
            /* Membuat tabel lebih responsif */
            width: 100%;
        }

        .attendance-table th,
        .attendance-table td {
            border: 1px solid #000;
            text-align: center;
            padding: 3px 5px;
            /* Mengurangi padding agar lebih padat */
        }

        .attendance-table th {
            background-color: #f2f2f2;
        }

        .statistic-table {
            padding: 0;
            margin-top: 20px;
            border-collapse: collapse;
            /* Menghilangkan jarak antar border */
        }

        .statistic-table th,
        .statistic-table td {
            border: none;
            text-align: left;
            padding: 1px;
            /* Menghilangkan padding dalam sel tabel statistik */
        }

        .statistic-table th {
            width: 80px;
            /* Lebar tetap untuk label statistik */
        }

        .statistic-table td {
            width: 40px;
            /* Lebar tetap untuk nilai statistik */
        }

        .statistic-table th,
        .statistic-table td {
            font-weight: normal;
            /* Menghilangkan efek bold pada teks dalam tabel statistik */
        }

        .header-info {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <!-- Logo di kiri -->
        <?php if ($logo): ?>
            <div class="logo">
                <img src="<?= $logo ?>" alt="Logo">
            </div>
        <?php endif; ?>

        <!-- Judul dan Subtitle di tengah -->
        <div class="text">
            <div class="title">DAFTAR HADIR GURU</div>
            <div class="subtitle"><?= $nama_sekolah; ?><br>TAHUN AJARAN <?= $tahun_ajaran; ?></div>
        </div>
    </div>

    <div class="content">
        <div class="header-info">
            <span><strong>Bulan:</strong> <?= $bulan; ?></span>
        </div>
        <!-- Tabel Daftar Hadir Guru -->
        <table class="attendance-table">
            <thead>
                <tr>
                    <th rowspan="3">No</th>
                    <th rowspan="3" style="width: 20%;">Nama Guru</th>
                    <th colspan="<?= count($tanggal_list); ?>" style="text-align: center;">Hari/Tanggal</th>
                    <th colspan="4" rowspan="2" style="text-align: center;">Total</th>
                </tr>
                <tr>
                    <?php foreach ($hari_list as $hari): ?>
                        <th style="text-align:center;"><?= $hari; ?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($tanggal_list as $index => $tanggal): ?>
                        <th style="text-align:center;"><?= date('d', strtotime($tanggal)); ?></th>
                    <?php endforeach; ?>
                    <th style="text-align:center;" style="background-color:#28a745">H</th> <!-- Hadir -->
                    <th style="text-align:center;" style="background-color:#17a2b8;">I</th> <!-- Izin -->
                    <th style="text-align:center;" style="background-color:#ffc107;">S</th> <!-- Sakit -->
                    <th style="text-align:center;" style="background-color:red;">A</th> <!-- Tanpa Keterangan / ALfa -->
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($guru_list as $guru): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td style="text-align:left; width: 20%;"><?= $guru['nama_guru']; ?></td>
                        <!-- Menampilkan status absensi per tanggal -->
                        <?php
                        $totalHadir = 0;
                        $totalSakit = 0;
                        $totalIzin = 0;
                        $totalAlfa = 0;
                        ?>
                        <?php foreach ($tanggal_list as $tanggal): ?>
                            <td style="text-align:center; 
                <?php
                            $kehadiran = $guru['absensi'][$tanggal] ?? null;
                            $isTodayOrBefore = (strtotime($tanggal) <= strtotime(date('Y-m-d'))); // Cek apakah ini hari ini atau sebelumnya
                            $isAfterToday = (strtotime($tanggal) > strtotime(date('Y-m-d'))); // Cek apakah ini setelah hari ini

                            // Menambahkan warna latar belakang sesuai status
                            if ($isTodayOrBefore && !$kehadiran) {
                                // Jika hari ini atau sebelumnya dan tidak ada kehadiran, tampilkan Alfa
                                echo 'background-color: red;'; // Tanpa Keterangan / Alfa
                                $totalAlfa++; // Tambah total Alfa
                            }
                            // Jika ini setelah hari ini, tidak ada warna latar belakang
                            elseif ($isAfterToday) {
                                echo ''; // Tidak ada absensi pada hari setelah hari ini
                            } else {
                                // Tampilkan warna latar belakang sesuai kehadiran
                                switch ($kehadiran) {
                                    case 1:
                                        echo 'background-color: #28a745;';
                                        $totalHadir++; // Tambah total hadir
                                        break;  // Hadir (Green)
                                    case 2:
                                        echo 'background-color: #ffc107;';
                                        $totalSakit++; // Tambah total sakit
                                        break;  // Sakit (Yellow)
                                    case 3:
                                        echo 'background-color: #17a2b8;';
                                        $totalIzin++; // Tambah total izin
                                        break;  // Izin (Blue)
                                    case 4:
                                        echo 'background-color: red;';
                                        $totalAlfa++; // Tambah total tanpa keterangan
                                        break;  // Tanpa Keterangan (Red)
                                    default:
                                        echo '';
                                        break; // Belum absen
                                }
                            }
                ?>
            ">
                                <?php
                                // Menampilkan status absensi per tanggal
                                if ($isTodayOrBefore && !$kehadiran) {
                                    echo 'A'; // Tanpa Keterangan / Alfa
                                } elseif ($isAfterToday) {
                                    echo ''; // Tidak ada absensi pada hari setelah hari ini
                                } else {
                                    switch ($kehadiran) {
                                        case 1:
                                            echo 'H';
                                            break;  // Hadir
                                        case 2:
                                            echo 'S';
                                            break;  // Sakit
                                        case 3:
                                            echo 'I';
                                            break;  // Izin
                                        case 4:
                                            echo 'A';
                                            break;  // Tanpa Keterangan
                                        default:
                                            echo '';
                                            break; // Belum absen
                                    }
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>

                        <!-- Menampilkan Total -->
                        <td style="text-align:center;"><?= $totalHadir > 0 ? $totalHadir : '-' ?></td>
                        <td style="text-align:center;"><?= $totalIzin > 0 ? $totalIzin : '-' ?></td>
                        <td style="text-align:center;"><?= $totalSakit > 0 ? $totalSakit : '-' ?></td>
                        <td style="text-align:center;"><?= $totalAlfa > 0 ? $totalAlfa : '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Tabel Statistik -->
        <table class="statistic-table">
            <tr>
                <th>Jumlah Guru</th>
                <td>: <?= count($guru_list); ?></td>
            </tr>
            <tr>
                <th>Laki-Laki</th>
                <td>: <?= $laki_laki; ?></td>
            </tr>
            <tr>
                <th>Perempuan</th>
                <td>: <?= $perempuan; ?></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        &copy; <?= $copyright; ?>
    </div>

</body>

</html>