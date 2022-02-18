<?php

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;

class Menu extends BaseController
{
    public function index()
    {
        $data['menus'] = [];
        if ($this->customer->isLogged()) {
                $data['menus'][] = [
                    'id'       => 'menu-start',
                    'icon'     => 'fas fa-tachometer-alt',
                    'class'    => 'active',
                    'name'     => lang('account/menu.text_dashboard'),
                    'href'     => route_to('account_dashboard', $this->customer->getUserName()),
                    'children' => [],
                ];

                $data['menus'][] = [
                    'id'       => 'menu-start',
                    'icon'     => 'far fa-comment-dots',
                    'class'    => 'active',
                    'name'     => lang('account/menu.text_inbox'),
                    'href'     => route_to('account_inbox', $this->customer->getUserName()),
                    'children' => [],
                ];

                $data['menus'][] = [
                    'id'       => 'menu-start',
                    'icon'     => 'fas fa-user-cog',
                    'class'    => '',
                    'name'     => lang('account/menu.text_settings'),
                    'href'     => route_to('account_setting', $this->customer->getUserName()),
                    'children' => [],
                ];

                // Projects
                $data['menus'][] = [
                    'id'       => 'menu-manage',
                    'icon'     => 'fas fa-building',
                    'class'    => '',
                    'name'     => lang('account/menu.text_my_projects'),
                    'href'     => route_to('account_project', $this->customer->getUserName()),
                    'children' => [],
                ];

                $data['menus'][] = [
                    'id'       => 'menu-manage',
                    'icon'     => 'fas fa-briefcase',
                    'class'    => '',
                    'name'     => lang('account/menu.text_my_local_jobs'),
                    'href'     => route_to('account_jobs', $this->customer->getUserName()),
                    'children' => [],
                ];

                $data['menus'][] = [
                    'id'       => 'menu-dispute',
                    'icon'     => 'fas fa-bomb',
                    'class'    => '',
                    'name'     => lang('account/menu.text_dispute'),
                    'href'     => route_to('account_dispute', $this->customer->getUserName()),
                    'children' => [],
                ];

                $data['menus'][] = [
                    'id'       => 'menu-start',
                    'icon'     => 'icon-material-outline-rate-review',
                    'class'    => '',
                    'name'     => lang('account/menu.text_reviews'),
                    'href'     => route_to('account_review', $this->customer->getUserName()),
                    'children' => [],
                ];
        }

        return view('account/menu', $data);
    }
    //--------------------------------------------------------------------
}
