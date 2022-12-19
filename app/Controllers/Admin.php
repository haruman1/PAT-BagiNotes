<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('user');
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
    }
    public function index()
    {
        if ($this->session->get('role') == 2 || $this->session->get('role') == NULL) {
            return redirect()->to('/');
        } else {
            $data = [
                'title' => 'Admin',
                'db' => $this->db,
                'request' => $this->request,
                'session' => $this->session,
            ];
            return view('/template/admin/header', $data)
                . view('/template/admin/sidebar', $data)
                . view('admin/book/tambah_buku', $data)
                . view('/template/admin/footer');
        }
    }
}
