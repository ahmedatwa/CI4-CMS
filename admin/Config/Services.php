<?php

namespace Config;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
	/**
	 * The User library handle the cusotmer requests
	 * like login register and intialize the user session.
	 *
	 * @param boolean $getShared
	 *
	 * @return User
	 */
    public static function user($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('user');
        }
        return new \Shared\Libraries\User();
    }

    //--------------------------------------------------------------------
	/**
	 * The Document library handle the Meta document tags
	 *
	 * @param boolean $getShared
	 *
	 * @return Document
	 */
    public static function document($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('document');
        }
        return new \Shared\Libraries\Document();
    }

    //--------------------------------------------------------------------
	/**
	 * The Registry library handle the systen settings variables
	 * and it could keep variables on the fly
	 *
	 * @param boolean $getShared
	 *
	 * @return Registry
	 */
    public static function registry($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('registry');
        }
        return new \Shared\Libraries\Registry();
    }

    //--------------------------------------------------------------------
	/**
	 * The Template library handle all custom template engines 
	 * current is TWIG and native CI4.
	 *
	 * @param boolean $getShared
	 *
	 * @return Template
	 */
    public static function template($getShared = true)
    {
        $engine = self::registry()->get('config_template_engine') ?: 'twig';
        if ($getShared) {
            return static::getSharedInstance('template');
        }
        return new \Shared\Libraries\Template($engine);
    }

    // --------------------------------------------
}
