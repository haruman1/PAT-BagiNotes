<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SemuaTriggerModel;

class SemuaTrigger extends BaseController
{
    public function __construct()
    {
        $this->sModel = new SemuaTriggerModel();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        //
    }
    public function TriggerInsertUser()
    {
        $this->sModel->log_insert_user();
        $berhasil =   print_r($this->db->error());
    }
    public function transaksi_insert_Trigger()
    {
        $this->sModel->transaksi_insert();
        $berhasil =   print_r($this->db->error());
    }
    public function procedureCreateUser()
    {
        $this->sModel->procedureCreateUser();
        $berhasil =   print_r($this->db->error());
    }
    public function trigger_hapus_buku()
    {
        $this->sModel->trigger_hapus_buku();
        $berhasil =   print_r($this->db->error());
    }
}
