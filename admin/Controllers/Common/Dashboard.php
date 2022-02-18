<?php

namespace Admin\Controllers\Common;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\ExtensionModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('common/dashboard.heading_title'));

        if (!$this->request->getVar('user_token') || !$this->session->get('user_token') || ($this->request->getVar('user_token') != $this->session->get('user_token'))) {
            return redirect()->to(base_url('common/login'))->with('warning', lang('en.error.error_token'));
        }

		$data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('common/dashboard.heading_title'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token'))
        ];

        // Dashboard Extensions
        $dashboards = [];

        $extensionsModel = new ExtensionModel();

        // Get a list of installed modules
        $extensions = $extensionsModel->getInstalled('dashboard');

        // Add all the modules which have multiple settings for each module
        foreach ($extensions as $code) {
            $setting = $this->registry->get('dashboard_' . $code);
            if ($setting[$code]['status'] && $this->user->hasPermission('access', 'extensions/dashboard/' . $code)) {
                $controller = ucfirst($code);
                // Loading controller Method
                $output = view_cell("\Extensions\Controllers\Dashboard\\{$controller}::dashboard");

                $dashboards[] = [
                    'code'       => $code,
                    'width'      => $setting[$code]['width'],
                    'sort_order' => $setting[$code]['sort_order'],
                    'output'     => $output,
                ];
            }
        }
        
        $data['dashboards'] = [];
        
        $sort_order = [];

        foreach ($dashboards as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $dashboards);
        
        foreach ($dashboards as $dashboard) {
            $data['dashboards'][] = $dashboard;
        }
        
        $data['header']      = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left'] = view_cell('\Admin\Controllers\Common\Column_left::index');
        $data['footer']      = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('common/dashboard');

        return $this->template->render('common/dashboard', $data);
    }
}
