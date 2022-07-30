<?php

namespace Catalog\Events;

use Config\Services;
use Shared\Models\Setting\SettingModel;
use Shared\Models\Localisation\LanguageModel;
use Shared\Models\Localisation\CurrencyModel;

class StartupEvent
{
    public static function index()
    {
        $registry = Services::registry();
        $language = Services::language();
        $request  = Services::request();
        $response = Services::response();
        
        // Settings
        $settingModel = new SettingModel();        
        foreach ($settingModel->findAll() as $key => $value) {
            $registry->set($key, $value);
           
        }

        // Language
        if ($request->getCookie(config('App')->cookiePrefix . 'language')) {
            if (in_array($code = hex2bin($request->getCookie(config('App')->cookiePrefix . 'language')), config('App')->supportedLocales)) {
                $languageModel    = new LanguageModel();
                $language_info    = $languageModel->getLanguageByCode($code);
                $locale           = $language_info['code'];
                $registry->set([
                    'config_language_id' => $language_info['language_id'],
                    'locale'             => $language_info['code'],
                ]);
                // Change Default Locale
                $language->setLocale($language_info['code']);
                $request->setLocale($language_info['code']);
            }
        } else {
            if (in_array($registry->get('config_language'), config('App')->supportedLocales)) {
                $languageModel = new LanguageModel();
                $language_info = $languageModel->getLanguageByCode($registry->get('config_language'));
                $registry->set([
                    'config_language_id' => $language_info['language_id'],
                    'locale'             => $language_info['code'],
                ]);
                // Change Default Locale
                $language->setLocale($language_info['code']);
                $request->setLocale($language_info['code']);
                $cookie = [
                    'name'     => 'language',
                    'value'    => bin2hex($language_info['code']),
                    'expire'   => '86500',
                    'domain'   => config('App')->cookieDomain,
                    'path'     => config('App')->cookiePath,
                    'prefix'   => config('App')->cookiePrefix,
                    'secure'   => config('App')->cookieSecure,
                    'httponly' => config('App')->cookieHTTPOnly,
                    'samesite' => config('App')->cookieSameSite
                ];
                $response->setCookie($cookie);
            }
        }

        // Currency
        if (!$request->getCookie(config('App')->cookiePrefix . 'currency')) {
            $cookie = [
                'name'     => 'currency',
                'value'    => bin2hex($registry->get('config_currency')),
                'expire'   => '86500',
                'domain'   => config('App')->cookieDomain,
                'path'     => config('App')->cookiePath,
                'prefix'   => config('App')->cookiePrefix,
                'secure'   => config('App')->cookieSecure,
                'httponly' => config('App')->cookieHTTPOnly,
                'samesite' => config('App')->cookieSameSite
            ];    
            $response->setCookie($cookie);
        } else {
            
            $registry->set('config_currency', strtolower(hex2bin($request->getCookie(config('App')->cookiePrefix . 'currency', FILTER_SANITIZE_STRING))));

        }


    }
    
    // -----------------------------------------------
}
