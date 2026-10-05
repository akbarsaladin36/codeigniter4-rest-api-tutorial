<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\PostService;
use CodeIgniter\API\ResponseTrait;
use Exception;

class PostController extends BaseController
{
    use ResponseTrait;

    protected $postService;

    public function __construct()
    {
        $this->postService = new PostService();
    }

    public function GetPostsController()
    {
        try {
            $posts = $this->postService->GetPostsService();
            return $this->respond($posts, $posts["status"]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function GetPostController($slug = '')
    {
        try {
            $post = $this->postService->GetPostService($slug);
            return $this->respond($post, $post["status"]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function CreatePostController()
    {
        try {
            $rules = $this->validate([
                'title' => 'required',
                'description' => 'required',
                'tags' => 'required'
            ]);

            if (!$rules) {
                $response = [
                    'message' => $this->validator->getErrors()
                ];
                return $this->failValidationErrors($response);
            }

            $auth = $this->request->authUser;
            $slug = mb_url_title($this->request->getVar('title'), "-", true);

            $data = [
                'user_id' => $auth["id"],
                'slug' => $slug,
                'title' => esc($this->request->getVar('title')),
                'description' => esc($this->request->getVar('description')),
                'tags' => esc($this->request->getVar('tags')),
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $post = $this->postService->CreatePostService($data);

            return $this->respondCreated($post, $post["status"]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function UpdatePostController($slug = '')
    {
        try {
            $rules = $this->validate([
                'title' => 'required',
                'description' => 'required',
                'tags' => 'required'
            ]);

            if (!$rules) {
                $response = [
                    'message' => $this->validator->getErrors()
                ];
                return $this->failValidationErrors($response);
            }

            $updatedSlug = mb_url_title(esc($this->request->getVar('title')), "-", true);

            $data = [
                'slug' => $updatedSlug,
                'title' => esc($this->request->getVar('title')),
                'description' => esc($this->request->getVar('description')),
                'tags' => esc($this->request->getVar('tags')),
                'status' => esc($this->request->getVar('status')),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $post = $this->postService->UpdatePostService($slug, $data);

            return $this->respond($post, $post["status"]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function DeletePostController($slug = '')
    {
        try {
            $post = $this->postService->DeletePostService($slug);
            return $this->respond($post, $post["status"]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }
}
