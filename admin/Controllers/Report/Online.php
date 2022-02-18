<?php

namespace Admin\Controllers\Report;

use Admin\Controllers\BaseController;
use Extensions\Models\Dashboard\CustomerOnlineModel;
use Admin\Models\Customer\CustomerModel;

class Online extends BaseController
{
    protected $onlineModel;

    public function __construct()
    {
        $this->onlineModel = new CustomerOnlineModel();
    }

    public function delete()
    {
        $json = [];

        if ($this->request->isAJAX()) {

            if (!$this->user->hasPermission('modify', 'report/online')) {
                $json['error_warning'] = lang('report/online.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $online_id) {
                    $this->onlineModel->delete($online_id);
                }
                $json['success'] = lang('report/online.text_success');
                $json['redirect'] = site_url('report/online?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('report/online.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->session->get('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('report/online.heading_title'),
            'href' => site_url('report/online?user_token=' . $this->session->get('user_token'))
        ];

        // Reports
        $data['reports'] = [];
        
        $customerModel = new CustomerModel();

        $results =  $this->onlineModel->findAll();

        foreach ($results as $result) {
            $customer_info = $customerModel->find($result['customer_id']);
            if ($customer_info) {
                $customer = $customer_info['firstname'] . ' ' . $customer_info['lastname'];
            } else {
                $customer = lang('en.text_guest');
            }

            $data['customers'][] = [
                'customer_online_id' => $result['customer_online_id'],
                'customer_id'        => $result['customer_id'],
                'ip'                 => $result['ip'],
                'customer'           => $customer,
                'url'                => $result['url'],
                'referer'            => $result['referer'],
                'date_added'         => datetimeFormat($result['date_added'], true),
                'edit'               => site_url('customer/customer/edit?user_token=' . $this->session->get('user_token') . '&customer_id=' . $result['customer_id'])
            ];
        }
        
        $data['user_token'] = $this->session->get('user_token');
        $data['action'] = site_url('report/online/delete?user_token=' . $this->session->get('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('report/online');

        return $this->template->render('report/online', $data);
    }


    //--------------------------------------------------------------------
}
