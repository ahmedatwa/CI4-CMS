<?php

namespace Admin\Controllers\Module;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\SettingModel;

class Menu extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function save()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (!$this->user->hasPermission('modify', 'module/menu')) {
                $json['error_warning'] = lang('module/menu.error.permission');
            }

            if (!$json && ($this->request->getMethod() == 'post')) {
                $settingModel = new SettingModel();
                $settingModel->editSetting('module_menu', $this->request->getPost());
                $json['success'] = lang('module/menu.text_success');
                $json['redirect'] = site_url('setting/module?user_token=' . $this->request->getVar('user_token'));
            }
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('module/menu.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard', 'user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('module/menu.text_module'),
            'href' => site_url('setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('module/menu.heading_title'),
            'href' => site_url('module/menu?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['action'] = site_url('module/menu/save?user_token=' . $this->request->getVar('user_token'));
        $data['back'] = site_url('setting/module?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('module_menu_output')) {
            $data['module_menu_output'] = $this->request->getPost('module_menu_output');
        } elseif ($this->registry->get('module_menu_output')) {
            $data['module_menu_output'] = $this->registry->get('module_menu_output');
        } else {
            $data['module_menu_output'] = '';
        }

        if ($this->request->getPost('module_menu_status')) {
            $data['module_menu_status'] = $this->request->getPost('module_menu_status');
        } else {
            $data['module_menu_status'] = $this->registry->get('module_menu_status');
        }

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('module/menu');

        return $this->template->render('module/menu', $data);
    }
    
    //--------------------------------------------------------------------
}
