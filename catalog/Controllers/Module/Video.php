<?php

namespace Catalog\Controllers\Module;

use Catalog\Controllers\BaseController;

class Video extends BaseController
{
    public function index(array $setting)
    {

        $data['videos'] = [];

        if (isset($setting['module_description'])) {
            foreach ($setting['module_description'] as $result) {
                if (is_file(DIR_IMAGE . $result)) {
                    $fileMime = mime_content_type(DIR_IMAGE . $result);
                } else {
                    $fileMime = '';
                }

                if (in_array($fileMime, ['video/mp4', 'video/webm'])) {
                    $data['videos'][] = [
                    'link' => base_url('images/' . $result),
                    'mime' => $fileMime
                ];
                }
            }
        

            $data['headline'] = $setting['module_description']['headline'];

            $data['background_image'] = resizeImage($setting['module_description']['image'], 846, 415);
        }

        lang('module/video');

        return $this->template->render('module/video', $data);
    }
}
