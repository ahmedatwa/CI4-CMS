<?php

namespace Shared\Models\Design;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class TranslationModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'translation';
    protected $primaryKey           = 'translation_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['site_id', 'language_id', 'route', 'key', 'value'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'int';
    protected $createdField         = 'date_added';
    protected $updatedField         = '';
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
    protected $afterDelete          = ['afterDelete'];

    // Callbacks
    protected function afterInsert(array $data)
    {
        if (isset($data['id'])) {
            $eventData = [
                'translation_id' => $data['id'],
                'route'          => $data['data']['route'],
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_add', 'add', $eventData);
        }
        return $data;
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $eventData = [
                'username'   => $data['data']['username'],
                'user_id' => $data['id'][0]
            ];
            
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'edit', $eventData);
        }
        return $data;
    }

    protected function afterDelete(array $data)
    {
        if (isset($data['id'][0])) {
            $banner_image_table = $this->db->table('banner_image');
            $banner_image_table->delete([
                'banner_id' => $data['id'][0]
            ]);
        }
    }
    
    // -----------------------------------------------------------
}
