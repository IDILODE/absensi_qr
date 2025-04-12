<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            color: #ffc107 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('auth/createAccount') ?>" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <?php if (session()->getFlashdata('email')): ?>
                    <input type="email" name="email" id="email" class="form-control" value="<?= session()->getFlashdata('email') ?>" readonly>
                <?php else: ?>
                    <input type="email" name="email" id="email" class="form-control" required>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <small class="form-text text-muted">Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka.</small>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <hr>
        <p class="text-center">Sudah punya akun? <a href="<?= base_url('auth/login') ?>" class="text-warning">Login di sini</a></p>
    </div>
</body>
</html>
