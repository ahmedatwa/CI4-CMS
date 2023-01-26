<?php

namespace Extensions\Controllers\Dashboard;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\SettingModel;
use Extensions\Models\Dashboard\CustomerOnlineModel;

class Customer_online extends BaseController
{
    public function install()
    {
        $customerOnlineModel = new CustomerOnlineModel();
        $customerOnlineModel->up();
    }

    public function uninstall()
    {
        $customerOnlineModel = new CustomerOnlineModel();
        $customerOnlineModel->down();
    }

    public function edit()
    {
        $json = [];
        if ($this->request->isAJAX()) {
            
            if (!$this->user->hasPermission('modify', 'extensions/dashboard/customer_online')) {
                $json['error'] = lang('dashboard/customer_online.error.permission');
            }

            if (! $json && ($this->request->getMethod() == 'post')) {
                $settingModel = new SettingModel();

                $settingModel->editSetting('dashboard_customer_online', $this->request->getPost());
                $json['success'] = lang('dashboard/customer_online.text_success');
                $json['redirect'] = site_url('setting/extension?user_token=' . $this->request->getVar('user_token')  . '&type=dashboard');
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = lang('en.error.form');
            }
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('dashboard/customer_online.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('dashboard/customer_online.text_extension'),
            'href' => site_url('setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=dashboard')
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('dashboard/customer_online.heading_title'),
            'href' => site_url('extension/dashboard/customer_online?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['action'] = site_url('extensions/dashboard/customer_online/edit?user_token=' . $this->request->getVar('user_token'));
        $data['back'] = site_url('setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=dashboard');
    
        $data['columns'] = [];
        
        for ($i = 3; $i <= 12; $i++) {
            $data['columns'][] = $i;
        }
                
        if ($this->request->getPost('dashboard_customer_online')) {
            $data['dashboard_customer_online'] = $this->request->getPost('dashboard_customer_online');
        } elseif ($this->registry->get('dashboard_customer_online')) {
            $data['dashboard_customer_online'] = $this->registry->get('dashboard_customer_online')['customer_online'];
        } else {
            $data['dashboard_customer_online'] = [];
        }

        lang('Extensions\Dashboard\Customer_online');

        return $this->template->render('Extensions\Views\Dashboard\customer_online_form', $data);
    }
    
    public function dashboard()
    {
        $onlineModel = new CustomerOnlineModel();

        // Customers Online
        $online_total = $onlineModel->getTotalOnline();

        if ($online_total > 1000000000000) {
            $data['total'] = round($online_total / 1000000000000, 1) . 'T';
        } elseif ($online_total > 1000000000) {
            $data['total'] = round($online_total / 1000000000, 1) . 'B';
        } elseif ($online_total > 1000000) {
            $data['total'] = round($online_total / 1000000, 1) . 'M';
        } elseif ($online_total > 1000) {
            $data['total'] = round($online_total / 1000, 1) . 'K';
        } else {
            $data['total'] = $online_total;
        }

        $data['online'] = site_url('report/online?user_token=' . $this->request->getVar('user_token'));

        lang('Extensions\Dashboard\customer_online');

        return $this->template->render('Extensions\Views\Dashboard\customer_online_info', $data);
    }
}
