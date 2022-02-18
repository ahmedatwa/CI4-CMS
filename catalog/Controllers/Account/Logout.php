<?php

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;

class Logout extends BaseController
{
    public function index()
    {
        if ($this->customer->isLogged()) {
            $this->customer->logout();
        }

        return redirect()->to(base_url());
    }

    //--------------------------------------------------------------------
}
