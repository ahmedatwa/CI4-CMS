<?php 

namespace Shared\Models\Localisation;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class LanguageModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'language';
    protected $primaryKey       = 'language_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'code', 'locale', 'image', 'directory', 'sort_order', 'status'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';
    protected $deletedField  = 'date_deleted';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = ['afterInsert'];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = ['afterUpdate'];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        }
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        }
    }

    public function addLanguage($data)
    {
        $builder = $this->db->table($this->table);
        $language_data = [
            'name'       => $data['name'],
            'code'       => $data['code'],
            'locale'     => $data['locale'],
            'sort_order' => $data['sort_order'],
            'status'     => $data['status']
        ];
        $builder->insert($language_data);
    }

    public function editLanguage(int $language_id, array $data)
    {
        $builder = $this->db->table($this->table);
        $language_data = [
            'name'       => $data['name'],
            'code'       => $data['code'],
            'locale'     => $data['locale'],
            'sort_order' => $data['sort_order'],
            'status'     => $data['status']
        ];
        $builder->where('language_id', $language_id);
        $builder->update($language_data);
    }

    public function getLanguageByCode(string $code) 
    {
        $builder = $this->db->table($this->table);
        $builder->select()
                ->where('code', $code);
        $query = $builder->get();
        return $query->getRowArray();
	}

    // -----------------------------------------------------------------
}
