<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 180
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
