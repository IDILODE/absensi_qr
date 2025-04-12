<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use Config\Services;

class AuthController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function createAccount()
    {
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validasi input
        if (empty($username) || empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'Semua field harus diisi.')->withInput();
        }

        // Cek apakah email sudah ada di database
        if ($this->userModel->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'Email sudah terdaftar')->withInput();
        }

        // Validasi password
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            return redirect()->back()->with('error', 'Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka.')->withInput();
        }

        // Simpan pengguna baru
        $dataToInsert = [
            'username' => $username,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
        ];

        if ($this->userModel->insert($dataToInsert)) {
            return redirect()->to('auth/login')->with('success', 'Akun berhasil dibuat, silakan login.');
        } else {
            $errors = $this->userModel->errors();
            return redirect()->back()->with('error', 'Gagal menyimpan akun: ' . implode(', ', $errors))->withInput();
        }
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email
        $user = $this->userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user->password_hash)) {
            session()->set('logged_in', true);
            session()->set('email', $user->email);
            session()->set('role', $user->role);
            session()->set('username', $user->username); // Menyimpan username ke session

            return redirect()->to('/');
        } else {
            return redirect()->back()->with('error', 'Email atau password tidak valid');
        }
    }

    public function forgot()
    {
        return view('auth/forgot');
    }

    public function reset_password()
    {
        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        if ($user) {
            $token = bin2hex(random_bytes(50));
            $this->userModel->update($user->id, [
                'reset_hash' => $token,
                'reset_at' => date('Y-m-d H:i:s'),
                'reset_expires' => date('Y-m-d H:i:s', strtotime('+1 hour'))
            ]);

            $this->sendResetPasswordEmail($email, $token);

            return redirect()->to('auth/login')->with('success', 'Link reset password telah dikirim ke email Anda.');
        } else {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }
    }

    private function sendResetPasswordEmail($email, $token)
    {
        $resetLink = base_url("auth/reset_password_form?token=$token");
        $emailBody = "Klik link ini untuk reset password Anda: <a href='$resetLink'>$resetLink</a>";

        $emailService = Services::email();
        $emailService->setFrom('idilode350@gmail.com', 'Absensi QR Code');
        $emailService->setTo($email);
        $emailService->setSubject('Reset Password');
        $emailService->setMessage($emailBody);
        $emailService->setMailType('html');

        if (!$emailService->send()) {
            log_message('error', 'Email gagal dikirim: ' . $emailService->printDebugger(['headers']));
            return redirect()->back()->with('error', 'Gagal mengirim email reset password, coba lagi.');
        }
    }

    public function reset_password_form()
    {
        $token = $this->request->getVar('token');
        $user = $this->userModel->where('reset_hash', $token)
            ->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            return redirect()->to('auth/forgot')->with('error', 'Token tidak valid atau sudah kedaluwarsa.');
        }

        return view('auth/reset', ['token' => $token]);
    }

    public function update_password()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        if (empty($token) || empty($password)) {
            return redirect()->back()->with('error', 'Token dan password tidak boleh kosong.')->withInput();
        }

        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            return redirect()->back()->with('error', 'Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka.')->withInput();
        }

        $user = $this->userModel->where('reset_hash', $token)
            ->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->first();

        if ($user) {
            $dataToUpdate = [
                'password_hash' => password_hash($password, PASSWORD_BCRYPT),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null
            ];

            $this->userModel->update($user->id, $dataToUpdate);
            return redirect()->to('auth/login')->with('success', 'Password berhasil direset.');
        }

        return redirect()->to('auth/forgot')->with('error', 'Token tidak valid atau sudah kedaluwarsa.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('auth/login');
    }

    public function google()
    {
        $client = new \Google\Client();
        $client->setClientId('790238117272-eq8fj3vr6bpktei08adgmipike0ssa6u.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri('http://localhost/absensi_qr/public/auth/googleCallback');
        $client->addScope('email');
        $client->addScope('profile');

        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function googleCallback()
    {
        $client = new \Google\Client();
        $client->setClientId('790238117272-eq8fj3vr6bpktei08adgmipike0ssa6u.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri('http://localhost/absensi_qr/public/auth/googleCallback');

        $code = $this->request->getVar('code');

        if (empty($code)) {
            return redirect()->to('auth/login')->with('error', 'Login Google dibatalkan.');
        }

        $token = $client->fetchAccessTokenWithAuthCode($code);
        $client->setAccessToken($token['access_token']);

        $oauth = new \Google\Service\Oauth2($client);
        $userInfo = $oauth->userinfo->get();

        $user = $this->userModel->where('email', $userInfo->email)->first();

        if (!$user) {
            return redirect()->to('auth/register')->with('email', $userInfo->email);
        }

        session()->set('logged_in', true);
        session()->set('email', $user->email);
        session()->set('role', $user->role);
        session()->set('username', $user->username); // Menyimpan username ke session

        return redirect()->to('/');
    }
}
