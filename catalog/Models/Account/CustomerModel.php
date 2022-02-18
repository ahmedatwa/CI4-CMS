<?php

namespace Catalog\Models\Account;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class CustomerModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customer';
    protected $primaryKey       = 'customer_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['customer_group_id', 'firstname', 'lastname', 'username', 'email', 'password', 'ip', 'status', 'image', 'newsletter', 'two_step'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';
    protected $deletedField  = 'date_deleted';
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = ['afterUpdate'];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function beforeInsert(array $data = [])
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);  
            unset($data['data']['confirm']);
        } else {
            unset($data['data']['password']);
            unset($data['data']['confirm']);
        }

        if (!isset($data['data']['username'])) {
            $data['data']['username'] = substr($data['data']['email'], 0, strpos($data['data']['email'], '@'));
        }

        if (!isset($data['data']['ip']) && !isset($data['data']['status'])) {
            $data['data']['ip']     = service('request')->getIPAddress();
            $data['data']['status'] = 1;
        }

        return $data;
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['id'])) {
            \CodeIgniter\Events\Events::trigger('customer_update', $data['id'][0]);
        }
        return $data;
    }

    // Login Attempts
    public function addLoginAttempt(string $email, $ipAddress)
    {
        $builder = $this->db->table('customer_login');
        
        $builder->select();
        $builder->where('email', $email);

        if ($builder->countAllResults() != 0) {
            $builder->set('total', 'total + 1', false);
            $builder->set('date_modified', Time::now()->getTimestamp());
            $builder->update();
        } else {
            $data = [
                'email'      => $email,
                'ip'         => $ipAddress,
                'total'      => '1',
                'date_added' => Time::now()->getTimestamp()
            ];
            $builder->set($data);
            $builder->insert($data);
        }
    }

    public function getLoginAttempts(string $email)
    {
        $builder = $this->db->table('customer_login');
        $builder->where('email', $email);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function deleteLoginAttempts(string $email)
    {
        $builder = $this->db->table('customer_login');
        $builder->delete(['email' => $email]);
    }

    public function getCustomerProfileView(int $customer_id)
    {
        $builder = $this->db->table('customer');
        $builder->select('viewed');
        $builder->where('customer_id', $customer_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        return $row['viewed'];
    }

    // Forgotten Password
    public function editCode($email, $code)
    {
        $builder = $this->db->table($this->table);
        $builder->where('email', $email);
        $builder->set('code', $code);
        $builder->update();
        // trigger forgotton email event
        \CodeIgniter\Events\Events::trigger('mail_forgotten', $email, $code);
    }

    public function editPassword(string $email, $password)
    {
        $builder = $this->db->table($this->table);
        $builder->where('email', $email);
        $builder->set('password', password_hash($password, PASSWORD_DEFAULT));
        $builder->update();
    }

    public function getCustomerByCode(string $code)
    {
        if ($code && (! empty($code))) {
            $builder = $this->db->table($this->table);
            $builder->select('customer_id, firstname, lastname, email, date_modified');
            $builder->where('code', $code);
            $query = $builder->get();
            return $query->getRowArray();
        }
        return false;
    }


    public function getTotalCustomersByEmail(string $email)
    {
        $builder = $this->db->table($this->table);
        $builder->where('email', $email);
        return $builder->countAllResults();
    }



    // -----------------------------------------------------------------
}
