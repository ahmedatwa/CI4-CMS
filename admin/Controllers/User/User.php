<?php

namespace Admin\Controllers\User;

use Admin\Controllers\BaseController;
use Admin\Models\User\UserModel;
use Admin\Models\User\UserGroupModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->userModel->insert($this->request->getPost());
                $json['success'] = lang('user/user.text_success');
                $json['redirect'] = site_url('user/user?user_token=' . $this->request->getVar('user_token'));
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
                $this->userModel->update($this->request->getVar('user_id'), $this->request->getPost());
                $json['success'] = lang('user/user.text_success');
                $json['redirect'] = site_url('user/user?user_token=' . $this->request->getVar('user_token'));
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
            if ($this->request->getPost('selected') && $this->validateDelete()) {
                foreach ($this->request->getPost('selected') as $user_id) {
                    $this->userModel->delete($user_id);
                }
                $json['success'] = lang('user/user.text_success');
                $json['redirect'] = site_url('user/user?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('user/user.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('user/user.heading_title'),
            'href' => site_url('user/user?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['users'] = [];

        $results = $this->userModel->findAll();

        foreach ($results as $result) {
            $data['users'][] = [
                'user_id'    => $result['user_id'],
                'email'      => $result['email'],
                'name'       => $result['firstname'] . ' ' . $result['lastname'],
                'date_added' => datetimeFormat($result['date_added']),
                'status'     => ($result['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                'edit'       => site_url('user/user/form?user_token=' . $this->request->getVar('user_token') . '&user_id=' . $result['user_id']),
                'delete'     => site_url('user/user/delete?user_token=' . $this->request->getVar('user_token') . '&user_id=' . $result['user_id']),
            ];
        }

        $data['add']    = site_url('user/user/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('user/user/delete?user_token=' . $this->request->getVar('user_token'));
        $data['purge'] = site_url('user/user/purge?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('user/user');

        return $this->template->render('user/user_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('user/user.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('user/user.heading_title'),
            'href' => site_url('user/user/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('user_id') ? lang('user/user.text_add') : lang('user/user.text_edit');

        $data['back'] = site_url('user/user?user_token=' . $this->request->getVar('user_token'));

        if (! $this->request->getVar('user_id')) {
            $data['action'] = site_url('user/user/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('user/user/edit?user_token=' . $this->request->getVar('user_token') . '&user_id=' . $this->request->getVar('user_id'));
        }


        if ($this->request->getVar('user_id') && ($this->request->getMethod() != 'post')) {
            $user_info = $this->userModel->find($this->request->getVar('user_id'));
        }

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } elseif (!empty($user_info)) {
            $data['firstname'] = $user_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } elseif (!empty($user_info)) {
            $data['lastname'] = $user_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('username')) {
            $data['username'] = $this->request->getPost('username');
        } elseif (!empty($user_info)) {
            $data['username'] = $user_info['username'];
        } else {
            $data['username'] = '';
        }

        if ($this->request->getPost('email', FILTER_SANITIZE_EMAIL)) {
            $data['email'] = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        } elseif (!empty($user_info)) {
            $data['email'] = $user_info['email'];
        } else {
            $data['email'] = '';
        }

        if (!empty($this->request->getPost('password'))) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        if (!empty($this->request->getPost('confirm'))) {
            $data['confirm'] = $this->request->getPost('confirm');
        } else {
            $data['confirm'] = '';
        }

        if ($this->request->getPost('image')) {
            $data['image'] = $this->request->getPost('image');
        } elseif (!empty($user_info)) {
            $data['image'] = $user_info['image'];
        } else {
            $data['image'] = '';
        }

        if ($this->request->getPost('image') && is_file(DIR_IMAGE . $this->request->getPost('image'))) {
            $data['thumb'] = resizeImage($this->request->getPost('image'), 100, 100);
        } elseif (!empty($user_info) && is_file(DIR_IMAGE . $user_info['image'])) {
            $data['thumb'] = resizeImage($user_info['image'], 100, 100);
        } else {
            $data['thumb'] = resizeImage('no_image.jpg', 100, 100);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 100, 100);

        // UserGroup
        $userGroupModel = new UserGroupModel();
        $data['user_groups'] = $userGroupModel->findAll();
        if ($this->request->getPost('user_group_id')) {
            $data['user_group_id'] = $this->request->getPost('user_group_id');
        } elseif (!empty($user_info)) {
            $data['user_group_id'] = $user_info['user_group_id'];
        } else {
            $data['user_group_id'] = 0;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($user_info)) {
            $data['status'] = $user_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('user/user');

        return $this->template->render('user/user_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->request->getVar('user_id')) {
            if (! $this->validate([
                    'firstname' => 'required|alpha_numeric_space|min_length[3]',
                    'lastname'  => 'required|alpha_numeric_space|min_length[3]',
                    'username'  => 'required|alpha_numeric_space|min_length[3]',
                    'email'     => 'required|valid_email|is_unique[user.email,user_id,{user_id}]',
                    'password'  => 'required|min_length[4]',
                    'confirm'   => 'required_with[password]|matches[password]',
                ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.form'));
                return false;
            }
        } else {
            if (! $this->validate([
                    'firstname' => 'required|alpha_numeric_space|min_length[3]',
                    'lastname'  => 'required|alpha_numeric_space|min_length[3]',
                    'username'  => 'required|alpha_numeric_space|min_length[3]',
                    'email'     => 'required|valid_email|is_unique[user.email,user_id,{user_id}]',
                    ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', 'user/user')) {
            $this->session->setFlashdata('error_warning', lang('user/user.error.permission'));
            return false;
        }

        return true;
    }

    protected function validateDelete()
    {
        if (! $this->user->hasPermission('modify', 'user/user')) {
            $this->session->setFlashdata('error_warning', lang('user/user.error.permission'));
            return false;
        } else {
            return true;
        }
    }

    //--------------------------------------------------------------------
}
