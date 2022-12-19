<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user'          => [
                'type'           => 'INT',
                'constraint'     => 15,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_lengkap'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' =>
            [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'role' => [
                'type' => 'text',
                'default' => '2', // 1 = admin, 2 = user
            ],
            'is_active' => [
                'type' => 'text',
                'default' => '1', // 0 = nonaktif, 1 = aktif
            ],
            'date_created' => [
                'type' => 'INT',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('id_user');
        $this->forge->addUniqueKey('username');

        $this->forge->createTable('user', true);
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
