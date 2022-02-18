<?php

namespace Admin\Controllers\Module;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\SettingModel;

class Account extends BaseController
{
    public function save()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (!$this->user->hasPermission('modify', 'module/account')) {
                $json['error_warning'] = lang('module/account.error.permission');
            }

            if (!$json && ($this->request->getMethod() == 'post')) {
                $settingModel = new SettingModel();
                $settingModel->editSetting('module_account', $this->request->getPost());
                $json['success'] = lang('module/account.text_success');
                $json['redirect'] = site_url('setting/module?user_token=' . $this->request->getVar('user_token'));
            }
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('module/account.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard', 'user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('module/account.text_module'),
            'href' => site_url('setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('module/account.heading_title'),
            'href' => site_url('module/account?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['action'] = site_url('module/account/save?user_token=' . $this->request->getVar('user_token'));
        $data['back'] = site_url('setting/module?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('module_account_status')) {
            $data['module_account_status'] = $this->request->getPost('module_account_status');
        } else {
            $data['module_account_status'] = $this->registry->get('module_account_status');
        }

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('module/account');

        return $this->template->render('module/account', $data);
    }

    // ---------------------------------------------------------------
}
