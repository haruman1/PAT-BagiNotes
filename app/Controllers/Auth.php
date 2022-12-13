<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthModel;
use CodeIgniter\I18n\Time;
use DateTime;

class Auth extends BaseController
{
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->AuthModel = new AuthModel();
        $this->builder = $this->db->table('user');
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {

        // if ($this->session->userdata('masuk') == TRUE) {
        //     $url = base_url('dashboard');
        //     redirect($url);
        // }
        // $data = [
        //     'title' => 'Login' . $_ENV['app.name'],
        // ];
        // if ($this->form_validation->run('login') == FALSE) {
        //     return view('auth/viewLogin', $data);
        // } else {
        //     $username = $this->input->getPost('username');
        //     $password = $this->input->post('password');
        //     $data = [
        //         'username' => $username,
        //         'password' => $password,
        //     ];

        //     $this->_login($data);
        // }
        // return view('auth/viewLogin', $data);
    }
    public function register()
    {
        helper('form');
        $data = [
            'title' => 'Register' . $_ENV['app.name'],
        ];
        // return view('auth/viewRegister', $data);
        // if (strtolower($this->request->getMethod()) !== 'post') {
        //     return view('auth/viewRegister', [
        //         'validation' => $this->validation,
        //         'title' => 'Register' . $_ENV['app.name'],
        //     ]);
        // }

        return view('auth/viewRegister', [
            'validation' => $this->validation,
            'title' => 'Register' . $_ENV['app.name'],
        ], $data);
        // . view('template/auth/footer');
        // $data = [
        //     'nama' => $this->request->getPost('nama_user'),
        //     'username' => $this->request->getPost('username_user'),
        //     'password' => $this->request->getPost('password_user'),
        //     'email' => $this->request->getPost('email_user'),
        //     'role' => '2',
        //     'is_active' => '0',
        //     'date_created' => $this->request->getPost('tanggal_dibuat'),
        // ];
        // $this->validation->setRule('nama_user', 'nama', 'required|min_length[3]|max_length[20]|is_unique[user.username]');
        // $this->validation->setRule('username_user', 'username', 'required|min_length[3]|max_length[20]|is_unique[user.username]');
        // $this->validation->setRule('password_user', 'password', 'required|min_length[3]|max_length[20]');
        // $this->validation->setRule('confirmation_password', 'Confirmation Password', 'required|min_length[3]|max_length[20]|matches[password_user]');
        // // $this->validation->setRule('password_user2', 'Password', 'required|min_length[3]|max_length[20]');

        // $this->validation->setRule('email_user', 'email', 'required|min_length[3]|max_length[20]|is_unique[user.email]');
        // $this->validation->setRule('tanggal_dibuat', 'tanggaldibuat', 'required|min_length[3]|max_length[20]');
        // if (!$this->validation->withRequest($this->request)->run()) {
        //     return redirect()->to('/auth/register')->withInput();
        // }
        // $this->_insert($data);
        // // $rules = [
        // //     'username' => 'required|min_length[3]|max_length[20]|is_unique[user.username]',
        // //     'password' => 'required|min_length[10]',
        // //     'passconf' => 'required|matches[password]',
        // //     'email'    => 'required|valid_email|is_unique[user.email]',
        // //     'date_created' => 'required',
        // // ];
        // // if (!$this->validate($rules)) {
        // //     return redirect()->to('/auth/register')->withInput();
        // // }
        // // return view('auth/register', $data);
    }
    public function save()
    {
        helper('form');
        // $this->validation->setRule('nama_user', 'nama', 'required|min_length[3]|max_length[20]|is_unique[user.username]');
        // $this->validation->setRule('username_user', 'username', 'required|min_length[3]|max_length[20]|is_unique[user.username]');
        // $this->validation->setRule('password_user', 'password', 'required|min_length[3]|max_length[20]');
        // $this->validation->setRule('confirmation_password', 'Confirmation Password', 'required|min_length[3]|max_length[20]|matches[password_user]');
        // // $this->validation->setRule('password_user2', 'Password', 'required|min_length[3]|max_length[20]');

        // $this->validation->setRule('email_user', 'email', 'required|min_length[3]|max_length[20]|is_unique[user.email]', [
        //     'required' => 'Email wajib di isi',
        //     'min_length' => 'Email terlalu pendek',
        //     'max_length' => 'Email terlalu panjang',
        //     'is_unique' => 'Email sudah ada,silahkan gunakan yang lain',
        // ]);

        $rules = [

            'nama_user' => [
                'rules' => 'required|min_length[3]|max_length[20]',
                'errors' => [
                    'required' => 'Nama wajib di isi',
                    'min_length[3]' => 'Nama terlalu pendek',
                    'max_length[20]' => 'Nama terlalu panjang',
                ],
            ],

            'username_user' => [
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[user.username]',
                'errors' => [
                    'required' => 'Username wajib di isi',
                    'min_length[3]' => 'Username terlalu pendek',
                    'max_length[20]' => 'Username terlalu panjang',
                    'is_unique' => 'Username sudah ada,silahkan gunakan yang lain',

                ],

                'password_user' => [
                    'rules' => 'required|trim|min_length[3]|callback_valid_password',
                    'errors' => [
                        'required' => 'Password wajib di isi',
                        'min_length[3]' => 'Password terlalu pendek',
                        'valid_password' => 'Password harus mengandung huruf kecil, huruf besar, angka, dan karakter spesial, dan tidak boleh lebih dari 15 karakter',
                    ],
                ],
                'confirmation_password' => [
                    'rules' => 'required|trim|min_length[3]|matches[password_user]|callback_valid_password',
                    'errors' => [
                        'required' => 'Password wajib di isi',
                        'min_length[3]' => 'Password terlalu pendek',
                        'valid_password' => 'Password harus mengandung huruf kecil, huruf besar, angka, dan karakter spesial, dan tidak boleh lebih dari 15 karakter',
                    ],
                ],

                'email_user' => [
                    'rules' => 'required|min_length[3]|max_length[20]|is_unique[user.email]',
                    'errors' => [
                        'required' => 'Email wajib di isi',
                        'min_length[3]' => 'Email terlalu pendek',
                        'max_length[20]' => 'Email terlalu panjang',
                        'is_unique' => 'Email sudah ada,silahkan gunakan yang lain',
                    ],
                ],

                // 'tanggal_dibuat' => 'required|min_length[3]|max_length[20]',
            ]
        ];



        //include helper form



        if ($this->validate($rules)) {

            $data = [

                'email' => $this->request->getVar('email_user'),
                'username' => htmlspecialchars($this->request->getVar('username_user')),
                'nama_lengkap' => htmlspecialchars($this->request->getVar('nama_user')),
                'password' => password_hash($this->request->getVar('password_user'), PASSWORD_DEFAULT),
                'date_created' => Time::now('Asia/Jakarta', 'id_ID'),
            ];
            $this->AuthModel->save($data);
            return redirect()->to('/login');
        } else {
            $data['validation'] = $this->validator;
            return view('auth/viewRegister', $data);
        }
    }
    public function valid_password($password = '')
    {
        $password = trim($password);

        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

        if (empty($password)) {
            $this->validation->setRule('valid_password', 'The {field} field is required.');

            return FALSE;
        }

        if (preg_match_all($regex_lowercase, $password) < 1) {
            $this->form_validation->setRule('valid_password', 'The {field} field must be at least one lowercase letter.');

            return FALSE;
        }

        if (preg_match_all($regex_uppercase, $password) < 1) {
            $this->form_validation->setRule('valid_password', 'The {field} field must be at least one uppercase letter.');

            return FALSE;
        }

        if (preg_match_all($regex_number, $password) < 1) {
            $this->form_validation->setRule('valid_password', 'The {field} field must have at least one number.');

            return FALSE;
        }

        if (preg_match_all($regex_special, $password) < 1) {
            $this->form_validation->setRule('valid_password', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));

            return FALSE;
        }

