<?php

namespace Extensions\Controllers\Dashboard;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\SettingModel;
use Admin\Models\Customer\CustomerModel;
use Extensions\Models\Dashboard\CustomerActivityModel;

class Customer_activity extends BaseController
{
    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            
            if (!$this->user->hasPermission('modify', 'extensions/dashboard/customer_activity')) {
                $json['error_warning'] = lang('dashboard/customer_activity.error.permission');
            }

            if (! $json && ($this->request->getMethod() == 'post')) {
                $settingModel = new SettingModel();

                $settingModel->editSetting('dashboard_customer_activity', $this->request->getPost());
                $json['success'] = lang('dashboard/customer_activity.text_success');
                $json['redirect'] = site_url('setting/extension?user_token=' . $this->request->getVar('user_token')  . '&type=dashboard');
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = lang('dashboard/customer_activity.error.permission');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('dashboard/customer_activity.heading_title'));
    
        $data['breadcrumbs'] = [];
  
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token'))
        ];
  
        $data['breadcrumbs'][] = [
            'text' => lang('dashboard/customer_activity.text_extension'),
            'href' => site_url('setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=dashboard')
        ];
  
        $data['breadcrumbs'][] = [
            'text' => lang('dashboard/customer_activity.heading_title'),
            'href' => site_url('extension/dashboard/customer_activity/user_token=' . $this->request->getVar('user_token'))
        ];
  
        $data['action'] = site_url('extensions/dashboard/customer_activity/edit?user_token=' . $this->request->getVar('user_token'));
        $data['back'] = site_url('setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=dashboard');
        
        $data['columns'] = [];
      
        for ($i = 3; $i <= 12; $i++) {
            $data['columns'][] = $i;
        }
      
        if ($this->request->getPost('dashboard_customer_activity')) {
            $data['dashboard_customer_activity'] = $this->request->getPost('dashboard_customer_activity');
        } elseif ($this->registry->get('dashboard_customer_activity')) {
            $data['dashboard_customer_activity'] = $this->registry->get('dashboard_customer_activity')['customer_activity'];
        } else {
            $data['dashboard_customer_activity'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('Extensions\Dashboard\Customer_activity');

        return $this->template->render('Extensions\Views\Dashboard\customer_activity_form', $data);
    }
    
    public function dashboard()
    {
  
        $data['activities'] = [];
  
        $activityModel = new CustomerActivityModel();
        $customerModel = new CustomerModel();

        $results = $activityModel->orderBy('date_added', 'DESC')->findAll(5);

        foreach ($results as $result) {
            $text = vsprintf(lang('dashboard/customer_activity.text_activity_' . $result['key']), json_decode($result['data'], true));

                $find = [
                    'customer_id=',
                    'customer_group_id=',
                ];
  
                $replace = [
                    site_url('customer/customer/form?user_token=' . $this->session->get('user_token') . '&customer_id='),
                    site_url('customer/customer_group/form?user_token=' . $this->session->get('user_token') . '&customer_group_id='),
                ];
  
                $data['activities'][] = [
                    'comment'    => str_replace($find, $replace, $text),
                    'date_added' => dateTimeFormat($result['date_added'], true)
                ];
        }
        
        lang('Extensions\Dashboard\Customer_activity');

        return $this->template->render('Extensions\Views\Dashboard\customer_activity_info', $data);
    }

    // -------------------------------------------------
}
