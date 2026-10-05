<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Post();
    }

    public function GetAll()
    {
        return $this->model->whereIn('status', ['posted', 'published'])->findAll();
    }

    public function GetOne($slug = '')
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function Create($data = null)
    {
        return $this->model->insert($data);
    }

    public function Update($slug = '', $data = null)
    {
        return $this->model->where('slug', $slug)->set($data)->update();
    }

    public function Delete($slug = '')
    {
        return $this->model->where('slug', $slug)->delete();
    }
}
