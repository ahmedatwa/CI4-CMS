<?php

namespace Admin\Models\Children;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class SchemesModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'children_scheme';
    protected $primaryKey           = 'scheme_id';
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
                'scheme_id' => $data['id'],
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_add', 'scheme_add', $eventData);
        }
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $eventData = [
                'scheme_id' => $data['id'][0],
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_update', 'scheme_edit', $eventData);
        }
    }


    // ----------------------------------------------------------------
}
