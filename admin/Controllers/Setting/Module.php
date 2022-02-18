<?php

namespace Admin\Controllers\Setting;

use Admin\Controllers\BaseController;
use Admin\Models\User\UserGroupModel;
use Shared\Models\Setting\ExtensionModel;
use Shared\Models\Setting\ModulesModel;

class Module extends BaseController
{
    public function install()
    {
        $json = [];

        if ($this->request->isAJAX()) {

            if (!$this->user->hasPermission('modify', 'setting/module')) {
                $json['warning'] = lang('setting/module.error.permission');
            }

            if (!$json) {
                $extensionModel = new ExtensionModel();

                $extension = $this->request->getVar('extension');

                $extensionModel->install('module', $extension);

                $userGroupModel = new UserGroupModel();

                $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'module/' . $this->request->getVar('extension'));
                $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'module/' . $this->request->getVar('extension'));

                $json['success']  = lang("module/{$extension}.text_success");
                $json['redirect'] = site_url('setting/module?user_token=' . $this->session->get('user_token'));
            }
        }

        return $this->response->setJSON($json);
    }

    public function uninstall()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (!$this->user->hasPermission('modify', 'setting/module')) {
                $json['warning'] = lang('setting/module.error.permission');
            }

            if (!$json) {
                $extensionModel = new ExtensionModel();
            
                $extension = $this->request->getVar('extension');

                $modulesModel = new ModulesModel();

                $extensionModel->uninstall('module', $extension);
                $modulesModel->deleteModulesByCode($extension);

                $json['success']  = lang("module/{$extension}.text_success");
                $json['redirect'] = site_url('setting/module?user_token=' . $this->session->get('user_token'));
            }
        }

        return $this->response->setJSON($json);
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (!$this->user->hasPermission('modify', 'setting/module')) {
                $json['warning'] = lang('setting/module.error.permission');
            }

            if (!$json) {
                $modulesModel = new ModulesModel();

                $name = $this->request->getPost('extension');
            
                $modulesModel->addModule($this->request->getVar('extension'), lang("module/{$name}.heading_title"));
            
                $json['success']  = lang("module/{$name}.text_success");
                $json['redirect'] = site_url('setting/module?user_token=' . $this->session->get('user_token'));
            }
        }

        return $this->response->setJSON($json);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (!$this->user->hasPermission('modify', 'setting/module')) {
                $json['warning'] = lang('setting/module.error.permission');
            }

            if (!$json && $this->request->getVar('module_id')) {
                $modulesModel = new ModulesModel();

                $name = $this->request->getVar('name');

                $modulesModel->deleteModule($this->request->getVar('module_id'));

                $json['success']  = lang("module/{$name}.text_success");
                $json['redirect'] = site_url('setting/module?user_token=' . $this->session->get('user_token'));
            }
        }
        
        return $this->response->setJSON($json);
    }
    
    public function index()
    {
        $this->document->setTitle(lang('setting/module.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/module.heading_title'),
            'href' => site_url('setting/module?user_token=' . $this->session->get('user_token')),
        ];


        $data['text_layout'] = sprintf(lang('setting/module.text_layout'), site_url('design/layout?user_token=' . $this->session->get('user_token')));

        $extensionModel = new ExtensionModel();
        $modulesModel = new ModulesModel();

        $installedExtensions = $extensionModel->getInstalled('module');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Controllers/Module/' . ucfirst($value) . '.php')) {
                $extensionModel->uninstall('module', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Controllers/Module', 1);

        sort($files);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');

                $module_data = [];

                $modules = $modulesModel->getModulesByCode($basename);

                foreach ($modules as $module) {
                    if ($module['setting']) {
                        $setting_info = json_decode($module['setting'], true);
                    } else {
                        $setting_info = [];
                    }
                    
                    $module_data[] = [
                        'module_id' => $module['module_id'],
                        'name'      => $module['name'],
                        'status'    => (isset($setting_info['status']) && $setting_info['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                        'edit'      => site_url('module/' . strtolower($basename) . '?user_token=' . $this->session->get('user_token') . '&module_id=' . $module['module_id']),
                        'delete'    => site_url('setting/module/delete?user_token=' . $this->session->get('user_token') . '&module_id=' . $module['module_id'] . '&name=' . $basename )
                    ];
                }
                

                $data['extensions'][] = [
                    'name'       => lang('module/' . strtolower($basename) . '.heading_title'),
                    'width'      => $this->registry->get('module_' . strtolower($basename) . '_width'),
                    'status'     => $this->registry->get('module_' . strtolower($basename) . '_status') ? lang('en.text_enabled') : lang('en.text_disabled'),
                    'sort_order' => $this->registry->get('module_' . strtolower($basename) . '_sort_order'),
                    'module'     => $module_data,
                    'install'    => site_url('setting/module/install?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => site_url('setting/module/uninstall?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => site_url('module/' . strtolower($basename) .'?user_token=' . $this->session->get('user_token')),
                ];
            }
        }

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('setting/module');

        return $this->template->render('setting/module', $data);
    }

    // ---------------------------------------
}
