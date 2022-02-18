<?php

namespace Admin\Controllers\Common;

use Admin\Controllers\BaseController;

class Footer extends BaseController
{
	public function index()
	{
		$data['text_footer']  = sprintf(lang('common/footer.text_footer'), $this->registry->get('config_name'));
		$data['text_version'] = sprintf(lang('common/footer.text_version'), APP_VERSION);

		lang('common/footer');

		return $this->template->render('common/footer', $data);
	}
}
