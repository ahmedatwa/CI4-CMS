<?php

namespace Extensions\Controllers\Analytics;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\SettingModel;

class Google extends BaseController
{
    public function edit()
    {
        $json = [];

        if (! $this->user->hasPermission('modify', 'extensions/analytics/google')) {
            $json['error_warning'] = lang('analytics/google.error.permission');
        }

        if ($this->request->isAJAX()) {
            $settingModel = new SettingModel();

            if (!$json && ($this->request->getMethod() == 'post')) {
                $settingModel->editSetting('analytics_google', $this->request->getPost());
                $json['success'] = lang('analytics/google.text_success');
                $json['redirect'] = site_url('setting/extension?user_token=' . $this->request->getVar('user_token')  . '&type=google');
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = lang('analytics/google.error.permission');
            }
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('analytics/google.heading_title'));

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
            'text' => lang('extension/blog.heading_title'),
            'href' => site_url('setting/extensions/?user_token=' . $this->request->getVar('user_token') . '&type=blog'),
        ];
        $data['breadcrumbs'][] = [
            'text' => lang('analytics/google.heading_title'),
            'href' => site_url('extensions/analytics/google/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['back'] = site_url('setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=analytics');
        $data['action'] = site_url('extensions/analytics/google/edit?user_token=' . $this->request->getVar('user_token'));
        
        if ($this->request->getPost('analytics_google')) {
            $data['analytics_google'] = $this->request->getPost('analytics_google');
        } elseif ($this->registry->get('analytics_google')) {
            $data['analytics_google'] = $this->registry->get('analytics_google');
        } else {
            $data['analytics_google'] = [];
        }

        $data['user_token'] = $this->request->getVar('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('Extensions\Analytics\Google');

        return $this->template->render('Extensions\Views\Analytics\google', $data);
    }
        
    //--------------------------------------------------------------------
}
