<?php

namespace Admin\Controllers\User;

use Admin\Controllers\BaseController;
use Admin\Models\User\UserGroupModel;

class User_group extends BaseController
{
    protected $userGroupModel;

    public function __construct()
    {
        $this->userGroupModel = new UserGroupModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->userGroupModel->insert($this->request->getPost());
                $json['success'] = lang('user/user_group.text_success');
                $json['redirect'] = site_url('user/user_group?user_token=' . $this->request->getVar('user_token'));
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
                $this->userGroupModel->update($this->request->getVar('user_group_id'), $this->request->getPost());
                $json['success'] = lang('user/user_group.text_success');
                $json['redirect'] = site_url('user/user_group?user_token=' . $this->request->getVar('user_token'));
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

            if (! $this->user->hasPermission('modify', 'user/user_group')) {
                $json['error_warning'] = lang('en.error.form');
            } 

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $user_group_id) {
                    $this->userGroupModel->delete($user_group_id);
                }
                $json['success'] = lang('user/user_group.text_success');
                $json['redirect'] = site_url('user/user_group?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('user/user_group.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('user/user_group.heading_title'),
            'href' => site_url('user/user_group?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['users_group'] = [];

        $results = $this->userGroupModel->findAll();

        foreach ($results as $result) {
            $data['users_group'][] = [
                'user_group_id' => $result['user_group_id'],
                'name'          => $result['name'],
                'date_added'    => datetimeFormat($result['date_added']),
                'edit'          => site_url('user/user_group/form?user_token=' . $this->request->getVar('user_token') . '&user_group_id=' . $result['user_group_id']),
                'delete'        => site_url('user/user_group/delete?user_token=' . $this->request->getVar('user_token') . '&user_group_id=' . $result['user_group_id']),
            ];
        }

        $data['add']    = site_url('user/user_group/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('user/user_group/delete?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('user/user_group');

        return $this->template->render('user/user_group_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('user/user_group.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('user/user_group.heading_title'),
            'href' => site_url('user/user_group/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('user_group_id') ? lang('user/user_group.text_add') : lang('user/user_group.text_edit');
        $data['back'] = site_url('user/user_group?user_token=' . $this->request->getVar('user_token'));

        if (! $this->request->getVar('user_group_id')) {
            $data['action'] = site_url('user/user_group/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('user/user_group/edit?user_token=' . $this->request->getVar('user_token') . '&user_group_id=' . $this->request->getVar('user_group_id'));
        }


        if ($this->request->getVar('user_group_id') && ($this->request->getMethod() != 'post')) {
            $userGroupInfo = $this->userGroupModel->find($this->request->getVar('user_group_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($userGroupInfo)) {
            $data['name'] = $userGroupInfo['name'];
        } else {
            $data['name'] = '';
        }

        $ignore = [
            'common/column_left',
            'common/dashboard',
            'common/footer',
            'common/forgotten',
            'common/header',
            'common/login',
            'common/logout',
            'error/not_found',
            'error/permission',
            'basecontroller'
        ];

        $data['permissions'] = [];

        $files = [];

        helper('filesystem');

        $default = get_filenames(APPPATH . 'Controllers/', true, false);
        $modules = get_filenames(APPPATH . 'Modules/Controllers/', true, false);
        $extensions = get_filenames(APPPATH . 'Extensions/Controllers/', true, false);

        $map = array_merge($default, $modules, $extensions);

        foreach ($map as $file) {
            $controller = str_replace('controllers/', '', str_replace('modules/', '', substr(strtolower($file), strlen(APPPATH))));

            $permission = substr($controller, 0, strrpos($controller, '.'));

            if (!empty($permission) && !in_array($permission, $ignore)) {
                $data['permissions'][] = $permission;
            }
        }

        if ($this->request->getPost('access')) {
            $data['access'] = $this->request->getPost('access');
        } elseif (!empty($userGroupInfo['permission']['access'])) {
            $data['access'] = $userGroupInfo['permission']['access'];
        } else {
            $data['access'] = [];
        }

        if ($this->request->getPost('modify')) {
            $data['modify'] = $this->request->getPost('modify');
        } elseif (!empty($userGroupInfo['permission']['modify'])) {
            $data['modify'] = $userGroupInfo['permission']['modify'];
        } else {
            $data['modify'] = [];
        }
        
        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('user/user_group');

        return $this->template->render('user/user_group_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'name' => 'required|min_length[4]',
            ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', 'user/user_group')) {
            $this->session->setFlashdata('error_warning', lang('user/user_group.error.permission'));
            return false;
        }

        return true;
    }

    //--------------------------------------------------------------------
}
