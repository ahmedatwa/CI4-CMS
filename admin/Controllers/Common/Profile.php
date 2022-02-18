<?php

namespace Admin\Controllers\Common;

use Admin\Controllers\BaseController;
use Admin\Models\User\UserModel;
use Admin\Models\User\UserGroupModel;
use Extensions\Models\Report\UserActivityModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $this->document->setTitle(lang('common/profile.text_profile'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/profile?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('common/profile.text_profile'),
            'href' => site_url('common/profile/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = lang('common/profile.form_edit');

        if ($this->request->getMethod() != 'post') {
            $user_info = $this->userModel->find($this->user->getID());
        }

        $data['edit'] = base_url('user/user/form?user_token=' . $this->request->getVar('user_token') . '&user_id=' . $user_info['user_id']);

        if (!empty($user_info)) {
            $data['firstname'] = $user_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if (!empty($user_info)) {
            $data['lastname'] = $user_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if (!empty($user_info)) {
            $data['username'] = $user_info['username'];
        } else {
            $data['username'] = '';
        }

        if (!empty($user_info)) {
            $data['email'] = $user_info['email'];
        } else {
            $data['email'] = '';
        }

        if (!empty($user_info)) {
            $data['image'] = $user_info['image'];
        } else {
            $data['image'] = '';
        }

        if (!empty($user_info) && is_file(DIR_IMAGE . $user_info['image'])) {
            $data['thumb'] = resizeImage($user_info['image'], 100, 100);
        } else {
            $data['thumb'] = resizeImage('no_image.jpg', 100, 100);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 100, 100);

        // UserGroup
        $userGroupModel = new UserGroupModel();
        $user_group = $userGroupModel->getUserGroup($user_info['user_group_id']);

        if (!empty($user_info)) {
            $data['user_group'] = $user_group['name'];
        } else {
            $data['user_group'] = '';
        }

        if (!empty($user_info)) {
            $data['status'] = $user_info['status'] ? lang('en.text_enabled') : lang('en.text_disabled');
        } else {
            $data['status'] = '';
        }

        $data['activities'] = [];

        $userActivityModel = new UserActivityModel();

        $results = $userActivityModel->where('user_id', $this->user->getID())->findAll();
        foreach ($results as $result) {            
            $comment = vsprintf(lang('report/user_activity.activity_' . $result['key']), $result['data']);

            $find = [
                'user_id=',
                'user_group_id=',
                'information_id=',
                'customer_id=',
                'customer_group_id=',
                'scheme_id=',
                'child_group_id=',
            ];
        
            $replace = [
                site_url('user/user/form?user_token=' . $this->request->getVar('user_token') . '&user_id='),
                site_url('user/user_group/form?user_token=' . $this->request->getVar('user_token') . '&user_group_id='),
                site_url('catalog/information/form?user_token=' . $this->request->getVar('user_token') . '&information_id='),
                site_url('customer/customer/form?user_token=' . $this->request->getVar('user_token') . '&customer_id='),
                site_url('customer/customer_group/form?user_token=' . $this->request->getVar('user_token') . '&customer_group_id='),
                site_url('children/schemes/form?user_token=' . $this->request->getVar('user_token') . '&scheme_id='),
                site_url('children/children_group/form?user_token=' . $this->request->getVar('user_token') . '&child_group_id='),
            ];

            $data['activities'][] = [
                'activity_id' => $result['activity_id'],
                'date_added'  => datetimeFormat($result['date_added'], true),
                'comment'     => str_replace($find, $replace, $comment),
                'ip'          => $result['ip'],
                'user_agent'  => $result['user_agent'],
            ];
        }

        
        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");        

        lang('common/profile');

        return $this->template->render('common/profile', $data);
    }

    //--------------------------------------------------------------------
}
