<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function GetUsersService()
    {
        $users = $this->userRepository->GetAll();

        return [
            'status' => 200,
            'message' => 'Data semua pengguna berhasil ditampilkan!',
            'data' => $users
        ];
    }

    public function GetUserService($username = null)
    {
        $user = $this->userRepository->GetOne($username);

        if (!$user) {
            return [
                'status' => 400,
                'message' => 'Data pengguna tersebut tidak ditemukan!',
                'data' => null
            ];
        }

        return [
            'status' => 200,
            'message' => 'Data pengguna tersebut berhasil ditampilkan!',
            'data' => $user
        ];
    }

    public function CreateUserService($data = null)
    {
        $user = $this->userRepository->GetOne($data['username']);

        if ($user) {
            return [
                'status' => 400,
                'message' => 'Data pengguna tersebut sudah terdaftar!'
            ];
        }

        $this->userRepository->Create($data);

        return [
            'status' => 200,
            'message' => 'Data baru pengguna sudah berhasil ditambahkan!'
        ];
    }

    public function UpdateUserService($username = null, $data = null)
    {
        $user = $this->userRepository->GetOne($username);

        if (!$user) {
            return [
                'status' => 400,
                'message' => 'Data pengguna tersebut tidak terdaftar!'
            ];
        }

        $data["address"] = $data["address"] ? $data["address"] : $user["address"];

        $this->userRepository->Update($username, $data);

        return [
            'status' => 200,
            'message' => 'Data baru pengguna sudah berhasil diupdate!'
        ];
    }

    public function DeleteUserService($username = null)
    {
        $user = $this->userRepository->GetOne($username);

        if (!$user) {
            return [
                'status' => 400,
                'message' => 'Data pengguna tersebut tidak terdaftar!'
            ];
        }

        $this->userRepository->Delete($username);

        return [
            'status' => 200,
            'message' => 'Data pengguna tersebut sudah berhasil dihapus!'
        ];
    }
}
