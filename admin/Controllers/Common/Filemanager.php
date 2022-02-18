<?php

namespace Admin\Controllers\Common;

use Admin\Controllers\BaseController;

class Filemanager extends BaseController
{
    public function index()
    {
        $server = slash_item(env('app.adminURL'));
        
        helper('filesystem');

        $images = [];

        // Make sure we have the correct directory
        if ($this->request->getGet('directory')) {
            $directory = DIR_IMAGE . 'catalog/' . $this->request->getGet('directory');
        } else {
            $directory = DIR_IMAGE . 'catalog/';
        }

        if (substr(str_replace('\\', '/', realpath($directory)), 0, strlen(DIR_IMAGE . 'catalog')) == str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
            $images = directory_map($directory, 1);
        }

        $data['images'] = [];

        if ($images) {
            $source_dir = realpath($directory) ?: $directory;
            $source_dir = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            $folderData = [];
            $fileData = [];
            $videoData = [];

            foreach ($images as $image) {
                $basename = pathinfo($image, PATHINFO_BASENAME);
                $mime_type = mime_content_type($source_dir . $image);
               
                if (is_dir($source_dir . $image)) {
                    $url = '';

                    if ($this->request->getGet('target')) {
                        $url .= '&target=' . $this->request->getGet('target');
                    }
        
                    if ($this->request->getGet('thumb')) {
                        $url .= '&thumb=' . $this->request->getGet('thumb');
                    }
    
                    $folderData[] = [
                        'thumb' => '',
                        'name'  => $basename,
                        'type'  => 'directory',
                        'path'  => str_replace('catalog/', '', substr(rtrim($source_dir . $image, '/'), strlen(DIR_IMAGE))),
                        'href'  => $server . 'index.php/common/filemanager?user_token=' . $this->session->get('user_token') . '&directory=' . urlencode(ltrim(str_replace('catalog/', '', str_replace(DIR_IMAGE, '', $directory . '/' . $basename)), '/')) . $url
                  ];
                }

                !empty($folderData) ? ksort($folderData) : false;

                if (is_file($source_dir . $image)) {
                    if (in_array($mime_type, ['image/gif', 'image/jpeg', 'image/png', 'image/bmp'])) {
                        $fileData[] = [
                            'thumb' => resizeImage(str_replace(DIR_IMAGE, '', $source_dir) . $basename, 100, 100),
                            'name'  => $basename,
                            'type'  => 'image',
                            'path'  => str_replace(DIR_IMAGE, '', $source_dir) . $basename,
                            'href'  => env('app.catalogURL') .'images/' . substr($source_dir, strlen(DIR_IMAGE)) . $basename
                        ];
                    }

                    !empty($fileData) ? sort($fileData) : false;

                    if (in_array($mime_type, ['video/mp4', 'video/webm'])) {
                        $videoData[] = [
                            'thumb' => '',
                            'name'  => $basename,
                            'type'  => 'video',
                            'mime'  => mime_content_type($source_dir . $basename),
                            'path'  => str_replace(DIR_IMAGE, '', $source_dir) . $basename,
                            'href'  => env('app.catalogURL') .'images/' . substr($source_dir, strlen(DIR_IMAGE)) . $basename
                        ];
                    }
                    !empty($videoData) ? sort($videoData) : false;
                }

                $data['images'] = array_merge($folderData, $fileData, $videoData);
            }
        }

        // Return the target ID for the file manager to set the value
        if ($this->request->getGet('target')) {
            $data['target'] = $this->request->getGet('target');
        } else {
            $data['target'] = '';
        }
        // Return the thumbnail for the file manager to show a thumbnail
        if ($this->request->getGet('thumb')) {
            $data['thumb'] = $this->request->getGet('thumb');
        } else {
            $data['thumb'] = '';
        }

        if ($this->request->getGet('directory')) {
            $data['directory'] = urlencode($this->request->getGet('directory'));
        } else {
            $data['directory'] = '';
        }
    
        // refresh
        $url = '';

        if ($this->request->getGet('directory')) {
            $url .= '&directory=' . urlencode($this->request->getGet('directory'));
        }

        if ($this->request->getGet('target')) {
            $url .= '&target=' . $this->request->getGet('target');
        }

        if ($this->request->getGet('thumb')) {
            $url .= '&thumb=' . $this->request->getGet('thumb');
        }

        $data['refresh'] = base_url('index.php/common/filemanager?user_token=' . $this->session->get('user_token') . $url);
        
        // Parent
        $url = '';

        if ($this->request->getGet('directory')) {
            $pos = strrpos($this->request->getGet('directory'), '/');
            if ($pos != false) {
                $url .= '&directory=' . urlencode(substr($this->request->getGet('directory'), 0, $pos));
            }
        }
        
        if ($this->request->getGet('target')) {
            $url .= '&target=' . $this->request->getGet('target');
        }

        if ($this->request->getGet('thumb')) {
            $url .= '&thumb=' . $this->request->getGet('thumb');
        }

        $data['back']   = base_url('index.php/common/filemanager?user_token=' . $this->session->get('user_token') . $url);
        $data['folder'] = site_url('common/filemanager/folder?user_token=' .  $this->session->get('user_token') . '&directory=' . $directory);
        $data['delete'] = site_url('common/filemanager/delete?user_token=' .  $this->session->get('user_token'));

        $data['user_token'] = $this->session->get('user_token');

        lang('common/filemanager');

        return $this->template->render('common/filemanager', $data);
    }

