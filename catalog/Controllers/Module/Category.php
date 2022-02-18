<?php

namespace Catalog\Controllers\Module;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\CategoryModel;

class Category extends BaseController
{
    public function index()
    {
        $filter_data = [
            'limit' => 8,
            'start' => 0,
        ];
        
        $data['categories'] = [];

        $categoryModel = new CategoryModel();

        $results = $categoryModel->getCategories($filter_data);

        foreach ($results as $result) {
            $data['categories'][] = [
                'name'  => $result['name'],
                'total' => $categoryModel->getTotalProjectsByCategoryId($result['category_id']),
                'icon'  => $result['icon'],
                'href'  => ($result['keyword']) ? route_to('category', $result['category_id'], $result['keyword']) : base_url('project/project/category?gid=' . $result['category_id']),
            ];
        }

        lang('module/category');

        return $this->template->render('module/category', $data);
    }
// --------------------------------------------------
}