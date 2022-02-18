<?php

namespace Catalog\Models\Catalog;

use CodeIgniter\Model;

class InformationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'information';
    protected $primaryKey       = 'information_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';
    protected $deletedField  = 'date_deleted';

    // Callbacks
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getInformations(int $limit = null, int $start = 0)
    {
        $builder = $this->db->table('information i');
        $builder->select();
        $builder->join('information_description id', 'id.information_id = i.information_id', 'left');
        $builder->where([
            'id.language_id' => service('registry')->get('config_language_id'),
            'status' => 1
        ]);
        $builder->orderBy('i.sort_order', 'LCASE(id.title) ASC');
        if ($limit) {
            $builder->limit($limit, $start);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getInformation(int $information_id)
    {
        $builder = $this->db->table('information i');

        $builder->select();
        $builder->join('information_description id', 'i.information_id = id.information_id', 'left');
        $builder->where('i.information_id', $information_id);
        $builder->where('id.language_id', service('registry')->get('config_language_id'));
        $query = $builder->get();
        return $query->getRowArray();
    }
    
    public function findIdByKeyword(string $keyword)
    {
        $builder = $this->db->table('information_description');
        $builder->where('keyword', $keyword);
        $row = $builder->get()->getRowArray();
        if ($row) {
            return  $row[$this->primaryKey];
        } else {
            return 0;
        }
    }

    public function keywordById(int $information_id)
    {
        $builder = $this->db->table('information_description');
        $builder->where('information_id', $information_id);
        $row = $builder->get()->getRow();
        if ($row) {
            return  $row->keyword;
        } else {
            return '';
        }
    }
    
    // -----------------------------------------------------------------
}
