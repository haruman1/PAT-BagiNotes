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
        if ($this->session->get('role') == 2 || $this->session->get('role') == NULL) {


            $data = [
                'title' => 'Category',
                'db' => $this->db,
                'category' => $this->db->table('hlmnbuku')->get()->getResultArray(),
                'sesison' => $this->session,
                // 'kategori_buku' => $this->db->table('hlmnbuku')->get()->getResultArray()->like('kategoribuku', 'Fiction'),
            ];
            return view('/template/awal/header', $data)
                . view('template/sidebar/nama-halaman')
                . view('kategori/index', $data)
                . view('/template/awal/footer');
        } else {
            return redirect()->to('/admin');
        }
    }
    public function pinjam_buku()
    {
        if ($this->session->get('role') == 2 || $this->session->get('role') == NULL) {
            $data = [
                'title' => 'Pinjam Buku',
                'db' => $this->db,
                'session' => $this->session,
                'request' => $this->request,
            ];
            return view('/template/awal/header')
                . view('template/sidebar/nama-halaman')
                . view('template/sidebar/search-halaman')
                . view('kategori/viewPinjam', $data)
                . view('/template/awal/footer');
        } else {
            $this->session->setTempdata('berhasilDaftar', 'Maaf, akun kamu tidak bisa meminjam buku ', 10);
            return redirect()->to('/admin');
        }
    }
    public function search()
    {
        if ($this->session->get('role') == 2 || $this->session->get('role') == NULL) {

            $keyword = $this->request->getVar('keyword');
            $data = [
                'title' => 'Category',
                'db' => $this->db,
                // 'category' => $this->db->table('hlmnbuku')->like('judulbuku', $keyword)->get()->getResultArray(),
                'request' => $this->request,
            ];
            return view('/template/awal/header')
                . view('template/sidebar/nama-halaman', $data)

                . view('kategori/pencarian', $data)
                . view('/template/awal/footer');
        } else {
            return redirect()->to('/admin');
        }
    }

    public function search_buku()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Category',
            'db' => $this->db,
            'category' => $this->db->table('hlmnbuku')->like('judulbuku', $keyword)->get()->getResultArray(),
            'request' => $this->request,
        ];
        return view('/template/awal/header')
            . view('template/sidebar/nama-halaman', $data)

            . view('kategori/pencarian', $data)
            . view('/template/awal/footer');
    }
    public function search_buku_saya()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Category',
            'db' => $this->db,
            'category' => $this->db->table('hlmnbuku')->like('judulbuku', $keyword)->get()->getResultArray(),
            'request' => $this->request,
        ];
        return view('/template/awal/header')
            . view('template/sidebar/nama-halaman', $data)

            . view('kategori/pencarian', $data)
            . view('/template/awal/footer');
    }
    public function search_buku_pinjam()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Category',
            'db' => $this->db,
            'category' => $this->db->table('hlmnbuku')->like('judulbuku', $keyword)->get()->getResultArray(),
            'request' => $this->request,
        ];
        return view('/template/awal/header')
            . view('template/sidebar/nama-halaman', $data)

            . view('kategori/pencarian', $data)
            . view('/template/awal/footer');
    }
    //     public function search_buku_pinjam_saya()
    //     {
    //         $keyword = $this->request->getVar('keyword');
    //         $data = [
    //             'title' => 'Category',
    //             'db' => $this->db,
    //             'category' => $this->db->table('hlmnbuku')->like('judulbuku', $
    // }
    public function buku_saya()
    {
        if ($this->session->get('role') == 2) {
            $data = [
                'title' => 'Buku Saya',
                'db' => $this->db,
                'request' => $this->request,
                'session' => $this->session,
            ];
            return view('/template/awal/header')
                . view('template/sidebar/nama-halaman')
                . view('template/sidebar/search-halaman')
                . view('kategori/viewbukuSaya', $data)
                . view('/template/awal/footer');
        } else if ($this->session->get('role') == 1) {
            return redirect()->to('/admin');
        } else {
            $this->session->setTempdata('berhasilDaftar', 'Silahkan Login terlebih dahulu untuk kehalaman ini ', 1);
            return redirect()->to('/login');
        }
    }
}
