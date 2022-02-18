<?php

namespace Admin\Controllers\Common;

use Admin\Controllers\BaseController;
use Admin\Models\User\UserModel;

class Forgotten extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $this->document->setTitle(lang('common/forgotten.heading_title'));

        if ($this->user->isLogged() && $this->session->get('user_token') == $this->request->getVar('user_token')) {
            return redirect()->to(site_url('common/dashboard?user_token=' . $this->session->get('user_token')));
        }

        $data['forgotten'] = site_url('common/forgotten/resetPassword');

        $data['header'] = view_cell('\Admin\Controllers\Common\Header::index');
        $data['footer'] = view_cell('\Admin\Controllers\Common\Footer::index');

        lang('common/forgotten');

        return $this->template->render('common/forgotten', $data);
    }

    public function resetPassword()
    {
        $json = [];

        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            if (! $this->validate([
                'email' => 'required|valid_email',
            ])) {
                $json['error'] = $this->validator->getError('email');
            }

            if (! $this->userModel->getTotalUsersByEmail($this->request->getPost('email', FILTER_SANITIZE_EMAIL))) {
                $json['error_record'] = lang('common/forgotten.error.email');
            }

            if (! $json) {
                $this->userModel->editCode($this->request->getPost('email', FILTER_SANITIZE_EMAIL), token('alpha', 40));
                $json['success']  = lang('common/forgotten.text_success');
                $json['redirect'] = site_url('common/login');
            }
        }
        
        return $this->response->setJSON($json);
    }
} //------------------------------------------------
