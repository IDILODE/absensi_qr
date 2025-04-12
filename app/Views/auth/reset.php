<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Reset Password</h1>
        
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
        
        <form action="<?= base_url('auth/update_password') ?>" method="post">
            <input type="hidden" name="token" value="<?= $token ?>">
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Perbarui Password</button>
        </form>

        <hr>
        <p class="text-center"><a href="<?= base_url('auth/login') ?>" class="text-warning">Kembali ke Login</a></p>
    </div>

    <script>
        // Optional: Show/hide password feature
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirm');
        function togglePasswordVisibility() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            confirmPasswordInput.type = type;
        }
    </script>
</body>
</html>
