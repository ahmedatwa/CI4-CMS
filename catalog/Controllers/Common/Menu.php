<?php

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\CategoryModel;

class Menu extends BaseController
{
    public function index()
    {        
        $data['categories'] = [];

        $categoryModel = new CategoryModel();
        
        $categories = $categoryModel->getCategories(['category_id' => 0]);

        foreach ($categories as $category) {
            // Level 2
            $children_data = [];

            $children = $categoryModel->getCategories(['category_id' => $category['category_id']]);

            foreach ($children as $child) {
                $children_data[] = [
                    'name'  => $child['name'],
                    'href'  => base_url('project/project/list?gid=' . $child['category_id'] . '&skills=' . $child['category_id'])
                ];
            }

            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name'        => $category['name'],
                'ico'         => $category['icon'],
                'children'    => $children_data,
                'href'        => route_to('category', $category['category_id'], $category['keyword']),
            ];
        }
    
        lang('common/menu');

        return $this->template->render('common/menu', $data);
    }

    //--------------------------------------------------------------------
}
