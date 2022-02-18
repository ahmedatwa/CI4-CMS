<?php

namespace Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class Setting extends Migration
{
    protected $table = 'setting';
    protected $primaryKey = 'setting_id';

    public function up()
    {
        $this->forge->addField([
            'setting_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'auto_increment' => true,
            ],
            'site_id' => [
                'type'       => 'INT',
                'constraint' => '11',
                'default'    => 0
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
            ],
            'value' => [
                'type'       => 'TEXT',
            ],
            'serialized' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
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
