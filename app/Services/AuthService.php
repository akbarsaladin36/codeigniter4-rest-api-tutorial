<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Firebase\JWT\JWT;

class AuthService
{
    protected $authRepository;

    public function __construct()
    {
        $this->authRepository = new UserRepository();
    }

    public function RegisterService($data = null)
    {
        $user = $this->authRepository->GetOne($data['username']);

        if ($user) {
            return [
                'status' => 400,
                'message' => 'Data pengguna tersebut sudah terdaftar!'
            ];
        }

        $this->authRepository->Create($data);

        return [
            'status' => 200,
            'message' => 'Data baru pengguna sudah berhasil ditambahkan!'
        ];
    }

    public function LoginService($data = null)
    {
        $user = $this->authRepository->GetOne($data['username']);

        if (!$user) {
            return [
                'status' => 400,
                'message' => 'Data pengguna tersebut tidak ditemukan!'
            ];
        }

        $checkPassword = password_verify($data['password'], $user["password"]);

        if (!$checkPassword) {
            return [
                'status' => 400,
                'message' => 'Password ini tidak sesuai! Silakan coba lagi!'
            ];
        }

        $key = getenv('JWT_SECRET_KEY');
        $iat = time();
        $exp = $iat + 3600;

        $payload = [
            'iat' => $iat,
            'exp' => $exp,
            'id' => $user["id"],
            'username' => $user["username"],
            'email' => $user["email"],
            'full_name' => $user["full_name"],
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        $response = [...$user, 'token' => $token];

        return [
            'status' => 200,
            'message' => 'Pengguna berhasil login ke aplikasi!',
            'data' => $response
        ];
    }
}
