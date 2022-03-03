<?php

namespace Shared\Models\Setting;

use CodeIgniter\Model;

class ModulesModel extends Model
{
    protected $table            = 'module';
    protected $primaryKey       = 'module_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['type', 'type'];
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'int';
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = ['afterFind'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Callbaks
    protected function afterFind(array $data)
    {
        
        if (isset($data['data']['setting'])) {
            $data['data']['setting'] = json_decode($data['data']['setting'], true);
        } else {
            $data['data']['setting'] = [];
        }
       // var_dump($data);
        return $data;
    }

    public function addModule(string $code, array $data)
    {
        $builder = $this->db->table($this->table);
        $module_data = array(
            'name'    => $data['name'],
            'code'    => $code,
            'setting' => json_encode($data)
        );
        $builder->insert($module_data, true);
    }

    public function editModule(int $module_id, array $data)
    {
        $builder = $this->db->table($this->table);
        $builder->where('module_id', $module_id);
        $module_data = array(
            'name' => $data['name'],
            'setting' => json_encode($data)
        );
        $builder->update($module_data);
    }

    public function deleteModule(int $module_id)
    {
        // Modules
        $builder = $this->db->table($this->table);
        $builder->delete(['module_id' => $module_id]);
        // Layout Module
        $layout_module = $this->db->table('layout_module');
        $layout_module->like('code', $module_id, 'before')
                      ->delete();
    }

    public function getModulesByCode(string $code)
    {
        $builder = $this->db->table($this->table);
        return $builder->select()
                         ->where('code', $code)
                         ->orderBy('name')
                         ->get()
                         ->getResultArray();
    }

    public function deleteModulesByCode(string $code)
    {
        // Modules
        $builder = $this->db->table($this->table);
        $builder->delete(['code' => $code]);
        // Layout Module
        $layout_module = $this->db->table('layout_module');
        $layout_module->like('code', $module_id, 'before')
                      ->delete();
    }

    // ----------------------------------------------------
}
