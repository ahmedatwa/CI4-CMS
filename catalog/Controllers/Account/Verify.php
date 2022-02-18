<?php

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;

class Verify extends BaseController
{
    public function index()
    {
        if ($this->customer->isLogged()) {
            return redirect()->route('account_dashboard');
        }

        $this->template->setTitle(lang('account/verify.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang($this->locale .'.text_home'),
            'href' => base_url()
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/verify.text_account'),
            'href' => route_to('account_dashboard')
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/verify.heading_title'),
            'href' => base_url('account/reset')
        ];

        lang('account/verify');

        $this->template->output('account/verify', $data);
    }

    public function validateLogin()
    {
        $json = [];
        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            if (! $this->validate([
                'code' => 'required',
            ])) {
                $json['error_warning'] = lang("{$this->locale}.error.form");
                $json['validator']     = $this->validator->getErrors();
            }

            if (! $json) {
                $customerModel = new CustomerModel();
                $customer_info = $customerModel->getCustomerByCode($this->request->getPost('code', FILTER_SANITIZE_STRING));
                // Code Validity 20 Minutes
                if ($customer_info && ($customer_info['date_modified'] <= strtotime('+20 minutes', $customer_info['date_modified']))) {
                    $json['error_expired'] = lang('account/verify.error.expired');
                }

                if ($customer_info && ($this->customer->LoginAccessVerify($customer_info['email'], $this->request->getPost('code', FILTER_SANITIZE_STRING)))) {
                    // check for any saved redirect url
                    if ($this->session->get('redirect_url')) {
                        $json['redirect'] = (string) $this->session->get('redirect_url');
                    } elseif (! is_null($this->request->getCookie(config('App')->cookiePrefix . 'redirect_url'))) {
                        $json['redirect'] = base64_decode($this->request->getCookie(config('App')->cookiePrefix . 'redirect_url', FILTER_SANITIZE_STRING));
                    } else {
                        $json['redirect'] = route_to('account_dashboard');
                    }
                } else {
                    $json['error_code'] = lang('account/verify.error.code');
                }
            }
        }
        return $this->response->setJSON($json);
    }
    //---------------------------------------------------------------
}
