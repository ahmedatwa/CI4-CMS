<?php 

namespace Catalog\Controllers\Information;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\InformationModel;

class Information extends BaseController
{
    public function index(string $keyword = null)
    {
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang($this->locale .'.text_home'),
            'href' => base_url('/')
        ];

        $informationModel = new InformationModel();

        if ($this->request->getVar('information_id')) {
            $information_id = $this->request->getVar('information_id');
        } elseif ($keyword) {
            $information_id = $informationModel->findIdByKeyword($keyword);
        } else {
            $information_id = 0;
        }

        $information_info = $informationModel->getInformation($information_id);

        if ($information_info) {
            $this->document->setTitle($information_info['meta_title']);
            $this->document->setDescription($information_info['meta_description']);
            $this->document->setKeywords($information_info['meta_keyword']);

            $data['breadcrumbs'][] = [
                'text' => $information_info['title'],
                'href' => base_url('information/Information/view?fid=' . $information_id),
            ];

            $data['heading_title'] = $information_info['title'];

            $data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

            $data['header']        = view_cell("\Catalog\Controllers\Common\Header::index");
            $data['menu']          = view_cell("\Catalog\Controllers\Common\Menu::index");
            $data['column_right']  = view_cell("\Catalog\Controllers\Common\Column_right::index");
            $data['column_left']   = view_cell("\Catalog\Controllers\Common\Column_left::index");
            $data['footer']        = view_cell("\Catalog\Controllers\Common\Footer::index");
            
            lang('information/information');

            return $this->template->render('information/information', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    
    //--------------------------------------------------------------------
}