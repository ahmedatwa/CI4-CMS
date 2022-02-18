<?php 

namespace Admin\Models\Customer;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customer';
    protected $primaryKey       = 'customer_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['firstname', 'lastname', 'username', 'email', 'telephone', 'password', 'status', 'customer_group_id', 'newsletter'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';
    protected $deletedField  = 'date_deleted';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = ['afterInsert'];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = ['afterUpdate'];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['afterDelete'];

    // Callbaks
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }

        return $data;
    }

    protected function afterInsert(array $data)
    {
        if (isset($data['id'])) {
            $eventData = [
                'customer_id' => (int) $data['id'],
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_add', 'customer_add', $eventData);
        }
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['id'])) {
            $eventData = [
                'customer_id' => (int) $data['id'][0]
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'customer_edit', $eventData);
        }
    }

    protected function afterDelete(array $data)
    {
        if (isset($data['id'])) {
            $customer_activity = $this->db->table('customer_activity');
            $customer_activity->delete(['customer_id' => $data['id']]);
            $customer_online = $this->db->table('customer_online');
            $customer_online->delete(['customer_id' => $data['id']]);
            // register event
            $eventData = ['customer_id' => $data['id']];

            \CodeIgniter\Events\Events::trigger('customer_activity_delete', 'customer_delete', $eventData);
        }
    }

    // -----------------------------------------------------------------
}
