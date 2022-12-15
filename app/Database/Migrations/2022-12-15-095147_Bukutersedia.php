<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bukutersedia extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 15,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_buku'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',

            ],
            'id_buku' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'stock' => [
                'type' => 'int',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nama_buku');
        $this->forge->addUniqueKey('id_buku');
        $this->forge->createTable('bukutersedia', true);
    }

    public function down()
    {
        $this->forge->dropTable('bukutersedia');
    }
}
