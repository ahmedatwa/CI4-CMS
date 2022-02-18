<?php

namespace Shared\Models\Design;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class BannerModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'banner';
    protected $primaryKey           = 'banner_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['name', 'status'];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'int';
    protected $createdField         = '';
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
                'banner_id' => $data['id'],
                'name' => $data['data']['name'],
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

    public function addBanner(array $data)
    {
        $builder = $this->db->table($this->table);
        $banner_data = [
            'name'   => $data['name'],
            'status' => $data['status']
        ];

        $builder->insert($banner_data);
        $banner_id = $this->db->insertID();
        
        if (isset($data['banner_image'])) {
            $banner_image_table = $this->db->table('banner_image');

            foreach ($data['banner_image'] as $key => $value) {
                $banner_image_data = [
                        'banner_id'   => $banner_id,
                        'title'       => $value['title'],
                        'caption'     => $value['caption'],
                        'link'        => $value['link'],
                        'image'       => $value['image'],
                        'sort_order'  => $value['sort_order'],
                    ];
                $banner_image_table->insert($banner_image_data);
            }
        }

        return $banner_id;
    }

    public function editBanner(int $banner_id, array $data)
    {
        $builder = $this->db->table($this->table);
        $banner_data = [
            'name'   => $data['name'],
            'status' => $data['status']
        ];

        $builder->where('banner_id', $banner_id)
                ->update($banner_data);
        
        if (isset($data['banner_image'])) {
            $banner_image_table = $this->db->table('banner_image');
            $banner_image_table->delete(['banner_id' => $banner_id]);

            foreach ($data['banner_image'] as $key => $value) {
                $banner_image_data = [
                        'banner_id'   => $banner_id,
                        'title'       => $value['title'],
                        'caption'     => $value['caption'],
                        'link'        => $value['link'],
                        'image'       => $value['image'],
                        'sort_order'  => $value['sort_order'],
                    ];
                $banner_image_table->insert($banner_image_data);
            }
        }
    }
    
    public function getBannerImages(int $banner_id)
    {
        $banner_image_data = [];

        $builder = $this->db->table('banner_image');
        $query = $builder->select()
                ->where('banner_id', $banner_id)
                ->orderBy('sort_order', 'ASC')
                ->get();
        foreach ($query->getResultArray() as $banner_image) {
            $banner_image_data[] = [
                'banner_image_id' => $banner_image['banner_image_id'],
                'title'           => $banner_image['title'],
                'caption'         => $banner_image['caption'],
                'link'            => $banner_image['link'],
                'image'           => $banner_image['image'],
                'sort_order'      => $banner_image['sort_order']
            ];
        }

        return $banner_image_data;
    }

    public function getBanner(int $banner_id)
    {
        $builder = $this->db->table('banner b');
        $builder->select();
        $builder->join('banner_image bi', 'b.banner_id = bi.banner_id', 'left');
        $builder->where([
            'b.banner_id'    => $banner_id,
            'b.status'       => 1,
            //'bi.language_id' => service('registry')->get('config_language_id')
        ]);

        $builder->orderBy('bi.sort_order', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // -----------------------------------------------------------
}
