<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisBuku extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_nomor'          => [
                'type'           => 'INT',
                'constraint'     => 15,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_jenisBuku' => [
                'type' => 'VARCHAR',
                'constraint' => '255',

            ],
            'id_buku' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id_nomor', true);
        $this->forge->addUniqueKey('id_buku');
        $this->forge->addUniqueKey('id_nomor');
        $this->forge->addUniqueKey('nama_jenisBuku');
        $this->forge->addForeignKey('id_buku', 'bukutersedia', 'id_buku');

        $this->forge->createTable('jenis_buku', true);
    }

    public function down()
    {
        $this->forge->dropTable('jenis_buku');
    }
}
