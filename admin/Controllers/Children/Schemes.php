<?php

namespace Admin\Controllers\Children;

use Admin\Controllers\BaseController;
use Admin\Models\Children\SchemesModel;

class Schemes extends BaseController
{
    protected $schemesModel;

    public function __construct()
    {
        $this->schemesModel = new SchemesModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->schemesModel->insert($this->request->getPost());
                $json['success'] = lang('children/schemes.text_success');
                $json['redirect'] = site_url('children/schemes?user_token=' . $this->request->getVar('user_token'));
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
                $this->schemesModel->update($this->request->getVar('scheme_id'), $this->request->getPost());
                $json['success'] = lang('children/schemes.text_success');
                $json['redirect'] = site_url('children/schemes?user_token=' . $this->request->getVar('user_token'));
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

            if (!$this->user->hasPermission('modify', 'children/schemes')) {
                $json['error_warning'] = lang('children/schemes.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $scheme_id) {
                    $this->schemesModel->delete($scheme_id);
                }
                $json['success'] = lang('children/schemes.text_success');
                $json['redirect'] = site_url('children/schemes?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('children/schemes.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('children/schemes.heading_title'),
            'href' => site_url('children/schemes?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['schemes'] = [];

        $results = $this->schemesModel->findAll();

        foreach ($results as $result) {
            $data['schemes'][] = [
                'scheme_id'   => $result['scheme_id'],
                'name'        => $result['name'],
                'description' => word_limiter($result['description'], 20),
                'date_added'  => datetimeFormat($result['date_added']),
                'edit'        => site_url('children/schemes/form?user_token=' . $this->request->getVar('user_token') . '&scheme_id=' . $result['scheme_id']),
                'delete'      => site_url('children/schemes/delete?user_token=' . $this->request->getVar('user_token') . '&scheme_id=' . $result['scheme_id']),
            ];
        }

        $data['add']    = site_url('children/schemes/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('children/schemes/delete?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('children/schemes');

        return $this->template->render('children/schemes_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('children/schemes.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('children/schemes.heading_title'),
            'href' => site_url('children/schemes/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('scheme_id') ? lang('children/schemes.text_add') : lang('children/schemes.text_edit');

        $data['back'] = site_url('children/schemes?user_token=' . $this->request->getVar('user_token'));

        if (! $this->request->getVar('scheme_id')) {
            $data['action'] = site_url('children/schemes/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('children/schemes/edit?user_token=' . $this->request->getVar('user_token') . '&scheme_id=' . $this->request->getVar('scheme_id'));
        }


        if ($this->request->getVar('scheme_id') && ($this->request->getMethod() != 'post')) {
            $schemeInfo = $this->schemesModel->find($this->request->getVar('scheme_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($schemeInfo)) {
            $data['name'] = $schemeInfo['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('description')) {
            $data['description'] = $this->request->getPost('description');
        } elseif (!empty($schemeInfo)) {
            $data['description'] = $schemeInfo['description'];
        } else {
            $data['description'] = '';
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('children/schemes');

        return $this->template->render('children/schemes_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'name' => 'required|min_length[2]',
                ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', 'children/schemes')) {
            $this->session->setFlashdata('error_warning', lang('children/schemes.error.permission'));
            return false;
        }

        return true;
    }

    //--------------------------------------------------------------------
}
