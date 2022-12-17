<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mybook extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_buku' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'judulbuku' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'filebuku' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'id_user' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],

        ]);

        $this->forge->addKey('id', true);

        $this->forge->addUniqueKey('id_user');
        $this->forge->addUniqueKey('id_buku');
        $this->forge->addUniqueKey('id');
        $this->forge->addForeignKey('id_user', 'User', 'id_user');
        $this->forge->addForeignKey('id_buku', 'bukutersedia', 'id_buku');

        $this->forge->createTable('mybook', true);
    }

    public function down()
    {
        $this->forge->dropTable('mybook');
    }
}
