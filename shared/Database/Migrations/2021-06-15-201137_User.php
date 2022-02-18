<?php

namespace Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';

    public function up()
    {
        $this->forge->addField([
                'user_id' => [
                        'type'           => 'INT',
                        'constraint'     => 11,
                        'unsigned'       => false,
                        'auto_increment' => true,
                ],
                'user_group_id'      => [
                        'type'       => 'TINYINT',
                        'constraint' => '1',
                ],
                'username' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 20,
                        'null'       => false,
                ],
                'firstname' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 64,
                        'null'       => false,
                ],
                'lastname' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 64,
                        'null'       => false,
                ],
                'email' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 128,
                        'null'       => false,
                ],
                'password' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 255,
                        'null'       => false,
                ],
                'salt' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 9,
                        'null'       => false,
                ],
                'status' => [
                        'type'       => 'TINYINT',
                        'constraint' => 1,
                        'null'       => false,
                ],
                'image' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 255,
                        'null'       => true,
                ],
                'code' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 40,
                        'null'       => false,
                ],
                'date_added' => [
                        'type'     => 'INT',
                        'unsigned' => true,
                        'null'     => false,
                        'default'  => 0
                ],
                'date_modified' => [
                        'type'     => 'INT',
                        'unsigned' => true,
                        'null'     => false,
                        'default'  => 0
                ],
                'date_deleted' => [
                        'type'     => 'INT',
                        'unsigned' => true,
                        'null'     => true,
                ],
        ]);
        $this->forge->addKey($this->primaryKey, true);
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }

    // --------------------------------------------
}
