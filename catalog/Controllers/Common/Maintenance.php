<?php 

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;

class Maintenance extends BaseController
{
	public function index() {

		$data['lang']      = $this->locale;

		$this->response->setStatusCode(503);

		lang('common/maintenance');

		return $this->template->render('common/maintenance', $data);
	}
}
