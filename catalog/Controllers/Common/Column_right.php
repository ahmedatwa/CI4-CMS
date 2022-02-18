<?php 

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use Shared\Models\Design\LayoutModel;
use Shared\Models\Setting\ModulesModel;

class Column_right extends BaseController
{
    public function index()
    {
        $router = \CodeIgniter\Config\Services::router();
        $route = str_replace('\\', '/', substr($router->controllerName(), strlen('\Catalog\Controllers\\')));

        if ($route) {
            $route = $route;
        } else {
            $route = 'common/home';
        }

        $layoutModel = new LayoutModel();
        $moduleModel = new ModulesModel();

        $data['modules'] = [];
        
        $layout_id = $layoutModel->getLayoutByRoute($route);

        $modules = $layoutModel->getLayoutModules($layout_id, 'column_right');
        
        foreach ($modules as $module) {

            $part = explode('.', $module['code']);

            $basename = ucfirst($part[0]);

            if (isset($part[0]) && $this->registry->get('module_' . $part[0] . '_status')) {

                $module_data = view_cell("Catalog\Controllers\Module\\{$basename}::index");

                if ($module_data) {
                    $data['modules'][] = $module_data;
                }
            }

            if (isset($part[1])) {

                $setting_info = $moduleModel->find($part[1])['setting'];

                if ($setting_info && $setting_info['status']) {
                   $output = view_cell("Catalog\Controllers\Module\\{$basename}::index", $setting_info);

                    if ($output) {
                        $data['modules'][] = $output;
                    }
                }
            }
        }
        
        lang('common/column_right');

        return $this->template->render('common/column_right', $data);
    }


    //--------------------------------------------------------------------
}
