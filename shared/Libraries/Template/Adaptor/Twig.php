<?php

/**
 * CodeIgniter TWIG
 *
 *
 * @package     CodeIgniter
 * @author      Ahmed Atwa
 * @copyright   Copyright (c) 2021 Ahmed Atwa
 * @subpackage  Libraries
 *
 */

namespace Shared\Libraries\Template\Adaptor;

use Config\Services;
use Psr\Log\LoggerInterface;
use Twig\TwigFunction;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Extension\DebugExtension;
use CodeIgniter\Autoloader\FileLocator;
use Shared\Libraries\Template\Exceptions\TemplateException;
use Shared\Libraries\Template\Debug\Toolbar\Twig as TwigCollector;
use Twig\Loader\FilesystemLoader;

class Twig
{
    /**
     * Merge langData and userData
     *
     * @var array
     */
    protected $tempData = [];
    /**
     * The base directory to look in for our Views.
     *
     * @var string
     */
    protected $viewPath;
    /**
     * set default template path if not set
     *
     * @var string
     */
    protected $default = 'default';
    /**
     * Twig Loader.
     *
     * @var object
     */
    protected object $loader;
    /**
     * Instance of FileLocator for when
     * we need to attempt to find a view
     * that's not in standard place.
     *
     * @var FileLocator
     */
    protected $locator;
    /**
     * Number of loaded views
     *
     * @var integer
     */
    protected $viewsCount = 0;
    /**
     * Cache stats about our performance here,
     * when CI_DEBUG = true
     *
     * @var array
     */
    protected $performanceData = [];
    /**
     * Constructor
     *
     * @param viewPath         $viewPath
     * @param FileLocator|null $locator
     * @param boolean|null     $registry
     * @param boolean|null     $debug
     * @param LoggerInterface  $logger
    */
    public function __construct(string $viewPath = null, FileLocator $locator = null, Registry $registry = null, bool $debug = null, LoggerInterface $logger = null)
    {
        $this->viewPath = rtrim(realpath($viewPath), '\\/ ') . DIRECTORY_SEPARATOR ?? config('Paths')->viewDirectory;
        $this->locator  = $locator ?? Services::locator();
        $this->registry = $registry ?? Services::registry();
        $this->logger   = $logger ?? Services::logger();
        $this->debug    = $debug ?? CI_DEBUG;
        $this->loader   = new FilesystemLoader([$this->viewPath, APPPATH]);
    }
    /**
    * Render
    *
    * @param	string	$filename
    * @param	array	$data
    * @return	string
    */
    public function render(string $filename, array $data = [], string $code = ''): string
    {        
        $start = microtime(true);

        $benchmark = \Config\Services::timer();
        $fileExt   = pathinfo($filename, PATHINFO_EXTENSION);
        $realPath  = empty($fileExt) ? $filename . '.twig' : $filename;
        $file      = $this->viewPath . $realPath;

    
        if (! is_file($file)) {
            $file = $this->locator->locateFile($filename, 'Views', empty($fileExt) ? 'twig' : $fileExt);
        }
        /**
         * since template file not found in default location
         * will check for any template folder supplied by registry
         * realpath should be changed accordingly
         */
        if (! is_file($file)) {
            // make sure template dir is there
            // otherwise fallback to default template
            if ($config_theme = $this->registry->get('config_theme')) {
                if (! is_dir($this->viewPath . $config_theme)) {
                    $this->registry->set('config_theme', $this->default);
                }
            } else {
                $config_theme = $this->default;
            }

            $config_theme = $this->registry->get('config_theme');
            
            $file      = $this->locator->locateFile($config_theme . DIRECTORY_SEPARATOR . $filename, 'Views', empty($fileExt) ? 'twig' : $fileExt);
            $realPath  = empty($fileExt) ? $config_theme . DIRECTORY_SEPARATOR .  $filename . '.twig' : $config_theme . DIRECTORY_SEPARATOR .  $filename;
        }

        // still no file found throw exeption
        if (! $file) {
            throw TemplateException::forFileNotFound($realPath);
        }

        // set the language Data
        if (!empty($this->tempData) && isset($this->tempData)) {
            foreach ($this->tempData as $key => $result) {
                $data = array_merge($result, $data);
            }
        }
        
        if ($code) {
            $loader = new ArrayLoader([
                $file => file_get_contents($file)
            ]);
        } else {
            $loader = $this->loader;
        }

        // remove the root web directory.
        $file = $realPath;

        try {
            // initialize Twig environment
            $config = [
                'autoescape'       => false,
                'auto_reload'      => true,
                'debug'            => ENVIRONMENT !== 'production',
                'cache'            => config('paths')->writableDirectory . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . strtolower(APP_NAMESPACE),
            ];

            $twig = new Environment($loader, $config);
            
            $twig->addExtension(new DebugExtension());
            // CI4 PHP CSRF functions
            $CIFunctions = ['csrf_field', 'csrf_token', 'csrf_hash', 'csrf_header', 'adminUrl', 'siteUrl'];
            foreach ($CIFunctions as $value) {
                if (function_exists($value)) {
                    $twig->addFunction(
                        new TwigFunction($value, $value, [
                            'is_safe' => ['html']
                        ])
                    );
                }
            }


            $benchmark->start($file);

            $output = $twig->render($file, $data);

            $this->logPerformance($start, microtime(true), $file);

            $benchmark->stop($file);

            if ($this->debug && in_array('CodeIgniter\Filters\DebugToolbar', service('filters')->getFiltersClass()['after'], true)) {
                $toolbarCollectors = config(Toolbar::class)->collectors;

                if (in_array(TwigCollector::class, $toolbarCollectors, true)) {
                    // Clean up our path names to make them a little cleaner
                    $file = clean_path($file);
                    $file = ++$this->viewsCount . ' ' . $file;

                    $output = '<!-- DEBUG-VIEW START ' . $file . ' -->' . PHP_EOL
                    . $output . PHP_EOL
                    . '<!-- DEBUG-VIEW ENDED ' . $file . ' -->' . PHP_EOL;
                }
            }

            // Clear the Data 
            $this->tempData = [];

            return $output;
            
        } catch (Exception $e) {
            throw TemplateException::forTemplateNotFound($filename);
            exit();
        }
    }
    /**
     * Logs performance data for rendering a view.
     *
     * @param float  $start
     * @param float  $end
     * @param string $view
     *
     * @return void
     */
    protected function logPerformance(float $start, float $end, string $view)
    {
        if ($this->debug) {
            $this->performanceData[] = [
                'start' => $start,
                'end'   => $end,
                'view'  => $view,
            ];
        }
    }
    /**
     * Returns the performance data that might have been collected
     * during the execution. Used primarily in the Debug Toolbar.
     *
     * @return array
     */
    public function getPerformanceData(): array
    {
        return $this->performanceData;
    }
    /**
     *
     *
     * @param array $data
     * @param array $data Additinal language files to be merged
    */
    public function setData(array $data = [])
    {
        $this->tempData = array_merge($this->tempData, $data);   
    }
    /**
     * Sets a single piece of view data.
     *
     * @param string $name
     * @param mixed $value
     */
    public function setVar(string $key, $value = null)
    {
        $this->tempData[$key] = $value;
    }
    // ----------------------------------------
}
