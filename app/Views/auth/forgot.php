<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #4a90e2, #9013fe);
            color: white;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        .form-group label {
            font-weight: bold;
        }
        p a {
            color: #ffdd57;
        }
        p a:hover {
            text-decoration: underline;
        }
        .text-warning {
            color: #ffc107 !important; /* Warna kuning untuk kontras dengan background */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lupa Password</h1>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('auth/reset_password') ?>" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset Password</button>
        </form>
        <hr>
        <p class="text-center">Kembali ke <a href="<?= base_url('auth/login') ?>"class="text-warning">Login</a></p>
    </div>
</body>
</html>
