<?php

namespace Admin\Controllers\Extension;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\ExtensionModel;
use Admin\Models\User\UserGroupModel;

class Dashboard extends BaseController
{
    public function install()
    {
        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/dashboard')) {
            $json['error'] = lang('extension/dashboard.error.permission');
        }

        if (! $json && $this->request->isAJAX()) {
            $extensionsModel = new ExtensionModel();

            $extensionsModel->install('dashboard', $this->request->getVar('extension'));

            $userGroupModel = new UserGroupModel();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/dashboard/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/dashboard/' . $this->request->getVar('extension'));

            // Call install Method is exists
            $class = 'Extensions\Controllers\Dashboard\\' . ucfirst($this->request->getVar('extension'));
            if (class_exists($class) && method_exists($class, 'install')) {
                $controller = new $class();
                $controller->install();
            }

            $json['success'] = lang('dashboard/' . $this->request->getVar('extension') . '.text_success');
        }

        return $this->response->setJSON($json);
    }

    public function uninstall()
    {
        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/dashboard')) {
            $json['error'] = lang('extension/dashboard.error.permission');
        }

        if (! $json && $this->request->isAJAX()) {
            $extensionsModel = new ExtensionModel();
            $extensionsModel->uninstall('dashboard', $this->request->getVar('extension'));

            // Call uninstall Method is exists
            $class = 'Extensions\Controllers\Dashboard\\' . ucfirst($this->request->getVar('extension'));
            if (class_exists($class) && method_exists($class, 'uninstall')) {
                $controller = new $class();
                $controller->uninstall();
            }

            $json['success'] = lang('dashboard/' . $this->request->getVar('extension') . '.text_success');
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {

        $this->document->setTitle(lang('extension/dashboard.heading_title'));

        $extensionsModel = new ExtensionModel();
        
        $installedExtensions = $extensionsModel->getInstalled('dashboard');

        foreach ($installedExtensions as $key => $value) {
            if (! is_file(APPPATH . 'Extensions/Controllers/Dashboard/' . ucfirst($value) . '.php')) {
                $extensionsModel->uninstall('dashboard', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Dashboard', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                $setting  = $this->registry->get('dashboard_' . strtolower($basename));

                $data['extensions'][] = [
                    'name'       => lang('dashboard/' . strtolower($basename) . '.heading_title'),
                    'width'      => $setting[strtolower($basename)]['width'] ?? '',
                    'status'     => isset($setting[strtolower($basename)]['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                    'sort_order' => $setting[strtolower($basename)]['sort_order'] ?? '',
                    'install'    => site_url('extension/dashboard/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => site_url('extension/dashboard/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => site_url('extensions/dashboard/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        lang('extension/dashboard');

        return $this->template->render('extension/dashboard', $data);
    }

    // --------------------------------------------------------------
}
