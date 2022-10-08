<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ovo extends Migration
{
    public function up()
    {
        // id, account_number, account_name, access_token
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'account_number' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'unique' => true,
            ],
            'account_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'access_token' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ovo');
    }

    public function down()
    {
        $this->forge->dropTable('ovo');
    }
}
