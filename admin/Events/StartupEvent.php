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
        $request  = Services::request();

        // Settings
        $settingModel = new SettingModel();
        $settingData = $settingModel->findAll();
        foreach ($settingData as $key => $value) {
                $registry->set($key, $value);
        }
        
        // Language
        if ($registry->get('config_admin_language')) {
        $languageModel = new LanguageModel();
            $language_info = $languageModel->getLanguageByCode($registry->get('config_admin_language'));
            $registry->set([
                'config_language_id' => $language_info['language_id'],
                'locale'             => $language_info['code'],
            ]);
            // Change Default Locale
            $language->setLocale($language_info['code']);
            $request->setLocale($language_info['code']);
        }






    }
    
    // -----------------------------------------------
}
