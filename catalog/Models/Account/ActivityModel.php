<?php

namespace Catalog\Models\Account;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ActivityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customer_activity';
    protected $tableIp          = 'customer_ip';
    protected $primaryKey       = 'customer_activity_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['customer_id', 'key', 'data', 'ip', 'user_agent'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = '';
    protected $deletedField  = '';
    // Callbacks
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function addActivity(string $key, array $data)
    {
        $builder = $this->db->table($this->table);
        $activity_data = [
            'customer_id' => $data['customer_id'],
            'key'         => $key,
            'data'        => json_encode($data),
            'ip'          => $data['ip'],
            'user_agent'  => $data['user_agent'],
            'date_added'  => Time::now()->getTimestamp()
        ];
        $builder->insert($activity_data);
    }

    public function getActivitiesByCustomerID(array $data = [])
    {
        $builder = $this->db->table($this->table);
        $builder->select('customer_id, data, key, date_added');
        if (isset($data['customer_id'])) {
           $builder->where([
            'seen' => 0,
            'customer_id' => $data['customer_id']
        ]);
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 10;
            }
            $builder->limit($data['limit'], $data['start']);
        }
        
        $builder->orderBy('date_added', 'DESC');
        $builder->notLike('key', 'admin_', 'both');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalActivitiesByCustomerID(array $data = [])
    {
        $builder = $this->db->table($this->table);
        $builder->distinct();
        if (isset($data['customer_id'])) {
           $builder->where([
            'seen' => 0,
            'customer_id' => $data['customer_id']
        ]);
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 10;
            }
            $builder->limit($data['limit'], $data['start']);
        }
        
        $builder->orderBy('date_added', 'DESC');
        $builder->notLike('key', 'admin_', 'both');
        return $builder->countAllResults();
    }

    public function addCustomerIP(array $data)
    {
        $builder = $this->db->table($this->tableIp);
        $ip_data = [
            'customer_id'   => $data['customer_id'],
            'ip'            => \Config\Services::request()->getIPAddress(),
            'user_agent'    => \Config\Services::request()->getUserAgent(),
            'date_added'    => Time::now()->getTimestamp()
        ];
        $builder->insert($ip_data);
    }

    public function getCustomerIP(int $customer_id)
    {
        $builder = $this->db->table($this->tableIp);
        $builder->where('customer_id', $customer_id);
        $query = $builder->get();
        if ($builder->countAllResults()) {
            return $query->getRowArray();
        } else {
            return;
        }
    }

    // ---------------------------------------------
}
