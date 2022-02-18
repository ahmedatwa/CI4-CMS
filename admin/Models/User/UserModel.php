<?php

namespace Admin\Models\User;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'user';
    protected $primaryKey           = 'user_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['user_group_id', 'username', 'firstname', 'lastname', 'email', 'password', 'status', 'code', 'salt', 'image'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'int';
    protected $createdField         = 'date_added';
    protected $updatedField         = 'date_modified';
    protected $deletedField         = 'date_deleted';

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = ['hashPassword'];
    protected $afterInsert          = ['afterInsert'];
    protected $beforeUpdate         = ['hashPassword'];
    protected $afterUpdate          = ['afterUpdate'];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    // Callbaks
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }

        if (isset($data['data']['firstname']) && !empty($data['data']['lastname'])) {
            $data['data']['username'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
        }

        return $data;
    }

    protected function afterInsert(array $data)
    {
        if (isset($data['id'])) {
            $eventData = [
                'user_id'  => $data['id'],
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_add', 'user_add', $eventData);
        }
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $eventData = [
                'user_id'  => $data['id'][0],
            ];
            
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'user_edit', $eventData);
        }
    }

    public function findUser(int $user_id): array
    {
        $builder = $this->db->table('user u');
        return $builder->select('u.firstname, u.lastname, u.email, ug.name as usergroup, u.image')
                       ->join('user_group ug', 'u.user_group_id = ug.user_group_id', 'left')
                       ->where('u.user_id', $user_id)
                       ->get()
                       ->getRowArray();
    }

    // Forget Passowrd functions
    public function getTotalUsersByEmail(string $email)
    {
        $builder = $this->db->table($this->table);
        return $builder->select('user_id')
                ->where('email', $email)
                ->countAllResults();
    }

    public function editCode(string $email, string $code)
    {
        $builder = $this->db->table($this->table);
        $builder->set('code', $code)
                ->where('email', $email)
                ->update();
    }

    // ----------------------------------------------------------------
}
