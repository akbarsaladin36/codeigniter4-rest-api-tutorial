<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\AuthService;
use CodeIgniter\API\ResponseTrait;
use Exception;

class AuthController extends BaseController
{

    use ResponseTrait;

    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function RegisterController()
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

            $user = $this->authService->RegisterService($data);

            return $this->respond($user, $user["status"]);
        } catch (Exception $e) {
            return $this->respond($e->getMessage(), 500);
        }
    }

    public function LoginController()
    {
        try {
            $rules = $this->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            if (!$rules) {
                $response = [
                    'message' => $this->validator->getErrors()
                ];
                return $this->failValidationErrors($response);
            }

            $data = [
                'username' => $this->request->getVar('username'),
                'password' => $this->request->getVar('password')
            ];

            $user = $this->authService->LoginService($data);

            return $this->respond($user, $user["status"]);
        } catch (Exception $e) {
            return $this->respond($e->getMessage(), 500);
        }
    }
}
