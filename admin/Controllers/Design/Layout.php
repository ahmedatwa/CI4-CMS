<?php

namespace Admin\Controllers\Design;

use Admin\Controllers\BaseController;
use Shared\Models\Design\LayoutModel;
use Shared\Models\Setting\ExtensionModel;
use Shared\Models\Setting\ModulesModel;

class Layout extends BaseController
{
    protected $layoutModel;

    public function __construct()
    {
        $this->layoutModel = new LayoutModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->layoutModel->addLayout($this->request->getPost());
                $json['success'] = lang('user/user.text_success');
                $json['redirect'] = site_url('user/user?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['success'] = lang('design/layout.text_success');
                $json['redirect'] = site_url('design/layout?user_token=' . $this->request->getVar('user_token'));
            }
        }

        return $this->response->setJSON($json);
    }

    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->layoutModel->editLayout($this->request->getVar('layout_id'), $this->request->getPost());
                $json['success'] = lang('design/layout.text_success');
                $json['redirect'] = site_url('design/layout?user_token=' . $this->request->getVar('user_token'));
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
            if ($this->request->getPost('selected') && $this->validateDelete()) {
                foreach ($this->request->getPost('selected') as $layout_id) {
                    $this->layoutModel->deleteLayout($layout_id);
                }
                $json['success'] = lang('design/layout.text_success');
                $json['redirect'] = site_url('design/layout?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }
    
    public function index()
    {
        $this->document->setTitle(lang('design/layout.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('design/layout.heading_title'),
            'href' => site_url('design/layout?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['add'] = site_url('design/layout/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = site_url('design/layout/delete?user_token=' . $this->request->getVar('user_token'));

        $data['layouts'] = [];

        $layoutModel = new LayoutModel();

        $results = $layoutModel->getLayouts();

        foreach ($results as $result) {
            $data['layouts'][] = array(
                'layout_id' => $result['layout_id'],
                'name'      => $result['name'],
                'edit'      => site_url('design/layout/form?user_token=' . $this->request->getVar('user_token') . '&layout_id=' . $result['layout_id'])
            );
        }

        if (isset($this->request->getPost()['selected'])) {
            $data['selected'] = (array)$this->request->getPost()['selected'];
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('design/layout');

        return $this->template->render('design/layout_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('design/layout.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('design/layout.heading_title'),
            'href' => site_url('design/layout?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['text_form'] = !$this->request->getVar('layout_id') ? lang('design/layout.text_add') : lang('design/layout.text_edit');
        $data['back'] = site_url('design/layout?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('layout_id')) {
            $data['action'] = site_url('design/layout/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('design/layout/edit?user_token=' . $this->request->getVar('user_token') . '&layout_id=' . $this->request->getVar('layout_id'));
        }

        $layoutModel = new LayoutModel();

        if ($this->request->getVar('layout_id') && ($this->request->getMethod() != 'post')) {
            $layout_info = $layoutModel->getLayout($this->request->getVar('layout_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($layout_info['name'])) {
            $data['name'] = $layout_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('layout_route')) {
            $data['layout_route'] = $this->request->getPost('layout_route');
        } elseif ($this->request->getVar('layout_id')) {
            $data['layout_route'] = $layoutModel->getLayoutRoutes($this->request->getVar('layout_id'));
        } else {
            $data['layout_route'] = '';
        }

        $extensionModel = new ExtensionModel();
        $modulesModel    = new ModulesModel();
        $layoutModel    = new LayoutModel();

        $data['extensions'] = [];
        
        // Get a list of installed modules
        $extensions = $extensionModel->getInstalled('module');

        // Add all the modules which have multiple settings for each module
        foreach ($extensions as $code) {
            $module_data = [];

            $modules = $modulesModel->getModulesByCode($code);

            foreach ($modules as $module) {
                $module_data[] = [
                    'name' => strip_tags(lang('module/' . $code . '.heading_title') . ' &gt; ' . $module['name']),
                    'code' => $code . '.' .  $module['module_id']
                ];
            }

            if ($this->registry->get('module_' . $code . '_status') || $module_data) {
                $data['extensions'][] = [
                    'name'   => strip_tags(lang('module/' . $code . '.heading_title')),
                    'code'   => $code,
                    'module' => $module_data
                ];
            }
        }

        // Modules layout
        if ($this->request->getPost('layout_module')) {
            $layout_modules = $this->request->getPost('layout_module');
        } elseif ($this->request->getVar('layout_id')) {
            $layout_modules = $layoutModel->getLayoutModules($this->request->getVar('layout_id'));
        } else {
            $layout_modules = [];
        }

        $data['layout_modules'] = [];
        
        // Add all the modules which have multiple settings for each module
        foreach ($layout_modules as $layout_module) {
            $part = explode('.', $layout_module['code']);
            
            
            if (!isset($part[1])) {
                $data['layout_modules'][] = [
                    'name'       => strip_tags(lang('design/layout.heading_title')),
                    'code'       => $layout_module['code'],
                    'edit'       => site_url('module/' . $part[0], '?user_token=' . $this->request->getVar('user_token')),
                    'position'   => $layout_module['position'],
                    'sort_order' => $layout_module['sort_order']
                ];
            } else {
                $module_info = $modulesModel->find($part[1]);
                if ($module_info) {
                    $data['layout_modules'][] = [
                        'name'       => isset($module_info['name']) ? $module_info['name'] : '',
                        'code'       => $layout_module['code'],
                        'edit'       => site_url('module/' . $part[0], '?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $part[1]),
                        'position'   => $layout_module['position'],
                        'sort_order' => $layout_module['sort_order']
                    ];
                }
            }
        }
        
        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('design/layout');

        return $this->template->render('design/layout_form', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'design/layout')) {
            $this->error['warning'] = lang('design/layout.error.permission');
            return false;
        }

        if (! $this->validate([
            "name" => 'required|min_length[3]|max_length[64]'
        ])) {
            $this->session->setFlashdata('error_warning', lang('design/layout.error.name'));
            return false;
        }
        
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'design/layout')) {
            $this->session->setFlashdata('error_warning', lang('design/layout.error.permission'));
            return false;
        }

        foreach ($this->request->getPost('selected') as $layout_id) {
            if ($this->registry->get('config_layout_id') == $layout_id) {
                $this->session->setFlashdata('error_warning', lang('design/layout.error.default'));
            }
        }

        return true;
    }
}
