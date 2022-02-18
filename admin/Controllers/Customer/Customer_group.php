<?php

namespace Admin\Controllers\Customer;

use Admin\Controllers\BaseController;
use Admin\Models\Customer\CustomerGroupModel;

class Customer_group extends BaseController
{
    protected $customerGroupModel;

    public function __construct()
    {
        $this->customerGroupModel = new CustomerGroupModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->customerGroupModel->insert($this->request->getPost());
                $json['success'] = lang('customer/customer_group.text_success');
                $json['redirect'] = site_url('customer/customer_group?user_token=' . $this->request->getVar('user_token'));
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
                $this->customerGroupModel->update($this->request->getVar('customer_group_id'), $this->request->getPost());
                $json['success'] = lang('customer/customer_group.text_success');
                $json['redirect'] = site_url('customer/customer_group?user_token=' . $this->request->getVar('user_token'));
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

            if (!$this->user->hasPermission('modify', 'customer/customer_group')) {
                $json['error_warning'] = lang('customer/customer_group.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $customerGroupId) {
                    $this->customerGroupModel->delete($customerGroupId);
                }
                $json['success'] = lang('customer/customer_group.text_success');
                $json['redirect'] = site_url('customer/customer_group?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('customer/customer_group.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('customer/customer_group.heading_title'),
            'href' => base_url('index.php/customer/customer_group?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['customer_groups'] = [];

        $results = $this->customerGroupModel->findAll();

        foreach ($results as $result) {
            $data['customer_groups'][] = [
                'customer_group_id' => $result['customer_group_id'],
                'name'              => $result['name'],
                'date_added'        => datetimeFormat($result['date_added']),
                'edit'              => base_url('index.php/customer/customer_group/form?user_token=' . $this->request->getVar('user_token') . '&customer_group_id=' . $result['customer_group_id']),
            ];
        }

        $data['add'] = base_url('index.php/customer/customer_group/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/customer/customer_group/delete?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('customer/customer_group');

        return $this->template->render('customer/customer_group_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('customer/customer_group.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('customer/customer_group.heading_title'),
            'href' => base_url('index.php/customer/customer_group/save?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('customer_group_id') ? lang('customer/customer_group.text_add') : lang('customer/customer_group.text_edit');

        $data['back'] = base_url('index.php/customer/customer_group?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('customer_group_id')) {
            $data['action'] = base_url('index.php/customer/customer_group/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/customer/customer_group/edit?user_token=' . $this->request->getVar('user_token') . '&customer_group_id=' . $this->request->getVar('customer_group_id'));
        }

        if ($this->request->getVar('customer_group_id') && ($this->request->getMethod() != 'post')) {
            $customer_group_info = $this->customerGroupModel->find($this->request->getVar('customer_group_id'));
        }
        
        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($customer_group_info)) {
            $data['name'] = $customer_group_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if ($this->request->getPost('description')) {
            $data['description'] = $this->request->getPost('description');
        } elseif (!empty($customer_group_info)) {
            $data['description'] = $customer_group_info['description'];
        } else {
            $data['description'] = '';
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('customer/customer_group');

        return $this->template->render('customer/customer_group_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
            "name" => [
                'label' => 'Group Name',
                'rules' => 'required|min_length[3]|is_unique[customer_group.name,customer_group_id,{customer_group_id}]',
            ],
        ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', 'customer/customer_group')) {
            $this->session->setFlashdata('error_warning', lang('customer/customer_group.error.permission'));
            return false;
        }
        return true;
    }


    //--------------------------------------------------------------------
}
