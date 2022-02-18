<?php

namespace Admin\Controllers\Tool;

use Admin\Controllers\BaseController;
use Admin\Models\Customer\CustomerModel;
use Admin\Models\Customer\CustomerGroupModel;

class Mail extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('tool/mail.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('tool/mail.heading_title'),
            'href' => site_url('tool/mail?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['action'] = site_url('tool/mail/send?user_token=' . $this->request->getVar('user_token'));
        $data['cancel'] = site_url('tool/mail?user_token=' . $this->request->getVar('user_token'));

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->request->getPost('from')) {
            $data['from'] = $this->request->getPost('from');
        } else {
            $data['from'] = $this->registry->get('config_email');
        }

        if ($this->request->getPost('to')) {
            $data['to'] = $this->request->getPost('to');
        } else {
            $data['to'] = '';
        }

        if ($this->request->getPost('customer_group_id')) {
            $data['customer_group_id'] = $this->request->getPost('customer_group_id');
        } else {
            $data['customer_group_id'] = '';
        }

        $customerGroupModel = new CustomerGroupModel();
        $data['customer_groups'] = $customerGroupModel->findAll();


        if ($this->request->getPost('customer')) {
            $data['customer'] = $this->request->getPost('customer');
        } else {
            $data['customer'] = '';
        }

        if ($this->request->getPost('subject')) {
            $data['subject'] = $this->request->getPost('subject');
        } else {
            $data['subject'] = '';
        }
        if ($this->request->getPost('message')) {
            $data['message'] = $this->request->getPost('message');
        } else {
            $data['message'] = '';
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('tool/mail');

        return $this->template->render('tool/mail', $data);
    }

    public function send()
    {
        $json = [];

        if (!$this->user->hasPermission('modify', 'tool/mail')) {
            $json['error_warning'] = lang('tool/mail.error.permission');
        }

        if (!$json) {
            $email = \Config\Services::email();

            $customerModel = new CustomerModel();

            switch ($this->request->getPost('to')) {
            case 'newsletter':
                    $results = $customerModel->where('newsletter', 1)->findColumn('email');
                    $emails = implode(', ', $results);
                    var_dump($emails);
                break;
            case 'customer_all':
                    $results = $customerModel->findColumn('email');
                    $emails = implode(', ', $results);
            break;
            case 'customer_group':
                    $results = $customerModel->where('customer_group_id', $this->request->getPost('customer_group_id'))->findColumn('email');
                    $emails = implode(', ', $results);
            break;
            case 'customer':
                if ($customers = $this->request->getPost('customer')) {
                    $results = $customerModel->whereIn('customer_id', $customers)->findColumn('email');
                    $emails = implode(', ', $results);
                }
                break;
        }

            $email->setFrom($this->registry->get('config_email'));
            $email->setTo($emails);

            $message  = '<html dir="ltr" lang="en">' . "\n";
            $message .= '  <head>' . "\n";
            $message .= '    <title>' . $this->request->getPost('subject') . '</title>' . "\n";
            $message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
            $message .= '  </head>' . "\n";
            $message .= '  <body>' . html_entity_decode($this->request->getPost('message'), ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
            $message .= '</html>' . "\n";

            $email->setSubject($this->request->getPost('subject'));

            $email->setMessage($message);

            if (! $email->send(false)) {
                $json['error_warning']  = $email->printDebugger();
            } else {
                $json['success'] = lang('tool/mail.text_success');
                $json['redirect'] = site_url('tool/mail?user_token=' . $this->request->getVar('user_token'));
            }
        }
        
        return $this->response->setJSON($json);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'tool/mail')) {
            $this->session->setFlashdata('error_warning', lang('tool/mail.error.permission'));
            return false;
        }
        return true;
    }


    //--------------------------------------------------------------------
}
