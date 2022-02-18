<?php

namespace Admin\Events;

use Config\Services;
use Shared\Models\Setting\SettingModel;
use Shared\Models\Localisation\LanguageModel;

class StartupEvent
{
    public static function index()
    {
        $registry = Services::registry();
        $language = Services::language();

        // Settings
        $settingModel = new SettingModel();
        $settingData = $settingModel->findAll();
        foreach ($settingData as $key => $value) {
                $registry->set($key, $value);
        }
        
        // Language
        $languageModel = new LanguageModel();
        $supportedLocales = config('App')->supportedLocales;
        if (in_array($registry->get('config_admin_language'), $supportedLocales)) {
            $language_info = $languageModel->getLanguageByCode($registry->get('config_admin_language'));
            $registry->set([
                'config_language_id' => $language_info['language_id'],
                'locale'             => $language_info['code'],
            ]);
            // Change Default Locale
            $language->setLocale($language_info['code']);
        }






    }
    
    // -----------------------------------------------
}
