<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4a90e2, #9013fe);
            font-family: 'Poppins', sans-serif;
            color: white;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 40px 30px;
            width: 100%;
            max-width: 1000px;
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            /* Menjamin bahwa kedua card memiliki tinggi yang sama */
        }

        .form-container,
        .card-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100%;
            /* Pastikan card-container bisa memenuhi tinggi yang sama */
        }

        .form-container {
            width: 60%;
        }

        .card-container {
            width: 35%;
        }

        .card h5 {
            font-size: 1rem;
            margin-top: 10px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 20px;
            color: #fff;
            flex-grow: 1;
            /* Agar card bisa menyesuaikan tinggi sesuai konten */
        }


        h1 {
            text-align: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 30px;
        }


        label {
            font-size: 1rem;
            margin-bottom: 8px;
            color: #fff;
            display: block;
        }

        input {
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

        input:focus {
            outline: none;
            border-color: #9013fe;
            box-shadow: 0 0 8px rgba(144, 19, 254, 0.6);
        }

        input::placeholder {
            color: #b0b0b0;
        }

        button {
            background-color: #9013fe;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px 20px;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0072ff;
        }

        button:focus {
            outline: none;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        }

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            color: #2d2d2d;
            text-decoration: none;
            font-size: 1rem;
            display: inline-block;
            margin-top: 10px;
            border: 2px solid #2d2d2d;
            padding: 8px 16px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .back-button a:hover {
            background-color: #9013fe;
            color: white;
        }


        .btn-info {
            background-color: #9013fe !important;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
            margin-top: 20px;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
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

        .btn-info:hover {
            background-color: #000000B3 !important;
        }

        .btn-info:focus {
            outline: none;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content {
            background-color: #2d2d2d;
            color: white;
        }

        .custom-file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
            border: 2px dashed #9013fe;
            padding: 20px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .custom-file-upload input[type="file"] {
            display: none;
            /* Sembunyikan input file asli */
        }

        .custom-file-upload label {
            cursor: pointer;
        }

        .custom-file-upload:hover {
            background-color: rgba(144, 19, 254, 0.2);
            border-color: #0072ff;
        }

        .custom-file-upload input[type="file"]:focus+label,
        .custom-file-upload label:active {
            border-color: #0072ff;
            background-color: rgba(144, 19, 254, 0.3);
        }

        /* Menambahkan efek saat drag over */
        .custom-file-upload.dragover {
            background-color: rgba(144, 19, 254, 0.3);
            border-color: #0072ff;
        }

        .custom-file-upload label:active {
            background-color: transparent;
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
    </style>
</head>

<body>
    <div class="container">
        <!-- Form Container -->
        <div class="form-container">
            <!-- Flash message for errors -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <h1>Import Data Siswa</h1>
            <form action="<?= base_url('data_siswa/importData') ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file">Pilih file *CSV/XLSX: <span id="file-name"></span></label>
                    <div class="custom-file-upload" id="file-upload">
                        <input type="file" name="file" id="file" required accept=".csv,.xlsx">
                        <label for="file">Pilih file Anda atau seret dan lepas di sini</label>
                    </div>
                </div>
                <button type="submit">Import Data</button>
            </form>
            <div class="back-button">
                <a href="<?= base_url('data_siswa') ?>">Kembali</a>
            </div>
        </div>

        <!-- Card Container -->
        <div class="card-container">
            <div class="card">
                <h5>Dokumen untuk menghasilkan file CSV/XLSX Anda</h5>
                <button class="btn btn-info" data-toggle="modal" data-target="#kelasModal">Lihat Kelas ID</button>
                <a href="<?= base_url('downloadTemplate/csv') ?>" class="btn btn-info">Unduh Template CSV</a>
                <a href="<?= base_url('downloadTemplate/xlsx') ?>" class="btn btn-info">Unduh Template XLSX</a>
            </div>
        </div>
    </div>

    <!-- Modal for Invalid File Format -->
    <div class="modal fade" id="invalidFileModal" tabindex="-1" role="dialog" aria-labelledby="invalidFileModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invalidFileModalLabel">Format File Tidak Valid</h5>
                </div>
                <div class="modal-body">
                    Hanya file dengan format CSV/XLSX yang diperbolehkan. Silakan pilih file dengan format yang sesuai.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Kelas ID -->
    <div class="modal fade" id="kelasModal" tabindex="-1" role="dialog" aria-labelledby="kelasModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kelasModalLabel">Daftar Kelas ID</h5>
                    <p class="card-text">Tahun Ajaran: <?= $tahun_ajaran ?></p>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered text-white">
                        <thead>
                            <tr>
                                <th>Kelas ID</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kelas as $k): ?>
                                <tr>
                                    <td><?= $k['id'] ?></td>
                                    <td><?= $k['nama_kelas'] ?></td>
                                    <td><?= $k['jurusan'] ?></td>
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




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Ambil elemen-elemen yang diperlukan
        const fileInput = document.getElementById('file');
        const fileUploadContainer = document.getElementById('file-upload');
        const fileNameDisplay = document.getElementById('file-name');

        // Fungsi untuk menangani event perubahan file
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name; // Tampilkan nama file yang dipilih
            } else {
                fileNameDisplay.textContent = "";
            }
        });

        // Fungsi untuk menangani drag-and-drop
        fileUploadContainer.addEventListener('dragover', function(e) {
            e.preventDefault();
            fileUploadContainer.classList.add('dragover');
        });

        fileUploadContainer.addEventListener('dragleave', function(e) {
            e.preventDefault();
            fileUploadContainer.classList.remove('dragover');
        });

        fileUploadContainer.addEventListener('drop', function(e) {
            e.preventDefault();
            fileUploadContainer.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files; // Masukkan file yang di-drop ke input
                fileNameDisplay.textContent = files[0].name; // Tampilkan nama file yang dijatuhkan
            }
        });



        document.querySelector("form").addEventListener("submit", function(event) {
            var fileInput = document.getElementById("file");
            var filePath = fileInput.value;
            var allowedExtensions = /(\.csv|\.xlsx)$/i;

            if (!allowedExtensions.exec(filePath)) {
                event.preventDefault(); // Mencegah form untuk submit
                $('#invalidFileModal').modal('show'); // Menampilkan modal jika format tidak valid
            }
        });
    </script>


</body>

</html>