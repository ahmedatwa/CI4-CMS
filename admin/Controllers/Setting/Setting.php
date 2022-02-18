<?php

namespace Admin\Controllers\Setting;

use Admin\Controllers\BaseController;
use Shared\Models\Localisation\LanguageModel;
use Shared\Models\Localisation\CurrencyModel;
use Shared\Models\Setting\SettingModel;
use Shared\Models\Setting\ExtensionModel;

class Setting extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post')) {
                $this->settingModel->editSetting('config', $this->request->getPost());
                $json['success'] = lang('setting/setting.text_success');
                $json['redirect'] = site_url('setting/setting?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->getFlashdata('error_warning');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('setting/setting.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
            ];
        
        $data['breadcrumbs'][] = [
            'text' => lang('setting/setting.heading_title'),
            'href' => site_url('setting/setting?user_token=' . $this->request->getVar('user_token')),
            ];
        
        $data['action'] = site_url('setting/setting/edit?user_token=' . $this->request->getVar('user_token'));
        
        if ($this->request->getMethod() != 'post') {
            $settingInfo = $this->settingModel->findAll();
        }
        // General
        if ($this->request->getPost('config_meta_title')) {
            $data['config_meta_title'] = $this->request->getPost('config_meta_title');
        } elseif (!empty($settingInfo['config_meta_title'])) {
            $data['config_meta_title'] = $settingInfo['config_meta_title'];
        } else {
            $data['config_meta_title'] = '';
        }

        if ($this->request->getPost('config_meta_description')) {
            $data['config_meta_description'] = $this->request->getPost('config_meta_description');
        } elseif (!empty($settingInfo['config_meta_description'])) {
            $data['config_meta_description'] = $settingInfo['config_meta_description'];
        } else {
            $data['config_meta_description'] = '';
        }

        if ($this->request->getPost('config_meta_keyword')) {
            $data['config_meta_keyword'] = $this->request->getPost('config_meta_keyword');
        } elseif (!empty($settingInfo['config_meta_keyword'])) {
            $data['config_meta_keyword'] = $settingInfo['config_meta_keyword'];
        } else {
            $data['config_meta_keyword'] = '';
        }

        if ($this->request->getPost('config_logo')) {
            $data['config_logo'] = $this->request->getPost('config_logo');
        } elseif (!empty($settingInfo['config_logo'])) {
            $data['config_logo'] = $settingInfo['config_logo'];
        } else {
            $data['config_logo'] = '';
        }

        if ($this->request->getPost('config_logo') && is_file(DIR_IMAGE . $this->request->getPost('config_logo'))) {
            $data['logo'] = resizeImage($this->request->getPost('config_logo'), 100, 100);
        } elseif ($this->registry->get('config_logo') && is_file(DIR_IMAGE . $this->registry->get('config_logo'))) {
            $data['logo'] = resizeImage($this->registry->get('config_logo'), 100, 100);
        } else {
            $data['logo'] = resizeImage('no_image.jpg', 100, 100);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 100, 100);

        if ($this->request->getPost('config_theme')) {
            $data['config_theme'] = $this->request->getPost('config_theme');
        } elseif (!empty($settingInfo['config_theme'])) {
            $data['config_theme'] = $settingInfo['config_theme'];
        } else {
            $data['config_theme'] = '';
        }

        $data['themes'] = [];

        $extensionModel = new ExtensionModel();

        $extensions = $extensionModel->getInstalled('theme');

        foreach ($extensions as $code) {
            $data['themes'][] = [
                'text'  => lang('theme/' . $code . '.heading_title'),
                'value' => ($code == 'basic') ? 'default' : $code,
            ];
        }

        if ($this->request->getPost('config_name')) {
            $data['config_name'] = $this->request->getPost('config_name');
        } elseif (!empty($settingInfo['config_name'])) {
            $data['config_name'] = $settingInfo['config_name'];
        } else {
            $data['config_name'] = '';
        }

        if ($this->request->getPost('config_template_engine')) {
            $data['config_template_engine'] = $this->request->getPost('config_template_engine');
        } elseif (!empty($settingInfo['config_template_engine'])) {
            $data['config_template_engine'] = $settingInfo['config_template_engine'];
        } else {
            $data['config_template_engine'] = 'twig';
        }

        if ($this->request->getPost('config_owner')) {
            $data['config_owner'] = $this->request->getPost('config_owner');
        } elseif (!empty($settingInfo['config_owner'])) {
            $data['config_owner'] = $settingInfo['config_owner'];
        } else {
            $data['config_owner'] = '';
        }
        if ($this->request->getPost('config_address')) {
            $data['config_address'] = $this->request->getPost('config_address');
        } elseif (!empty($settingInfo['config_address'])) {
            $data['config_address'] = $settingInfo['config_address'];
        } else {
            $data['config_address'] = '';
        }
        if ($this->request->getPost('config_email')) {
            $data['config_email'] = $this->request->getPost('config_email');
        } elseif (!empty($settingInfo['config_email'])) {
            $data['config_email'] = $settingInfo['config_email'];
        } else {
            $data['config_email'] = '';
        }
        if ($this->request->getPost('config_telephone')) {
            $data['config_telephone'] = $this->request->getPost('config_telephone');
        } elseif (!empty($settingInfo['config_telephone'])) {
            $data['config_telephone'] = $settingInfo['config_telephone'];
        } else {
            $data['config_telephone'] = '';
        }
        if ($this->request->getPost('config_opening_times')) {
            $data['config_opening_times'] = $this->request->getPost('config_opening_times');
        } elseif (!empty($settingInfo['config_opening_times'])) {
            $data['config_opening_times'] = $settingInfo['config_opening_times'];
        } else {
            $data['config_opening_times'] = '';
        }
        if ($this->request->getPost('config_admin_limit')) {
            $data['config_admin_limit'] = $this->request->getPost('config_admin_limit');
        } elseif (!empty($settingInfo['config_admin_limit'])) {
            $data['config_admin_limit'] = $settingInfo['config_admin_limit'];
        } else {
            $data['config_admin_limit'] = '';
        }

        if ($this->request->getPost('config_customer_activity')) {
            $data['config_customer_activity'] = $this->request->getPost('config_customer_activity');
        } elseif (!empty($settingInfo['config_customer_activity'])) {
            $data['config_customer_activity'] = $settingInfo['config_customer_activity'];
        } else {
            $data['config_customer_activity'] = '';
        }

        if ($this->request->getPost('config_customer_online')) {
            $data['config_customer_online'] = $this->request->getPost('config_customer_online');
        } elseif (!empty($settingInfo['config_customer_online'])) {
            $data['config_customer_online'] = $settingInfo['config_customer_online'];
        } else {
            $data['config_customer_online'] = 0;
        }

        if ($this->request->getPost('config_login_attempts')) {
            $data['config_login_attempts'] = $this->request->getPost('config_login_attempts');
        } elseif (!empty($settingInfo['config_login_attempts'])) {
            $data['config_login_attempts'] = $settingInfo['config_login_attempts'];
        } else {
            $data['config_login_attempts'] = '';
        }
        if ($this->request->getPost('config_maintenance')) {
            $data['config_maintenance'] = $this->request->getPost('config_maintenance');
        } elseif (!empty($settingInfo['config_maintenance'])) {
            $data['config_maintenance'] = $settingInfo['config_maintenance'];
        } else {
            $data['config_maintenance'] = 0;
        }

        if ($this->request->getPost('config_file_ext_allowed')) {
            $data['config_file_ext_allowed'] = $this->request->getPost('config_file_ext_allowed');
        } elseif (!empty($settingInfo['config_social_networks'])) {
            $data['config_file_ext_allowed'] = $settingInfo['config_file_ext_allowed'];
        } else {
            $data['config_social_networks'] = [];
        }

        if ($this->request->getPost('config_file_mime_allowed')) {
            $data['config_file_mime_allowed'] = $this->request->getPost('config_file_mime_allowed');
        } elseif (!empty($settingInfo['config_file_mime_allowed'])) {
            $data['config_file_mime_allowed'] = $settingInfo['config_file_mime_allowed'];
        } else {
            $data['config_social_networks'] = [];
        }
        // Social Networks
        if ($this->request->getPost('config_social_networks')) {
            $data['config_social_networks'] = $this->request->getPost('config_social_networks');
        } elseif (!empty($settingInfo['config_social_networks'])) {
            $data['config_social_networks'] = $settingInfo['config_social_networks'];
        } else {
            $data['config_social_networks'] = [];
        }

        if ($this->request->getPost('config_global_alert')) {
            $data['config_global_alert'] = $this->request->getPost('config_global_alert');
        } elseif (!empty($settingInfo['config_global_alert'])) {
            $data['config_global_alert'] = $settingInfo['config_global_alert'];
        } else {
            $data['config_global_alert'] = '';
        }

        if ($this->request->getPost('config_chat_widget')) {
            $data['config_chat_widget'] = $this->request->getPost('config_chat_widget');
        } elseif (!empty($settingInfo['config_chat_widget'])) {
            $data['config_chat_widget'] = $settingInfo['config_chat_widget'];
        } else {
            $data['config_chat_widget'] = '';
        }

        $languageModel = new LanguageModel();
		$data['languages'] = $languageModel->findAll();

        if ($this->request->getPost('config_language')) {
			$data['config_language'] = $this->request->getPost('config_language');
        } elseif (!empty($settingInfo['config_language'])) {
            $data['config_language'] = $settingInfo['config_language'];
        } else {
			$data['config_language'] = '';
		}

        $currencyModel = new CurrencyModel();
		$data['currencies'] = $currencyModel->findAll();

        if ($this->request->getPost('config_currency')) {
			$data['config_currency'] = $this->request->getPost('config_currency');
        } elseif (!empty($settingInfo['config_currency'])) {
            $data['config_currency'] = $settingInfo['config_currency'];
        } else {
			$data['config_currency'] = '';
		}

		if ($this->request->getPost('config_admin_language')) {
			$data['config_admin_language'] = $this->request->getPost('config_admin_language');
        } elseif (!empty($settingInfo['config_admin_language'])) {
            $data['config_admin_language'] = $settingInfo['config_admin_language'];
        } else {
			$data['config_admin_language'] = '';
		}

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('setting/setting');

        return $this->template->render('setting/setting', $data);
    }
    
    protected function validateForm()
    {
        if (! $this->validate([
        'config_meta_title' => [
            'label' => 'Title',
            'rules' => 'required|min_length[3]'
        ],
        'config_name' => [
            'label' => 'Site Name',
            'rules' => 'required|min_length[3]|max_length[32]'
        ],
        'config_owner' => [
            'label' => 'Site Owner',
            'rules' => 'required|min_length[3]|max_length[64]'
        ],
        'config_address' => [
            'label' => 'Site Address',
            'rules' => 'required|min_length[10]|max_length[256]'
        ],
        'config_email' => [
            'label' => 'E-Mail Address',
            'rules' => 'required|valid_email'
        ],
        'config_telephone' => [
            'label' => 'Telephone',
            'rules' => 'required|min_length[3]|max_length[32]'
        ],
        'config_admin_limit' => [
            'label' => 'Admin List Limit',
            'rules' => 'required'
        ],
        'config_login_attempts' => [
            'label' => 'Login Attempts',
            'rules' => 'required|numeric|greater_than[0]'
        ],
          ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', 'setting/setting')) {
            $this->session->setFlashdata('error_warning', lang('setting/setting.error.permission'));
            return false;
        }
        return true;
    }

    //--------------------------------------------------------------------
}
