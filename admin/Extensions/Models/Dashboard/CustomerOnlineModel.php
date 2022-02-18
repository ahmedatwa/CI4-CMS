<?php

namespace Extensions\Models\Dashboard;

use CodeIgniter\Model;

class CustomerOnlineModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customer_online';
    protected $primaryKey       = 'customer_online_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['ip', 'customer_id', 'url', 'referer'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getTotalOnline()
    {
        $builder = $this->db->table($this->table);
        return $builder->countAll();
    }

    public function up()
    {
        $forge = \Config\Database::forge();
        $forge->addField([
            'customer_online_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'auto_increment' => true,
            ],
            'ip' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'null'       => false,
            ],
            'customer_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'url' => [
                'type' => 'TEXT',
            ],           
            'referer' => [
                'type' => 'TEXT',
            ],
            'date_added' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
                'default'  => 0
            ],
        ]);

        $forge->addKey($this->primaryKey, true);
        $forge->createTable($this->table, true);
    }
    
    public function down()
    {
        $forge = \Config\Database::forge();
        $forge->dropTable($this->table, true);
    }

    // ----------------------------------------------------------
}
