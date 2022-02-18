<?php

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;

class Profile extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        if (!$this->customer->isLogged()) {
            return redirect()->to('account/login');
        }

        $this->document->setTitle(lang('account/profile.heading_title'));

        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/profile.heading_title'),
            'href' => route_to('account/profile') ?: base_url('account/profile'),
        ];

        if ($this->customer->getID()) {
            $customer_info = $this->customerModel->find($this->customer->getID());
        } else {
            $customer_info = [];
        }

        if (!empty($customer_info['firstname'])) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }        
        
        if (!empty($customer_info['lastname'])) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if (!empty($customer_info['username'])) {
            $data['username'] = $customer_info['username'];
        } else {
            $data['username'] = '';
        }

        if (!empty($customer_info['two_step'])) {
            $data['two_step'] = $customer_info['two_step'];
        } else {
            $data['two_step'] = '';
        }

        if (!empty($customer_info['newsletter'])) {
            $data['newsletter'] = $customer_info['newsletter'];
        } else {
            $data['newsletter'] = '';
        }
        
        if (!empty($customer_info['image'])) {
            $data['image'] = $customer_info['image'];
        } else {
            $data['image'] = '';
        }

        if ($this->request->getPost('image') && is_file(DIR_IMAGE . $this->request->getPost('image'))) {
            $data['thumb'] = resizeImage($this->request->getPost('image'), 100, 100);
        } elseif (!empty($user_info) && is_file(DIR_IMAGE . $user_info['image'])) {
            $data['thumb'] = resizeImage($user_info['image'], 100, 100);
        } else {
            $data['thumb'] = resizeImage('no_image.jpg', 100, 100);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 100, 100);

        $data['save']   = base_url('account/profile/save');
        $data['upload'] = base_url('account/profile/upload');

        $data['header']        = view_cell("\Catalog\Controllers\Common\Header::index");
        $data['menu']          = view_cell("\Catalog\Controllers\Common\Menu::index");
        $data['footer']        = view_cell("\Catalog\Controllers\Common\Footer::index");

        lang('account/profile');

        return $this->template->render('account/profile', $data);
    }

    public function save()
    {
        $json = [];
    
        if ($this->request->isAJAX()) {
            if (! $this->validate([
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[4]',
            ])) {
                $json['error_warning'] = lang("{$this->locale}.error.form");
                $json['validator'] = $this->validator->getErrors();
            }

            if ($this->request->getMethod() == 'post') {
                $this->customerModel = new CustomerModel();
                // 2-step verification
                if ($this->customer->checkTwoStepVerification($this->request->getPost('email', FILTER_SANITIZE_EMAIL))) {
                    $this->customer->editAccessCode($this->request->getPost('email', FILTER_SANITIZE_EMAIL), random_string('numeric', 7));
                    $json['redirect'] = route_to('account_verify');
                }

                if ($customerModel->getTotalCustomersByEmail($this->request->getPost('email', FILTER_SANITIZE_EMAIL)) == 0) {
                    $json['error_warning'] = lang("account/login.error.not_found");
                }

                if (!$json && (! $this->customer->login($this->request->getPost('email', FILTER_SANITIZE_EMAIL), $this->request->getPost('password', FILTER_SANITIZE_STRING)))) {
                    $json['error_warning'] = lang("account/login.error.warning");
                    $this->customerModel->addLoginAttempt($this->request->getPost('email', FILTER_SANITIZE_EMAIL), $this->request->getIPAddress());
                }
                
                // Check how many login attempts have been made.
                $login_info = $customerModel->getLoginAttempts($this->request->getPost('email', FILTER_SANITIZE_EMAIL));
                if ($login_info && ($login_info['total'] >= $this->registry->get('config_login_attempts')) && strtotime('-1 hour') < $login_info['date_modified']) {
                    $json['error_warning'] = lang('account/login.error.attempts');
                }
            }

            // continue if logged
            if (! $json) {
                $this->customerModel->deleteLoginAttempts($this->request->getPost('email', FILTER_SANITIZE_EMAIL));
                // check for any saved redirect url
                if ($this->session->get('redirect_url')) {
                    $json['redirect'] = (string) $this->session->get('redirect_url');
                } elseif (! is_null($this->request->getCookie(config('App')->cookiePrefix . 'redirect_url'))) {
                    $json['redirect'] = base64_decode($this->request->getCookie(config('App')->cookiePrefix . 'redirect_url', FILTER_SANITIZE_STRING));
                } else {
                    $json['redirect'] = base_url('account/dashboard');
                }
            }
        }
        return $this->response->setJSON($json);
    }


    //--------------------------------------------------------------------
}
