<?php 

namespace Shared\Models\Setting;

use CodeIgniter\Model;

class EventsModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'event';
    protected $primaryKey           = 'event_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';  
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['code', 'action', 'status', 'priority'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'int';
    protected $createdField         = 'date_added';
    protected $updatedField         = '';
    protected $deletedField         = 'date_deleted';

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = ['afterUpdate'];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    // Callbacks
    protected function afterUpdate(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $eventData = [
                'event_id' => $data['id'][0],
                'status'   => $data['data']['status']
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_update', 'user_edit', $eventData);
        }
        return $data;
    }

    public function install(string $type, string $code)
    {    
        $builder = $this->db->table($this->table);
        if (!in_array($code, $this->getInstalled($type))) {
            $data = array(
                'type' => $type,
                'code' => $code
            );
            $builder->insert($data, TRUE);
        }
        
    }

    public function uninstall($type, $code)
    {
        $extension = $this->db->table($this->table);
        $extension->delete(['type' => $type, 'code' => $code]);
        $setting = $this->db->table('setting');
        $setting->delete(['code' => $type . '_' . $code]);
    }

    public function addExtensionInstall()
    {
    }

    // ----------------------------------------------------
}