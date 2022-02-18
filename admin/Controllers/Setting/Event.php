<?php

namespace Admin\Controllers\Setting;

use Admin\Controllers\BaseController;
use Shared\Models\Setting\EventsModel;

class Event extends BaseController
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventsModel = new EventsModel();
    }

    public function disable()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (! $this->user->hasPermission('modify', 'setting/event')) {
                $json['error_warning'] = lang('setting/event.error.permission');
            }

            if (!$json && ($this->request->getMethod() == 'post')) {
                $this->eventsModel->update($this->request->getPost('event_id'), ['status' => $this->request->getPost('status')]);
                $json['success'] = lang('setting/event.text_success');
                $json['redirect'] = site_url('setting/event?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('setting/event.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/event.heading_title'),
            'href' => site_url('setting/event?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['events'] = [];

        $results = $this->eventsModel->findAll();

        foreach ($results as $result) {
            if ((substr($result['trigger'], 0, 6) == '\\Admin')) {
                $group = 'Admin';
            } else {
                $group = 'Catalog';
            }

            $data['events'][] = [
                'event_id'    => $result['event_id'],
                'code'        => $result['code'],
                'trigger'     => $result['trigger'],
                'group'       => $group,
                'priority'    => $result['priority'],
                'description' => $result['description'],
                'enabled'     => $result['status'],
                'status'      => ($result['status']) ? lang('en.text_enabled') : lang('en.text_disabled'),
              ];
        }

        $data['disable'] = site_url('setting/event/disable?user_token=' . $this->request->getVar('user_token'));

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('setting/event');

        return $this->template->render('setting/event', $data);
    }

    //--------------------------------------------------------------------
}
