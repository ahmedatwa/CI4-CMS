<?php

namespace Shared\Libraries\Template\Adaptor;

use Config\Services;
use CodeIgniter\Autoloader\FileLocator;
use Twig\Loader\FilesystemLoader;
use CodeIgniter\View\Exceptions\ViewException;

class Template
{
    /**
	 * Builds the output based upon a file name and any
	 * data that has already been set.
	 *
	 * Valid $options:
	 *  - cache      Number of seconds to cache for
	 *  - cache_name Name to use for cache
	 *
	 * @param string       $view     File name of the view source
	 * @param array|null   $options  Reserved for 3rd-party uses since
	 *                               it might be needed to pass additional info
	 *                               to other template engines.
	 * @param boolean|null $saveData If true, saves data for subsequent calls,
	 *                               if false, cleans the data after displaying,
	 *                               if null, uses the config setting.
	 *
	 * @return string
	 */
     /**
     * Merge langData and userData
     *
     * @var array
     */
    protected $tempData = [];
    /**
     * set default template path if not set
     *
     * @var string
     */
    protected $default = 'default';

    public function __construct(string $viewPath = null, FileLocator $locator = null, Registry $registry = null, bool $debug = null, LoggerInterface $logger = null)
    {
        $this->viewPath = rtrim(realpath($viewPath), '\\/ ') . DIRECTORY_SEPARATOR ?? config('Paths')->viewDirectory;
        $this->locator  = $locator ?? Services::locator();
        $this->registry = $registry ?? Services::registry();
        $this->logger   = $logger ?? Services::logger();
        $this->debug    = $debug ?? CI_DEBUG;
        $this->loader   = new FilesystemLoader([$this->viewPath, APPPATH]);
    }

    public function render(string $name, array $data = [], array $options = []): string
    {
        /**
         * @var CodeIgniter\View\View $renderer
         */
        $renderer = Services::renderer();

        $saveData = config(View::class)->saveData;

         /**
         * since template file not found in default location
         * will check for any template folder supplied by registry
         * realpath should be changed accordingly
         */
            // make sure template dir is there
            // otherwise fallback to default template
            if ($config_theme = $this->registry->get('config_theme')) {
                if (! is_dir($this->viewPath . $config_theme)) {
                    $registry->set('config_theme', $this->default);
                }
            } else {
                $config_theme = $this->default;
            }

            $config_theme = $this->registry->get('config_theme');
            
            $file      = $this->locator->locateFile($config_theme . DIRECTORY_SEPARATOR . $name, 'Views', empty($fileExt) ? 'php' : $fileExt);
            $realPath  = empty($fileExt) ? $config_theme . DIRECTORY_SEPARATOR .  $name . '.php' : $config_theme . DIRECTORY_SEPARATOR .  $name;

        
        // still no file found throw exeption
        if (! $file) {
          throw ViewException::forInvalidFile($realPath);
        }


        // set the language Data
        if (!empty($this->tempData) && isset($this->tempData)) {
            foreach ($this->tempData as $key => $result) {
                $data = array_merge($result, $data);
            }
        }

        if (array_key_exists('saveData', $options)) {
            $saveData = (bool) $options['saveData'];
            unset($options['saveData']);
        }

        return $renderer->setData($data, 'raw')
                        ->render($realPath, $options, $saveData);
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

    // --------------------------------------------------------------------------------------------------
}
