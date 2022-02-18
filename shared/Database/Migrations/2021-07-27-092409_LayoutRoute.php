<?php

namespace Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class LayoutRoute extends Migration
{
    protected $table = 'layout_route';
    protected $primaryKey = 'layout_route_id';

    public function up()
    {
        $this->forge->addField([
        'layout_route_id' => [
            'type'           => 'INT',
            'constraint'     => 11,
            'unsigned'       => false,
            'auto_increment' => false,
            ],
        'layout_id' => [
            'type'       => 'INT',
            'constraint' => '11',
            ],
        'site_id' => [
            'type'       => 'INT',
			'constraint' => '11',
            ],
        'route' => [
            'type'       => 'VARCHAR',
			'constraint' => '64',
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