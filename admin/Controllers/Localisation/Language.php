<?php

namespace Admin\Controllers\Localisation;

use Admin\Controllers\BaseController;
use Shared\Models\Localisation\LanguageModel;

class Language extends BaseController
{
    protected $languageModel;

    public function __construct()
    {
        $this->languageModel = new LanguageModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->languageModel->addLanguage($this->request->getPost());
                $json['success']  = lang('localisation/language.text_success');
                $json['redirect'] = site_url('localisation/language?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->getFlashdata('error_warning');
            }
        }
        return $this->response->setJSON($json);
    }

    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $languageModel->editLanguage($this->request->getVar('language_id'), $this->request->getPost());
                $json['success']  = lang('localisation/language.text_success');
                $json['redirect'] = site_url('localisation/language?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->getFlashdata('error_warning');
            }
        }

        return $this->response->setJSON($json);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (!$this->user->hasPermission('modify', 'localisation/language')) {
                $json['error_warning'] = lang('localisation/language.error.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $language_id) {
                    $this->languageModel->delete($language_id);
                }
                $json['success']  = lang('localisation/language.text_success');
                $json['redirect'] = site_url('localisation/language?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('localisation/language.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('localisation/language.heading_title'),
            'href' => site_url('localisation/language?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['languages'] = [];
        $languageModel = new LanguageModel();

        $results = $languageModel->findAll($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['languages'][] = [
                'language_id' => $result['language_id'],
                'name'        => $result['name'],
                'code'        => $result['code'],
                'edit'        => site_url('localisation/language/form?user_token=' . $this->request->getVar('user_token') . '&language_id=' . $result['language_id']),
                'delete'      => site_url('localisation/language/delete?user_token=' . $this->request->getVar('user_token') . '&language_id=' . $result['language_id']),
            ];
        }

        $data['add']    = site_url('localisation/language/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('localisation/language/delete?user_token=' . $this->request->getVar('user_token'));


        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->request->getVar('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('localisation/language');

        return $this->template->render('localisation/language_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('localisation/language.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('localisation/language.heading_title'),
            'href' => site_url('localisation/language/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = ! $this->request->getVar('language_id') ? lang('localisation/language.text_add') : lang('localisation/language.text_edit');

        $data['back'] = site_url('localisation/language?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('language_id')) {
            $data['action'] = site_url('localisation/language/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('localisation/language/edit?user_token=' . $this->request->getVar('user_token') . '&language_id=' . $this->request->getVar('language_id'));
        }

        if ($this->request->getVar('language_id') && ($this->request->getMethod() != 'post')) {
            $language_info = $this->languageModel->find($this->request->getVar('language_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($language_info['name'])) {
            $data['name'] = $language_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('code')) {
            $data['code'] = $this->request->getPost('code');
        } elseif (!empty($language_info['code'])) {
            $data['code'] = $language_info['code'];
        } else {
            $data['code'] = '';
        }

        helper('filesystem');

        $languages = directory_map(ROOTPATH . 'Catalog/Language', 1);

        $data['languages'] = [];

        foreach (array_reverse($languages) as $language) {
            $data['languages'][] = rtrim($language, '/');
        }

        if ($this->request->getPost('locale')) {
            $data['locale'] = $this->request->getPost('locale');
        } elseif (!empty($language_info['locale'])) {
            $data['locale'] = $language_info['locale'];
        } else {
            $data['locale'] = '';
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($language_info['sort_order'])) {
            $data['sort_order'] = $language_info['sort_order'];
        } else {
            $data['sort_order'] = 1;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($language_info)) {
            $data['status'] = $language_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('localisation/language');

        return $this->template->render('localisation/language_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'name' => [
                    'label' => 'Language Name',
                    'rules' => 'required|min_length[3]|max_length[32]',
                ],
                'code'  => [
                    'label' => 'Language Code',
                    'rules' => 'required|min_length[2]',
                ],
                'locale' => 'required',
                ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', 'localisation/language')) {
            $this->session->setFlashdata('error_warning', lang('localisation/language.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
