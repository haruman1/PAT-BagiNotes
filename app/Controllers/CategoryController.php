<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->cModel = new CategoryModel();
        $this->builder = $this->db->table('hlmnbuku');
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
    }
    public function index()
    {
        $data = [
            'title' => 'Category',
            'db' => $this->db,
            'category' => $this->db->table('hlmnbuku')->get()->getResultArray(),
            // 'kategori_buku' => $this->db->table('hlmnbuku')->get()->getResultArray()->like('kategoribuku', 'Fiction'),
        ];
        return view('/template/awal/header')
            . view('kategori/index', $data)
            . view('/template/awal/footer');
    }
    public function pinjam_buku()
    {
        $data = [
            'title' => 'Pinjam Buku',
            'db' => $this->db,
            'request' => $this->request,
        ];
        return view('/template/awal/header')
            . view('template/sidebar/nama-halaman')
            . view('template/sidebar/search-halaman')
            . view('kategori/viewPinjam', $data)
            . view('/template/awal/footer');
    }
}
