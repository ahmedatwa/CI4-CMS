<?php

namespace Admin\Controllers\Design;

use Admin\Controllers\BaseController;
use Shared\Models\Design\TranslationModel;
use Shared\Models\Localisation\LanguageModel;

class Translation extends BaseController
{
    protected $translationModel;

    public function __construct()
    {
        $this->translationModel = new TranslationModel();
    }

    public function add()
    {
        $json = [];
        if ($this->request->isAJAX()) {
            if (! $this->user->hasPermission('modify', 'design/translation')) {
                $json['error_warning'] = lang('design/translation.error.permission');
            }

            if (!$json && ($this->request->getMethod() == 'post')) {
                $this->translationModel->insert($this->request->getPost());
                $json['success'] = lang('design/translation.text_success');
                $json['redirect'] = site_url('design/translation?user_token=' . $this->request->getVar('user_token'));
            } 
        }

        return $this->response->setJSON($json);
    }

    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (! $this->user->hasPermission('modify', 'design/translation')) {
                $json['error_warning'] = lang('design/translation.error.permission');
            }

            if (!$json && ($this->request->getMethod() == 'post')) {
                $this->translationModel->editBanner($this->request->getVar('translation_id'), $this->request->getPost());
                $json['success'] = lang('design/translation.text_success');
                $json['redirect'] = site_url('design/translation?user_token=' . $this->request->getVar('user_token'));
            } 
        }

        return $this->response->setJSON($json);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (! $this->user->hasPermission('modify', 'design/translation')) {
                $json['error_warning'] = lang('design/translation.error.permission');
            }

            if (!$json && ($this->request->getMethod() == 'post')) {
                if ($this->request->getPost('selected')) {
                    foreach ($this->request->getPost('selected') as $translation_id) {
                        $this->translationModel->delete($translation_id);
                    }
                    $json['success'] = lang('design/translation.text_success');
                    $json['redirect'] = site_url('design/translation?user_token=' . $this->request->getVar('user_token'));
                } else {
                    $json['error_warning'] = lang('en.error.form');
                }
            }
        }
        return $this->response->setJSON($json);
    }
    
    public function index()
    {
        $this->document->setTitle(lang('design/translation.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('design/translation.heading_title'),
            'href' => base_url('design/translation?user_token=' . $this->request->getVar('user_token'))
         ];

        $data['add'] = base_url('index.php/design/translation/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/design/translation/delete?user_token=' . $this->request->getVar('user_token'));

        $data['translations'] = [];

        $results = $this->translationModel->findAll();

        foreach ($results as $result) {
            $data['translations'][] = [
                'translation_id' => $result['translation_id'],
                'route'          => $result['route'],
                'language'       => $result['language_id'],
                'key'            => $result['key'],
                'value'          => $result['value'],
                'edit'           => site_url('design/translation/form?user_token=' . $this->session->get('user_token') . '&translation_id=' . $result['translation_id']),
            ];
        }

        if (isset($this->request->getPost()['selected'])) {
            $data['selected'] = (array) $this->request->getPost()['selected'];
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('design/translation');

        return $this->template->render('design/translation_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('design/translation.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('design/translation.heading_title'),
            'href' => site_url('design/translation?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['text_form'] = !$this->request->getVar('translation_id') ? lang('design/translation.text_add') : lang('design/translation.text_edit');

        $data['back'] = site_url('design/translation?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('translation_id')) {
            $data['action'] = site_url('design/translation/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('design/translation/edit?user_token=' . $this->request->getVar('user_token') . '&translation_id=' . $this->request->getVar('translation_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getVar('translation_id') && ($this->request->getMethod() != 'post')) {
            $translationInfo = $this->translationModel->find($this->request->getVar('translation_id'));
        }

        $languageModel = new LanguageModel();

        $data['languages'] = $languageModel->findAll();

        if (!empty($translationInfo)) {
            $language = $languageModel->find($translationInfo['language_id']);
            $code = $language['code'];
        } else {
            $code = $this->registry->get('config_language');
            $language = $languageModel->getLanguageByCode($code);
        }

        if ($this->request->getPost('language_id')) {
            $data['language_id'] = $this->request->getPost('language_id');
        } elseif (!empty($translationInfo)) {
            $data['language_id'] = $translationInfo['language_id'];
        } else {
            $data['language_id'] = $language['language_id'];
        }

        if ($this->request->getPost('route')) {
            $data['route'] = $this->request->getPost('route');
        } elseif (!empty($translationInfo)) {
            $data['route'] = $translationInfo['route'];
        } else {
            $data['route'] = true;
        }
        
        if ($this->request->getPost('key')) {
            $data['key'] = $this->request->getPost('key');
        } elseif (!empty($translationInfo)) {
            $data['key'] = $translationInfo['key'];
        } else {
            $data['key'] = '';
        }

        if ($this->request->getPost('value')) {
            $data['value'] = $this->request->getPost('value');
        } elseif (!empty($translationInfo)) {
            $data['value'] = $translationInfo['value'];
        } else {
            $data['value'] = '';
        }
        
        $data['user_token'] = $this->session->get('user_token');

        $data['path'] = site_url('design/translation/path?user_token=' . $this->session->get('user_token'));

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('design/translation');

        return $this->template->render('design/translation_form', $data);
    }

    public function path()
    {
        helper('filesystem');

        $json = [];

        if ($this->request->getVar('language_id')) {
            $language_id = $this->request->getVar('language_id');
        } else {
            $language_id = 0;
        }

        $languageModel = new LanguageModel();

        $language_info = $languageModel->find($language_id);

        if (!empty($language_info)) {
            $path = get_filenames(ROOTPATH . 'catalog/Language/' . $language_info['code'], true);
            foreach ($path as $file) {
                if (substr($file, -4) == '.php') {
                    $json[] = substr(substr($file, strlen(ROOTPATH . 'catalog/Language/' . $language_info['code'].'/')), 0, -4);
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function translation()
    {
        $json = [];

        if ($this->request->getVar('language_id')) {
            $language_id = $this->request->getVar('language_id');
        } else {
            $language_id = 0;
        }

        if ($this->request->getVar('path')) {
            $route = $this->request->getVar('path');
        } else {
            $route = '';
        }

        $languageModel = new LanguageModel();

        $language_info = $languageModel->find($language_id);

        $directory = ROOTPATH . 'catalog/Language/';

        if ($language_info && is_file($directory . $language_info['code'] . '/' . $route . '.php') && substr(str_replace('\\', '/', realpath($directory . $language_info['code'] . '/' . $route . '.php')), 0, strlen($directory)) == str_replace('\\', '/', $directory)) {
            $_ = [];
            $list = [];

            $_ = include($directory . $language_info['code'] . '/' . $route . '.php');
            
            foreach ($_ as $key => $value) {
                $json[] = [
                    'key'   => $key,
                    'value' => $value,
                ];
            }
        }

        return $this->response->setJSON($json);
    }


    // ----------------------------------------------------------------------------
}
