<?php

namespace Admin\Controllers\Children;

use Admin\Controllers\BaseController;
use Admin\Models\Children\ChildrenGroupModel;

class Children_group extends BaseController
{
    protected $childrenGroupModel;

    public function __construct()
    {
        $this->childrenGroupModel = new ChildrenGroupModel();
    }
    
    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                 $this->childrenGroupModel->insert($this->request->getPost());
                $json['success'] = lang('children/children_group.text_success');
                $json['redirect'] = site_url('children/children_group?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->get('error_warning');
            }
        }

        return $this->response->setJSON($json);
    }

    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->childrenGroupModel->update($this->request->getVar('child_group_id'), $this->request->getPost());
                $json['success'] = lang('children/children_group.text_success');
                $json['redirect'] = site_url('children/children_group?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->get('error_warning');
            }
        }

        return $this->response->setJSON($json);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->isAJAX()) {

            if (!$this->user->hasPermission('modify', 'children/children_group')) {
                $json['error_warning'] = lang('children/children_group.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $child_group_id) {
                    $this->childrenGroupModel->delete($child_group_id);
                }
                $json['success'] = lang('children/children_group.text_success');
                $json['redirect'] = site_url('children/children_group?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('children/children_group.heading_title'));
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('children/children_group.heading_title'),
            'href' => site_url('children/children_group?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['children_group'] = [];

        $results = $this->childrenGroupModel->findAll();

        foreach ($results as $result) {
            $data['children_group'][] = [
                'child_group_id' => $result['child_group_id'],
                'name'          => $result['name'],
                'date_added'    => datetimeFormat($result['date_added']),
                'edit'          => site_url('children/children_group/form?user_token=' . $this->request->getVar('user_token') . '&child_group_id=' . $result['child_group_id']),
                'delete'        => site_url('children/children_group/delete?user_token=' . $this->request->getVar('user_token') . '&child_group_id=' . $result['child_group_id']),
            ];
        }

        $data['add']    = site_url('children/children_group/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('children/children_group/delete?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('children/children_group');

        return $this->template->render('children/children_group_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('children/children_group.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('children/children_group.heading_title'),
            'href' => site_url('children/children_group/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('child_group_id') ? lang('children/children_group.text_add') : lang('children/children_group.text_edit');

        $data['back'] = site_url('children/children_group?user_token=' . $this->request->getVar('user_token'));

        if (! $this->request->getVar('child_group_id')) {
            $data['action'] = site_url('children/children_group/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('children/children_group/edit?user_token=' . $this->request->getVar('user_token') . '&child_group_id=' . $this->request->getVar('child_group_id'));
        }

        if ($this->request->getVar('child_group_id') && ($this->request->getMethod() != 'post')) {
            $childrenGroupInfo = $this->childrenGroupModel->find($this->request->getVar('child_group_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($childrenGroupInfo)) {
            $data['name'] = $childrenGroupInfo['name'];
        } else {
            $data['name'] = '';
        }
        
        if ($this->request->getPost('description')) {
            $data['description'] = $this->request->getPost('description');
        } elseif (!empty($childrenGroupInfo)) {
            $data['description'] = $childrenGroupInfo['description'];
        } else {
            $data['description'] = '';
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('children/children_group');

        return $this->template->render('children/children_group_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->request->getVar('child_group_id')) {
            if (! $this->validate([
            "name" => [
                'label' => 'Group Name',
                'rules' => 'required|min_length[3]|is_unique[customer_group.name,customer_group_id,{customer_group_id}]',
            ],
        ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.form'));
                return false;
            }
        } 

        if (! $this->user->hasPermission('modify', 'children/children_group')) {
            $this->session->setFlashdata('error_warning', lang('children/children_group.error.permission'));
            return false;
        }

        return true;
    }

    //--------------------------------------------------------------------
}
