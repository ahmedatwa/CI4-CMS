<?php

namespace Admin\Controllers\Common;

use Admin\Controllers\BaseController;
use Admin\Models\User\UserModel;

class Header extends BaseController
{
    public function index()
    {  

        $data['base']       = slash_item(env('app.adminURL'));
        $data['site_url']   = slash_item(env('app.siteURL'));
        $data['home']       = site_url('common/dashboard?user_token=' . $this->session->get('user_token'));
        $data['profile']    = site_url('common/profile?user_token=' . $this->session->get('user_token'));
        $data['logout']     = site_url('common/logout?user_token=' . $this->session->get('user_token'));
        $data['activity']   = site_url('report/activity_log?user_token=' . $this->session->get('user_token'));
        $data['setting']    = site_url('setting/setting?user_token=' . $this->session->get('user_token'));
        $data['setting']    = site_url('setting/setting?user_token=' . $this->session->get('user_token'));
        $data['configName'] = $this->registry->get('config_name');

        $data['title']       = $this->document->getTitle();
        $data['description'] = $this->document->getDescription();
        $data['keywords']    = $this->document->getKeywords();
        $data['links']       = $this->document->getLinks();
        $data['styles']      = $this->document->getStyles();
        $data['scripts']     = $this->document->getScripts();

        $data['logged'] = $this->user->isLogged();

        $userModel = new UserModel();

        if ($this->user->isLogged() && $this->user->getID()) {
            $user_info = $userModel->find($this->user->getID());

            if ($user_info) {
                $data['firstname']     = $user_info['firstname'];
                $data['lastname']      = $user_info['lastname'];
                $data['username']      = $user_info['username'];
                $data['user_group_id'] = $user_info['user_group_id'];

                if (is_file(DIR_IMAGE . $user_info['image'])) {
                    $data['image'] = resizeImage($user_info['image'], 45, 45);
                } else {
                    $data['image'] = resizeImage('profile.png', 45, 45);
                }
            } else {
                $data['firstname']     = '';
                $data['lastname']      = '';
                $data['user_group_id'] = '';
                $data['image']         = '';
            }
        }
        
        $data['locale'] = $this->registry->get('locale') ? strtoupper($this->registry->get('locale')) :  strtoupper($this->request->getLocale());

        lang('common/header'); 

        return $this->template->render('common/header', $data);
    }
}
