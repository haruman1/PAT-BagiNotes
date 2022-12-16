<?php

namespace App\Models;

use CodeIgniter\Model;

class SemuaTriggerModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'semuatriggers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    public function log_insert_user()
    {
        $query = $this->db->query('CREATE TRIGGER log_insert_user AFTER INSERT ON User FOR EACH ROW begin
        INSERT INTO log_user(id_user,nama_user,email_user,waktu_terdaftar,keterangan)
        VALUES (NEW.id_user, NEW.nama_lengkap, NEW.email, NOW(), "insert data user baru");
        END');
        return $query;
    }
    public function log_update_user()
    {
        $query = $this->db->query('CREATE TRIGGER log_update_user AFTER UPDATE ON User FOR EACH ROW begin
        INSERT INTO log_user(id_user,nama_user,email_user,waktu_terdaftar,keterangan)
        VALUES (NEW.id_user, NEW.nama_lengkap, NEW.email, NOW(), "update data user baru");
        END');
        return $query;
    }
    public function transaksi_insert()
    {
        $query = $this->db->query('CREATE TRIGGER `transaksi_insert` AFTER INSERT ON `transaksibuku` FOR EACH ROW BEGIN
        INSERT INTO mybook(id_buku, judulbuku,file_buku)
        VALUES(NEW.id_buku, NEW.judulbuku,new.file_buku);
        END');
        return $query;
    }
    public function procedureCreateUser()
    {
        $query = $this->db->query('CREATE PROCEDURE `createUser`(IN `id_user` VARCHAR(255), IN `nama_user` VARCHAR(255), IN `username_user` VARCHAR(255), IN `email_user` VARCHAR(100), IN `password_user` VARCHAR(100), IN `role_user` INT(2), IN `is_active_user` INT(5), IN `date_created` INT(100))
        BEGIN
        INSERT INTO User(id_user,nama_lengkap, username, email, password,role,is_active,date_created)
        VALUES(id_user, nama_user,username_user,email_user, password_user,role_user,is_active_user,date_created);
        END');

        return $query;
    }
    public function trigger_hapus_buku()
    {
        $query = $this->db->query('CREATE TRIGGER `trigger_hapus_buku` AFTER DELETE ON `hlmnbuku` FOR EACH 
        ROW BEGIN
        INSERT INTO log_buku (keterangan, waktu, id_buku, id_user, judul_buku)
        VALUES("Menghapus buku", NOW(), OLD.id_buku, OLD.id_user, OLD.judul_buku);
        END');
        return $query;
    }
    public function trigger_penambahan_buku()
    {
        $query = $this->db->query('CREATE TRIGGER `trigger_penambahan_buku` AFTER INSERT ON `hlmnbuku` FOR EACH 
        ROW BEGIN
        INSERT INTO log_buku (keterangan, waktu, id_buku, id_user, judul_buku)
        VALUES("Menambah buku", NOW(), NEW.id_buku, NEW.id_user, NEW.judul_buku);
        END');
        return $query;
    }
    public function trigger_perubahan_buku()
    {
        $query = $this->db->query('CREATE TRIGGER `trigger_perubahan_buku` AFTER UPDATE ON `hlmnbuku` FOR EACH 
        ROW BEGIN
        INSERT INTO log_buku (keterangan, waktu, id_buku, id_user, judul_buku)
        VALUES("Menambah buku", NOW(), NEW.id_buku, NEW.id_user, NEW.judul_buku);
        END');
        return $query;
    }
}