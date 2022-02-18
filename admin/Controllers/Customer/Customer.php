<?php

namespace Admin\Controllers\Customer;

use Admin\Controllers\BaseController;
use Admin\Models\Customer\CustomerModel;
use Admin\Models\Customer\CustomerGroupModel;

class Customer extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->customerModel->insert($this->request->getPost());
                $json['success'] = lang('customer/customer.text_success');
                $json['redirect'] = site_url('customer/customer?user_token=' . $this->request->getVar('user_token'));
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
                $this->customerModel->update($this->request->getVar('customer_id'), $this->request->getPost());
                $json['success'] = lang('customer/customer.text_success');
                $json['redirect'] = site_url('customer/customer?user_token=' . $this->request->getVar('user_token'));
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
            if (!$this->user->hasPermission('modify', 'customer/customer')) {
                $json['error_warning'] = lang('customer/customer.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $customer_id) {
                    $this->customerModel->delete($customer_id);
                }
                $json['success'] = lang('customer/customer.text_success');
                $json['redirect'] = site_url('customer/customer?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('customer/customer.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('customer/customer.heading_title'),
            'href' => site_url('customer/customer?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['customers'] = [];
        $results = $this->customerModel->findAll();

        foreach ($results as $result) {
            $data['customers'][] = [
                'customer_id'       => $result['customer_id'],
                'name'              => $result['firstname'] . " " . $result['lastname'],
                'email'             => $result['email'],
                'customer_group_id' => $result['customer_group_id'],
                'ip'                => $result['ip'],
                'date_added'        => datetimeFormat($result['date_added']),
                'status'            => ($result['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                'edit'              => site_url('customer/customer/form?user_token=' . $this->request->getVar('user_token') . '&customer_id=' . $result['customer_id']),
                'delete'            => site_url('customer/customer/delete?user_token=' . $this->request->getVar('user_token') . '&customer_id=' . $result['customer_id']),
            ];
        }

        $data['add'] = site_url('customer/customer/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('customer/customer/delete?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('customer/customer');

        return $this->template->render('customer/customer_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('customer/customer.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('customer/customer.heading_title'),
            'href' => site_url('customer/customer/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('customer_id') ? lang('customer/customer.text_add') : lang('customer/customer.text_edit');
        $data['back'] = site_url('customer/customer?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('customer_id')) {
            $data['action'] = site_url('customer/customer/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('customer/customer/edit?user_token=' . $this->request->getVar('user_token') . '&customer_id=' . $this->request->getVar('customer_id'));
        }

        if ($this->request->getVar('customer_id') && ($this->request->getMethod() != 'post')) {
            $customer_info = $this->customerModel->find($this->request->getVar('customer_id'));
        }

        if (!empty($customer_info['customer_id'])) {
            $data['customer_id'] = $customer_info['customer_id'];
        } else {
            $data['customer_id'] = $this->request->getVar('customer_id');
        }

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } elseif (!empty($customer_info)) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } elseif (!empty($customer_info)) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        } elseif (!empty($customer_info)) {
            $data['email'] = $customer_info['email'];
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('telephone')) {
            $data['telephone'] = $this->request->getPost('telephone');
        } elseif (!empty($customer_info)) {
            $data['telephone'] = $customer_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        if ($this->request->getPost('confirm')) {
            $data['confirm'] = $this->request->getPost('confirm');
        } else {
            $data['confirm'] = '';
        }

        // UserGroup
        $customerGroupModel = new CustomerGroupModel();

        $data['customer_groups'] = $customerGroupModel->findAll();
        
        if ($this->request->getPost('customer_group_id')) {
            $data['customer_group_id'] = $this->request->getPost('customer_group_id');
        } elseif (!empty($customer_info)) {
            $data['customer_group_id'] = $customer_info['customer_group_id'];
        } else {
            $data['customer_group_id'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($customer_info)) {
            $data['status'] = $customer_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($this->request->getPost('newsletter')) {
            $data['newsletter'] = $this->request->getPost('newsletter');
        } elseif (!empty($customer_info)) {
            $data['newsletter'] = $customer_info['newsletter'];
        } else {
            $data['newsletter'] = 0;
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('customer/customer');

        return $this->template->render('customer/customer_form', $data);
    }

    public function autocomplete()
    {
        $json = [];
        
        if ($this->request->isAJAX()) {
            $results = [];
            
            if ($this->request->getVar('name')) {
                $results = $this->customerModel->like('firstname', $this->request->getVar('name'), 'after')->findAll();
            }

            foreach ($results as $result) {
                $json[] = [
                    'customer_id' => $result['customer_id'],
                    'name'        => $result['firstname'] . ' ' . $result['lastname'],
                ];
            }
        }
        return $this->response->setJSON($json);
    }
    
    protected function validateForm()
    {
        if (! $this->request->getVar('customer_id')) {
            if (! $this->validate([
                    'firstname' => 'required|alpha_numeric_space|min_length[3]',
                    'lastname'  => 'required|alpha_numeric_space|min_length[3]',
                    'email'     => 'required|valid_email|is_unique[customer.email,customer_id,{customer_id}]',
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
                    'email'     => 'required|valid_email',
                    ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', 'customer/customer')) {
            $this->session->setFlashdata('error_warning', lang('customer/customer.error.permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
