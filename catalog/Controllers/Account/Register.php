<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;

class Register extends BaseController
{
    public function index()
    {
        if ($this->customer->isLogged()) {
            return redirect()->to(route_to('account_dashboard', $this->customer->getUserName()));
        }

        $this->document->setTitle(lang('account/register.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/register.heading_title'),
            'href' => route_to('account_register') ? route_to('account_register') : base_url('account/register'),
        ];
        
        $data['text_login'] = sprintf(lang('account/register.text_login'), route_to('account_login') ? route_to('account_login') : base_url('account/login'));

        $data['register'] = base_url('account/register/register');

        $data['header']        = view_cell("\Catalog\Controllers\Common\Header::index");
        $data['menu']          = view_cell("\Catalog\Controllers\Common\Menu::index");
        $data['footer']        = view_cell("\Catalog\Controllers\Common\Footer::index");

        lang('account/register');

        return $this->template->render('account/register', $data);
    }

    public function register()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (! $this->validate([
                'email' => [
                    'rules' => 'required|valid_email|is_unique[customer.email]',
                    'errors' => [
                        'is_unique' => 'Warning: E-Mail Address is already registered!'
                    ],
                ],
                'firstname' => 'required|min_length[4]',
                'lastname'  => 'required|min_length[4]',
                'password'  => 'required|min_length[4]',
                'confirm'   => 'required_with[password]|matches[password]',
            ])) {
                $json['errors'] = $this->validator->getErrors();
                $json['error_warning'] = lang("{$this->locale}.error.form");
            }
        
            if (! $json && ($this->request->getMethod() == 'post')) {
                $customerModel = new CustomerModel();
                $customer_id = $customerModel->insert($this->request->getPost());

                // Clear any previous login attempts for unregistered accounts.
                $customerModel->deleteLoginAttempts($this->request->getPost('email'));

                $this->customer->login($this->request->getPost('email', FILTER_SANITIZE_EMAIL), $this->request->getPost('password'));

                $this->session->setFlashdata('success', lang('account/register.text_success'));
                $json['redirect'] = route_to('account_success');
            }
        }


        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
