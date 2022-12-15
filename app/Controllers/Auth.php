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
        $this->session = \Config\Services::session();
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
        $active = 1;
        helper('form');
        $data = [
            'title' => 'Register' . $_ENV['app.name'],

        ];

        return view('template/auth/header') . view('auth/viewRegister', [
            'validation' => $this->validation,
            'session' => $this->session,
            'title' => 'Register' . $_ENV['app.name'],
            'waktuHabis' =>  $this->session->waktuhabis = time() - 10,
        ], $data)
            . view('template/auth/footer');
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
            'email_user' => [
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[user.email]',
                'errors' => [
                    'required' => 'Email wajib di isi',
                    'min_length[3]' => 'Email terlalu pendek',
                    'max_length[20]' => 'Email terlalu panjang',
                    'is_unique' => 'Email sudah ada,silahkan gunakan yang lain',
                ],
            ],
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
                    'is_unique' => 'Username sudah ada, silahkan gunakan yang lain',

                ],
            ],
            'password_user' => [
                'rules' => 'required|trim|min_length[3]',
                'errors' => [
                    'required' => 'Password wajib di isi',
                    'min_length[3]' => 'Password terlalu pendek',

                ],
            ],
            'confirmation_password' => [
                'rules' => 'required|trim|min_length[3]|matches[password_user]|',
                'errors' => [
                    'required' => 'Password konfirmasi wajib di isi',
                    'min_length[3]' => 'Password terlalu pendek',
                    'matches[password_user]' => 'Password harus tidak sama,tolong samakan password',
                ],
            ],



            // 'tanggal_dibuat' => 'required|min_length[3]|max_length[20]',

        ];



        //include helper form



        if ($this->validate($rules)) {

            $data = [

                'email' => htmlspecialchars($this->request->getVar('email_user')),
                'username' => htmlspecialchars($this->request->getVar('username_user')),
                'nama_lengkap' => htmlspecialchars($this->request->getVar('nama_user')),
                'password' => password_hash($this->request->getVar('password_user'), PASSWORD_DEFAULT),
                'date_created' => Time::now('Asia/Jakarta', 'id_ID'),
            ];
            $this->AuthModel->save($data);
            return redirect()->to('/login');
        } else {
            // $this->session->set('errorNama',);
            $data['validation'] = $this->validator;
            $data['session'] = $this->session;
            $this->session->setTempdata('errorEmail', $this->validation->getError('email_user'), 10);
            $this->session->setTempdata('errorUsername', $this->validation->getError('username_user'), 10);
            $this->session->setTempdata('errorNama', $this->validation->getError('nama_user'), 10);
            $this->session->setTempdata('errorPassword', $this->validation->getError('password_user'), 10);
            $this->session->setTempdata('errorPasswordConf', $this->validation->getError('confirmation_password'), 10);
            return view('template/auth/header') . view('auth/viewRegister', [
                'validation' => $this->validation,
                'session' => $this->session,
                'title' => 'Register' . $_ENV['app.name'],
                'waktuHabis' =>  $this->session->waktuhabis = time() - 10,
            ], $data)
                . view('template/auth/footer', $data);
        }
    }

    public function login()
    {
        helper('form');
        $data = [
            'title' => 'Register' . $_ENV['app.name'],
        ];
        $this->session->waktuhabis = time() - 10;

        return view('template/auth/header') . view('auth/viewLogin', [
            'validation' => $this->validation,
            'session' => $this->session,
            'title' => 'Register' . $_ENV['app.name'],
            'waktuHabis' => $this->session->waktuhabis,
        ], $data)
            . view('template/auth/footer');
    }
    public function loginSave()
    {
        $rules = [



            'username_user' => [
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[user.username]',
                'errors' => [
                    'required' => 'Username wajib di isi',
                    'min_length[3]' => 'Username terlalu pendek',
                    'max_length[20]' => 'Username terlalu panjang',
                    'is_unique' => 'Username sudah ada, silahkan gunakan yang lain',

                ],

                'password_user' => [
                    'rules' => 'required|trim|min_length[3]|callback_valid_password',
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
        helper('form');
        $data = [
            'title' => 'Register' . $_ENV['app.name'],
        ];
        $this->session->waktuhabis = time() - 10;

        return view('template/auth/header') . view('auth/viewLogin', [
            'validation' => $this->validation,
            'session' => $this->session,
            'title' => 'Register' . $_ENV['app.name'],
            'waktuHabis' => $this->session->waktuhabis,
        ], $data)
            . view('template/auth/footer');
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
