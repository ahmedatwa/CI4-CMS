<?php

namespace Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sessions extends Migration
{
    protected $table = 'sessions';
    protected $primaryKey = 'id';

    public function up()
    {
        $this->forge->addField([
        'id' => [
            'type'           => 'VARCHAR',
            'constraint'     => 128,
            'unsigned'       => false,
            'auto_increment' => false,
            ],
        'ip_address' => [
            'type'       => 'VARCHAR',
            'constraint' => '45',
            ],
        'timestamp' => [
            'type'       => 'INT',
            ],
        'data' => [
            'type'     => 'BLOB',
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
