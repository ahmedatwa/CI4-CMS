<?php

namespace Extensions\Controllers\Blog;

use Admin\Controllers\BaseController;
use Extensions\Models\Blog\BlogModel;

class Category extends BaseController
{

    public function install()
    {
        $blogModel = new BlogModel();
        $blogModel->install('category');
    }

    public function uninstall()
    {
        $blogModel = new BlogModel();
        $blogModel->uninstall('category');
    }

    public function add()
    {
        $json = [];
        if ($this->request->isAJAX()) {
            $blogModel = new BlogModel();

            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $blogModel->addCategory($this->request->getPost());
                $json['success'] = lang('blog/category.text_success');
                $json['redirect'] = site_url('extensions/blog/category?user_token=' . $this->request->getVar('user_token')  . '&type=blog');
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
            $blogModel = new BlogModel();

            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $blogModel->editCategory($this->request->getVar('category_id'), $this->request->getPost());
                $json['success'] = lang('blog/category.text_success');
                $json['redirect'] = site_url('extensions/blog/category?user_token=' . $this->request->getVar('user_token')  . '&type=blog');
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
            if (! $this->user->hasPermission('modify', 'extensions/blog/category')) {
                $json['error_warning'] = lang('blog/category.error.permission');
            }
           
            if (!$json && ($this->request->getMethod() == 'post')) {
                $blogModel = new BlogModel();
                if ($this->request->getPost('selected')) {
                    foreach ($this->request->getPost('selected') as $category_id) {
                        $blogModel->deleteCategory($category_id);
                        $json['success'] = lang('blog/category.text_success');
                        $json['redirect'] = 'index.php/extensions/blog/category?user_token=' . $this->request->getVar('user_token');
                    }
                }
            } else {
                $json['error_warning'] = lang('blog/category.error_permission');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('blog/category.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.heading_title'),
            'href' => site_url('setting/extensions?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('extension/blog.heading_title'),
            'href' => site_url('setting/extensions/?user_token=' . $this->request->getVar('user_token') . '&type=blog'),
        ];
        $data['breadcrumbs'][] = [
            'text' => lang('blog/category.heading_title'),
            'href' => site_url('extension/blog/category?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $blogModel = new BlogModel();

        $data['categories'] = [];
        $results =  $blogModel->getCategories();

        foreach ($results as $result) {
            $data['categories'][] = [
                'category_id' => $result['category_id'],
                'name'        => $result['name'],
                'status'      => ($result['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                'edit'        => site_url('extensions/blog/category/form?user_token=' . $this->request->getVar('user_token') . '&category_id=' . $result['category_id']),
                'delete'      => site_url('extensions/blog/category/delete?user_token=' . $this->request->getVar('user_token') . '&category_id=' . $result['category_id']),
            ];
        }

        $data['add'] = site_url('extensions/blog/category/form?user_token=' . $this->request->getVar('user_token'));
        $data['back'] = site_url('setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=blog');

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('Extensions\Blog\category');

        return $this->template->render('Extensions\Views\Blog\category_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('blog/category.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.heading_title'),
            'href' => site_url('setting/extensions?user_token=' . $this->request->getVar('user_token')),
        ];
        $data['breadcrumbs'][] = [
            'text' => lang('extension/blog.heading_title'),
            'href' => site_url('setting/extensions/?user_token=' . $this->request->getVar('user_token') . '&type=blog'),
        ];
        $data['breadcrumbs'][] = [
            'text' => lang('blog/category.heading_title'),
            'href' => site_url('extensions/blog/category/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('category_id') ? lang('blog/category.text_add') : lang('blog/category.text_edit');
        $data['back'] = site_url('extensions/blog/category?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('category_id')) {
            $data['action'] = site_url('extensions/blog/category/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('extensions/blog/category/edit?user_token=' . $this->request->getVar('user_token') . '&category_id=' . $this->request->getVar('category_id'));
        }

        $blogModel = new BlogModel();
        
        if ($this->request->getVar('category_id') && ($this->request->getMethod() != 'category')) {
            $category_info = $blogModel->getCategory($this->request->getVar('category_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($category_info)) {
            $data['name'] = $category_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($category_info)) {
            $data['status'] = $category_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['user_token'] = $this->request->getVar('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('Extensions\Blog\category');

        return $this->template->render('Extensions\Views\Blog\category_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                    'name'    => 'required|min_length[3]',
                    ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.form'));
            return false;
        }
            
        if (! $this->user->hasPermission('modify', 'extensions/blog/category')) {
            $this->session->setFlashdata('error_warning', lang('blog/category.error.permission'));
            return false;
        }

        return true;
    }

        
    //--------------------------------------------------------------------
}
