<?php

namespace Extensions\Controllers\Theme;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\SettingModel;

class Dustrix extends BaseController
{
    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {

            if (!$this->user->hasPermission('modify', 'extensions/theme/dustrix')) {
                $json['error_warning'] = lang('theme/dustrix.error.permission');
            }

            if (!$json && ($this->request->getMethod() == 'post')) {
                $settingModel = new SettingModel();
                $settingModel->editSetting('theme_dustrix', $this->request->getPost());
                $json['success'] = lang('theme/dustrix.text_success');
                $json['redirect'] = site_url('setting/extension?user_token=' . $this->request->getVar('user_token')  . '&type=theme');
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('theme/dustrix.heading_title'));

        $data['breadcrumbs'] = [];
  
        $data['breadcrumbs'][] = [
        'text' => lang('en.text_home'),
        'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token'))
      ];
  
        $data['breadcrumbs'][] = [
        'text' => lang('setting/extension.heading_title'),
        'href' => base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=theme')
      ];
  
        $data['breadcrumbs'][] = [
        'text' => lang('theme/dustrix.heading_title'),
        'href' => base_url('index.php/extensions/theme/dustrix/user_token=' . $this->session->get('user_token'))
      ];

        $data['action'] = base_url('index.php/extensions/theme/dustrix/edit?user_token=' . $this->session->get('user_token'));
        $data['back'] = base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=theme');

        $data['directories'] = [];

        helper('filesystem');

        $directories = directory_map(ROOTPATH . 'catalog/Views/', 1);

        // Exclude Errors Directory
        unset($directories[array_search('errors/', $directories)]);

        foreach ($directories as $key => $directory) {
            $data['directories'][] = basename($directory);
        }

        
        $data['colors'] = directory_map(str_replace('admin', 'catalog', FCPATH) . 'default/stylesheet', 1);
        
        if ($this->request->getPost('theme_dustrix')) {
            $data['theme_dustrix'] = $this->request->getPost('theme_dustrix');
        } elseif ($this->registry->get('theme_dustrix')) {
            $data['theme_dustrix'] = $this->registry->get('theme_dustrix')['dustrix'];
        } else {
            $data['theme_dustrix'] = [];
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('Extensions\Theme\dustrix');

        return $this->template->render('Extensions\Views\theme\dustrix', $data);
    }
    
    //--------------------------------------------------------------------
}
