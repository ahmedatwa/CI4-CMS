<?php

namespace Admin\Controllers\Catalog;

use Admin\Controllers\BaseController;
use Admin\Models\Catalog\InformationModel;
use Shared\Models\Localisation\LanguageModel;

class Information extends BaseController
{
    protected $informationModel;

    public function __construct()
    {
        $this->informationModel = new InformationModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->informationModel->addInformation($this->request->getPost());
                $json['success'] = lang('catalog/information.text_success');
                $json['redirect'] = site_url('catalog/information?user_token=' . $this->request->getVar('user_token'));
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
                $this->informationModel->editInformation($this->request->getVar('information_id'), $this->request->getPost());
                $json['success'] = lang('catalog/information.text_success');
                $json['redirect'] = site_url('catalog/information?user_token=' . $this->request->getVar('user_token'));
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
            if (!$this->user->hasPermission('modify', 'catalog/information')) {
                $json['error_warning'] = lang('catalog/information.error.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                if ($this->request->getPost('selected')) {
                    foreach ($this->request->getPost('selected') as $information_id) {
                        $this->informationModel->delete($information_id);
                    }
                    $json['success'] = lang('catalog/information.text_success');
                    $json['redirect'] = site_url('catalog/information?user_token=' . $this->request->getVar('user_token'));
                } else {
                    $json['error_warning'] = lang('en.error.form');
                }
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('catalog/information.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/information.heading_title'),
            'href' => site_url('catalog/information?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['informations'] = [];
        
        $results = $this->informationModel->getInformations();

        foreach ($results as $result) {
            $data['informations'][] = [
                'information_id' => $result['information_id'],
                'title'          => $result['title'],
                'status'         => ($result['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                'edit'           => site_url('catalog/information/form?user_token=' . $this->request->getVar('user_token') . '&information_id=' . $result['information_id']),
                'delete'         => site_url('catalog/information/delete?user_token=' . $this->request->getVar('user_token') . '&information_id=' . $result['information_id']),
            ];
        }

        $data['add']    = site_url('catalog/information/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('catalog/information/delete?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('catalog/information');

        return $this->template->render('catalog/information_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('catalog/information.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/information.heading_title'),
            'href' => site_url('catalog/information/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('information_id') ? lang('catalog/information.text_add') : lang('catalog/information.text_edit');

        $data['back'] = site_url('catalog/information?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('information_id')) {
            $data['action'] = site_url('catalog/information/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('catalog/information/edit?user_token=' . $this->request->getVar('user_token') . '&information_id=' . $this->request->getVar('information_id'));
        }

        if ($this->request->getVar('information_id') && ($this->request->getMethod() != 'post')) {
            $information_info = $this->informationModel->getInformation($this->request->getVar('information_id'));
        }

        if ($this->request->getPost('information_description')) {
            $data['information_description'] = $this->request->getPost('information_description');
        } elseif ($this->request->getVar('information_id')) {
            $data['information_description'] = $this->informationModel->getInformationDescription($this->request->getVar('information_id'));
        } else {
            $data['information_description'] = [];
        }

        if ($this->request->getPost('information_seo_url')) {
            $data['information_seo_url'] = $this->request->getPost('information_seo_url');
        } elseif ($this->request->getVar('information_id')) {
            $data['information_seo_url'] = $this->informationModel->getInformationDescription($this->request->getVar('information_id'));
        } else {
            $data['information_seo_url'] = [];
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($information_info)) {
            $data['sort_order'] = $information_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($this->request->getPost('bottom')) {
            $data['bottom'] = $this->request->getPost('bottom');
        } elseif (!empty($information_info)) {
            $data['bottom'] = $information_info['bottom'];
        } else {
            $data['bottom'] = 0;
        }

        if ($this->request->getPost('top')) {
            $data['top'] = $this->request->getPost('top');
        } elseif (!empty($information_info)) {
            $data['top'] = $information_info['top'];
        } else {
            $data['top'] = 0;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($information_info)) {
            $data['status'] = $information_info['status'];
        } else {
            $data['status'] = 1;
        }

        $languageModel = new LanguageModel();
        $data['languages'] = $languageModel->where('status', 1)->findAll();

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('catalog/information');

        return $this->template->render('catalog/information_form', $data);
    }

    protected function validateForm()
    {            
        foreach ($this->request->getPost('information_description') as $language_id => $value) {
            if (! $this->validate([
                    "information_description.{$language_id}.title" => [
                    'label' => 'Information Title',
                    'rules' => 'required|min_length[3]|max_length[64]'
                ],
                "information_description.{$language_id}.description" => [
                    'label' => 'Meta Description',
                    'rules' => 'required|min_length[3]'
                ],
                "information_description.{$language_id}.meta_title" => [
                    'label' => 'Meta Title',
                    'rules' => 'required|min_length[3]|max_length[255]'
                ],
                ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.form'));
                return false;
            }
        }

        if (!$this->user->hasPermission('modify', 'catalog/information')) {
            $this->session->setFlashdata('error_warning', lang('catalog/information.error.permission'));
            return false;
        }

        return true;
    }
        
    //--------------------------------------------------------------------
}
