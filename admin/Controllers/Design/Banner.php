<?php

namespace Admin\Controllers\Design;

use Admin\Controllers\BaseController;
use Shared\Models\Design\BannerModel;

class Banner extends BaseController
{
    protected $bannerModel;

    public function __construct()
    {
        $this->bannerModel = new BannerModel();
    }

    public function add()
    {
        $json = [];
        
        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->bannerModel->addBanner($this->request->getPost());
                $json['success'] = lang('design/banner.text_success');
                $json['redirect'] = site_url('design/banner?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning']    = $this->session->getFlashdata('error_warning');
            }
        }

        return $this->response->setJSON($json);
    }

    public function edit()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $this->bannerModel->editBanner($this->request->getVar('banner_id'), $this->request->getPost());
                $json['success'] = lang('design/banner.text_success');
                $json['redirect'] = site_url('design/banner?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['validationErrors'] = $this->validator->getErrors();
                $json['error_warning'] = $this->session->getFlashdata('error_warning');
            }
        }

        return $this->response->setJSON($json);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (! $this->user->hasPermission('modify', 'design/banner')) {
                $json['error_warning'] = lang('design/banner.error.permission');
            }

            if (!$json && $this->request->getPost('selected')) {
                foreach ($this->request->getPost('selected') as $banner_id) {
                    $this->bannerModel->delete($banner_id);
                }
                $json['success'] = lang('design/banner.text_success');
                $json['redirect'] = site_url('design/banner?user_token=' . $this->request->getVar('user_token'));
            } else {
                $json['error_warning'] = lang('en.error.form');
            }
        }
        return $this->response->setJSON($json);
    }
    
    public function index()
    {
        $this->document->setTitle(lang('design/banner.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('design/banner.heading_title'),
            'href' => base_url('design/banner?user_token=' . $this->request->getVar('user_token'))
         ];

        $data['add'] = base_url('index.php/design/banner/form?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/design/banner/delete?user_token=' . $this->request->getVar('user_token'));

        $data['banners'] = [];

        $results = $this->bannerModel->findAll();

        foreach ($results as $result) {
            $data['banners'][] = [
                'banner_id' => $result['banner_id'],
                'name'      => $result['name'],
                'status'    => ($result['status'] ? lang('en.text_enabled') : lang('en.text_disabled')),
                'edit'      => base_url('index.php/design/banner/form?user_token=' . $this->request->getVar('user_token') . '&banner_id=' . $result['banner_id'])
            ];
        }

        if (isset($this->request->getPost()['selected'])) {
            $data['selected'] = (array) $this->request->getPost()['selected'];
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->session->get('user_token');

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('design/banner');

        return $this->template->render('design/banner_list', $data);
    }

    public function form()
    {
        $this->document->setTitle(lang('design/banner.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => site_url('common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('design/banner.heading_title'),
            'href' => site_url('design/banner?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['text_form'] = !$this->request->getVar('banner_id') ? lang('design/banner.text_add') : lang('design/banner.text_edit');

        $data['back'] = site_url('design/banner?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('banner_id')) {
            $data['action'] = site_url('design/banner/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = site_url('design/banner/edit?user_token=' . $this->request->getVar('user_token') . '&banner_id=' . $this->request->getVar('banner_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getVar('banner_id') && ($this->request->getMethod() != 'post')) {
            $bannerInfo = $this->bannerModel->find($this->request->getVar('banner_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($bannerInfo)) {
            $data['name'] = $bannerInfo['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($bannerInfo)) {
            $data['status'] = $bannerInfo['status'];
        } else {
            $data['status'] = true;
        }

        if ($this->request->getPost('banner_image')) {
            $banner_images = $this->request->getPost('banner_image');
        } elseif ($this->request->getVar('banner_id')) {
            $banner_images = $this->bannerModel->getBannerImages($this->request->getVar('banner_id'));
        } else {
            $banner_images = [];
        }

        $data['banner_images'] = [];

        foreach ($banner_images as $banner_image) {
            if (is_file(DIR_IMAGE . $banner_image['image'])) {
                $image = $banner_image['image'];
                $thumb = $banner_image['image'];
            } else {
                $image = '';
                $thumb = 'no_image.jpg';
            }
                
            $data['banner_images'][] = [
                    'title'           => $banner_image['title'],
                    'caption'         => $banner_image['caption'],
                    'link'            => $banner_image['link'],
                    'image'           => $image,
                    'thumb'           => resizeImage($thumb, 100, 100),
                    'sort_order'      => $banner_image['sort_order']
                ];
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 100, 100);

        $data['header']       = view_cell("\Admin\Controllers\Common\Header::index");
        $data['column_left']  = view_cell("\Admin\Controllers\Common\Column_left::index");
        $data['footer']       = view_cell("\Admin\Controllers\Common\Footer::index");

        lang('design/banner');

        return $this->template->render('design/banner_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
            'name' => [
                'label' => 'Banner Name',
                'rules' => 'required|min_length[2]'
            ]
        ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.form'));
            return false;
        }
        if ($this->request->getPost('banner_image')) {
            foreach ($this->request->getPost('banner_image') as $key => $value) {
                if (! $this->validate([
                        "banner_image.{$key}.title" => [
                         'label' => 'Title',
                         'rules' => 'required|min_length[2]|max_length[64]'
                        ],
                    ])) {
                    $this->session->setFlashdata('error_warning', lang('en.error.form'));
                    return false;
                }
            }
        }

        if (! $this->user->hasPermission('modify', 'design/banner')) {
            $this->session->setFlashdata('error_warning', lang('design/banner.error.permission'));
            return false;
        }

        return true;
    }


    // ----------------------------------------------------------------------------
}
