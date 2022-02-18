<?php

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\CategoryModel;
use Catalog\Models\Catalog\InformationModel;
use Shared\Models\Tool\OnlineModel;

class Footer extends BaseController
{
    public function index()
    {
        $data['informations'] = [];

        $informationModel = new InformationModel();
        foreach ($informationModel->getInformations() as $result) {
            if ($result['bottom']) {
                $data['informations'][] = [
                    'information_id' => $result['information_id'],
                    'title'          => $result['title'],
                    'href'           => base_url('information/information?information_id=' . $result['information_id']),
                ];
            }
        }

        // Categories
        $data['categories'] = [];
        $categoryModel = new CategoryModel();

        $filter_data = [
            'start'         => 0,
            'limit'         => 5,
            'parent_id'     => 0,
        ];

        $results = $categoryModel->getCategories($filter_data);
        foreach ($results as $result) {
            $data['categories'][] = [
                'category_id' => $result['category_id'],
                'name'        => $result['name'],
                'href'        => base_url('catalog/category?category_id=' . $result['category_id']),
         ];
        }

        // Social
        $data['contact']     = base_url('information/contact');
        $data['login']       = base_url('account/login');
        $data['register']    = base_url('account/register');

        $data['text_footer']      = sprintf(lang('common/footer.text_footer'), $this->registry->get('config_name'));
        $data['config_name']      = $this->registry->get('config_name');
        $data['config_owner']     = $this->registry->get('config_owner');
        $data['config_telephone'] = $this->registry->get('config_telephone');
        $data['config_email']     = $this->registry->get('config_email');
        $data['config_address']   = $this->registry->get('config_address');
        $data['social_networks']  = $this->registry->get('config_social_networks');

        $data['open_hours'] = [];
        $config_opening_times = preg_replace('~\r?\n~', "\n", $this->registry->get('config_opening_times'));
        foreach (explode("\n", $config_opening_times) as $time) {
            $data['open_hours'][] = trim($time);
        }

        if (is_file(DIR_IMAGE . $this->registry->get('config_logo'))) {
            $data['logo'] = slash_item(env('app.siteURL')) . 'images' . DIRECTORY_SEPARATOR . $this->registry->get('config_logo');
        } else {
            $data['logo'] = '';
        }

        if ($this->registry->get('config_customer_online')) {
            $onlineModel = new OnlineModel();
            $agent = $this->request->getUserAgent();

            if ($this->request->getIPAddress()) {
                $ip = $this->request->getIPAddress();
            } else {
                $ip = '';
            }

            if ($this->customer->getID()) {
                $customer_id = $this->customer->getID();
            } else {
                $customer_id = 0;
            }

            if (current_url()) {
                $url = current_url();
            } else {
                $url = '';
            }

            if ($agent->isReferral()) {
                $referer = $agent->getReferrer();
            } else {
                $referer = previous_url();
            }

            $onlineModel->addOnline($ip, $customer_id, $url, $referer);
        }

        // Chat Widget Code
        if ($this->registry->get('config_chat_widget')) {
            $data['config_chat_widget'] = $this->registry->get('config_chat_widget');
        } else {
            $data['config_chat_widget'] = '';
        }

        $data['scripts'] = $this->document->getScripts();

        $data['currency'] = view_cell('\Catalog\Controllers\Common\Currency::index');
        $data['language'] = view_cell('\Catalog\Controllers\Common\Language::index');

        lang('common/footer');

        return $this->template->render('common/footer', $data, true);
    }

    //--------------------------------------------------------------------
}
