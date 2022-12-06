<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class HandlerLogin extends ResourceController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->Auth = new AuthModel();
        $this->builder = $this->db->table('user');
        $this->validation = \Config\Services::validation();
    }
    use ResponseTrait;
    // get all product
    public function index()
    {
        $data =  $this->Auth->findAll();
        return $this->respond($data, 200);
    }

    // get single product
    public function show($id = null)
    {
        $data =  $this->builder->getWhere(['id_user' => $id])->getResult();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    // create a product
    public function create()
    {

        $data = [
            'nama' => $this->request->getPost('nama_user'),
            'username' => $this->request->getPost('username_user'),
            'password' => $this->request->getPost('password_user'),
            'email' => $this->request->getPost('email_user'),
            'role' => '2',
            'is_active' => '0',
            'date_created' => date('Y-m-d H:i:s'),

        ];
        $data = json_decode(file_get_contents("php://input"));
        //$data = $this->request->getPost();
        $this->Auth->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];

        return $this->respondCreated($data, 201);
    }

    // update product
    public function update($id = null)
    {

        $json = $this->request->getJSON();
        if ($json) {
            $data = [
                'product_name' => $json->product_name,
                'product_price' => $json->product_price
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'product_name' => $input['product_name'],
                'product_price' => $input['product_price']
            ];
        }
        // Insert to Database
        $this->Auth->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
        return $this->respond($response);
    }

    // delete product
    public function delete($id = null)
    {

        $data =  $this->Auth->find($id);
        if ($data) {
            $this->Auth->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }
}
