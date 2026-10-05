<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function GetPostsService()
    {
        $posts = $this->postRepository->GetAll();

        if (!$posts) {
            return [
                'status' => 400,
                'message' => 'Data semua post kosong / tidak ada sama sekali!'
            ];
        }

        return [
            'status' => 400,
            'message' => 'Data semua post berhasil ditampilkan!',
            'data' => $posts
        ];
    }

    public function GetPostService($slug = '')
    {
        $post = $this->postRepository->GetOne($slug);

        if (!$post) {
            return [
                'status' => 400,
                'message' => 'Data post tersebut tidak ditemukan!'
            ];
        }

        return [
            'status' => 200,
            'message' => 'Data post tersebut berhasil ditampilkan!',
            'data' => $post
        ];
    }

    public function CreatePostService($data = null)
    {
        $post = $this->postRepository->GetOne($data["slug"]);

        if ($post) {
            return [
                'status' => 400,
                'message' => 'Data post tersebut sudah dibuat sebelumnya!'
            ];
        }

        $this->postRepository->Create($data);

        return [
            'status' => 200,
            'message' => 'Data post baru telah berhasil ditambahkan!'
        ];
    }

    public function UpdatePostService($slug = '', $data = null)
    {
        $post = $this->postRepository->GetOne($slug);

        if (!$post) {
            return [
                'status' => 400,
                'message' => 'Data post tersebut tidak ditemukan!'
            ];
        }

        $this->postRepository->Update($slug, $data);

        return [
            'status' => 200,
            'message' => 'Data post tersebut telah berhasil diupdate!'
        ];
    }

    public function DeletePostService($slug = '')
    {
        $post = $this->postRepository->GetOne($slug);

        if (!$post) {
            return [
                'status' => 400,
                'message' => 'Data post tersebut tidak ditemukan!'
            ];
        }

        $this->postRepository->Delete($slug);

        return [
            'status' => 200,
            'message' => 'Data post tersebut telah berhasil dihapus!'
        ];
    }
}
