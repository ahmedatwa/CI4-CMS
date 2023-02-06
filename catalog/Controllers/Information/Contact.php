<?php 

namespace Catalog\Controllers\Information;

use Catalog\Controllers\BaseController;

class Contact extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('information/contact.heading_title'));
    
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url('common/home')
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('information/contact.heading_title'),
            'href' => route_to('contact_us')
        ];

        $data['site']         = $this->registry->get('config_name');
        $data['address']      = nl2br($this->registry->get('config_address'));
        $data['telephone']    = $this->registry->get('config_telephone');
        $data['config_email'] = $this->registry->get('config_email');
        $data['send']         = route_to('contact_send');

        $data['open_hours'] = [];

        $config_opening_times = preg_replace('~\r?\n~', "\n", $this->registry->get('config_opening_times'));
        foreach (explode("\n", $config_opening_times) as $time) {
            $data['open_hours'][] = trim($time);
        }

        
        $data['header']       = view_cell('\Catalog\Controllers\Common\Header::index');
        $data['menu']         = view_cell('\Catalog\Controllers\Common\Menu::index');
        $data['column_left']  = view_cell('\Catalog\Controllers\Common\Column_left::index');
        $data['column_right'] = view_cell('\Catalog\Controllers\Common\Column_right::index');
        $data['footer']       = view_cell('\Catalog\Controllers\Common\Footer::index');

        lang('information/contact');

        return $this->template->render('information/contact', $data);
    }

    public function send()
    {
        $json = [];
        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            if (! $this->validate([
                'name'    => 'required|min_length[3]|max_length[32]',
                'email'   => 'required|valid_email',
                'inquiry' => 'required|min_length[10]|max_length[300]',
            ])) {
                $json['errors'] = $this->validator->getErrors();
            }

            if (! $json) {
                $email = \Config\Services::email();

                $email->setFrom($this->registry->get('config_email'), $this->registry->get('config_name'));
                $email->setTo(html_entity_decode($this->request->getPost('name'), ENT_QUOTES, 'UTF-8'));

                $email->setSubject(html_entity_decode(sprintf(lang('information/contact.text_subject'), esc($this->request->getPost('name'))), ENT_QUOTES, 'UTF-8'));
                $email->setMessage(esc($this->request->getPost('enquiry'), 'html'));
            
                if ($email->send()) {
                    $json['success'] = lang('information/contact.text_success');
                }
            }
        }

        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
