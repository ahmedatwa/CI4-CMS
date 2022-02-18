<?php

namespace Admin\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        
        // override login route
        if ((string) $request->uri == slash_item('baseURL')) {
            return;
        }
        
        $router = service('router');
        $user   = service('user');

        if (substr($router->controllerName(), 0, strlen(APP_NAMESPACE) + 1) == '\\' . APP_NAMESPACE) {
            $route = str_replace('\\', '/', substr($router->controllerName(), strlen('\\/' . APP_NAMESPACE . '\\Controllers')));
        } else {
            $route = ltrim(str_replace('\\', '/', str_replace('Controllers\\', '', $router->controllerName())), '/\\');
        }


        if ($route) {
            $route = strtolower($route);

            // Ignore controllers for login Check
            $ignoreLogin = [
                'common/login',
                'common/forgotten',
            ];

            if (!$user->isLogged() && !in_array($route, $ignoreLogin)) {
                echo view_cell('\Admin\Controllers\Common\Login::index', ['redirect' => strtolower($route), 'warning' => lang('en.error.token')]);
                exit(403);
            }

            // Ignore controllers for token Check
            $ignoreToken = [
                'common/dashboard',
                'common/login',
                'common/logout',
                'common/forgotten',
                'error/not_found',
                'error/permission',
            ];

            // redirect if not logged in or token expired
            if (!in_array($route, $ignoreToken) && (!$request->getVar('user_token')) && !session('user_token') || ($request->getVar('user_token') != session('user_token'))) {                
                echo view_cell('\Admin\Controllers\Common\Login::index', ['redirect' => strtolower($route), 'warning' => lang('en.error.token')]);
                exit(403);
            }

            // Ignore controllers for access Check
            $ignoreAccess = [
                'common/dashboard',
                'common/login',
                'common/logout',
                'common/forgotten',
                'error/not_found',
                'error/permission',
            ];

            if (!in_array($route, $ignoreAccess) && !$user->hasPermission('access', $route)) {
                echo view_cell('\Admin\Controllers\Error\Permission::index');
                exit(401);
            }
        } else {
            throw new \Exception('Error: Route is not found' . $route);
            exit(404);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing Here
    }

    // ----------------------------------------------------
}
