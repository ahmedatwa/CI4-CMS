<?php

namespace Shared\Models\Setting;

use CodeIgniter\Model;

class ExtensionModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'extension';
    protected $primaryKey           = 'extension_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = false;
    protected $allowedFields        = ['type', 'code'];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'int';
    protected $createdField         = '';
    protected $updatedField         = '';
    protected $deletedField         = '';

    // Callbacks
    protected $allowCallbacks       = false;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    public function getInstalled(string $type)
    {
        $extension_data = [];
        $builder = $this->db->table($this->table);
        $query = $builder->select()
                         ->where('type', $type)
                         ->orderBy('code')
                         ->get();

        foreach ($query->getResultArray() as $result) {
            $extension_data[] = $result['code'];
        }
        return $extension_data;
    }

    public function install(string $type, string $code)
    {
        $builder = $this->db->table($this->table);
        if (!in_array($code, $this->getInstalled($type))) {
            $builder->set([
                'type' => $type,
                'code' => $code,
            ]);
            $builder->insert();
        }
        return $this->db->insertID();
    }

    public function uninstall(string $type, string $code)
    {
        $extension = $this->db->table($this->table);
        $extension->delete([
            'type' => $type,
            'code' => $code
        ]);
        $setting = $this->db->table('setting');
        $setting->delete([
            'code' => $type . '_' . $code
        ]);
    }


    // ----------------------------------------------------
}
