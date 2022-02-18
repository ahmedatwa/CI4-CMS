<?php 

namespace Catalog\Controllers\Module;

use Catalog\Controllers\BaseController;

class Account extends BaseController
{
	public function index() 
	{
		$data['logged']     = $this->customer->isLogged();
		$data['register']   = base_url('account/register');
		$data['login']      = base_url('account/login');
		$data['logout']     = base_url('account/logout');
		$data['forgotten']  = base_url('account/forgotten');
		$data['account']    = base_url('account/account');
		$data['edit']       = base_url('account/edit');
		$data['password']   = base_url('account/password');
		$data['download']   = base_url('account/download');
		$data['newsletter'] = base_url('account/newsletter');
		
		lang('module/account');

		return $this->template->render('module/account', $data);
	}

	// --------------------------------------------
}