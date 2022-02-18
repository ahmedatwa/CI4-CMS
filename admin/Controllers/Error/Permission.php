<?php 

namespace Admin\Controllers\Error;

use Admin\Controllers\BaseController;

class Permission extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('error/permission.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('error/permission.heading_title'),
            'href' => site_url('error/permission?user_token=' . $this->request->getVar('user_token')),
        ];
                
        $data['header']      = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left'] = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']      = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('error/permission');

        return $this->template->render('errors/html/permission', $data);
    }

    //--------------------------------------------------------------------
}