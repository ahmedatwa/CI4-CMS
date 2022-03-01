<?php

/**
 * CodeIgniter Template Engine
 *
 *
 * @package     CodeIgniter
 * @author      Ahmed Atwa
 * @copyright   Copyright (c) 2021 Ahmed Atwa
 * @subpackage  Libraries
 *
 */

namespace Shared\Libraries;

use Config\Services;
use Shared\Registry;
use Psr\Log\LoggerInterface;
use CodeIgniter\Autoloader\FileLocator;
use Shared\Models\Design\TranslationModel;
use Shared\Libraries\Template\Exceptions\TemplateException;

class Template
{
    /**
     * @param object $adaptor
    */
    protected $adaptor;
    /**
     * Merge langData and userData
     *
     * @var array
     */
    protected $tempData = [];
    /**
     * locale.
     *
     * @var string
     */
    protected $locale;
    /**
     * Constructor
     *
     * @param adaptor          $adaptor
     * @param FileLocator|null $locator
     * @param boolean|null     $debug
     * @param LoggerInterface  $logger
    */
    public function __construct(string $adaptor, FileLocator $locator = null, Registry $registry = null, bool $debug = null, LoggerInterface $logger = null)
    {
        $this->locator  = $locator ?? Services::locator();
        $this->registry = $registry ?? Services::registry();
        $this->locale   = $this->registry->get('locale') ?? Services::request()->getLocale();
        $viewPath       = config('Paths')->viewDirectory;

        $class = 'Shared\Libraries\Template\Adaptor\\' . ucwords($adaptor);

        if (class_exists($class)) {
            $this->adaptor = new $class($viewPath, $locator, $registry, $debug, $logger);
        } else {
            throw TemplateException::forInvalidAdaptor($adaptor);
        }

        log_message('info', "Template: Class initialized using 'Shared\Libraries\Template'.");
    }
    /**
     * Sets a single piece of view data.
     *
     * @param mixed       $value
     * @param string|null $context The context to escape it for: html, css, js, url
     *                             If null, no escaping will happen
     */
    public function setVar(string $name, $value = null, ?string $context = null)
    {
        if ($context) {
            $value = esc($value, $context);
        }

        $this->tempData[$name] = $value;

        return $this;
    }
    /**
     *
     *
     * @param array  $data
     * @param array  $data Additinal language files to be merged
    */
    public function setData(array $data = []): void
    {
        $this->tempData = array_merge($this->tempData, $data);
    }
    /**
     * Sets a single piece of view data.
     *
     * @param mixed       $value
     * @param string|null $context The context to escape it for: html, css, js, url
     *                             If null, no escaping will happen
     */
    public function getVar(string $name)
    {
        return (isset($this->tempData[$name]) ? $this->tempData[$name] : $name);
    }
    /**
     * Returns the current data that will be displayed in the view.
     *
     * @return array
     */
    public function getData(): array
    {
        return  $this->tempData;
    }
    /**
     *
     * @param  string $filename
     * @param  array  $data
     * @return string
    */
    public function render(string $filename, array $data = []): string
    {

        // Make our view data available to the view adaptor.
        if ($this->tempData) {      
            $this->adaptor->setData($this->tempData);
        }

        // will clear the data between each call
        // This keeps your data safe and ensures there is no accidental
        // leaking between calls
        $this->tempData = [];

        return $this->adaptor->render($filename, $data);
    }

    // ----------------------------------------------------
}
