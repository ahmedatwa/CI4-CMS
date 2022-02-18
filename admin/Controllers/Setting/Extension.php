<?php

namespace Admin\Controllers\Setting;

use Admin\Controllers\BaseController;

class Extension extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('setting/extension.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.heading_title'),
            'href' => site_url('setting/extension?user_token=' . $this->request->getVar('user_token')),
        ];

        if ($this->request->getVar('type')) {
            $data['type'] = $this->request->getVar('type');
        } else {
            $data['type'] = '';
        }

        helper('filesystem');

        $data['categories'] = [];

        $files = directory_map(APPPATH . 'Controllers/Extension', 1);

        sort($files);

        foreach ($files as $file) {
            $basename = basename($file, '.php');

            if ($this->user->hasPermission('access', 'extension/' . strtolower($basename))) {
                $children = directory_map(APPPATH . 'Extensions/Controllers/' . ucfirst($basename), 1);

                $data['categories'][] = [
                    'code' => strtolower($basename),
                    'text' => lang('extension/'. strtolower($basename) .'.heading_title') . ' (' . count($children) . ')',
                    'href' => site_url('extension/' . strtolower($basename) . '?user_token=' . $this->request->getVar('user_token'))
                ];
            }
        }

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('setting/extension');

        return $this->template->render('setting/extension', $data);
    }
        
    //--------------------------------------------------------------------
}