        if (strlen($password) < 5) {
            $this->form_validation->setRule('valid_password', 'The {field} field must be at least 5 characters in length.');

            return FALSE;
        }

        if (strlen($password) > 32) {
            $this->form_validation->setRule('valid_password', 'The {field} field cannot exceed 32 characters in length.');

            return FALSE;
        }

        return TRUE;
    }
    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $data = [
            'username' => $username,
            'password' => $password,
        ];
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->to('/auth/register')->withInput();
        }
        $this->_login($data);

        // $cek = $this->db->get_where('user', ['username' => $username])->row_array();
        // if ($cek->num_rows() > 0) {
        //     $data = $cek->row_array();
        //     if (password_verify($password, $data['password'])) {
        //         $this->session->set_userdata('masuk', TRUE);
        //         if ($data['role'] == '1') {
        //             $this->session->set_userdata('akses', '1');
        //             $this->session->set_userdata('ses_id', $data['id_user']);
        //             $this->session->set_userdata('ses_nama', $data['nama']);
        //             redirect('admin');
        //         } else {
        //             $this->session->set_userdata('akses', '2');
        //             $this->session->set_userdata('ses_id', $data['id_user']);
        //             $this->session->set_userdata('ses_nama', $data['nama']);
        //             redirect('user');
        //         }
        //     } else {
        //         $url = base_url('auth');
        //         echo $this->session->set_flashdata('msg', 'Username Atau Password Salah');
        //         redirect($url);
        //     }
        // } else {
        //     $url = base_url('auth');
        //     echo $this->session->set_flashdata('msg', 'Username Atau Password Salah');
        //     redirect($url);
        // }
    }
    public function _login()
    {
    }
    public function _insert($data)
    {

        $data_string = json_encode($data);
        $curl = curl_init('http://localhost:8080/api/user');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data

        // Send the request
        $result = curl_exec($curl);

        // Free up the resources $curl is using
        curl_close($curl);

        echo $result;
    }
}
