<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */
/*
* @var filename string
* @var width int
* @var height int
* @return string
*/
use Config\Services;


 //--------------------------------------------------------------------
 if (! function_exists('lang')) {
    /**
     * A convenience method to translate a string or array of them and format
     * the result with the intl extension's MessageFormatter.
     *
     * @return string
     */
    function lang(string $line, array $args = [], ?string $locale = null)
    {
        
        $tempData = [];

        $locale = Services::registry()->get('locale') ?? Services::request()->getLocale();
   
        // getting the parsed the line
        if (strpos($line, '.') == false) {
           //  fill the array with lang strings
            if ($file = Services::locator()->locateFile(ucwords($line, '/'), "Language/{$locale}", 'php')) {
                
                $tempData[$line] = require($file);
            }
            // Load the main locale file if found
            if ($mainLangFile = Services::locator()->locateFile(ucwords($locale), "Language/{$locale}", 'php')) {
                
                $tempData[$locale] = require($mainLangFile);
            } 
        }
      
        // set the template data
        Services::template()->setData($tempData);

        // override case-sensitivity on live server
        if (strpos($line, '/')) {
            $parts = array_map('ucfirst', explode('/', $line));
            $line  = implode('/', $parts);
        } elseif(substr($line, 0, 2) == $locale) {
            $line = ucfirst($line);
        }

        return Services::language($locale)
           ->getLine($line, $args);
    }
}
