<?php

namespace Admin\Controllers\Module;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\ModulesModel;

class Html extends BaseController
{
    protected $moduleModel;

    public function __construct()
    {
        $this->modulesModel = new ModulesModel();
    }

    public function save()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                if (! $this->request->getVar('module_id')) {
                    $this->modulesModel->addModule('html', $this->request->getPost());
                } else {
                    $this->modulesModel->editModule($this->request->getVar('module_id'), $this->request->getPost());
                }
                $json['success'] = lang('module/html.text_success');
                $json['redirect'] = site_url('setting/module?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->getFlashdata('error_warning');
            }
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('module/html.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard', 'user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('module/html.text_extension'),
            'href' => site_url('setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = [
                'text' => lang('module/html.heading_title'),
                'href' => site_url('module/html?user_token=' . $this->request->getVar('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('heading_title'),
                'href' => site_url('module/html?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        $data['action'] = site_url('module/html/save?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'));
        $data['back'] = site_url('setting/module?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getVar('module_id') && ($this->request->getMethod() != 'post')) {
            $module_info = $this->modulesModel->find($this->request->getVar('module_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('module_description')) {
            $data['module_description'] = $this->request->getPost('module_description');
        } elseif (!empty($module_info)) {
            $data['module_description'] = $module_info['setting']['module_description'];
        } else {
            $data['module_description'] = [];
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['setting']['status'];
        } else {
            $data['status'] = 1;
        }

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('module/html');

        return $this->template->render('module/html', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'name'   => 'required|min_length[3]|max_length[64]',
            ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.form'));
            return false;
        }

        if (!$this->user->hasPermission('modify', 'module/html')) {
            $this->session->setFlashdata('error_warning', lang('module/html.error.permission'));
            return false;
        }
        return true;
    }

    // ---------------------------------------------------------------
}
