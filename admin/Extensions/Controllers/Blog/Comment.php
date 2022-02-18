<?php

namespace Extensions\Controllers\Blog;

use Admin\Controllers\BaseController;
use Extensions\Models\Blog\BlogModel;

class Comment extends BaseController
{
    public function install()
    {
        $blogModel = new BlogModel();
        $blogModel->install('comment');
    }

    public function uninstall()
    {
        $blogModel = new BlogModel();
        $blogModel->uninstall('comment');
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            $blogModel = new BlogModel();

            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $blogModel->addComment($this->request->getPost());
                $json['success'] = lang('blog/comment.text_success');
                $json['redirect'] = site_url('extensions/blog/comment?user_token=' . $this->request->getVar('user_token')  . '&type=blog');
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
                $blogModel->editComment($this->request->getVar('comment_id'), $this->request->getPost());
                $json['success'] = lang('blog/comment.text_success');
                $json['redirect'] = site_url('extensions/blog/comment?user_token=' . $this->request->getVar('user_token')  . '&type=blog');
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
            if (! $this->user->hasPermission('modify', 'extensions/blog/comment')) {
                $json['error_warning'] = lang('blog/comment.error.permission');
            }
            if (!$json && ($this->request->getMethod() == 'post')) {
                $blogModel = new BlogModel();
                if ($this->request->getPost('selected')) {
                    foreach ($this->request->getPost('selected') as $comment_id) {
                        $blogModel->delete($comment_id);
                        $json['success'] = lang('blog/comment.text_success');
                        $json['redirect'] = 'index.php/extensions/blog/comment?user_token=' . $this->request->getVar('user_token');
                    }
                }
            } else {
                $json['error_warning'] = lang('blog/comment.error_permission');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('blog/comment.heading_title'));

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
            'text' => lang('blog/comment.heading_title'),
            'href' => site_url('extensions/blog/comment?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $blogModel = new BlogModel();

        $data['comments'] = [];

        $results = $blogModel->getComments($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['comments'][] = [
                'comment_id' => $result['comment_id'],
                'name'       => $result['name'],
                'status'     => ($result['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                'date_added' => DateShortFormat($result['date_added']),
                'edit'       => site_url('extensions/blog/comment/form?user_token=' . $this->request->getVar('user_token') . '&comment_id=' . $result['comment_id']),
                'delete'     => site_url('extensions/blog/comment/delete?user_token=' . $this->request->getVar('user_token') . '&comment_id=' . $result['comment_id']),
            ];
        }

        $data['add']    = site_url('extensions/blog/comment/form?user_token=' . $this->request->getVar('user_token'));
        $data['back'] = site_url('setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=blog');

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('Extensions\Blog\comment');

        return $this->template->render('Extensions\Views\Blog\comment_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('blog/comment.heading_title'));
        
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
            'text' => lang('blog/comment.heading_title'),
            'href' => site_url('extensions/blog/comment/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = ! $this->request->getVar('comment_id') ? lang('blog/comment.text_add') : lang('blog/comment.text_edit');

        $data['back'] = site_url('extensions/blog/comment?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('comment_id')) {
            $data['action'] = site_url('extensions/blog/comment/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('extensions/blog/comment/edit?user_token=' . $this->request->getVar('user_token') . '&comment_id=' . $this->request->getVar('comment_id'));
        }

        $blogModel = new BlogModel();
        
        if ($this->request->getVar('comment_id') && ($this->request->getMethod() != 'comment')) {
            $comment_info = $blogModel->getComment($this->request->getVar('comment_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($comment_info)) {
            $data['name'] = $comment_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } elseif (!empty($comment_info)) {
            $data['email'] = $comment_info['email'];
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('comment')) {
            $data['comment'] = $this->request->getPost('comment');
        } elseif (!empty($comment_info)) {
            $data['comment'] = $comment_info['comment'];
        } else {
            $data['comment'] = '';
        }
        
        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($comment_info)) {
            $data['status'] = $comment_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('Extensions\Blog\comment');

        return $this->template->render('Extensions\Views\Blog\comment_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->user->hasPermission('modify', 'extensions/blog/comment')) {
            $this->session->setFlashdata('error_warning', lang('blog/comment.error.permission'));
            return false;
        }

        return true;
    }

        
    //--------------------------------------------------------------------
}
