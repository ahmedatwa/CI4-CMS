<?php 

namespace Catalog\Controllers\Module;

use Catalog\Controllers\BaseController;
use Shared\Models\Design\BannerModel;

class Carousel extends BaseController
{
    public function index(array $setting)
    {        
        $bannerModel = new BannerModel();
        
        $data['banners'] = [];

        $results = $bannerModel->getBanner($setting['banner_id']);
        
        foreach ($results as $result) {
            if (is_file(DIR_IMAGE . $result['image'])) {
                $data['banners'][] = [
                    'banner_image_id' => $result['banner_image_id'],
                    'title'           => $result['title'],
                    'link'            => $result['link'],
                    'image'           => resizeImage($result['image'], $setting['width'], $setting['height'])
            ];
            } else {
                $data['banners'][] = [
                    'banner_image_id' => $result['banner_image_id'],
                    'title'           => $result['title'],
                    'link'            => $result['link'],
                    'image'           => $result['link']
                ];
            }
        }

        $data['indicators'] = $setting['dots'];
        $data['arrows']     = $setting['arrows'];
        $data['autoplay']   = $setting['autoplay'];

        lang('module/carousel');

        return $this->template->render('module/carousel', $data);
    }

    // ------------------------------------------------
}