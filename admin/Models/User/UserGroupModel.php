<?php

namespace Admin\Models\User;

use CodeIgniter\Model;

class UserGroupModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'user_group';
    protected $primaryKey           = 'user_group_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['name', 'permission'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'int';
    protected $createdField         = 'date_added';
    protected $updatedField         = 'date_modified';
    protected $deletedField         = '';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = ['encodeData'];
    protected $afterInsert          = ['afterInsert'];
    protected $beforeUpdate         = ['encodeData'];
    protected $afterUpdate          = ['afterUpdate'];
    protected $beforeFind           = [];
    protected $afterFind            = ['decodeData'];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    protected function decodeData(array $data)
    {
        if (isset($data['data']['permission'])) {
            $data['data']['permission'] = json_decode($data['data']['permission'], true);
        }
        return $data;
    }

    protected function encodeData(array $data)
    {
        if (isset($data['data']['permission'])) {
            $data['data']['permission'] = json_encode($data['data']['permission']);
        }

        return $data;
    }

    protected function afterInsert(array $data)
    {
        if (isset($data['id'])) {
            $eventData = [
                'user_group_id' => $data['id'],
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_add', 'user_group_add', $eventData);
        }
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $eventData = [
                'user_group_id' => $data['id'][0],
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'user_group_edit', $eventData);
        }
    }

    public function addPermission(int $user_group_id, string $type, string $route)
    {
        $builder = $this->db->table($this->table);
        $builder->distinct();
        if ($builder->countAllResults() > 0) {
            $builder->where('user_group_id', $user_group_id);
            $row = $builder->get()
                           ->getRowArray();
            $data = json_decode($row['permission'], true);

            $data[$type][] = $route;
            
            $builder->set('permission', json_encode($data))
                    ->where('user_group_id', $user_group_id)
                    ->update();
        }
    }

    public function getUserGroup(int $user_group_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('user_group_id', $user_group_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        $user_group = [
             'name'       => $row['name'],
             'permission' => json_decode($row['permission'], true),
        ];
        return $user_group;
    }


    // --------------------------------------
}
