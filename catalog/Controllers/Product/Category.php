<?php 

namespace Catalog\Controllers\Product;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\CategoryModel;

class Category extends BaseController
{
   public function index()
    {
        $categoryModel = new CategoryModel();

        $this->document->setTitle(lang('product/category.heading_title'));
            
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('product/category.text_by'),
            'href' => route_to('categories') ? route_to('categories') : base_url('product/category'),
        ];

        if ($this->request->getVar('sort_by')) {
            $sort_by = $this->request->getVar('sort_by');
        } else {
            $sort_by = 'c.category_id';
        }
       
        if ($this->request->getVar('order_by')) {
            $order_by = $this->request->getVar('order_by');
        } else {
            $order_by = 'ASC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = $this->registry->get('theme_default_products_limit') ?? 15;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
            'category_id'   => 0,
            'sort_by'       => $sort_by,
            'order_by'      => $order_by,
            'limit'         => $limit,
            'start'         => ($page - 1) * $limit,
        ];
    
        $data['categories'] = [];
        
        $results = $categoryModel->getCategories($filter_data);

        $total = $categoryModel->getTotalCategories();

        foreach ($results as $result) {
            
            $children = $categoryModel->getCategories([
                'category_id' => $result['category_id'],
            ]);

            $children_data = [];
            
            foreach ($children as $child) {

                $children_data[] = [
                    'category_id' => $child['category_id'],
                    'parent_id'   => $child['parent_id'],
                    'name'        => $child['name'],
                    'icon'        => $child['icon'],
                    'description' => $child['description'],
                    'href'        => route_to('category', $child['category_id'], $child['keyword']),
                ];
            }

            $data['categories'][] = [
                'category_id' => $result['category_id'],
                'name'        => $result['name'],
                'icon'        => $result['icon'],
                'description' => word_limiter(strip_tags($result['description']), 10),
                'href'        => route_to('category', $result['category_id'], $result['keyword']),
                'children'    => $children_data,
            ];
        }

        $data['add_product'] = base_url('product/product/add');
        $data['login']       = route_to('account_login');

        $data['sort_by']       = $sort_by;
        $data['order_by']      = $order_by;
        $data['limit']         = $limit;
        $data['page']          = $page;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        $data['header']        = view_cell("\Catalog\Controllers\Common\Header::index");
        $data['menu']          = view_cell("\Catalog\Controllers\Common\Menu::index");
        $data['column_right']  = view_cell("\Catalog\Controllers\Common\Column_right::index");
        $data['column_left']   = view_cell("\Catalog\Controllers\Common\Column_left::index");
        $data['footer']        = view_cell("\Catalog\Controllers\Common\Footer::index");

        lang('product/category');

       return $this->template->render('product/category', $data);
    }
    
    public function autocomplete()
    {
        $json = [];

        if ($this->request->getVar('filter_category')) {
            $categoryModel = new CategoryModel();

            if ($this->request->getVar('filter_category')) {
                $filter_name = html_entity_decode($this->request->getVar('filter_category'), ENT_QUOTES, 'UTF-8');
            } else {
                $filter_name = null;
            }

            $filter_data = [
                'filter_name' => $filter_name,
                'start' => 0,
                'limit' => 5,
            ];

            $results = $categoryModel->getCategories($filter_data);

            foreach ($results as $result) {
                $json[] = [
                    'category_id' => $result['category_id'],
                    'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                ];
            }
       }

        return $this->response->setJSON($json);
    }
    
    //--------------------------------------------------------------------
}