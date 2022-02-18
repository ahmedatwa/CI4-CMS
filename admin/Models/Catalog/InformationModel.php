<?php

namespace Admin\Models\Catalog;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class InformationModel extends Model
{
    protected $table            = 'information';
    protected $primaryKey       = 'information_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = ['bottom', 'sort_order', 'status'];

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

    protected function afterInsert(array $data)
    {
        if (isset($data)) {
            $eventData = [
                'information_id' => $data['id'],
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_add', 'information_add', $eventData);
        }
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data)) {
            $eventData = [
                'information_id' => $data['id'],
            ];
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'information_edit', $eventData);
        }
    }
    
    public function getInformations(array $data = [])
    {
        $builder = $this->db->table('information i');
        $builder->select();
        $builder->join('information_description id', 'i.information_id = id.information_id', 'left');
        $builder->where('id.language_id', (int) service('registry')->get('config_language_id'));
        
        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('id.title', 'DESC');
        } else {
            $builder->orderBy('id.title', 'ASC');
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

    public function getInformation(int $information_id)
    {
        $builder = $this->db->table('information i');
        $query = $builder->select()
                ->join('information_description id', 'i.information_id = id.information_id', 'left')
                ->where('i.information_id', $information_id)
                ->get();
        return $query->getRowArray();
    }

    public function getInformationDescription(int $information_id)
    {
        $builder = $this->db->table('information_description');

        $information_description_data = [];
        
        $query =$builder->select()
                ->where('information_id', $information_id)
                ->get();
        foreach ($query->getResultArray() as $result) {
            $information_description_data[$result['language_id']] = [
                'title'            => $result['title'],
                'description'      => $result['description'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
            ];
        }
        return $information_description_data;
    }
    
    public function addInformation(array $data)
    {
        $builder = $this->db->table($this->table);
        $information_data = [
            'sort_order'    => $data['sort_order'],
            'status'        => $data['status'],
            'bottom'        => $data['bottom'],
            'top'           => $data['top'],
            'date_added'    => Time::now()->getTimestamp(),
            'date_modified' => Time::now()->getTimestamp(),
        ];

        $builder->insert($information_data);
        $information_id = $this->db->insertID();
        // information_description Query
        if (isset($data['information_description'])) {
            $informationDescriptionTable = $this->db->table('information_description');
            foreach ($data['information_description'] as $language_id => $result) {
                // if ($language_id == service('registry')->get('config_language_id')) {
                //     $keyword = generateSeoUrl($result['title']) . '-' . $information_id;
                // }
                $informationDescriptionData = [
                    'information_id'   => $information_id,
                    'language_id'      => $language_id,
                    'title'            => $result['title'],
                    'description'      => $result['description'],
                    'meta_title'       => $result['meta_title'],
                    'meta_description' => $result['meta_description'],
                    'meta_keyword'     => $result['meta_keyword'],
                ];

                $informationDescriptionTable->insert($informationDescriptionData);
                //  Seo Urls
                $seo_url = $this->db->table('seo_url');
                $seo_url->delete(['path' => service('router')->controllerName()  . '::' . service('router')->methodName()]);
                $seo_url_data = [
                    'site_id'     => 0,
                    'language_id' => $language_id,
                    'query'       => 'information_id=' . $information_id,
                    'keyword'     => generateSeoUrl($result['title']),
                ];
                $seo_url->insert($seo_url_data);
            }
        }
        // trigger the insert event
        $eventData = [
            'id'   => (int) $information_id,
            'name' => $informationDescriptionData['title'],
        ];
        $this->afterInsert($eventData);
    }
    
    public function editInformation(int $information_id, array $data)
    {
        $builder = $this->db->table($this->table);
        $information_data = [
            'sort_order'    => $data['sort_order'],
            'status'        => $data['status'],
            'bottom'        => $data['bottom'],
            'top'           => $data['top'],
            'date_modified' => Time::now()->getTimestamp(),
        ];
        $builder->where('information_id', $information_id)
                ->update($information_data);

        // information_description Query
        if (isset($data['information_description'])) {
            $informationDescriptionTable = $this->db->table('information_description');
            $informationDescriptionTable->delete(['information_id' => $information_id]);
            foreach ($data['information_description'] as $language_id => $result) {
                $informationDescriptionData = [
                    'information_id'   => $information_id,
                    'language_id'      => $language_id,
                    'title'            => $result['title'],
                    'description'      => $result['description'],
                    'meta_title'       => $result['meta_title'],
                    'meta_description' => $result['meta_description'],
                    'meta_keyword'     => $result['meta_keyword'],
                ];
                $informationDescriptionTable->insert($informationDescriptionData);
                //  Seo Urls
                if ($language_id == service('registry')->get('config_language_id')) {
                    $seo_url = $this->db->table('seo_url');
                    $seo_url->delete(['query' => 'information_id=' . $information_id]);
                    $seo_url_data = [
                        'site_id'     => 0,
                        'language_id' => $language_id,
                        'query'       => 'information_id=' . $information_id,
                        'keyword'     => generateSeoUrl($result['title']),
                    ];
                    $seo_url->insert($seo_url_data);
                }
            }
        }

        // trigger the insert event
        $eventData = [
            'id'   => (int) $information_id,
            'name' => $informationDescriptionData['title'],
        ];
        $this->afterUpdate($eventData);
    }

    public function deleteInformation(int $information_id)
    {
        $builder = $this->db->table($this->table);
        $builder->delete(['information_id' => $information_id]);
        //  information_description
        $builderDescription = $this->db->table('information_description');
        $builderDescription->delete(['information_id' => $information_id]);
    }

    // -----------------------------------------------------------------
}
