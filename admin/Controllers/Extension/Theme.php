<?php

namespace Admin\Controllers\Extension;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\ExtensionModel;
use Admin\Models\User\UserGroupModel;
use Shared\Models\Setting\SettingModel;

class Theme extends BaseController
{
    public function install()
    {
        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/theme')) {
            $json['error'] = lang('extension/theme.permission');
        }

        if (! $json && $this->request->isAJAX()) {
            $extensionsModel = new ExtensionModel();
            $extensionsModel->install('theme', $this->request->getVar('extension'));

            $userGroupModel = new UserGroupModel();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/theme/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/theme/' . $this->request->getVar('extension'));

            $settingModel = new SettingModel();
            $settingModel->editSetting('theme_' . $this->request->getVar('extension'), ['theme_' . $this->request->getVar('extension') => [
                $this->request->getVar('extension') => [
                    'status' => 1]
                ]
              ]
            );

            $json['success'] = lang('theme/' . $this->request->getVar('extension') . '.text_success');
        }

        return $this->response->setJSON($json);
    }

    public function uninstall()
    {
        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/theme')) {
            $json['error'] = lang('extension/theme.permission');
        }

        if (! $json && $this->request->isAJAX()) {
            $extensionsModel = new ExtensionModel();
            $extensionsModel->uninstall('theme', $this->request->getVar('extension'));
            $json['success'] = lang('theme/' . $this->request->getVar('extension') . '.text_success');
        }
        
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('extension/theme.heading_title'));

        $extensionsModel = new ExtensionModel();
        
        $installedExtensions = $extensionsModel->getInstalled('theme');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/Theme/' . $value . '.php')) {
                $extensionsModel->uninstall('theme', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Theme', 1);

        $data['extensions'] = [];
        
        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                $setting = $this->registry->get('theme_' . strtolower($basename));

                $data['extensions'][] = [
                    'name'      => lang('theme/' . strtolower($basename) . '.heading_title'),
                    'status'    => isset($setting[strtolower($basename)]['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                    'install'   => site_url('extension/theme/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall' => site_url('extension/theme/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed' => in_array(strtolower($basename), $installedExtensions),
                    'edit'      => site_url('extensions/theme/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('extension/theme');

        return $this->template->render('extension/theme', $data);
    }
    
    // -----------------------------------------------------------
}
