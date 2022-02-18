<?php

namespace Admin\Controllers\Extension;

use Admin\Controllers\BaseController;
use Admin\Models\User\UserGroupModel;
use Shared\Models\Setting\SettingModel;
use Shared\Models\Setting\ExtensionModel;

class Report extends BaseController
{
    public function install()
    {
        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/report')) {
            $json['error'] = lang('extension/report.permission');
        }

        if (! $json && $this->request->isAJAX()) {
            $extensionModel = new ExtensionModel();
            $extensionModel->install('report', $this->request->getVar('extension'));

            $userGroupModel = new UserGroupModel();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/report/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/report/' . $this->request->getVar('extension'));
            
            // Call install Method is exists
            $class = 'Extensions\Controllers\Report\\' . ucfirst($this->request->getVar('extension'));
            if (class_exists($class) && method_exists($class, 'install')) {
                $controller = new $class();
                $controller->install();
            }

            $json['success'] = lang('report/' . $this->request->getVar('extension') . '.text_success');
        }

        return $this->response->setJSON($json);
    }

    public function uninstall()
    {
        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/report')) {
            $json['error'] = lang('extension/report.permission');
        }

        if (! $json && $this->request->isAJAX()) {
            $extensionModel = new ExtensionModel();
            $extensionModel->uninstall('report', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            $class = 'Extensions\Controllers\Report\\' . ucfirst($this->request->getVar('extension'));
            if (class_exists($class) && method_exists($class, 'uninstall')) {
                $controller = new $class();
                $controller->uninstall();
            }
        
            $json['success'] = lang('report/' . $this->request->getVar('extension') . '.text_success');
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('extension/report.heading_title'));
        
        $extensionModel = new ExtensionModel();

        $installedExtensions = $extensionModel->getInstalled('report');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/Report/' . ucfirst($value) . '.php')) {
                $extensionModel->uninstall('report', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Report', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                $setting = $this->registry->get('report_' . strtolower($basename));

                $data['extensions'][] = [
                    'name'       => lang('report/' . strtolower($basename) . '.heading_title'),
                    'status'    => isset($setting[strtolower($basename)]['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                    'install'    => base_url('index.php/extension/report/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/report/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extensions/report/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        lang('extension/report');

        return $this->template->render('extension/report', $data);
    }

    // --------------------------------------------------------------
}
