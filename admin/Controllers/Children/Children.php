<?php

namespace Admin\Controllers\Children;

use Admin\Controllers\BaseController;
use Admin\Models\Children\ChildrenModel;
use Admin\Models\Children\ChildrenGroupModel;
use Admin\Models\Children\SchemesModel;

class Children extends BaseController
{
    protected $childrenModel;

    public function __construct()
    {
        $this->childrenModel = new ChildrenModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->childrenModel->insert($this->request->getPost());
                $json['success'] = lang('children/children.text_success');
                $json['redirect'] = site_url('children/children?user_token=' . $this->request->getVar('user_token'));
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
                $this->childrenModel->update($this->request->getVar('child_id'), $this->request->getPost());
                $json['success'] = lang('children/children.text_success');
                $json['redirect'] = site_url('children/children?user_token=' . $this->request->getVar('user_token'));
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

            if (!$this->user->hasPermission('modify', 'children/children')) {
                $json['error_warning'] = lang('children/children.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $child_id) {
                    $this->childrenModel->delete($child_id);
                }
                $json['success'] = lang('children/children.text_success');
                $json['redirect'] = site_url('children/children?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('children/children.list.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.list.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('children/children.list.heading_title'),
            'href' => site_url('children/children?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['children'] = [];

        $schemesModel = new SchemesModel();

        $results = $this->childrenModel->findAll();

        foreach ($results as $result) {
            $data['children'][] = [
                'child_id'   => $result['child_id'],
                'dob'        => datetimeFormat($result['dob']),
                'name'       => $result['firstname'] . ' ' . $result['lastname'],
                'scheme'     => $schemesModel->where('scheme_id', $result['scheme_id'])->findColumn('name')[0] ?? lang('en.list.text_other'),
                'date_added' => datetimeFormat($result['date_added']),
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'       => site_url('children/children/form?user_token=' . $this->request->getVar('user_token') . '&child_id=' . $result['child_id']),
                'delete'     => site_url('children/children/delete?user_token=' . $this->request->getVar('user_token') . '&child_id=' . $result['child_id']),
            ];
        }

        $data['add']    = site_url('children/children/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('children/children/delete?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        // Language Data
        lang('children/children');

        return $this->template->render('children/children_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('children/children.list.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.list.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('children/children.list.heading_title'),
            'href' => site_url('children/children/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('child_id') ? lang('children/children.text_add') : lang('children/children.text_edit');
        $data['back'] = site_url('children/children?user_token=' . $this->request->getVar('user_token'));

        if (! $this->request->getVar('child_id')) {
            $data['action'] = site_url('children/children/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('children/children/edit?user_token=' . $this->request->getVar('user_token') . '&child_id=' . $this->request->getVar('child_id'));
        }

        if ($this->request->getVar('child_id') && ($this->request->getMethod() != 'post')) {
            $childInfo = $this->childrenModel->find($this->request->getVar('child_id'));
        }

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } elseif (!empty($childInfo)) {
            $data['firstname'] = $childInfo['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } elseif (!empty($childInfo)) {
            $data['lastname'] = $childInfo['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('dob')) {
            $data['dob'] = $this->request->getPost('dob');
        } elseif (!empty($childInfo)) {
            $data['dob'] = datetimeFormat($childInfo['dob']);
        } else {
            $data['dob'] = '';
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
        $childrenGroupModel = new ChildrenGroupModel();
        $data['children_group'] = $childrenGroupModel->findAll();
        if ($this->request->getPost('child_group_id')) {
            $data['child_group_id'] = $this->request->getPost('child_group_id');
        } elseif (!empty($childInfo)) {
            $data['child_group_id'] = $childInfo['child_group_id'];
        } else {
            $data['child_group_id'] = 0;
        }

        // UserGroup
        $schemesModel = new SchemesModel();
        $data['schemes'] = $schemesModel->findAll();
        if ($this->request->getPost('scheme_id')) {
            $data['scheme_id'] = $this->request->getPost('scheme_id');
        } elseif (!empty($childInfo)) {
            $data['scheme_id'] = $childInfo['scheme_id'];
        } else {
            $data['scheme_id'] = 0;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($childInfo)) {
            $data['status'] = $childInfo['status'];
        } else {
            $data['status'] = 1;
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        // Language Data
        lang('children/children');

        return $this->template->render('children/children_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->request->getVar('child_id')) {
            if (! $this->validate([
                    'firstname' => 'required|alpha_numeric_space|min_length[3]',
                    'lastname'  => 'required|alpha_numeric_space|min_length[3]',
                    'dob'       => 'required',
                ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.form'));
                return false;
            }
        } else {
            if (! $this->validate([
                    'firstname' => 'required|alpha_numeric_space|min_length[3]',
                    'lastname'  => 'required|alpha_numeric_space|min_length[3]',
                    'dob'       => 'required',
                    ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', 'children/children')) {
            $this->session->setFlashdata('error_warning', lang('children/children.permission'));
            return false;
        }

        return true;
    }

    //--------------------------------------------------------------------
}
