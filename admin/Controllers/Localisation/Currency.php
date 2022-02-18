<?php

namespace Admin\Controllers\Localisation;

use Admin\Controllers\BaseController;
use Shared\Models\Localisation\CurrencyModel;

class Currency extends BaseController
{
    protected $currencyModel;

    public function __construct()
    {
        $this->currencyModel = new CurrencyModel();
    }

    public function add()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->currencyModel->insert($this->request->getPost());
                $json['success']  = lang('localisation/currency.text_success');
                $json['redirect'] = site_url('localisation/currency?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->getFlashdata('error_warning');
            }
        }
        return $this->response->setJSON($json);
    }

    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->currencyModel->update($this->request->getVar('currency_id'), $this->request->getPost());
                $json['success'] = lang('localisation/currency.text_success');
                $json['redirect'] = site_url('localisation/currency?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->getFlashdata('error_warning');
            }
        }

        return $this->response->setJSON($json);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (!$this->user->hasPermission('modify', 'localisation/currency')) {
                $json['error_warning'] = lang('localisation/currency.error.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $currency_id) {
                    $this->currencyModel->delete($currency_id);
                }
                $json['success']  = lang('localisation/currency.text_success');
                $json['redirect'] = site_url('localisation/currency?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }

    public function refresh()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            $this->currencyModel->refresh($this->registry->get('config_currency'));

            $json['success']  = lang('localisation/currency.text_success');
            $json['redirect'] = site_url('localisation/currency?user_token=' . $this->request->getVar('user_token'));
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {
        $this->document->setTitle(lang('localisation/currency.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('localisation/currency.heading_title'),
            'href' => site_url('localisation/currency?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['currencies'] = [];

        $results = $this->currencyModel->findAll($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['currencies'][] = [
                'currency_id'   => $result['currency_id'],
                'title'         => $result['title'] . (($result['code'] == $this->registry->get('config_currency')) ? lang('en.text_default') : null),
                'code'          => $result['code'],
                'value'         => $result['value'],
                'date_modified' => datetimeFormat($result['date_modified'], true),
                'edit'          => site_url('localisation/currency/form?user_token=' . $this->request->getVar('user_token') . '&currency_id=' . $result['currency_id']),
            ];
        }

        $data['add']     = site_url('localisation/currency/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete']  = site_url('localisation/currency/delete?user_token=' . $this->request->getVar('user_token'));
        $data['refresh'] = site_url('localisation/currency/refresh?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->request->getVar('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('localisation/currency');

        return $this->template->render('localisation/currency_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('localisation/currency.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('localisation/currency.heading_title'),
            'href' => site_url('localisation/currency/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('currency_id') ? lang('localisation/currency.text_add') : lang('localisation/currency.text_edit');

        $data['back'] = site_url('localisation/currency?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('currency_id')) {
            $data['action'] = site_url('localisation/currency/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('localisation/currency/edit?user_token=' . $this->request->getVar('user_token') . '&currency_id=' . $this->request->getVar('currency_id'));
        }

        if ($this->request->getVar('currency_id') && ($this->request->getMethod() != 'post')) {
            $currency_info = $this->currencyModel->find($this->request->getVar('currency_id'));
        }

        if ($this->request->getPost('title')) {
            $data['title'] = $this->request->getPost('title');
        } elseif (!empty($currency_info['title'])) {
            $data['title'] = $currency_info['title'];
        } else {
            $data['title'] = '';
        }

        if ($this->request->getPost('code')) {
            $data['code'] = $this->request->getPost('code');
        } elseif (!empty($currency_info['code'])) {
            $data['code'] = $currency_info['code'];
        } else {
            $data['code'] = '';
        }

        if ($this->request->getPost('symbol_left')) {
            $data['symbol_left'] = $this->request->getPost('symbol_left');
        } elseif (!empty($currency_info['symbol_left'])) {
            $data['symbol_left'] = $currency_info['symbol_left'];
        } else {
            $data['symbol_left'] = '';
        }

        if ($this->request->getPost('symbol_right')) {
            $data['symbol_right'] = $this->request->getPost('symbol_right');
        } elseif (!empty($currency_info['symbol_right'])) {
            $data['symbol_right'] = $currency_info['symbol_right'];
        } else {
            $data['symbol_right'] = '';
        }

        if ($this->request->getPost('value')) {
            $data['value'] = $this->request->getPost('value');
        } elseif (!empty($currency_info['value'])) {
            $data['value'] = $currency_info['value'];
        } else {
            $data['value'] = '1.0000';
        }


        if ($this->request->getPost('fraction')) {
            $data['fraction'] = $this->request->getPost('fraction');
        } elseif (!empty($currency_info['fraction'])) {
            $data['fraction'] = $currency_info['fraction'];
        } else {
            $data['fraction'] = 2;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($currency_info)) {
            $data['status'] = $currency_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('localisation/currency');

        return $this->template->render('localisation/currency_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'title' => [
                    'label' => 'Currency Title',
                    'rules' => 'required|min_length[3]|max_length[32]',
                ],
                'code'  => [
                    'label' => 'Currency Code',
                    'rules' => 'required|min_length[3]',
                ],
                ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', 'localisation/currency')) {
            $this->session->setFlashdata('error_warning', lang('localisation/currency.error.permission'));
            return false;
        }
        return true;
    }
      
    //--------------------------------------------------------------------
}
