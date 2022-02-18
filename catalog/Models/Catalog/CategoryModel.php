<?php

namespace Catalog\Models\Catalog;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'category';
    protected $primaryKey       = 'category_id';
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

    public function getCategories(array $data = [])
    {
        $builder = $this->db->table('category c');
        $builder->select('cd.category_id, cd.name, c.sort_order, c.status, cd.description, c.icon, c.parent_id, cd.keyword, cd.keyword');
        $builder->join('category_description cd', 'c.category_id = cd.category_id', 'left');
        $builder->where([
            'cd.language_id' => service('registry')->get('config_language_id'),
            'c.status !='    => '0'
        ]);

        if (isset($data['category_id'])) {
            $builder->where('c.parent_id', $data['category_id']);
        }

        if (isset($data['filter_name'])) {
            $builder->like('cd.name', $data['filter_name'], 'both');
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('cd.category_id', 'DESC');
        } else {
            $builder->orderBy('cd.category_id', 'ASC');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getCategory(int $category_id)
    {
        $builder = $this->db->table('category c');
        $builder->select('c.category_id, cd.name, cd.description, c.status, c.icon, cd.keyword');
        $builder->join('category_description cd', 'c.category_id = cd.category_id', 'left');
        $builder->where([
            'c.category_id' => $category_id,
            'language_id'   => service('registry')->get('config_language_id'),
        ]);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getCategoriesByProjectId(int $project_id)
    {
        $builder = $this->db->table('project_to_category p2c');
        $builder->select();
        $builder->join('category_description cd', 'p2c.category_id = cd.category_id', 'left');
        $builder->where([
            'p2c.project_id' => $project_id,
            'cd.language_id' => service('registry')->get('config_language_id')
        ]);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getCategoryByProjectId($project_id)
    {
        $builder = $this->db->table('project_to_category p2c');
        $builder->select('name');
        $builder->join('category_description cd', 'p2c.category_id = cd.category_id', 'left');
        $builder->where('p2c.project_id', $project_id);
        $query = $builder->get()
                         ->getRowArray();
        if ($query) {
            return $query['name'];
        } else {
            return '';
        }
    }

    public function getTotalCategories()
    {
        $builder = $this->db->table('category');
        return $builder->countAll();
    }

    // Category Module
    public function getTotalProjectsByCategoryId($category_id)
    {
        $builder = $this->db->table('project_to_category');
        $builder->where('category_id', $category_id);
        return $builder->countAllResults();
    }

    public function findID(string $keyword)
    {
        $builder = $this->db->table('category_description');
        $builder->where('keyword', $keyword);
        $row = $builder->get()->getRowArray();
        if ($row) {
            return  $row[$this->primaryKey];
        } else {
            return 0;
        }
    }
    // -----------------------------------------------------------------
}
