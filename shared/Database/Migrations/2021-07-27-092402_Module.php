<?php

namespace Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class Module extends Migration
{
    protected $table = 'module';
    protected $primaryKey = 'module_id';

    public function up()
    {
        $this->forge->addField([
        'module_id' => [
            'type'           => 'INT',
            'constraint'     => 11,
            'unsigned'       => false,
            'auto_increment' => true,
            ],
        'name' => [
            'type'       => 'VARCHAR',
            'constraint' => '64',
            ],
        'code' => [
            'type'       => 'VARCHAR',
			'constraint' => '32',
            ],
        'setting' => [
            'type'     => 'TEXT',
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
