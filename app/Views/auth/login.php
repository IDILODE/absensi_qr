<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .form-group label {
            font-weight: bold;
        }
        .text-warning {
            color: #ffc107 !important; /* Warna kuning untuk kontras dengan background */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('auth/authenticate') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        
        <hr>
        <p class="text-center">Atau login dengan:</p>
        <a href="<?= base_url('auth/googleLogin') ?>" class="btn btn-danger btn-block">Google</a>
        <p class="text-center">Belum punya akun? <a href="<?= base_url('auth/register') ?>" class="text-warning">Daftar di sini</a></p>
        <p class="text-center"><a href="<?= base_url('auth/forgot') ?>" class="text-warning">Lupa Password?</a></p>
    </div>
</body>
</html>
