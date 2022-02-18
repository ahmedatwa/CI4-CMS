<?php

namespace Extensions\Models\Report;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class UserActivityModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'user_activity';
    protected $primaryKey           = 'activity_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['user_id', 'key', 'data', 'ip', 'user_agent'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'int';
    protected $createdField         = 'date_added';
    protected $updatedField         = 'date_modified';
    protected $deletedField         = '';

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = ['afterFind'];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    protected function afterFind(array $data)
    {
        if (empty($data['data'])) {
            return $data;
        }

        if (isset($data['data'])) {
            if (is_array($data['data'][array_key_first($data['data'])])) {
                foreach ($data['data'] as $key => $result) {
                    $data['data'][$key]['data'] = json_decode($result['data'], true);
                }
            } else {
                $data['data']['data'] = json_decode($data['data']['data'], true);
            }
        }

        return $data;
    }

    public function addActivity(string $key, array $data)
    {
        $builder = $this->db->table($this->table);
        $activity_data = [
            'user_id'    => $data['user_id'],
            'key'        => $key,
            'data'       => json_encode($data),
            'ip'         => $data['ip'],
            'user_agent' => $data['user_agent'],
            'date_added' => Time::now()->getTimestamp()
        ];
        $builder->insert($activity_data);
    }

    public function up()
    {
        $forge = \Config\Database::forge();
        $forge->addField([
            'activity_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => false,
            ],
            'data' => [
                'type' => 'TEXT',
            ],
            'ip' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'null'       => false,
            ],
            'user_agent' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
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

    // ----------------------------------------------------------------
}
