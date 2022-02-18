<?php

namespace Admin\Controllers\Extension;

use Admin\Controllers\BaseController;
use Extensions\Models\Blog\BlogModel;
use Admin\Models\User\UserGroupModel;
use Shared\Models\Setting\SettingModel;
use Shared\Models\Setting\ExtensionModel;

class Blog extends BaseController
{
    public function install()
    {
        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/blog')) {
            $json['error'] = lang('extension/blog.permission');
        }

        if (! $json && $this->request->isAJAX()) {
            $extensionsModel = new ExtensionModel();
            $extensionsModel->install('blog', $this->request->getVar('extension'));

            $userGroupModel = new UserGroupModel();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/blog/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/blog/' . $this->request->getVar('extension'));

            $settingModel = new SettingModel();
            $settingModel->editSetting('blog_' . $this->request->getVar('extension'), ['blog_' . $this->request->getVar('extension') . '_status' => 1]);

            // Call install Method is exists
            $class = 'Extensions\Controllers\Blog\\' . ucfirst($this->request->getVar('extension'));
            if (class_exists($class) && method_exists($class, 'install')) {
                $controller = new $class();
                $controller->install($this->request->getVar('extension'));
            }

            $json['success'] = lang('blog/' . $this->request->getVar('extension') . '.text_success');
        }

        return $this->response->setJSON($json);
    }

    public function uninstall()
    {
        $json = [];

        if (! $this->user->hasPermission('modify', 'extension/blog')) {
            $json['error'] = lang('extension/blog.permission');
        }

        if (! $json && $this->request->isAJAX()) {
            $extensionsModel = new ExtensionModel();
            $extensionsModel->uninstall('blog', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            $class = 'Extensions\Controllers\Blog\\' . ucfirst($this->request->getVar('extension'));
            if (class_exists($class) && method_exists($class, 'uninstall')) {
                $controller = new $class();
                $controller->uninstall($this->request->getVar('extension'));
            }

            $json['success'] = lang('blog/' . $this->request->getVar('extension') . '.text_success');
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('extension/blog.heading_title'));

        if ($this->session->getFlashdata('warning')) {
            $data['error_warning'] = $this->session->getFlashdata('warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $extensionsModel = new ExtensionModel();

        $installedExtensions = $extensionsModel->getInstalled('blog');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/Blog/' . ucfirst($value) . '.php')) {
                $extensionsModel->uninstall('blog', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Blog', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');

                $data['extensions'][] = [
                    'name'       => lang('blog/' . strtolower($basename) . '.heading_title'),
                    'status'     => ($this->registry->get('blog_' . strtolower($basename) . '_status')) ? lang('en.text_enabled') : lang('en.text_disabled'),
                    'install'    => site_url('extension/blog/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => site_url('extension/blog/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => site_url('extensions/blog/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('extension/blog');

        return $this->template->render('extension/blog', $data);
    }
    
    // --------------------------------------------------------------
}
