<?php

namespace Admin\Controllers\Common;

use Admin\Controllers\BaseController;

class Column_left extends BaseController
{
    public function index()
    {
        $data['configName'] = $this->registry->get('config_name');
        $data['text_navigation'] = lang('common/column_left.text_navigation');

        $data['menus'][] = [
            'id'       => 'menu-dashboard',
            'icon'     => 'fas fa-tachometer-alt',
            'name'     => lang('common/column_left.text_dashboard'),
            'href'     => site_url("common/dashboard?user_token=" . $this->request->getVar('user_token')),
        ];
        // catalog Level 1
        $catalog = [];
        if ($this->user->hasPermission('access', 'catalog/category')) {
            $catalog[] = [
                'id'       => 'menu-catalog',
                'name'     => lang('common/column_left.text_categories'),
                'href'     => site_url('catalog/category?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', 'catalog/application')) {
            $catalog[] = [
                'id'           => 'menu-catalog',
                'name'         => lang('common/column_left.text_applications'),
                "icon"         => "fas fa-angle-double-right",
                'href'         => site_url('catalog/application?user_token=' . $this->request->getVar('user_token')),
                'children'     => [],
            ];
        }
        if ($this->user->hasPermission('access', 'catalog/information')) {
            $catalog[] = [
                'id'           => 'menu-catalog',
                'name'         => lang('common/column_left.text_information'),
                "icon"         => "fas fa-angle-double-right",
                'href'         => site_url('catalog/information?user_token=' . $this->request->getVar('user_token')),
                'children'     => [],
            ];
        }

        if ($this->user->hasPermission('access', ['catalog/application', 'catalog/information'])) {
            $data['menus'][] = [
                'id'           => 'menu-catalog',
                'icon'         => 'fas fa-tag',
                'name'         => lang('common/column_left.text_catalog'),
                'children'     => $catalog,
            ];
        }

        $customer = [];

        if ($this->user->hasPermission('access', 'customer/customer')) {
            $customer[] = [
                'id'        => 'menu-customer',
                'name'      => lang('common/column_left.text_customer'),
                "icon"      => "fas fa-angle-double-right",
                'href'      => site_url('customer/customer?user_token=' . $this->request->getVar('user_token')),
                'children'  => [],
            ];
        }

        if ($this->user->hasPermission('access', 'customer/customer_group')) {
            $customer[] = [
                'id'       => 'menu-customer',
                'name'     => lang('common/column_left.text_customer_group'),
                "icon" => "fas fa-angle-double-right",
                'href'     => site_url('customer/customer_group?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', ['customer/customer', 'customer/customer_group'])) {
            $data['menus'][] = [
                'id'           => 'menu-customer',
                'icon'         => 'fas fa-chalkboard-teacher',
                'name'         => lang('common/column_left.text_customer'),
                'children'     => $customer,
            ];
        }

        // children Level 1
        $children = [];

        if ($this->user->hasPermission('access', 'children/children')) {
            $children[] = [
                'id'       => 'menu-children',
                'name'     => lang('common/column_left.text_children'),
                "icon"     => "fas fa-angle-double-right",
                'href'     => site_url('children/children?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', 'children/children_group')) {
            $children[] = [
                'id'       => 'menu-children',
                'name'     => lang('common/column_left.text_children_group'),
                "icon"     => "fas fa-angle-double-right",
                'href'     => site_url('children/children_group?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', 'children/schemes')) {
            $children[] = [
                'id'       => 'menu-children',
                'name'     => lang('common/column_left.text_schemes'),
                "icon"     => "fas fa-angle-double-right",
                'href'     => site_url('children/schemes?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', ['children/children', 'children/schemes', 'children/schemes'])) {
            $data['menus'][] = [
                'id'           => 'menu-children',
                'icon'         => 'fas fa-child',
                'name'         => lang('common/column_left.text_children'),
                'children'     => $children,
            ];
        }

        // Extensions Level 1
        $extensions = [];

        if ($this->user->hasPermission('access', 'setting/extension')) {
            $extensions[] = [
                'id'       => 'menu-extensions',
                'name'     => lang('common/column_left.text_extensions'),
                "icon"     => "fas fa-angle-double-right",
                'href'     => site_url('setting/extension?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', 'setting/module')) {
            $extensions[] = [
                'id'       => 'menu-extensions',
                'name'     => lang('common/column_left.text_modules'),
                "icon"     => "fas fa-angle-double-right",
                'href'     => site_url('setting/module?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', ['setting/extension', 'setting/module'])) {
            $data['menus'][] = [
                'id'           => 'menu-extensions',
                'icon'         => 'fas fa-puzzle-piece',
                'name'         => lang('common/column_left.text_extensions'),
                'children'     => $extensions,
            ];
        }

        // Design Level 1
        $design = [];

        if ($this->user->hasPermission('access', 'design/layout')) {
            $design[] = [
                'id'        => 'menu-design',
                'name'      => lang('common/column_left.text_layouts'),
                "icon"      => "fas fa-angle-double-right",
                'href'      => site_url('design/layout?user_token=' . $this->request->getVar('user_token')),
                'children'  => [],
            ];
        }

        if ($this->user->hasPermission('access', 'design/banner')) {
            $design[] = [
                'id'       => 'menu-design',
                'name'     => lang('common/column_left.text_banner'),
                "icon"     => "fas fa-angle-double-right",
                'href'     => site_url('design/banner?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', 'design/translation')) {
            $design[] = [
                'id'       => 'menu-design',
                'name'     => lang('common/column_left.text_translation'),
                "icon"     => "fas fa-angle-double-right",
                'href'     => site_url('design/translation?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', ['design/layout', 'design/banner'])) {
            $data['menus'][] = [
                'id'           => 'menu-design',
                'icon'         => 'fas fa-desktop',
                'name'         => lang('common/column_left.text_design'),
                'children'     => $design,
            ];
        }

        // usrs 2 levels
        $user = [];

        if ($this->user->hasPermission('access', 'user/user')) {
            $user[] = [
                'id'   => 'menu-user',
                "name" => lang('common/column_left.text_users'),
                "icon" => "fas fa-angle-double-right",
                "href" => site_url("user/user?user_token=" . $this->request->getVar('user_token'))
            ];
        }

        if ($this->user->hasPermission('access', 'user/user_group')) {
            $user[] = [
                'id'   => 'menu-user',
                "name" => lang('common/column_left.text_user_group'),
                "icon" => "fas fa-angle-double-right",
                "href" => site_url("user/user_group?user_token=" . $this->request->getVar('user_token'))
            ];
        }

        if ($this->user->hasPermission('access', ['user/user', 'user/user_group'])) {
            $data['menus'][] = [
                'id'           => 'menu-user',
                'icon'         => 'fas fa-users-cog',
                'name'         => lang('common/column_left.text_users'),
                'children'     => $user,
            ];
        }

        // report Level 1
        $report = [];

        if ($this->user->hasPermission('access', 'report/report')) {
            $report[] = [
                'id'       => 'menu-report',
                'name'     => lang('common/column_left.text_report'),
                'href'     => site_url('report/report?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', 'report/online')) {
            $report[] = [
                'id'       => 'menu-report',
                'name'     => lang('common/column_left.text_online'),
                'href'     => site_url('report/online?user_token=' . $this->request->getVar('user_token')),
                'children' => [],
            ];
        }

        if ($this->user->hasPermission('access', ['report/report', 'report/online'])) {
            $data['menus'][] = [
                'id'           => 'menu-report',
                'icon'         => 'fas fa-chart-pie',
                'name'         => lang('common/column_left.text_report'),
                'children'     => $report,
            ];
        }

        // setting 2 levels
        $system = [];

        if ($this->user->hasPermission('access', 'setting/setting')) {
            $system[] = [
                'id'   => 'menu-system',
                "name" => lang('common/column_left.text_setting'),
                "icon" => "fas fa-angle-double-right",
                "href" => site_url("setting/setting?user_token=" . $this->request->getVar('user_token'))
            ];
        }

        if ($this->user->hasPermission('access', 'setting/event')) {
            $system[] = [
                'id'   => 'menu-system',
                'name' => lang('common/column_left.text_events'),
                "icon" => "fas fa-angle-double-right",
                'href' => site_url('setting/event?user_token=' . $this->request->getVar('user_token')),
            ];
        }

        if ($this->user->hasPermission('access', 'setting/application_status')) {
            $system[] = [
                'id'   => 'menu-system',
                'name' => lang('common/column_left.text_application_statuses'),
                "icon" => "fas fa-angle-double-right",
                'href' => site_url('setting/application_status?user_token=' . $this->request->getVar('user_token')),
            ];
        }
        // tools
        $tools = [];
        if ($this->user->hasPermission('access', 'tool/mail')) {
            $tools[] = [
                'id'       => 'menu-tools',
                'name'     => lang('common/column_left.text_mail'),
                'href'     => site_url('tool/mail?user_token=' . $this->request->getVar('user_token')),
                'children' => '',
            ];
        }

        if ($this->user->hasPermission('access', 'tool/log')) {
            $tools[] = [
                'id'       => 'menu-tools',
                'icon'     => 'fas fa-angle-double-right',
                'name'     => lang('common/column_left.text_error_logs'),
                'href'     => site_url('tool/log?user_token=' . $this->request->getVar('user_token')),
                'children' => '',
            ];
        }

        if ($this->user->hasPermission('access', ['tool/mail', 'tool/log'])) {
            $system[] = [
                'id'       => 'menu-tools',
                'icon'     => '',
                'name'     => lang('common/column_left.text_tools'),
                'children' => $tools,
            ];
        }

        // localisation
        $localisation = [];
        if ($this->user->hasPermission('access', 'localisation/language')) {
            $localisation[] = [
                'id'       => 'menu-localisation',
                'name'     => lang('common/column_left.text_language'),
                'href'     => site_url('localisation/language?user_token=' . $this->request->getVar('user_token')),
                'children' => '',
            ];
        }

        if ($this->user->hasPermission('access', 'localisation/currency')) {
            $localisation[] = [
                'id'       => 'menu-localisation',
                'icon'     => 'fas fa-angle-double-right',
                'name'     => lang('common/column_left.text_currency'),
                'href'     => site_url('localisation/currency?user_token=' . $this->request->getVar('user_token')),
                'children' => '',
            ];
        }

        if ($this->user->hasPermission('access', ['localisation/currency', 'localisation/language'])) {
            $system[] = [
                'id'       => 'menu-localisation',
                'icon'     => '',
                'name'     => lang('common/column_left.text_localisation'),
                'children' => $localisation,
            ];
        }

        $data['menus'][] = [
            'id'           => 'menu-system',
            'icon'         => 'fas fa-cogs',
            'name'         => lang('common/column_left.text_system'),
            'children'     => $system,
        ];
        
              
        return $this->template->render('common/column_left', $data);
    }
}
