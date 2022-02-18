<?php

namespace Catalog\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

/**
 *
 * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
 * @param array|null                                         $arguments
 *
 * @return mixed
 */
class MaintenanceFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        if (substr(Services::router()->controllerName(), 1, strlen(APP_NAMESPACE)) == 'Catalog') {
            if (Services::registry()->get('config_maintenance')) {
                echo view_cell('\Catalog\Controllers\Common\Maintenance::index');
                exit(503);
            }
        }

    }

    //--------------------------------------------------------------------

    /**
     * We don't have anything to do here.
     *
     * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
     * @param ResponseInterface|\CodeIgniter\HTTP\Response       $response
     * @param array|null                                         $arguments
     *
     * @return mixed
     */

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}
