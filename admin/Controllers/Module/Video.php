<?php

namespace Admin\Controllers\Module;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\ModulesModel;

class Video extends BaseController
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
            if (!$this->user->hasPermission('modify', 'module/video')) {
                $json['error_warning'] = lang('module/video.error.permission');
            }

            if (!$json && ($this->request->getMethod() == 'post')) {
                if (! $this->request->getVar('module_id')) {
                    $this->modulesModel->addModule('video', $this->request->getPost());
                } else {
                    $this->modulesModel->editModule($this->request->getVar('module_id'), $this->request->getPost());
                }
                $json['success'] = lang('module/video.text_success');
                $json['redirect'] = site_url('setting/module?user_token=' . $this->request->getVar('user_token'));
            }
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('module/video.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard', 'user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('module/account.text_module'),
            'href' => site_url('setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        if (! $this->request->getVar('module_id')) {
            $data['breadcrumbs'][] = [
                'text' => lang('module/video.heading_title'),
                'href' => site_url('module/video?user_token=' . $this->request->getVar('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('module/video.heading_title'),
                'href' => site_url('module/video?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        $data['action'] = site_url('module/video/save?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'));

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
            $data['status'] = '';
        }

        if ($this->request->getPost('image') && is_file(DIR_IMAGE . $this->request->getPost('image'))) {
            $data['thumb'] = resizeImage($this->request->getPost('image'), 864, 415);
        } elseif (isset($module_info['setting']['module_description']) && is_file(DIR_IMAGE . $module_info['setting']['module_description']['image'])) {
            $data['thumb'] = resizeImage($module_info['setting']['module_description']['image'], 200, 100);
        } else {
            $data['thumb'] = resizeImage('no_image.jpg', 200, 100);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 200, 100);

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('module/video');

        return $this->template->render('module/video', $data);
    }

    // ---------------------------------------------------------------
}
