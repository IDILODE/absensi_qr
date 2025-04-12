<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kelas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome -->
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
            max-width: 500px;
            backdrop-filter: blur(10px);
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

        input,
        .dropdown {
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
        .dropdown:hover {
            outline: none;
            border-color: #9013fe;
            box-shadow: 0 0 8px rgba(144, 19, 254, 0.6);
        }

        /* Mengubah warna placeholder */
        input::placeholder {
            color: #b0b0b0;
            /* Ganti dengan warna yang Anda inginkan */
        }

        /* Dropdown Styling */
        .dropdown-container {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .dropdown {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            padding: 0px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            max-height: 200px;
            overflow-y: scroll;
            /* Enable scroll tanpa scrollbar */
            width: 100%;
        }

        /* Menghilangkan scrollbar */
        .dropdown-menu::-webkit-scrollbar {
            display: none;
        }

        .dropdown-item {
            padding: 10px 15px;
            background-color: #2d2d2d;
            color: white;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            text-align: left;
        }

        .dropdown-item:hover {
            background-color: #9013fe;
            color: white;
        }

        .dropdown-icon {
            font-size: 1.5rem;
            transition: transform 0.3s;
            color: white;
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Tambah Kelas</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('data_kelas/simpan') ?>" method="post" autocomplete="off">
            <label for="nama_kelas">Kelas:</label>
            <input type="text" name="nama_kelas" id="nama_kelas" value="<?= old('nama_kelas') ?>" required autocomplete="off" placeholder="X/10">

            <label for="jurusan_id">Jurusan:</label>
            <div class="dropdown-container">
                <div class="dropdown" id="dropdown">
                    <span id="selected-jurusan">
                        <?= old('jurusan_id') ? array_column($jurusan, 'jurusan', 'id')[old('jurusan_id')] : 'Pilih Jurusan' ?>
                    </span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </div>
                <div class="dropdown-menu" id="dropdown-menu">
                    <?php foreach ($jurusan as $j): ?>
                        <div class="dropdown-item" data-id="<?= esc($j['id']) ?>" onclick="selectJurusan('<?= esc($j['jurusan']) ?>', '<?= esc($j['id']) ?>')">
                            <?= esc($j['jurusan']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <input type="hidden" name="jurusan_id" id="jurusan_id" value="<?= old('jurusan_id') ?>">

            <button type="submit">Simpan</button>
        </form>

        <div class="back-button">
            <a href="<?= base_url('data_kelas') ?>">Kembali</a>
        </div>
    </div>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function selectJurusan(jurusan, id) {
            document.getElementById('selected-jurusan').textContent = jurusan;
            document.getElementById('jurusan_id').value = id; // Set the hidden input value
            dropdownMenu.style.display = 'none';
            dropdownIcon.style.transform = 'rotate(0deg)';
        }

        const dropdown = document.getElementById('dropdown');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownIcon = document.querySelector('.dropdown-icon');

        dropdown.addEventListener('click', () => {
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
            dropdownIcon.style.transform = dropdownMenu.style.display === 'block' ? 'rotate(180deg)' : 'rotate(0deg)';
        });

        window.addEventListener('click', function(event) {
            if (!dropdown.contains(event.target)) {
                dropdownMenu.style.display = 'none';
                dropdownIcon.style.transform = 'rotate(0deg)';
            }
        });
    </script>
</body>

</html>