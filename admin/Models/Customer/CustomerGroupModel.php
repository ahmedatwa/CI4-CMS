<?php

namespace Admin\Models\Customer;

use CodeIgniter\Model;

class CustomerGroupModel extends Model
{
    protected $table            = 'customer_group';
    protected $primaryKey       = 'customer_group_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';
    protected $deletedField  = '';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = ['afterInsert'];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = ['afterUpdate'];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Callbaks
    protected function afterInsert(array $data)
    {
        if (isset($data['id'])) {
            $eventData = [
                'customer_group_id' => $data['id'],
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_add', 'customer_group_add', $eventData);
        }
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $eventData = [
                'customer_group_id' => $data['id'][0]
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'customer_group_edit', $eventData);
        }
    }



    // -----------------------------------------------------------------
}
