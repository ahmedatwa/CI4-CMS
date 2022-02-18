<?php 

namespace Shared\Models\Design;

use CodeIgniter\Model;

class SeoUrlModel extends Model
{
    protected $table            = 'seo_url';
    protected $primaryKey       = 'seo_url_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['site_id', 'language_id', 'path', 'keyword'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';
    protected $deletedField  = 'date_deleted';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = ['afterInsert'];
    protected $beforeUpdate   = ['afterUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    public function getSeoUrls(array $data = [])
    {
        $builder = $this->db->table('seo_url su');
        $builder->join('language l', 'su.language_id = l.language_id', 'left');
        $builder->select('l.name AS language, su.seo_url_id, su.query, su.keyword');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getKeywordByQuery($query)
    {
        $keywords = array();

        $builder = $this->db->table($this->table);
        $builder->where('query', $query);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $keywords[$result['language_id']] = array(
                    'keyword' => $result['keyword'],
            );
        }
        return $keywords;
        
    }
    
    public function getSeoUrlsByQuery($keyword)
    {
        $builder = $this->db->table($this->table);
        $builder->where('keyword', $keyword);
        $query = $builder->get();
        return $query->getResultArray();
    }


    // --------------------------------------------------------------------
}
