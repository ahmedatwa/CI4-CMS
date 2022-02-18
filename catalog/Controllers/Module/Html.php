<?php 

namespace Catalog\Controllers\Module;

use Catalog\Controllers\BaseController;

class Html extends BaseController
{
    public function index(array $setting) 
    {
		if (isset($setting['module_description'])) {
			$data['heading_title'] = html_entity_decode($setting['module_description']['title'], ENT_QUOTES, 'UTF-8');
			$data['html'] = html_entity_decode($setting['module_description']['description'], ENT_QUOTES, 'UTF-8');
		} else {
			$data['heading_title'] = '';
			$data['html'] = '';
		}

		lang('module/html');

        return $this->template->render('module/html', $data);
	}
// -----------------------------------------
}
