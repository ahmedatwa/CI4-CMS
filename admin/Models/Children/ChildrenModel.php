<?php

namespace Admin\Models\Children;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ChildrenModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'children';
    protected $primaryKey           = 'child_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['child_group_id', 'scheme_id', 'firstname', 'lastname', 'dob', 'status', 'image'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'int';
    protected $createdField         = 'date_added';
    protected $updatedField         = 'date_modified';
    protected $deletedField         = 'date_deleted';

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = ['afterInsert'];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = ['afterUpdate'];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    // Callbacks
    protected function afterInsert(array $data)
    {
        if (isset($data['id'])) {
            $eventData = [
                'id'            => service('user')->getID(),
                'user'          => service('user')->getuserName(),
                'chikd_id'      => $data['id'],
                'name'          => $data['data']['firstname'],
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_add', 'user_add', $eventData);
        }
        return $data;
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $eventData = [
                'id'            => service('user')->getID(),
                'user'          => service('user')->getuserName(),
                'child_id'      => $data['id'][0],
                'name'          => $data['data']['firstname'],
            ];
            
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'user_edit', $eventData);
        }
        return $data;
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

    public function getUsers(array $data = [])
    {
        $builder = $this->db->table($this->table);
        $builder->select('user_id, firstname, lastname, username, email, status, date_added');
        
        if ($this->useSoftDeletes) {
            $builder->where($this->deletedField, null);
        }

        if (isset($data['filterName']) && !empty($data['filterName'])) {
            $builder->like('username', $data['filterName'], 'after');
        }

        if (isset($data['filterEmail']) && !empty($data['filterEmail'])) {
            $builder->like('email', $data['filterEmail'], 'after');
        }

        if (isset($data['filterStatus'])) {
            $builder->where('status', (int) $data['filterStatus']);
        }

        if (!empty($data['filterDateAdded'])) {
            $builder->like('date_added', $data['filterDateAdded'], 'after');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalUsers(array $data = [])
    {
        $builder = $this->db->table($this->table);

        if ($this->useSoftDeletes) {
            $builder->where($this->deletedField, null);
        }

        if (isset($data['filterName']) && !empty($data['filterName'])) {
            $builder->like('username', $data['filterName'], 'after');
        }

        if (isset($data['filterEmail']) && !empty($data['filterEmail'])) {
            $builder->like('email', $data['filterEmail'], 'after');
        }

        if (isset($data['filterStatus'])) {
            $builder->where('status', (int) $data['filterStatus']);
        }

        if (!empty($data['filterDateAdded'])) {
            $builder->like('date_added', $data['filterDateAdded'], 'after');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        return $builder->countAllResults();
    }



    // ----------------------------------------------------------------
}
