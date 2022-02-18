<?php

namespace Admin\Models\Children;

use CodeIgniter\Model;

class ChildrenGroupModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'children_group';
    protected $primaryKey           = 'child_group_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['name', 'description'];

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
    protected $beforeInsert         = [];
    protected $afterInsert          = ['afterInsert'];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = ['afterUpdate'];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    protected function afterInsert(array $data)
    {
        if (isset($data['id'])) {
            $eventData = [
                'child_group_id' => (int) $data['id'],
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_add', 'child_group_add', $eventData);
        }
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['id'])) {
            $eventData = [
                'child_group_id' => (int) $data['id'][0],
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'child_group_edit', $eventData);
        }
    }

    // --------------------------------------
}
