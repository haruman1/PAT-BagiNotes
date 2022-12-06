<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthModel;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->Auth = new AuthModel();
        $this->builder = $this->db->table('user');
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        helper('form');
        $data = [
            'title' => 'Login Mamahmuda',
            'validation' => $this->validation,
            'anggota' => $this->Auth->tampilAnggota(),
        ];
        return view('auth/index', $data);
    }
}
