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
use Config\App;
use Shared\Models\Localisation\CurrencyModel;
use Shared\Models\Design\TranslationModel;

//--------------------------------------------------------------------

if (! function_exists('datetimeFormat')) {
    /*
    * @return String
    * @var timestamp int
    */
    function datetimeFormat(int $timestamp = 0, bool $time = false): string
    {
        $locale = Services::registry()->get('locale') ?? Services::request()->getLocale();

        if ($time) {
            return ($timestamp) ? date(lang("{$locale}.datetime_format"), $timestamp) : $timestamp;
        } else {
            return ($timestamp) ? date(lang("{$locale}.date_format_short"), $timestamp) : $timestamp;
        }
    }
}
//--------------------------------------------------------------------
if (! function_exists('currencyFormat')) {
    /**
     * currencyFormat
     *
     * @param null $params
     *
     * @return string
     */
    function currencyFormat(float $number): string
    {
        $currencyModel = new CurrencyModel();
    
        if (Services::request()->getCookie(config('App')->cookiePrefix . 'currency')) {
            $code = Services::request()->getCookie(config('App')->cookiePrefix . 'currency', FILTER_SANITIZE_STRING);
        } else {
            $code = Services::registry()->get('config_currency');
        }

        $currency_info = $currencyModel->getCurrencyByCode($code);

        $fraction = (int) $currency_info['fraction'] ?? 2;

        $value = $currency_info['value'] ? (float) $number * $currency_info['value'] : (float) $number;

        if (Services::request()->getCookie(config('App')->cookiePrefix . 'currency')) {
            if ($currency_info['symbol_left']) {
                return $currency_info['symbol_left'] . number_format(round($value, $fraction), $fraction);
            } else {
                return number_format(round($value, $fraction), $fraction) . $currency_info['symbol_right'];
            }
        } else {
            if ($currency_info['symbol_left']) {
                return $currency_info['symbol_left'] . number_format(round($value, $fraction), $fraction);
            } else {
                return number_format(round($value, $fraction), $fraction) . $currency_info['symbol_right'];
            }
        }
    }
}
//--------------------------------------------------------------------

if (! function_exists('generateSeoUrl')) {
    /**
     * @var string text
     * @return mixed
     */
    function generateSeoUrl(string $string): ?string
    {
        helper('text');
        $string = strtolower(url_title(convert_accented_characters($string), '-'));
        return reduce_multiples($string, '-', true);
    }
}
//--------------------------------------------------------------------

if (! function_exists('slash_item')) {
    // Unlike CI3, this function is placed here because
    // it's not a config, or part of a config.
    /**
     * Fetch a config file item with slash appended (if not empty)
     *
     * @param string $item Config item name
     *
     * @return string|null The configuration item or NULL if
     *                     the item doesn't exist
     */
    function slash_item(string $item): ?string
    {
        $config = config(App::class);

        if (! isset($config->{$item}) || !empty(trim($config->{$item}))) {
            return rtrim($item, '/') . '/';
        } else {
            return rtrim($config->{$item}, '/') . '/';
        }
    }
}

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

           // fill the array with controller lang strings
            if ($file = Services::locator()->locateFile(ucwords($line, '/'), "Language/{$locale}", 'php')) {
                $tempData[$line] = require($file);
            }

            // Load the main locale file if found
            if ($mainLangFile = Services::locator()->locateFile(ucwords($locale), "Language/{$locale}", 'php')) {
                $tempData[$locale] = require($mainLangFile);
            } 
            
            // Replace the data with any keys set by language editor
            $translationModel = new TranslationModel();
            $results = $translationModel->where([
                            'route'       => $line,
                            'language_id' => Services::registry()->get('config_language_id')
                        ])->findAll();

            if ($results) {
                foreach ($results as $result) {
                    if ($result['route'] ==  $line) {
                        $tempData[$line][$result['key']] = $result['value'];
                    }
                }
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
//--------------------------------------------------------------------

if (! function_exists('resizeImage')) {
    /*
    * @var filename string
    * @var width int
    * @var height int
    * @return string
    */
    function resizeImage(string $filename, int $width, int $height)
    {
        if (!is_file(DIR_IMAGE . $filename) || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $filename)), 0, strlen(DIR_IMAGE)) != str_replace('\\', '/', DIR_IMAGE)) {
            return;
        }

        // get the image extension
        $image_extension = pathinfo($filename, PATHINFO_EXTENSION);
        //get the image name
        $image_old = $filename;

        // store resized images in new cach path with the same folder names
        $image_new = 'cache' . DIRECTORY_SEPARATOR . substr($image_old, 0, strrpos($image_old, '.')) . '-' . $width . 'x' . $height . '.' . $image_extension;

        if (!is_file(DIR_IMAGE . $image_new) || (filemtime(DIR_IMAGE . $image_old) > filemtime(DIR_IMAGE . $image_new))) {
            // Assign variables as if they were an array:
            list($original_width, $original_height, $original_type) = getimagesize(DIR_IMAGE . $image_old);

            // double check type is extension
            if (!in_array($original_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_BMP))) {
                return DIR_IMAGE . $image_old;
            }

            $path = '';
            
            $directories = explode('/', dirname($image_new));

            foreach ($directories as $directory) {
                $path =  $path . DIRECTORY_SEPARATOR . $directory;

                if (!is_dir(DIR_IMAGE . ltrim($path, '/'))) {
                    @mkdir(rtrim(DIR_IMAGE, '/') . $path, 0777);
                }
            }

            // Resize the image
            if ($original_width != $width || $original_height != $height) {
                try {
                    Services::image()->withFile(DIR_IMAGE . $image_old)
                                     ->resize($width, $height, false, 'height')
                                     ->save(DIR_IMAGE . $image_new);
                } catch (CodeIgniter\Images\ImageException $e) {
                    echo $e->getMessage();
                }
            } else {
                copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);
            }
        }
        // return the image href
        return slash_item(env('app.siteURL')) . 'images' . DIRECTORY_SEPARATOR  . $image_new;
    }
}

//--------------------------------------------------------------------

if (! function_exists('token')) {
    /*
    * @return String
    * @vars type
    *
    */
    function token(int $len = 16, string $type = 'alnum'): string
    {
        switch ($type) {
            case 'alpha':
                return random_string('alpha', $len);
                break;
            case 'alnum':
                return random_string('alnum', $len);
                break;
            case 'basic':
                return random_string('basic', $len);
                break;
            case 'numeric':
                return random_string('numeric', $len);
                break;
            case 'nozero':
                return random_string('nozero', $len);
                break;
                // fixed length of 32
            case 'md5':
                return random_string('md5', 32);
                break;
                // fixed length of 40
            case 'sha1':
                return random_string('sha1', 40);
                break;
            case 'crypto':
                return random_string('crypto', $len);
                break;
            default:
                return random_string('alnum', $len);
                break;
        }
    }
}

//--------------------------------------------------------------------
