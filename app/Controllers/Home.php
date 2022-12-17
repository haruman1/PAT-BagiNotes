<?php

namespace App\Controllers;

use App\Models\HomeModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->homeModel = new HomeModel();
        $this->builder = $this->db->table('trendingbook');
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $data = [

            'db' => $this->db,
        ];

        return view('/template/awal/header')
            . view('home/index', $data)
            . view('/template/awal/footer');
    }
}
