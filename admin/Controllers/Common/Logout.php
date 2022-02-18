<?php 

namespace Admin\Controllers\Common;

use Admin\Controllers\BaseController;

class Logout extends BaseController
{
    public function index()
    {
        $this->user->logout();

        return redirect()->to(base_url());
    }


    //--------------------------------------------------------------------
}