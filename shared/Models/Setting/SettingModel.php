<?php

namespace Shared\Models\Setting;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'setting';
    protected $primaryKey           = 'setting_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = false;
    protected $allowedFields        = ['site_id', 'code', 'key', 'value', 'serialized'];
    protected $data = [];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'int';
    protected $createdField         = '';
    protected $updatedField         = '';
    protected $deletedField         = '';

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = ['afterFind'];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    // Callbacks
    protected function afterFind(array $data)
    {
        $setting_data = [];
        
        if (! isset($data['data'])) {
            return $data;
        }

        foreach ($data['data'] as $result) {
            if (! $result['serialized']) {
                $setting_data[$result['key']] = $result['value'];
            } else {
                $setting_data[$result['key']] = json_decode($result['value'], true);
            }
        }
        unset($data['data']);
        $data['data'] = $setting_data;
        return $data;
    }

    public function editSetting(string $code, array $data = [], int $site_id = 0)
    {
        $builder = $this->db->table($this->table);
        $builder->delete([
            'site_id' => $site_id,
            'code'    => $code
        ]);

        foreach ($data as $k => $v) {
            if (substr($k, 0, strlen($code)) == $code) {
                $settingData = [
                    'site_id'    => $site_id,
                    'code'       => $code,
                    'key'        => $k,
                    'value'      => (is_array($v)) ? json_encode($v) : $v,
                    'serialized' => (is_array($v)) ? 1 : 0,
                ];
                $builder->insert($settingData, true);
            }
        }
    }
    
    public function editValue(string $code = '', string $name = '', $setting = '', int $site_id = 0): void
    {
        if (!is_array($name)) {
            $builder = $this->db->table($this->table);
            $data = [
                'setting' => $setting,
                'serialized' => 0,
            ];

            $builder->set($data)
                    ->where([
                        'code'    => $code,
                        'name'    => $name,
                        'site_id' => $site_id
                    ])->update();
        } else {
            $builder->set($data)
                    ->where([
                        'code'    => $code,
                        'name'    => $name,
                        'site_id' => $site_id
                    ])->update();
        }
    }


    // ----------------------------------------------------
}
