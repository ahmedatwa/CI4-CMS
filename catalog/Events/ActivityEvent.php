<?php

namespace Catalog\Events;

use Catalog\Libraries\Customer;
use Catalog\Models\Account\CustomerModel;

class ActivityEvent
{
    /**
    *@trigger Catalog/Controllers/Account/Login::authenticate
    */
    public static function authenticate(array $data)
    {
        /**
        * @register Admin event.
        * @var data array
        */
        $activityData = [
            'customer_id' => $data['customer_id'],
            'username'    => $data['username'],
            'ip'          => $data['ip'],
            'user_agent'  => $data['user_agent']
        ];

        model('\Catalog\Models\Account\ActivityModel')->addActivity('customer_login', $activityData);
        /**
        * @register system event for suspecious login from differnt IP.
        * if IP doesn't match send email to customer.
        */
        model('\Catalog\Models\Account\ActivityModel')->addCustomerIP(['customer_id' => $data['customer_id']]);
    }

    /*
    * For Admin Visibility Only.
    * @trigger Catalog/Controllers/Account/Register::Register
    */
    public static function register(array $data)
    {
        $activityData = [
            'customer_id' => $data['customer_id'],
            'username'    => $data['username'],
            'ip'          => $data['ip'],
            'user_agent'  => $data['user_agent']
        ];

        model('\Catalog\Models\Account\ActivityModel')->addActivity('customer_register', $activityData);
    }


    // --------------------------------------------------
}
