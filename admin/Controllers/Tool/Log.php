<?php

namespace Admin\Controllers\Tool;

use Admin\Controllers\BaseController;

class Log extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('tool/log.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('tool/log.heading_title'),
            'href' => site_url('tool/log?user_token=' . $this->request->getVar('user_token')),
        ];

        helper('filesystem');

        $logsDir = WRITEPATH . 'logs/';

        $map = get_filenames($logsDir);

        $ignore = [
            'index.html',
            '.htaccess',
        ];

        foreach ($map as $key => $file) {
            if (in_array($file, $ignore)) {
                unset($map[$key]);
            }
        }

        $logs = [];

        foreach ($map as $file) {
            $FileDir = $logsDir . $file;
            if (file_exists($FileDir)) {
                $logs[] = file_get_contents($FileDir, FILE_USE_INCLUDE_PATH, null);
            }
        }
        
        foreach ($logs as $log) {
            $data['log'] = $log;
        }

        $data['delete'] = site_url('tool/log/clear?user_token=' . $this->request->getVar('user_token'));

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('tool/log');

        return $this->template->render('tool/log', $data);
    }

    public function clear()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (!$this->user->hasPermission('modify', 'tool/log')) {
                $json['error_warning'] = lang('tool/log.error.permission');
            }

            if (!$json && ($this->request->getMethod() == 'post')) {
                helper('filesystem');
                delete_files(WRITEPATH . 'logs/', true, true, true);
                $json['redirect'] = site_url('tool/log?user_token=' . $this->request->getVar('user_token'));
                $json['success']  = lang('tool/log.text_success');
            }
        }
         
        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
