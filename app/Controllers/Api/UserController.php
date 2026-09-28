<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\UserService;
use CodeIgniter\API\ResponseTrait;
use Exception;

class UserController extends BaseController
{
    use ResponseTrait;

    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function GetUsersController()
    {
        try {
            $users = $this->userService->GetUsersService();
            return $this->respond($users, $users['status']);
        } catch (Exception $e) {
            return $this->respond($e->getMessage(), 500);
        }
    }

    public function GetUserController($username = null)
    {
        try {
            $user = $this->userService->GetUserService($username);
            return $this->respond($user, $user['status']);
        } catch (Exception $e) {
            return $this->respond($e->getMessage(), 500);
        }
    }

    public function CreateUserController($data = null)
    {
        try {
            $rules = $this->validate([
                'username' => 'required',
                'email' => 'required',
                'password' => 'required',
                'full_name' => 'required',
                'phone_number' => 'required',
            ]);

            if (!$rules) {
                $response = [
                    'message' => $this->validator->getErrors()
                ];
                return $this->failValidationErrors($response);
            }

            $hashedPassword = password_hash(esc($this->request->getVar('password')), PASSWORD_DEFAULT);

            $data = [
                'username' => esc($this->request->getVar('username')),
                'email' => esc($this->request->getVar('email')),
                'password' => $hashedPassword,
                'full_name' => esc($this->request->getVar('full_name')),
                'address' => esc($this->request->getVar('address')),
                'phone_number' => esc($this->request->getVar('phone_number')),
                'created_at' => date("Y-m-d H:i:s"),
            ];

            $user = $this->userService->CreateUserService($data);

            return $this->respond($user, $user["status"]);
        } catch (Exception $e) {
            return $this->respond($e->getMessage(), 500);
        }
    }

    public function UpdateUserController($username = null, $data = null)
    {
        try {
            $rules = $this->validate([
                'full_name' => 'required',
                'phone_number' => 'required',
            ]);

            if (!$rules) {
                $response = [
                    'message' => $this->validator->getErrors()
                ];
                return $this->failValidationErrors($response);
            }

            $data = [
                'full_name' => esc($this->request->getVar('full_name')),
                'address' => esc($this->request->getVar('address')),
                'phone_number' => esc($this->request->getVar('phone_number')),
                'updated_at' => date("Y-m-d H:i:s"),
            ];

            $user = $this->userService->UpdateUserService($username, $data);

            return $this->respond($user, $user["status"]);
        } catch (Exception $e) {
            return $this->respond($e->getMessage(), 500);
        }
    }

    public function DeleteUserController($username = null)
    {
        try {
            $user = $this->userService->DeleteUserService($username);
            return $this->respond($user, $user["status"]);
        } catch (Exception $e) {
            return $this->respond($e->getMessage(), 500);
        }
    }
}
