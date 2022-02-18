<?php

namespace Admin\Controllers\Module;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\ModulesModel;
use Shared\Models\Design\BannerModel;

class Carousel extends BaseController
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
                    $this->modulesModel->addModule('carousel', $this->request->getPost());
                } else {
                    $this->modulesModel->editModule($this->request->getVar('module_id'), $this->request->getPost());
                }
                $json['success'] = lang('module/carousel.text_success');
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
        $this->document->setTitle(lang('module/carousel.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard', 'user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('module/carousel.text_extension'),
            'href' => site_url('setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = [
                'text' => lang('module/carousel.heading_title'),
                'href' => site_url('module/carousel?user_token=' . $this->request->getVar('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('heading_title'),
                'href' => site_url('module/carousel?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        $data['action'] = site_url('module/carousel/save?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'));
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

        if ($this->request->getPost('banner_id')) {
            $data['banner_id'] = $this->request->getPost('banner_id');
        } elseif (!empty($module_info)) {
            $data['banner_id'] = $module_info['setting']['banner_id'];
        } else {
            $data['banner_id'] = '';
        }

        if ($this->request->getPost('width')) {
            $data['width'] = $this->request->getPost('width');
        } elseif (!empty($module_info)) {
            $data['width'] = $module_info['setting']['width'];
        } else {
            $data['width'] = 130;
        }

        if ($this->request->getPost('height')) {
            $data['height'] = $this->request->getPost('height');
        } elseif (!empty($module_info)) {
            $data['height'] = $module_info['setting']['height'];
        } else {
            $data['height'] = 100;
        }

        if ($this->request->getPost('autoplay')) {
            $data['autoplay'] = $this->request->getPost('autoplay');
        } elseif (!empty($module_info['autoplay'])) {
            $data['autoplay'] = $module_info['setting']['autoplay'];
        } else {
            $data['autoplay'] = true;
        }

        if ($this->request->getPost('dots')) {
            $data['dots'] = $this->request->getPost('dots');
        } elseif (!empty($module_info['dots'])) {
            $data['dots'] = $module_info['setting']['dots'];
        } else {
            $data['dots'] = true;
        }

        if ($this->request->getPost('infinite')) {
            $data['infinite'] = $this->request->getPost('infinite');
        } elseif (!empty($module_info['infinite'])) {
            $data['infinite'] = $module_info['setting']['infinite'];
        } else {
            $data['infinite'] = true;
        }

        if ($this->request->getPost('arrows')) {
            $data['arrows'] = $this->request->getPost('arrows');
        } elseif (!empty($module_info['arrows'])) {
            $data['arrows'] = $module_info['setting']['arrows'];
        } else {
            $data['arrows'] = false;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['setting']['status'];
        } else {
            $data['status'] = 1;
        }

        $bannerModel = new BannerModel();
        $data['banners'] = $bannerModel->findAll();

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('module/carousel');

        return $this->template->render('module/carousel', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'name'   => 'required|min_length[3]',
                'width'  => 'required|alpha_numeric',
                'height' => 'required|alpha_numeric',
            ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.form'));
            return false;
        }

        if (!$this->user->hasPermission('modify', 'module/carousel')) {
            $this->session->setFlashdata('error_warning', lang('module/carousel.error.permission'));
            return false;
        }
        return true;
    }

    // ---------------------------------------------------------------
}
