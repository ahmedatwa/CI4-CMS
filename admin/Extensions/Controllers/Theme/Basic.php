<?php

namespace Extensions\Controllers\Theme;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\SettingModel;

class Basic extends BaseController
{
    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {

            if (!$this->user->hasPermission('modify', 'extensions/theme/basic')) {
                $json['error_warning'] = lang('theme/basic.error.permission');
            }

            if (!$json && ($this->request->getMethod() == 'post')) {
                $settingModel = new SettingModel();
                $settingModel->editSetting('theme_basic', $this->request->getPost());
                $json['success'] = lang('theme/basic.text_success');
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
        $this->document->setTitle(lang('theme/basic.heading_title'));

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
        'text' => lang('theme/basic.heading_title'),
        'href' => base_url('index.php/extensions/theme/default/user_token=' . $this->session->get('user_token'))
      ];

        $data['action'] = base_url('index.php/extensions/theme/basic/edit?user_token=' . $this->session->get('user_token'));
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
        
        if ($this->request->getPost('theme_basic')) {
            $data['theme_basic'] = $this->request->getPost('theme_basic');
        } elseif ($this->registry->get('theme_basic')) {
            $data['theme_basic'] = $this->registry->get('theme_basic')['basic'];
        } else {
            $data['theme_basic'] = [];
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('Extensions\Theme\Basic');

        return $this->template->render('Extensions\Views\theme\basic', $data);
    }
    
    //--------------------------------------------------------------------
}
