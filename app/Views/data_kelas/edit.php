<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas</title>
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

        /* Dropdown Styling */
        .dropdown-container {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .dropdown {
            width: 100%;
            padding: 12px 15px;
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid #dde2e7;
            border-radius: 8px;
            font-size: 1rem;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .dropdown:hover {
            border-color: #9013fe;
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
            overflow-y: auto;
            width: 100%;
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
        <h1>Edit Kelas</h1>
        <form action="<?= base_url('data_kelas/update/' . $kelas['id']) ?>" method="post" autocomplete="off">
            <label for="nama_kelas">Kelas:</label>
            <input type="text" name="nama_kelas" id="nama_kelas" value="<?= esc($kelas['nama_kelas']) ?>" required autocomplete="off" placeholder="X/10">

            <label for="jurusan_id">Jurusan:</label>
            <div class="dropdown-container">
                <div class="dropdown" id="dropdown">
                    <span id="selected-jurusan">
                        <?= isset($selectedJurusan) ? esc($selectedJurusan['jurusan']) : 'Pilih Jurusan' ?>
                    </span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </div>
                <div class="dropdown-menu" id="dropdown-menu">
                    <?php foreach ($jurusan as $item): ?>
                        <div class="dropdown-item" data-id="<?= esc($item['id']) ?>" onclick="selectJurusan('<?= esc($item['jurusan']) ?>', '<?= esc($item['id']) ?>')">
                            <?= esc($item['jurusan']) ?>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Hidden input to store selected jurusan_id -->
            <input type="hidden" name="jurusan_id" id="jurusan_id" value="<?= esc($kelas['jurusan_id']) ?>">


            <button type="submit">Update</button>
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
        // Fungsi untuk menampilkan jurusan yang sudah dipilih
        function selectJurusan(jurusan, id) {
            document.getElementById('selected-jurusan').textContent = jurusan;
            document.getElementById('jurusan_id').value = id; // Set the hidden input value
            dropdownMenu.style.display = 'none';
            dropdownIcon.style.transform = 'rotate(0deg)';
        }

        // Toggle dropdown menu
        const dropdown = document.getElementById('dropdown');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownIcon = document.querySelector('.dropdown-icon');

        dropdown.addEventListener('click', () => {
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
            dropdownIcon.style.transform = dropdownMenu.style.display === 'block' ? 'rotate(180deg)' : 'rotate(0deg)';
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', function(event) {
            if (!dropdown.contains(event.target)) {
                dropdownMenu.style.display = 'none';
                dropdownIcon.style.transform = 'rotate(0deg)';
            }
        });

        // Saat halaman dimuat, pastikan jurusan yang sudah dipilih ditampilkan
        window.addEventListener('DOMContentLoaded', (event) => {
            const selectedJurusanId = document.getElementById('jurusan_id').value; // Ambil id jurusan yang sudah dipilih
            if (selectedJurusanId) {
                const dropdownItems = document.querySelectorAll('.dropdown-item');
                dropdownItems.forEach(item => {
                    const itemId = item.getAttribute('data-id'); // Ambil ID jurusan dari data-id
                    if (itemId === selectedJurusanId) {
                        // Jika ID jurusan cocok, tampilkan nama jurusan dan beri tanda pada dropdown
                        document.getElementById('selected-jurusan').textContent = item.textContent.trim();
                        item.classList.add('selected'); // Tandai sebagai yang dipilih
                    }
                });
            }
        });
    </script>
</body>

</html>