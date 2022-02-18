<?php

namespace Extensions\Controllers\Report;

use Admin\Controllers\BaseController;
use Extensions\Models\Report\UserActivityModel;
use Shared\Models\Setting\SettingModel;

class User_activity extends BaseController
{
    public function install()
    {
        $userActivityModel = new UserActivityModel();
        $userActivityModel->up();
    }

    public function uninstall()
    {
        $userActivityModel = new UserActivityModel();
        $userActivityModel->down();
    }

    public function delete()
    {
        $json = [];

        if (! $this->user->hasPermission('modify', 'extensions/report/user_activity')) {
            $json['error_warning'] = lang('report/user_activity.error.permission');
        }

        if (!$json && $this->request->isAJAX()) {
            if ($this->request->getPost('selected')) {
                $userActivityModel = new UserActivityModel();
                foreach ($this->request->getPost('selected') as $activity_id) {
                    $userActivityModel->delete($activity_id);
                }
                $json['success'] = lang('report/user_activity.text_success');
                $json['redirect'] = site_url('report/report?user_token=' . $this->request->getVar('user_token') . '&code=user_activity');
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('report/user_activity.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.heading_title'),
            'href' => site_url('setting/extensions?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('report/user_activity.heading_title'),
            'href' => site_url('extensions/report/user_activity?user_token=' . $this->session->get('user_token')),
        ];

        $data['action'] = site_url('extensions/report/user_activity/edit?user_token=' . $this->session->get('user_token'));
        $data['back'] = site_url('setting/extension?user_token=' . $this->session->get('user_token') . '&type=report');

        if ($this->request->getPost('report_user_activity')) {
            $data['report_user_activity'] = $this->request->getPost('report_user_activity');
        } elseif (!empty($this->registry->get('report_user_activity'))) {
            $data['report_user_activity'] = $this->registry->get('report_user_activity')['user_activity'];
        } else {
            $data['report_user_activity'] = [];
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('Extensions\Dashboard\user_activity');

        return $this->template->render('Extensions\Views\report\user_activity_form', $data);
    }

    public function report()
    {
        $data['activities'] = [];

        $userActivityModel = new UserActivityModel();

        $results = $userActivityModel->findAll();

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

        
        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['delete'] = site_url('extensions/report/user_activity/delete?user_token=' . $this->request->getVar('user_token'));

        lang('Extensions\Dashboard\user_activity');

        return $this->template->render('Extensions\Views\report\user_activity_info', $data);
    }

    //--------------------------------------------------------------------
}
