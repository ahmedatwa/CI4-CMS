<?php

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Catalog\InformationModel;
use Shared\Models\Setting\ExtensionModel;

class Header extends BaseController
{
    public function index()
    {
        $extensionModel = new ExtensionModel();
        //Analytics
        $data['analytics'] = [];

        $analytics = $extensionModel->getInstalled('analytics');

		foreach ($analytics as $analytic) {
			if ($this->registry->get('analytics_' . $analytic)['status']) {
				$data['analytics'][] = html_entity_decode($this->registry->get('analytics_' . $analytic)['code'], ENT_QUOTES, 'UTF-8');;
			}
		}

        $data['lang']        = $this->locale;
        $data['title']       = $this->document->getTitle();
        $data['description'] = $this->document->getDescription();
        $data['keywords']    = $this->document->getKeywords();
        $data['scripts']     = $this->document->getScripts();

        $data['base']        = slash_item(env('app.siteURL'));
        $data['direction']   = lang($this->locale . '.direction');
        $data['author']      = 'A0twa';
        $data['ico']         = base_url() . DIRECTORY_SEPARATOR . 'favicon.ico';
        $data['home']        = route_to('home');

        
        if (is_file(DIR_IMAGE . $this->registry->get('config_logo'))) {
            $data['logo'] = base_url('images') . DIRECTORY_SEPARATOR . $this->registry->get('config_logo');
        } else {
            $data['logo'] = '';
        }
       
        // Blog
        if ($this->registry->get('blog_extension_status')) {
            $data['blog'] = route_to('blog');
        } else {
            $data['blog'] = '';
        }

        // Hard coding css so they can be replaced via the events system.
        $data['bootstrap_css']    = 'catalog/default/vendor/bootstrap/css/bootstrap.min.css';
        $data['fontawesome_css']  = 'catalog/default/vendor/fontawesome/css/all.min.css';
        
        $data['stylesheet_css']   = 'catalog/' . $this->registry->get('config_theme') . '/stylesheet/stylesheet.css'; 

        if (lang($this->locale . '.direction') == 'rtl' && file_exists('catalog/' . $this->registry->get('config_theme') .'/stylesheet/stylesheet-rtl.css')) {
            $data['stylesheet_css']   = 'catalog/' . $this->registry->get('config_theme') . '/stylesheet/stylesheet-rtl.css';
        } 

        $data['links']       = $this->document->getLinks();
        $data['styles']      = $this->document->getStyles();

        if ($this->customer->getID()) {
            $customer_id = $this->customer->getID();
        } else {
            $customer_id = 0;
        }

        if ($this->registry->get('config_global_alert')) {
            $data['global_alert'] = $this->registry->get('config_global_alert');
        } else {
            $data['global_alert'] = '';
        }

        // Static Pages
        $data['informations'] = [];
        $informationModel = new InformationModel();
        foreach ($informationModel->getInformations() as $result) {
            if ($result['top']) {
                $data['informations'][] = [
                    'information_id' => $result['information_id'],
                    'title'          => $result['title'],
                    'href'           => base_url("information/information/?information_id=" . $result['information_id'] . '&locale=' . $this->locale),
                ];
            }
        }

        $data['contact']     = base_url('information/contact');

        $data['logged'] = $this->customer->isLogged();
        $data['username'] = $this->customer->getName();

        $data['login']     = base_url('account/login');
        $data['profile']   = base_url('account/profile');
        $data['dashboard'] = base_url('account/dashboard');
        $data['logout']    = base_url('account/logout');

        if (is_file(DIR_IMAGE . $this->session->get('image'))) {
            $data['image'] = slash_item(env('app.siteURL'))  . 'images/' . $this->session->get('image');
        } else {
            $data['image'] = slash_item(env('app.siteURL')) . 'images/profile.png';
        }

        // Language Data
        lang('common/header');

        return $this->template->render('common/header', $data);
    }

    //--------------------------------------------------------------------
}
