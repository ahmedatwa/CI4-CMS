<?php

namespace Shared\Libraries\Template\Adaptor;

use Config\Services;

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
    public function render(string $name, array $data = [], array $options = []): string
    {
        /**
         * @var CodeIgniter\View\View $renderer
         */
        $renderer = Services::renderer();

        $saveData = config(View::class)->saveData;

        if (array_key_exists('saveData', $options)) {
            $saveData = (bool) $options['saveData'];
            unset($options['saveData']);
        }

        return $renderer->setData($data, 'raw')
                        ->render($name, $options, $saveData);
    }

    // --------------------------------------------------------------------------------------------------
}