    public function upload()
    {
        $json = [];

        // Check user has permission
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $json['error'] = lang('common/filemanager.error.permission');
        }

        // Make sure we have the correct directory
        if ($this->request->getGet('directory')) {
            $directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->getGet('directory')), '/');
        } else {
            $directory = DIR_IMAGE . 'catalog';
        }

        // Check its a directory
        if (!is_dir($directory)) {
            $json['error'] = lang('common/filemanager.error.directory');
        }

        // Allowed file extension types
        $extensions = ['jpg','jpeg','gif','png', 'bmp', 'mp4', 'webm'];
        // Allowed file mime types
        $mimes = ['image/jpeg','image/pjpeg','image/png','image/x-png','image/gif', 'image/bmp', 'video/webm', 'video/mp4'];

        $files = $this->request->getFiles();
        if ($files) {
            foreach ($files['file'] as $file) {
                $filename = $file->getName();
                $fileExtenstion = $file->getClientExtension();
                $fileType = $file->getClientMimeType();

                if (! $file->isValid()) {
                    throw new RuntimeException($file->getErrorString().'('.$file->getError().')');
                }

                if (!in_array($fileExtenstion, $extensions)) {
                    $json['error'] = lang('common/filemanager.error.filetype');
                }

                if (!in_array($fileType, $mimes)) {
                    $json['error'] = lang('common/filemanager.error.filetype');
                }

                if (!$json) {
                    if ($file->isValid() && ! $file->hasMoved()) {
                        $file->move($directory);
                        $json['success'] = lang('common/filemanager.text_uploaded');
                    }
                }
            }
        }


        return $this->response->setJSON($json);
    }

    public function folder()
    {
        $json = [];

        // Check user has permission
        if (!$this->user->hasPermission('modify', 'common/filemanager')) {
            $json['error'] = lang('common/filemanager.error.permission');
        }

        // Make sure we have the correct directory
        if ($this->request->getGet('directory')) {
            $directory = rtrim(str_replace(array('../', '..\\', '..'), '', $this->request->getGet('directory')), '/');
        } else {
            $directory = DIR_IMAGE . 'catalog';
        }

        // Check its a directory
        if (!is_dir($directory)) {
            $json['error'] = lang('common/filemanager.error.directory');
        }

        if (!$json) {
            // Sanitize the folder name
            $folder = str_replace(array('../', '..\\', '..'), '', basename(html_entity_decode($this->request->getPost('folder'), ENT_QUOTES, 'UTF-8')));

            // Validate the filename length
            if ((strlen($folder) < 3) || (strlen($folder) > 128)) {
                $json['error'] = lang('common/filemanager.error.folder');
            }
            // Check if directory already exists or not
            if (is_dir($directory . '/' . $folder)) {
                $json['error'] = lang('common/filemanager.error.exists');
            }
        }

        if (!$json) {
            mkdir($directory . '/' . $folder, 0777);
            chmod($directory . '/' . $folder, 0777);
            $json['success'] = lang('common/filemanager.text_directory');
        }

        return $this->response->setJSON($json);
    }

    public function delete()
    {
        $json = [];

        // Check user has permission
        if (!$this->user->hasPermission('modify', 'common/filemanager')) {
            $json['error'] = lang('common/filemanager.error.permission');
        }

        if ($this->request->getPost('path')) {
            $paths = $this->request->getPost('path');
        } else {
            $paths = [];
        }


        foreach ($paths as $path) {
            // Check path exsists
            if ($path == DIR_IMAGE . 'catalog') {
                $json['error'] = lang('common/filemanager.error.delete');
                break;
            }
        }

        if (!$json) {
            // Loop through each path
            foreach ($paths as $path) {
                $path = rtrim(DIR_IMAGE . 'catalog/' . $path, '/');

                // If path is just a file delete it
                if (is_file($path)) {
                    unlink($path);
                }
                // If path is a directory
                if (is_dir($path)) {
                    helper('filesystem');
                    //beging deleting each file and sub folder
                    delete_files($path, true);
                    // Remove Dir
                    rmdir($path);
                }
            }
            $json['success'] = lang('common/filemanager.text_delete');
        }

        return $this->response->setJSON($json);
    }


    //--------------------------------------------------------------------
}
