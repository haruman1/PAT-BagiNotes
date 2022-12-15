<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransaksibukuModel;

class SemuaTrigger extends BaseController
{
    public function __construct()
    {
        $this->tbModel = new transaksibukuModel();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        //
    }
    public function TriggerUser()
    {

        // $query['delete_user'] = $this->dbUser->query("CREATE TRIGGER `log_delete_user` BEFORE UPDATE ON user " .
        //     "FOR EACH ROW begin" .
        //     "INSERT INTO log_user(id_user,nama_user,email_user,waktu_terdaftar,keterangan)
        // VALUES (Old.id_user, old.nama, old.email,NOW(),'Hapus data user';" .
        //     "END");
        // $query['insert_user'] = $this->dbUser->query('CREATE TRIGGER log_insert_user AFTER INSERT ON user FOR EACH ROW begin
        // INSERT INTO log_user(id_user,nama_user,email_user,waktu_terdaftar,keterangan)
        // VALUES (NEW.id_user, NEW.nama, NEW.email,NOW(), "insert data user baru");
        // END');
        // return $query;
        $query = $this->tbModel->transaksiTrigger();
        $berhasil =   print_r($this->db->error());
        // return view('trigger/berhasil', $berhasil);
    }
    public function transaksiTrigger()
    {
        $query =  $this->dbTransaksi->query('CREATE TRIGGER `transaksi_insert` AFTER INSERT ON `transaksibuku` FOR EACH ROW BEGIN
        INSERT INTO mybook(id_buku, judulbuku,file_buku)
        VALUES(NEW.id_buku, NEW.judulbuku,new.file_buku);
        END');
        $query = $this->dbTransaksi->query('CREATE TRIGGER `update_stok` AFTER INSERT ON `transaksibuku` FOR EACH ROW BEGIN
        UPDATE hlmnbuku SET stok = stok - 1 WHERE id_buku = NEW.id_buku;
        END');
        return view('trigger/berhasil', $query);
    }
}
