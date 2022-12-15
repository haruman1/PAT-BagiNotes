<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Trendingbook extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_buku' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'judulbuku' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'textbuku' => [
                'type' => 'text',

            ],
            'author' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],

            'file_buku' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'stok' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
            ],
            'cover_buku' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'tanggal_pinjam' => [
                'type' => 'datetime',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('id_buku');
        $this->forge->addForeignKey('id_buku', 'bukutersedia', 'id_buku');
        $this->forge->createTable('trendingbook', true);
    }

    public function down()
    {
        $this->forge->dropTable('trendingbook');
    }
}
