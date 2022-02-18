<?php

namespace Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserGroup extends Migration
{
    protected $table = 'user_group';
    protected $primaryKey = 'user_group_id';

    public function up()
    {
        $this->forge->addField([
            'user_group_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'auto_increment' => true,
                ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                ],
            'permission' => [
                    'type'       => 'TEXT',
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
    ]);
        $this->forge->addKey($this->primaryKey, true);
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
