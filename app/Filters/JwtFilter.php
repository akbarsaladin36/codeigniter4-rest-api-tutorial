<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine('Authorization');

        if (empty($header) || !str_starts_with($header, 'Bearer ')) {
            return Services::response()->setJSON(['status' => 401, 'message' => 'Token tidak ditemukan atau format salah!'])->setStatusCode(401);
        }

        $token = trim(str_replace('Bearer ', '', $header));

        try {
            $key = getenv('JWT_SECRET_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $request->authUser = (array)$decoded;
            return $request;
        } catch (Exception $e) {
            return Services::response()->setJSON(['status' => 500, 'message' => $e->getMessage()])->setStatusCode(500);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
