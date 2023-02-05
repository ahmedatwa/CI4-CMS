<?php

namespace Shared\Models\Tool;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class OnlineModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customer_online';
    protected $primaryKey       = 'ip';
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
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function addOnline(string $ip, int $customer_id, string $url, string $referer)
    {
        $time = Time::now()->subHours(1);
        $builder = $this->db->table($this->table);
        $builder->where('date_added < ', date('Y-m-d H:i:s', strtotime('-1 hour')));
        $builder->delete();

        $onlineData = [
            'ip'          => $ip,
            'customer_id' => $customer_id,
            'url'         => $url,
            'referer'     => $referer,
            'date_added'  => Time::now()->getTimestamp(),
        ];
        $builder->replace($onlineData);
    }


    // --------------------------------------------
}
