<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Pulang</title>
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
        }

        .form-container {
            width: 60%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;

        }

        .card-container {
            width: 35%;
            display: flex;
            flex-direction: column;
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
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            color: white;
        }

        /* Garis di bawah 'Pilih Kamera' */
        .form-group label {
            display: inline-block;
            border-bottom: 2px solid white;
            /* Mengatur ketebalan border bottom */
            padding-bottom: 5px;
            /* Jarak antara teks dan garis border */
            width: 100%;
            /* Atur panjang border sesuai lebar elemen label */
        }

        /* Gaya untuk dropdown kamera */
        #cameraSelect {
            background-color: rgba(255, 255, 255, 0.2);
            max-height: 200px;
            overflow-y: scroll;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            color: #fff;
            padding-left: 10px;
            border-color: #dde2e7;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            appearance: none;
            /* Menghapus ikon panah default */
            z-index: 1000;
        }

        /* Gaya default untuk opsi dalam dropdown */
        #cameraSelect option {
            background-color: #2d2d2d;
            color: white;
            cursor: pointer;
            font-size: 14px;
            /* Ukuran font untuk teks di dalam setiap pilihan */
            z-index: 1000;
        }

        #cameraSelect:hover {
            outline: none;
            border-color: #9013fe;
            box-shadow: 0 0 8px rgba(144, 19, 254, 0.6);
        }

        #cameraSelect::-webkit-scrollbar {
            display: none;
        }

        .video-container {
            width: 100%;
            border: 2px solid #fff;
            /* Warna border */
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.2);
            /* Warna latar saat kamera tidak aktif */
        }

        .video-container video {
            width: 100%;
            border-radius: 8px;
        }

        #statusAbsensi.error {
            color: rgb(225, 0, 0);
        }

        #statusAbsensi.errorr {
            color: rgb(225, 0, 0);
        }

        #statusAbsensi.success {
            color: rgb(0, 200, 0);
        }

        .btn {
            transition: background-color 0.3s ease !important;
            border: none !important;
            /* Menghilangkan border */
        }

        /* Hilangkan border dan outline pada tombol */
        .btn:focus,
        .btn:active {
            outline: none !important;
            /* Hilangkan outline saat tombol aktif */
            border: none !important;
            /* Hilangkan border saat tombol aktif */
            box-shadow: none !important;
            /* Hilangkan shadow yang mungkin muncul */
        }

        .tombol {
            display: flex;
            justify-content: space-between;
            /* Tombol tetap dipengaruhi space-between */
            width: 100%;
            margin-top: auto;
        }

        .btn-success {
            width: 100%;

        }

        .btn-custom {
            background-color: #9013fe;
            color: #fff;
            width: 50%;

        }

        .btn-custom:hover {
            background-color: #000000B3;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Form Container -->
        <div class="form-container">
            <h1>Absen Pulang</h1>

            <div class="tips-penggunaan">
                <h4>Tips:</h4>
                <ul>
                    <li>Pastikan QR Code Tersedia dan valid.</li>
                    <li>Arahkan QR Code ke kamera dengan jarak yang cukup jelas.</li>
                    <li>Jika gagal, posisikan ulang QR Code dan pastikan kamera dapat membacanya dengan baik.</li>
                </ul>
                <h4>Penggunaan:</h4>
                <ol>
                    <li><strong>Aktifkan Kamera:</strong> Pilih kamera dari dropdown dan kamera akan otomatis aktif.</li>
                    <li><strong>Absen:</strong> Klik tombol absen masuk/absen pulang untuk mengatur waktu absen.</li>
                    <li><strong>Absensi:</strong> Setelah QR Code dipindai, data akan muncul sebagai konfirmasi absensi pulang.</li>
                </ol>
            </div>
            <div class="tombol">
                <a href="<?= base_url('/') ?>" class="btn btn-custom mr-2">Dashboard</a>
                <a href="<?= base_url('scan/absen_masuk') ?>" class="btn btn-success">Absen Masuk</a>
            </div>

        </div>

        <!-- Card Container -->
        <div class="card-container">
            <div class="card">
                <div class="form-group">
                    <label for="cameraSelect">Pilih Kamera:</label>
                    <select id="cameraSelect" class="form-control">
                        <!-- Dropdown kamera akan diisi dengan JavaScript -->
                    </select>
                </div>
                <div class="video-container">
                    <video id="video" autoplay></video> <!-- Tampilan kamera -->
                </div>
                <!-- Hasil Absensi -->
                <div id="absensiResult" class="mt-3" style="display: none;">
                    <p><strong id="statusAbsensi"></strong></p>

                    <!-- Data Siswa -->
                    <p>Nama Siswa: <span id="namaSiswa"></span></p>
                    <p>NIS: <span id="nis"></span></p>
                    <p>Kelas: <span id="kelas"></span></p>

                    <!-- Data Guru -->
                    <p>Nama Guru: <span id="namaGuru"></span></p>
                    <p>NUPTK: <span id="nuptk"></span></p>
                    <p>No. HP: <span id="noHp"></span></p>

                    <p>Jam Masuk: <span id="jamMasuk"></span></p>
                    <p>Jam Pulang: <span id="jamPulang"></span></p>
                </div>
                <audio id="beepSound" src="<?= base_url('assets/audio/beep.mp3') ?>" preload="auto"></audio>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>

    <script>
        // Cek status izin kamera
        async function checkCameraPermission() {
            const permission = await navigator.permissions.query({
                name: 'camera'
            });
            return permission.state;
        }

        // Mendapatkan daftar kamera yang terhubung
        async function getCameras() {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const videoDevices = devices.filter(device => device.kind === 'videoinput');

            const cameraSelect = document.getElementById('cameraSelect');
            cameraSelect.innerHTML = ''; // Reset dropdown

            const uniqueDevices = [];
            const deviceIds = new Set();

            videoDevices.forEach((device, index) => {
                if (!deviceIds.has(device.deviceId)) {
                    deviceIds.add(device.deviceId);
                    uniqueDevices.push(device);
                }
            });

            uniqueDevices.forEach((device, index) => {
                const option = document.createElement('option');
                option.value = device.deviceId;
                option.text = device.label || `Kamera ${index + 1}`;
                cameraSelect.appendChild(option);
            });

            if (uniqueDevices.length > 0) {
                cameraSelect.value = uniqueDevices[0].deviceId;
                activateCamera(uniqueDevices[0].deviceId);
            }
        }

        // Mengaktifkan kamera yang dipilih
        async function activateCamera(deviceId) {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        deviceId: {
                            exact: deviceId
                        }
                    }
                });
                const videoElement = document.getElementById('video');
                videoElement.srcObject = stream;
                scanQRCodePulang(); // Mulai pemindaian QR code
            } catch (error) {
                console.error('Gagal mengakses kamera:', error);
            }
        }

        // Fungsi untuk memindai QR code
        let isProcessing = false; // Flag untuk memastikan hanya satu pemrosesan yang terjadi sekaligus
        let isScanning = true; // Flag untuk menandakan apakah pemindaian diaktifkan

        // Panggil fungsi baru ini untuk memproses absensi pulang
        function scanQRCodePulang() {
            const videoElement = document.getElementById('video');
            const canvasElement = document.createElement('canvas');
            const canvasContext = canvasElement.getContext('2d');

            function detectQRCode() {
                if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA && isScanning) {
                    canvasElement.height = videoElement.videoHeight;
                    canvasElement.width = videoElement.videoWidth;
                    canvasContext.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);

                    const imageData = canvasContext.getImageData(0, 0, canvasElement.width, canvasElement.height);
                    const qrCode = jsQR(imageData.data, canvasElement.width, canvasElement.height);

                    if (qrCode && !isProcessing) {
                        isProcessing = true;
                        console.log('QR Code detected:', qrCode.data);
                        handleQRCodePulang(qrCode.data);

                        stopCameraTemporarily();
                    }
                }
                requestAnimationFrame(detectQRCode);
            }

            detectQRCode();
        }

        // Fungsi untuk menyembunyikan video sementara dan menonaktifkan pemindaian
        function stopCameraTemporarily() {
            const videoElement = document.getElementById('video');

            // Sembunyikan elemen video (kamera)
            videoElement.style.visibility = 'hidden'; // Gunakan visibility untuk menyembunyikan elemen

            // Nonaktifkan pemindaian QR Code selama 2 detik
            isScanning = false;

            // Matikan kamera selama 2 detik
            setTimeout(() => {
                // Tampilkan kembali elemen video
                videoElement.style.visibility = 'visible'; // Kembalikan visibilitas elemen video

                // Aktifkan kembali pemindaian QR Code setelah 2 detik
                isScanning = true;

                // Pastikan kamera tetap aktif dengan memanggil ulang fungsi aktivasi kamera jika perlu
                const selectedDeviceId = document.getElementById('cameraSelect').value;
                activateCamera(selectedDeviceId); // Memastikan kamera tetap berjalan
            }, 2000); // 2 detik jeda
        }

        // Fungsi untuk memindai QR code dan mengirimkan data ke server
        async function handleQRCodePulang(qrData) {
            const currentTime = new Date().toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit'
            });

            const data = {
                qrData: qrData,
                currentTime: currentTime
            };

            const response = await fetch('<?= base_url('scan/absen_pulang/processQR') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            const statusAbsensiElement = document.getElementById('statusAbsensi');
            const absensiResultElement = document.getElementById('absensiResult');

            // Reset hasil sebelumnya
            statusAbsensiElement.textContent = '';
            absensiResultElement.style.display = 'none'; // Pastikan pesan tersembunyi

            // Sembunyikan elemen-elemen data siswa dan guru terlebih dahulu
            document.getElementById('namaSiswa').parentElement.style.display = 'none';
            document.getElementById('nis').parentElement.style.display = 'none';
            document.getElementById('kelas').parentElement.style.display = 'none';
            document.getElementById('namaGuru').parentElement.style.display = 'none';
            document.getElementById('nuptk').parentElement.style.display = 'none';
            document.getElementById('noHp').parentElement.style.display = 'none';
            document.getElementById('jamMasuk').parentElement.style.display = 'none';
            document.getElementById('jamPulang').parentElement.style.display = 'none';

            if (result.status === 'error' && result.message === 'Anda sudah absen pulang.') {
                // Jika sudah absen pulang
                statusAbsensiElement.textContent = result.message;
                statusAbsensiElement.classList.remove('success');
                statusAbsensiElement.classList.add('error');

                if (result.siswa) {
                    // Menampilkan data siswa jika sudah absen
                    document.getElementById('namaSiswa').textContent = result.siswa.nama_siswa;
                    document.getElementById('namaSiswa').parentElement.style.display = 'block';
                    document.getElementById('nis').textContent = result.siswa.nis;
                    document.getElementById('nis').parentElement.style.display = 'block';
                    document.getElementById('kelas').textContent = result.siswa.nama_kelas + ' - ' + result.siswa.jurusan;
                    document.getElementById('kelas').parentElement.style.display = 'block';
                }
                if (result.guru) {
                    // Tampilkan data guru
                    document.getElementById('namaGuru').textContent = result.guru.nama_guru;
                    document.getElementById('namaGuru').parentElement.style.display = 'block';
                    document.getElementById('nuptk').textContent = result.guru.nuptk;
                    document.getElementById('nuptk').parentElement.style.display = 'block';
                    document.getElementById('noHp').textContent = result.guru.no_hp;
                    document.getElementById('noHp').parentElement.style.display = 'block';
                }

                document.getElementById('jamMasuk').textContent = result.absensi.jam_masuk.split(':').slice(0, 2).join(':');
                document.getElementById('jamMasuk').parentElement.style.display = 'block';
                document.getElementById('jamPulang').textContent = result.absensi.jam_pulang.split(':').slice(0, 2).join(':');
                document.getElementById('jamPulang').parentElement.style.display = 'block';

                // Menampilkan hasil absensi
                absensiResultElement.style.display = 'block';
                document.getElementById('beepSound').play();
            } else if (result.status === 'success') {
                // Absensi berhasil pulang
                statusAbsensiElement.textContent = result.message;
                statusAbsensiElement.classList.remove('error');
                statusAbsensiElement.classList.add('success');
                if (result.siswa) {
                    // Menampilkan data siswa
                    document.getElementById('namaSiswa').textContent = result.siswa.nama_siswa;
                    document.getElementById('namaSiswa').parentElement.style.display = 'block';
                    document.getElementById('nis').textContent = result.siswa.nis;
                    document.getElementById('nis').parentElement.style.display = 'block';
                    document.getElementById('kelas').textContent = result.siswa.nama_kelas + ' - ' + result.siswa.jurusan;
                    document.getElementById('kelas').parentElement.style.display = 'block';
                }
                if (result.guru) {
                    // Tampilkan data guru
                    document.getElementById('namaGuru').textContent = result.guru.nama_guru;
                    document.getElementById('namaGuru').parentElement.style.display = 'block';
                    document.getElementById('nuptk').textContent = result.guru.nuptk;
                    document.getElementById('nuptk').parentElement.style.display = 'block';
                    document.getElementById('noHp').textContent = result.guru.no_hp;
                    document.getElementById('noHp').parentElement.style.display = 'block';
                }

                document.getElementById('jamMasuk').textContent = result.absensi.jam_masuk.split(':').slice(0, 2).join(':');
                document.getElementById('jamMasuk').parentElement.style.display = 'block';
                document.getElementById('jamPulang').textContent = result.absensi.jam_pulang.split(':').slice(0, 2).join(':');
                document.getElementById('jamPulang').parentElement.style.display = 'block';

                absensiResultElement.style.display = 'block';
                document.getElementById('beepSound').play();
            } else if (result.status === 'errorr') {
                // QR code tidak valid
                statusAbsensiElement.textContent = result.message; // Pesan error
                statusAbsensiElement.classList.remove('success');
                statusAbsensiElement.classList.add('errorr'); // Kelas error untuk styling

                document.getElementById('statusAbsensi').parentElement.style.display = 'block';
                absensiResultElement.style.display = 'block';
                document.getElementById('beepSound').play();
            }

            isProcessing = false; // Reset flag setelah proses selesai
        }

        // Mengatur event listener untuk memilih kamera
        document.getElementById('cameraSelect').addEventListener('change', (event) => {
            const selectedDeviceId = event.target.value;
            activateCamera(selectedDeviceId);
        });

        // Menangani izin kamera saat halaman dimuat
        window.addEventListener('load', async () => {
            const permissionState = await checkCameraPermission();

            if (permissionState === 'prompt') {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(() => location.reload())
                    .catch((error) => console.error('Kamera tidak dapat diakses', error));
            } else {
                getCameras();
            }
        });

        // Panggil getCameras untuk mendapatkan daftar kamera yang terhubung
        getCameras();
    </script>



</body>

</html>