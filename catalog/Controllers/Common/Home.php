<?php 

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;

class Home extends BaseController
{
	public function index()
	{
		$this->document->setTitle($this->registry->get('config_meta_title'));
		$this->document->setDescription($this->registry->get('config_meta_description'));
		$this->document->setKeywords($this->registry->get('config_meta_keyword'));

        $data['header']         = view_cell("\Catalog\Controllers\Common\Header::index");
        $data['menu']           = view_cell("\Catalog\Controllers\Common\Menu::index");
        $data['content_top']    = view_cell("\Catalog\Controllers\Common\Content_top::index");
        $data['content_bottom'] = view_cell("\Catalog\Controllers\Common\Content_bottom::index");
        $data['footer']         = view_cell("\Catalog\Controllers\Common\Footer::index");
		
		
		lang('common/home');

		return $this->template->render('common/home', $data);

	}

	//--------------------------------------------------------------------

}
