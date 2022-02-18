<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;

class Success extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('account/success.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] =  [
            'text' => lang('account/success.heading_title'),
            'href' => base_url('account/success')
        ];

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->customer->isLogged()) {
            $data['text_message'] = sprintf(lang('account/success.text_message'), route_to('contact'));
        } 

        $data['header']        = view_cell("\Catalog\Controllers\Common\Header::index");
        $data['menu']          = view_cell("\Catalog\Controllers\Common\Menu::index");
        $data['footer']        = view_cell("\Catalog\Controllers\Common\Footer::index");

        lang('account/success');

        return $this->template->render('account/success', $data);
    }

    //---------------------------------------------------------------
}
