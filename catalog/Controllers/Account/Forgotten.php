<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;

class Forgotten extends BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('account/forgotten.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('account/forgotten.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/forgotten.heading_title'),
            'href' => route_to('account_forgotten') ? route_to('account_forgotten') : base_url('account/forgotten'),
        ];

        $data['login'] = route_to('account_login') ? route_to('account_login') : base_url('account/login');
        $data['heading_title'] = lang('account/forgotten.heading_title');
        
        lang('account/forgotten');

        $this->template->output('account/forgotten', $data);
    }

    public function forgotten()
    {
        $json = [];
        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            $customerModel = new CustomerModel();

            if (! $this->validate([
              'email' => "required|valid_email",
            ])) {
                $json['error']['email'] = $this->validator->getError('email');
            }

            if (! $customerModel->getTotalCustomersByEmail($this->request->getPost('email', FILTER_SANITIZE_EMAIL))) {
                $json['error']['not_found'] = lang('account/forgotten.error.email');
            }

        if (! $json) {
            $customerModel->editCode($this->request->getPost('email', FILTER_SANITIZE_EMAIL), random_string('alnum', 40));
            $json['success'] = lang('account/forgotten.text_success');
            $json['redirect'] = route_to('account_login') ? route_to('account_login') : base_url('account/login');
        }
    }
        return $this->response->setJSON($json);
    }

    // -------------------------------------------------------------
}