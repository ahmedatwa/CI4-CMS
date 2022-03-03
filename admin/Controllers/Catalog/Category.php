<?php 

namespace Admin\Controllers\Catalog;

use Admin\Controllers\BaseController;
use Admin\Models\Catalog\CategoryModel;
use Shared\Models\Localisation\LanguageModel;

class Category extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->categoryModel->addCategory($this->request->getPost());
                $json['success'] = lang('catalog/category.text_success');
                $json['redirect'] = site_url('catalog/category?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->getFlashdata('error_warning');
            }
        }

        return $this->response->setJSON($json);
    }

    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->categoryModel->editCategory($this->request->getVar('category_id'), $this->request->getPost());
                $json['success'] = lang('catalog/category.text_success');
                $json['redirect'] = site_url('catalog/category?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->getFlashdata('error_warning');
            }
        }

        return $this->response->setJSON($json);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->isAJAX()) {

            if (!$this->user->hasPermission('modify', 'catalog/category')) {
                $json['error_warning'] = lang('catalog/category.permission');
            }

            if ($this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $category_id) {
                    $this->categoryModel->deleteCategory($category_id);
                }
                $json['success'] = lang('catalog/category.text_success');
                $json['redirect'] = site_url('catalog/category?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('catalog/category.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/category.heading_title'),
            'href' => site_url('catalog/category?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['categories'] = [];

        $results = $this->categoryModel->getCategories();

        foreach ($results as $result) {
            $data['categories'][] = [
                'category_id' => $result['category_id'],
                'name'        => $this->categoryModel->getParentByCategoryId($result['category_id']) . $result['name'],
                'sort_order'  => $result['sort_order'],
                'status'      => ($result['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                'edit'        => site_url('catalog/category/form?user_token=' . $this->request->getVar('user_token') . '&category_id=' . $result['category_id']),
                'delete'      => site_url('catalog/category/delete?user_token=' . $this->request->getVar('user_token') . '&category_id=' . $result['category_id']),
            ];
        }

        $data['add'] = site_url('catalog/category/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('catalog/category/delete?user_token=' . $this->request->getVar('user_token'));


        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('catalog/category');

        return $this->template->render('catalog/category_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('catalog/category.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/category.heading_title'),
            'href' => site_url('catalog/category/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getGet('category_id') ? lang('catalog/category.text_add') : lang('catalog/category.text_edit');

        $data['back'] = site_url('catalog/category?user_token=' . $this->request->getVar('user_token'));

        $data['user_token'] = $this->request->getVar('user_token');

        if (!$this->request->getGet('category_id')) {
            $data['action'] = site_url('catalog/category/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('catalog/category/edit?user_token=' . $this->request->getVar('user_token') . '&category_id=' . $this->request->getVar('category_id'));
        }

        if ($this->request->getGet('category_id') && ($this->request->getMethod() != 'post')) {
            $category_info = $this->categoryModel->getCategory($this->request->getGet('category_id'));
        }

        $languageModel = new LanguageModel();
        $data['languages'] = $languageModel->where('status', 1)->findAll();

        if ($this->request->getPost('category_description')) {
            $data['category_description'] = $this->request->getPost('category_description');
        } elseif ($this->request->getVar('category_id')) {
            $data['category_description'] = $this->categoryModel->getCategoryDescriptions($this->request->getVar('category_id'));
        } else {
            $data['category_description'] = [];
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($category_info)) {
            $data['sort_order'] = $category_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        $data['parents'] = $this->categoryModel->getCategoryParents();

        if ($this->request->getPost('parent_id')) {
            $data['parent_id'] = $this->request->getPost('parent_id');
        } elseif (!empty($category_info)) {
            $data['parent_id'] = $category_info['parent_id'];
        } else {
            $data['parent_id'] = 0;
        }

        if ($this->request->getPost('icon')) {
            $data['icon'] = str_replace(array('<i class="', '>'), '', $this->request->getPost('icon'));
        } elseif (!empty($category_info)) {
            $data['icon'] = $category_info['icon'];
        } else {
            $data['icon'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($category_info)) {
            $data['status'] = $category_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('catalog/category');

        return $this->template->render('catalog/category_form', $data);
    }

    public function autocomplete()
    {
        $json = [];

        if ($this->request->getVar('parent_id')) {

            $categoryModel = new CategoryModel();

            if ($this->request->getVar('parent_id')) {
                $filter_name = $this->request->getVar('parent_id');
            } else {
                $filter_name = null;
            }

            $filter_data = [
                'filter_name' => $filter_name,
                'start'       => 0,
                'limit'       => 5,
            ];

            $results = $this->categoryModel->getCategories($filter_data);

            foreach ($results as $result) {
                $json[] = [
                    'parent_id' => $result['category_id'],
                    'name'      => $result['name']
                ];
            }
        }

        return $this->response->setJSON($json);
    }

    protected function validateForm()
    {
        foreach ($this->request->getPost('category_description') as $language_id => $value) {
            if (! $this->validate([
                "category_description.{$language_id}.name" => [
                     'label' => 'Category Name', 'rules' => 'required|min_length[3]'
                ],
                "category_description.{$language_id}.meta_title" => [
                     'label' => 'Category Name', 'rules' => 'required|min_length[3]'
                ],
            ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.form'));
                return false;
            }
        }
    

        if (! $this->user->hasPermission('modify', 'catalog/category')) {
            $this->session->setFlashdata('error_warning', lang('catalog/category.error.permission'));
            return false;
        }

        return true;
    }
        
    //--------------------------------------------------------------------
}
