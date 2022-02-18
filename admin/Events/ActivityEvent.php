<?php

namespace Admin\Events;

use Config\Services;
use CodeIgniter\Config\Factories;

class ActivityEvent
{
    /**
     * This is a demo implementation of using the Throttler class
     * to implement rate limiting for your application.
     *
     * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
     * @param array|null                                         $arguments
     *
     * @return mixed
     */
    protected static function activityStatus()
    {
        $userActivity = Services::registry()->get('report_user_activity');
        return $userActivity['user_activity']['status'];
    }
    protected static function userData()
    {
        return [
            'user_id'  => (int) Services::user()->getID(),
            'username' => (string) Services::user()->getUserName()
        ];
    }

    // Admin\Models\*\::insert\/Update
    public static function crudEvent(...$args)
    {
        
        if (self::activityStatus() && $args) {
            $data = [
                'key'        => $args[0],
                'data'       => array_merge(self::userData(), $args[1]),
            ];
            Factories::models('Extensions\Models\Report\UserActivityModel')->insert($data);
        }
    }
    /**
    *@trigger Catalog/Controllers/Account/Login::authLogin
    */
    public static function authLogin(array $data)
    {
        /**
        * @register Admin event.
        * @var data array
        */
        $activityData = [
            'user_id'    => $data['user_id'],
            'username'   => $data['username'],
            'ip'         => $data['ip'],
            'user_agent' => $data['user_agent']
        ];

        model('\Extensions\Models\Report\UserActivityModel')->addActivity('user_login', $activityData);
    }

    // Admin\Controllers\user\user::Rules
    public static function addLoginAttempt(string $email)
    {
        Factories::models('Admin\Models\User\UserModel')->addLoginAttempt($email);
    }

    // Admin\Controllers\Common\Forgotten::index
    public static function mailForgotten($email)
    {
        $email = Services::email();

        $email->setFrom('your@example.com', 'Your Name');
        $email->setTo($email);
    
        $email->setSubject('Reset Your Password');
        $email->setMessage(view('Mail/forgotten'));
    
        $email->send();
    }
    // -----------------------------------------------
}
