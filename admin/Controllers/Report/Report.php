<?php

namespace Admin\Controllers\Report;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\ExtensionModel;

class Report extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('report/report.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('common/dashboard?user_token=' . $this->session->get('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('report/report.heading_title'),
            'href' => base_url('report/report?user_token=' . $this->session->get('user_token'))
        ];

        if ($this->request->getVar('code')) {
            $data['code'] = $this->request->getVar('code');
        } else {
            $data['code'] = '';
        }

        // Reports
        $data['reports'] = [];
        
        $extensionModel = new ExtensionModel();

        $extensions = $extensionModel->getInstalled('report');

        foreach ($extensions as $code) {
            $setting = $this->registry->get('report_' . $code);

            if ($setting[$code]['status'] && $this->user->hasPermission('access', 'extensions/report/' . $code)) {
                $data['reports'][] = [
                    'text'       => lang('report/'. $code .'.heading_title'),
                    'code'       => $code,
                    'sort_order' => $setting[$code]['sort_order'],
                    'href'       => site_url('extensions/report/' . $code . '/report?user_token=' . $this->session->get('user_token'))
                ];
            }
        }
        
        $sort_order = [];

        foreach ($data['reports'] as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $data['reports']);
        
        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('report/report');

        return $this->template->render('report/report', $data);
    }


    //--------------------------------------------------------------------
}
