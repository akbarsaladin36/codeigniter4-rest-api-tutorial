<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function GetAll()
    {
        return $this->model->findAll();
    }

    public function GetOne($username = null)
    {
        return $this->model->where('username', $username)->first();
    }

    public function Create($data = null)
    {
        return $this->model->insert($data);
    }

    public function Update($username = null, $data = null)
    {
        return $this->model->where('username', $username)->set($data)->update();
    }

    public function Delete($username = null)
    {
        return $this->model->where('username', $username)->delete();
    }
}
