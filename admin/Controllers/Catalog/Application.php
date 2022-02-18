<?php

namespace Admin\Controllers\Catalog;

use Admin\Controllers\BaseController;
use Admin\Models\Catalog\InformationModel;
use Admin\Models\Localisation\LanguageModel;

class Application extends BaseController
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
            if (($this->request->getMethod() == 'post') && $this->_validateForm()) {
                $this->informationModel->addInformation($this->request->getPost());
                $json['success'] = lang('catalog/application.text_success');
                $json['redirect'] = site_url('catalog/application?user_token=' . $this->request->getVar('user_token'));
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
            if (($this->request->getMethod() == 'post') && $this->_validateForm()) {
                $this->informationModel->editInformation($this->request->getVar('application_id'), $this->request->getPost());
                $json['success'] = lang('catalog/application.text_success');
                $json['redirect'] = site_url('catalog/application?user_token=' . $this->request->getVar('user_token'));
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

            if (!$this->user->hasPermission('modify', 'catalog/application')) {
                $json['error_warning'] = lang('catalog/application.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $application_id) {
                    $this->informationModel->delete($application_id);
                }
                $json['success'] = lang('catalog/application.text_success');
                $json['redirect'] = site_url('catalog/application?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function purge()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->_validateDelete()) {
                $this->informationModel->purgeDeleted();
                $json['success'] = lang('catalog/application.text_success');
                $json['redirect'] = site_url('catalog/application?user_token=' . $this->request->getVar('user_token'));
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('catalog/application.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/application.heading_title'),
            'href' => site_url('catalog/application?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['informations'] = [];
        
        $results = $this->informationModel->findAll();

        foreach ($results as $result) {
            $data['informations'][] = [
                'application_id' => $result['application_id'],
                'title'          => $result['title'],
                'status'         => ($result['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
                'edit'           => site_url('catalog/application/form?user_token=' . $this->request->getVar('user_token') . '&application_id=' . $result['application_id']),
                'delete'         => site_url('catalog/application/delete?user_token=' . $this->request->getVar('user_token') . '&application_id=' . $result['application_id']),
            ];
        }

        $data['add'] = site_url('catalog/application/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('catalog/application/delete?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        return $this->template->render('catalog/application_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('catalog/application.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/application.heading_title'),
            'href' => site_url('catalog/application/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('application_id') ? lang('catalog/application.text_add') : lang('catalog/application.text_edit');

        $data['back'] = site_url('catalog/application?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('application_id')) {
            $data['action'] = site_url('catalog/application/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('catalog/application/edit?user_token=' . $this->request->getVar('user_token') . '&application_id=' . $this->request->getVar('application_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getVar('application_id') && ($this->request->getMethod() != 'post')) {
            $information_info = $this->informationModel->getInformation($this->request->getVar('application_id'));
        }

        if ($this->request->getPost('information_description')) {
            $data['information_description'] = $this->request->getPost('information_description');
        } elseif ($this->request->getVar('application_id')) {
            $data['information_description'] = $this->informationModel->getInformationDescription($this->request->getVar('application_id'));
        } else {
            $data['information_description'] = [];
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($information_info)) {
            $data['sort_order'] = $information_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        if ($this->request->getPost('bottom')) {
            $data['bottom'] = $this->request->getPost('bottom');
        } elseif (!empty($information_info)) {
            $data['bottom'] = $information_info['bottom'];
        } else {
            $data['bottom'] = 0;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($information_info)) {
            $data['status'] = $information_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['user_token'] = $this->session->get('user_token');

        // Language Data
        $data['information_lang'] = lang('catalog/application');

        $this->template->render('catalog/application_form', $data);
    }

    protected function _validateForm()
    {            
        if (! $this->validate([
                "information_description.title" => [
                'label' => 'Information Title',
                'rules' => 'required|min_length[3]|max_length[64]'
            ],
            "information_description.description" => [
                'label' => 'Information Description',
                'rules' => 'required|min_length[3]'
            ],
            "information_description.meta_title" => [
                'label' => 'Information Meta Title',
                'rules' => 'required|min_length[3]|max_length[255]'
            ],
        ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', 'catalog/application')) {
            $this->session->setFlashdata('error_warning', lang('catalog/application.error.permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
