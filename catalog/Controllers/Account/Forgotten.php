<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;

class Forgotten extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('account/forgotten.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/forgotten.heading_title'),
            'href' => route_to('account_forgotten') ? route_to('account_forgotten') : base_url('account/forgotten'),
        ];

        $data['login'] = base_url('account/login');

        $data['forgotten'] = base_url('account/forgotten/forgotten');


        $data['header']        = view_cell("\Catalog\Controllers\Common\Header::index");
        $data['menu']          = view_cell("\Catalog\Controllers\Common\Menu::index");
        $data['footer']        = view_cell("\Catalog\Controllers\Common\Footer::index");
        
        lang('account/forgotten');

        return $this->template->render('account/forgotten', $data);
    }

    public function forgotten()
    {
        $json = [];

        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            $customerModel = new CustomerModel();

            if (! $this->validate([
              'email' => "required|valid_email",
            ])) {
                $json['validator']['email'] = $this->validator->getError('email');
            }

            if (! $customerModel->getTotalCustomersByEmail($this->request->getPost('email', FILTER_SANITIZE_EMAIL))) {
                $json['validator']['not_found'] = lang('account/forgotten.error.email');
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