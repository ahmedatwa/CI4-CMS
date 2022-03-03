<?php

namespace Admin\Controllers\Common;

use Admin\Controllers\BaseController;
use Admin\Models\User\UserModel;

class Login extends BaseController
{
    public function index(array $params = [])
    {

        $this->document->setTitle(lang('common/login.heading_title'));

        if ($this->user->isLogged() && $this->session->get('user_token')) {
            return redirect()->to('common/dashboard?user_token=' . $this->session->get('user_token'));
        }

        // user_token validation
        if (($this->request->getVar('user_token') &&  ! $this->session->get('user_token')) || $this->session->get('user_token') != $this->request->getVar('user_token')) {
            $this->session->setFlashData('warning', lang('en.error.token'));
        }

        $data['forgotten'] = site_url('common/forgotten');
        $data['authLogin'] = site_url('common/login/authLogin');
        $data['base']      = slash_item(env('app.adminURL'));
        
        // preserve a flashdata variable
        if (isset($params['redirect'])) {
            $this->session->setTempdata('redirect', $params['redirect'], 300);
        } else {
            $this->session->setTempdata('redirect', $this->session->getFlashdata('redirect'), 300);
        } 

        if (!empty($this->request->getPost('email', FILTER_SANITIZE_EMAIL))) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        if (!empty($this->request->getPost('password'))) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        if ($this->session->getTempdata('redirect')) {
            $data['redirect'] = $this->session->getTempdata('redirect');
        } else {
            $data['redirect'] = '';
        }


        if (isset($params['warning']))  {
            $data['warning'] = $params['warning'];
        } elseif ($this->session->getFlashdata('warning')) {
            $data['warning'] = $this->session->getFlashdata('warning');
        } else {
            $data['warning'] = '';
        }

        $data['header'] = view_cell('\Admin\Controllers\Common\Header::index');
        $data['footer'] = view_cell('\Admin\Controllers\Common\Footer::index');
        
        // Make language data available to view  
        lang('common/login');

        return $this->template->render('common/login', $data);
    }

    public function authLogin()
    {
        $json = [];

        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            if (! $this->validate([
                'email'    => 'required',
                'password' => 'required|min_length[4]',
        ]) || ! $this->user->login($this->request->getPost('email', FILTER_SANITIZE_EMAIL), $this->request->getPost('password'))) {
                $json['validator'] = $this->validator->getErrors();
                $json['error'] = lang('common/login.text_warning');
            }

            if (! $json) {
                // set Token
                $this->session->set('user_token', token(32));
                // get Redirect Url if set
                if ($this->request->getPost('redirect')) {
                    $json['redirect'] = site_url(strtolower($this->request->getPost('redirect')) . '?user_token=' . $this->session->get('user_token'));
                } else {
                    $json['redirect'] = site_url('common/dashboard?user_token=' . $this->session->get('user_token'));
                }
            }
        }

        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
