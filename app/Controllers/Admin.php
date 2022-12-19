<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->adminModel = new \App\Models\AdminModel();
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
                . view('admin/index', $data);
        }
    }
    public function anggota()
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
                . view('admin/kelolaanggota', $data);
        }
    }
    public function buku()
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
                . view('admin/kelolabuku', $data);
        }
    }
    public function transaksi()
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
                . view('admin/transaksi', $data);
        }
    }
    public function tambahAnggota()
    {
        if ($this->session->get('role') == 2 || $this->session->get('role') == NULL) {
            return redirect()->to('/');
        } else {
            if (!$this->validate(
                [
                    'email_user' => [
                        'rules' => 'required|min_length[3]|is_unique[user.email.id,{id}]',
                        'errors' => [
                            'required' => 'Email wajib di isi',
                            'min_length[3]' => 'Email terlalu pendek',
                            'is_unique' => 'Email sudah ada,silahkan gunakan yang lain',
                        ],
                    ],
                    'nama' => [
                        'rules' => 'required|min_length[3]|max_length[20]',
                        'errors' => [
                            'required' => 'Nama wajib di isi',
                            'min_length[3]' => 'Nama terlalu pendek',
                            'max_length[20]' => 'Nama terlalu panjang',
                        ],
                    ],

                    'username' => [
                        'rules' => 'required|min_length[3]|max_length[20]|is_unique[user.username.id,{id}]',
                        'errors' => [
                            'required' => 'Username wajib di isi',
                            'min_length[3]' => 'Username terlalu pendek',
                            'max_length[20]' => 'Username terlalu panjang',
                            'is_unique' => 'Username sudah ada, silahkan gunakan yang lain',

                        ],
                    ],
                    'password' => [
                        'rules' => 'required|trim|min_length[8]',
                        'errors' => [
                            'required' => 'Password wajib di isi',
                            'min_length[8]' => 'Password terlalu pendek',

                        ],
                    ],
                    'password_sama' => [
                        'rules' => 'required|trim|min_length[8]|matches[password]',
                        'errors' => [
                            'required' => 'Password konfirmasi wajib di isi',
                            'min_length[8]' => 'Password terlalu pendek',
                            'matches' => 'Password tidak sama,tolong samakan password',
                        ],
                    ],
                ]

            )) {
                $this->session->setTempdata(' Emailerror', $this->validation->getError('email_user'), 10);
                $this->session->setTempdata('Usernamerror', $this->validation->getError('username'), 10);
                $this->session->setTempdata('Namaerror', $this->validation->getError('nama'), 10);
                $this->session->setTempdata('Passworderror', $this->validation->getError('password'), 10);
                $this->session->setTempdata('PasswordConferror', $this->validation->getError('password_sama'), 10);

                return view('/template/admin/header')
                    . view('admin/kelolaanggota', [
                        'validation' => $this->validation,
                        'session' => $this->session,
                        'title' => 'Register' . $_ENV['app.name'],
                        'db' => $this->db,
                    ]);
            } else {
                $this->adminModel->save([
                    'email' => $this->request->getVar('email_user'),
                    'nama_lengkap' => $this->request->getVar('nama'),
                    'username' => $this->request->getVar('username'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'role' => 2,
                    'is_active' => 1,
                    'date_created' => date('Y-m-d H:i:s'),

                ]);
                $this->session->setTempdata('pesanBerhasil', 'Berhasil Menambahkan User Baru', 10);
                return redirect()->to('/admin/anggota');
            }
        }
    }
    public function editUser()
    {
        if ($this->session->get('role') == 2 || $this->session->get('role') == NULL) {
            return redirect()->to('/');
        } else {
            $id = $this->request->getVar('id_user');
            $check_id =  $this->builder->where('id_user', $id);

            if ($this->adminModel->Find($id) == TRUE) {
                if (!$this->validate(
                    [
                        'edit_email_user' => [
                            'rules' => 'required|min_length[3]|is_unique[user.email.id,{id}]',
                            'errors' => [
                                'required' => 'Email wajib di isi',
                                'min_length[3]' => 'Email terlalu pendek',
                                'is_unique' => 'Email sudah ada,silahkan gunakan yang lain',
                            ],
                        ],
                        'edit_nama' => [
                            'rules' => 'required|min_length[3]|max_length[20]',
                            'errors' => [
                                'required' => 'Nama wajib di isi',
                                'min_length[3]' => 'Nama terlalu pendek',
                                'max_length[20]' => 'Nama terlalu panjang',
                            ],
                        ],

                        'edit_username' => [
                            'rules' => 'required|min_length[3]|max_length[20]|is_unique[user.username.id,{id}]',
                            'errors' => [
                                'required' => 'Username wajib di isi',
                                'min_length[3]' => 'Username terlalu pendek',
                                'max_length[20]' => 'Username terlalu panjang',
                                'is_unique' => 'Username sudah ada, silahkan gunakan yang lain',

                            ],
                        ],
                        'edit_password' => [
                            'rules' => 'required|trim|min_length[8]',
                            'errors' => [
                                'required' => 'Password wajib di isi',
                                'min_length[8]' => 'Password terlalu pendek',

                            ],
                        ],
                        'edit_password_sama' => [
                            'rules' => 'required|trim|min_length[8]|matches[password]',
                            'errors' => [
                                'required' => 'Password konfirmasi wajib di isi',
                                'min_length[8]' => 'Password terlalu pendek',
                                'matches' => 'Password tidak sama,tolong samakan password',
                            ],
                        ],
                        'edit_role' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'Role wajib di isi',

                            ],
                        ],
                        'edit_apakah_active' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'is active wajib di isi',

                            ],
                        ],
                    ]

                )) {

                    $this->session->setTempdata('Emailedit', $this->validation->getError('edit_email_user'), 10);
                    $this->session->setTempdata('Usernamedit', $this->validation->getError('edit_username'), 10);
                    $this->session->setTempdata('Namaedit', $this->validation->getError('edit_nama'), 10);
                    $this->session->setTempdata('Passwordedit', $this->validation->getError('edit_password'), 10);
                    $this->session->setTempdata('roleError', $this->validation->getError('edit_role'), 10);
                    $this->session->setTempdata('isactiveError', $this->validation->getError('edit_apakah_active'), 10);

                    return view('/template/admin/header')
                        . view('admin/kelolaanggota', [
                            'validation' => $this->validation,
                            'session' => $this->session,
                            'title' => 'Register' . $_ENV['app.name'],
                            'db' => $this->db,
                        ]);
                    $this->session->setTempdata('pesanGagal', 'Gagal Edit User', 10);
                    return redirect()->to('/admin/anggota');
                } else {
                    $this->adminModel->update($id, [
                        'email' => $this->request->getVar('edit_email_user'),
                        'nama_lengkap' => $this->request->getVar('edit_nama'),
                        'username' => $this->request->getVar('edit_username'),
                        'password' => password_hash($this->request->getVar('edit_password'), PASSWORD_DEFAULT),
                        'role' => $this->request->getVar('edit_role'),
                        'is_active' => $this->request->getVar('edit_apakah_active'),

                    ]);
                    $this->session->setTempdata('pesanBerhasil', 'Berhasil Edit User', 10);
                    return redirect()->to('/admin/anggota');
                }
            } else {
                $this->session->setTempdata('pesanGagal', 'Gagal Edit User', 10);
                return redirect()->to('/admin/anggota');
            }
        }
    }
    public function deleteUser()
    {
        if ($this->session->get('role') == 2 || $this->session->get('role') == NULL) {
            return redirect()->to('/');
        } else {
            $id = $this->request->getVar('id_user');
            if ($this->request->getVar('id_user')) {
                $this->session->setTempdata('pesanBerhasil', 'Berhasil Menghapus data', 10);
                $this->adminModel->delete($id);
                return redirect()->to('/admin/anggota');
            } else {
                $this->session->setTempdata('pesanGagal', 'Gagal Menghapus data', 10);
                return redirect()->to('/admin/anggota');
            }
        }
    }
}
