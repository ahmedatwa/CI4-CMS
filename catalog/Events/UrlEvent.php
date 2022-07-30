<?php

namespace Catalog\Events;

use Config\Services;
use Shared\Models\Setting\SettingModel;
use Shared\Models\Localisation\LanguageModel;
use Shared\Models\Localisation\CurrencyModel;

class UrlEvent
{

    use CodeIgniter\HTTP\IncomingRequest;
    use CodeIgniter\HTTP\URI;
    use CodeIgniter\Router\Exceptions\RouterException;
    use Config\App;
    use Config\Services;


   
   public function index(): void {
        // Add rewrite to URL class
            add_rewrite($this);

        $this->load->model('design/seo_url');

        // Decode URL
        if (isset($this->request->get['_route_'])) {
            $parts = explode('/', $this->request->get['_route_']);

            // remove any empty arrays from trailing
            if (utf8_strlen(end($parts)) == 0) {
                array_pop($parts);
            }

            foreach ($parts as $part) {
                $seo_url_info = $this->model_design_seo_url->getSeoUrlByKeyword($part);

                if ($seo_url_info) {
                    $this->request->get[$seo_url_info['key']] = html_entity_decode($seo_url_info['value'], ENT_QUOTES, 'UTF-8');
                }
            }
        }
    }

    
    // -----------------------------------------------
}
