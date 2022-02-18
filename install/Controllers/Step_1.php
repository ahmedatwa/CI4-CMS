<?php

namespace Install\Controllers;

class Step_1 extends BaseController
{
    protected $error = [];
    
    public function index()
    {
        $this->document->setTitle(lang('Step_1.heading_title'));

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            return redirect()->to(base_url('index.php/step_2'));
        }

        $data['base'] = HTTP_SERVER;

        $data['config_name'] = 'CI-App';

        $data['php_version']        = phpversion();
        $data['register_globals']   = ini_get('register_globals');
        $data['magic_quotes_gpc']   = ini_get('magic_quotes_gpc');
        $data['file_uploads']       = ini_get('file_uploads');
        $data['session_auto_start'] = ini_get('session_auto_start');

        $db = [
            'mysqli',
            'pgsql',
            'pdo'
        ];

        if (! array_filter($db, 'extension_loaded')) {
            $data['db'] = false;
        } else {
            $data['db'] = true;
        }

        $data['gd']       = extension_loaded('gd');
        $data['curl']     = extension_loaded('curl');
        $data['openssl']  = function_exists('openssl_encrypt');
        $data['zlib']     = extension_loaded('zlib');
        $data['zip']      = extension_loaded('zip');
        $data['iconv']    = function_exists('iconv');
        $data['mbstring'] = extension_loaded('mbstring');
        $data['intl']     = extension_loaded('intl');

        $data['catalog_config'] = ROOTPATH . 'catalog/config/App.php';
        $data['admin_config']   = ROOTPATH . 'admin/config/App.php';
        $data['env']            = ROOTPATH . 'env';
        $data['image']          = realpath(FCPATH . '../images');
        $data['image_cache']    = realpath(FCPATH . '../images/cache');
        $data['cache']          = ROOTPATH . 'storage/cache';
        $data['logs']           = ROOTPATH . 'storage/logs';
        $data['download']       = ROOTPATH . 'storage/download';
        $data['upload']         = ROOTPATH . 'storage/uploads';

        $data['action'] = base_url('index.php/step_1');

        $data['footer'] = sprintf(lang('Footer.text_footer'), 'CI4-App');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // catalog config
        if (! is_really_writable(ROOTPATH . 'catalog/Config/App.php')) {
            $data['error_catalog_config'] = lang('Step_1.error.unwritable');
        } else {
            $data['error_catalog_config'] = '';
        }
       
        if (! is_really_writable(ROOTPATH . 'env')) {
            $data['error_env'] = lang('Step_1.error.unwritable');
        } else {
            $data['error_env'] = '';
        }

        // admin configs
        if (!is_really_writable(ROOTPATH . 'admin/Config/App.php')) {
            $data['error_admin_config'] = lang('Step_1.error.unwritable');
        } else {
            $data['error_admin_config'] = '';
        }

        if (!is_really_writable(ROOTPATH . 'storage/uploads')) {
            $data['error_upload'] = lang('Step_1.error.unwritable');
        } else {
            $data['error_upload'] = '';
        }

        if (!is_really_writable(ROOTPATH . 'storage/download')) {
            $data['error_download'] = lang('Step_1.error.unwritable');
        } else {
            $data['error_download'] = '';
        }

        if (!is_really_writable(ROOTPATH . 'storage/logs')) {
            $data['error_logs'] = lang('Step_1.error.unwritable');
        } else {
            $data['error_logs'] = '';
        }

        if (!is_really_writable(ROOTPATH . 'storage/cache')) {
            $data['error_cache'] = lang('Step_1.error.unwritable');
        } else {
            $data['error_cache'] = '';
        }

        if (!is_really_writable(FCPATH . '../images')) {
            $data['error_image'] = lang('Step_1.error.unwritable');
        } else {
            $data['error_image'] = '';
        }

        if (!is_really_writable(FCPATH . '../images/cache')) {
            $data['error_cache'] = lang('Step_1.error.unwritable');
        } else {
            $data['error_cache'] = '';
        }
        
        lang('Step_1');

        return $this->template->render('step_1', $data);
    }

    protected function validateForm()
    {
        if (phpversion() < '7.3') {
            $this->error['warning'] = lang('Step_1.error.version');
        }

        if (!ini_get('file_uploads')) {
            $this->error['warning'] = lang('Step_1.error.file_upload');
        }

        if (ini_get('session.auto_start')) {
            $this->error['warning'] = lang('Step_1.error.session');
        }

        $db = ['mysqli', 'pdo', 'pgsql'];

        if (!array_filter($db, 'extension_loaded')) {
            $this->error['warning'] = lang('Step_1.error.db');
        }

        if (!extension_loaded('gd')) {
            $this->error['warning'] = lang('Step_1.error.gd');
        }

        if (!extension_loaded('curl')) {
            $this->error['warning'] = lang('Step_1.error.curl');
        }

        if (!function_exists('openssl_encrypt')) {
            $this->error['warning'] = lang('Step_1.error.openssl');
        }

        if (!extension_loaded('zlib')) {
            $this->error['warning'] = lang('Step_1.error.zlib');
        }

        if (!extension_loaded('zip')) {
            $this->error['warning'] = lang('Step_1.error.zip');
        }

        if (!extension_loaded('mbstring')) {
            $this->error['warning'] = lang('Step_1.error.mbstring');
        }

        if (!extension_loaded('intl')) {
            $this->error['warning'] = lang('Step_1.error.intl');
        }

        if (! file_exists(ROOTPATH . 'catalog/Config/App.php')) {
            $this->error['warning'] = lang('Step_1.error.catalog_exist');
        } elseif (!is_really_writable(ROOTPATH . 'catalog/Config/App.php')) {
            $this->error['warning'] = lang('Step_1.error.catalog_writable');
        }
        
        if (! file_exists(ROOTPATH . 'admin/Config/App.php')) {
            $this->error['warning'] = lang('Step_1.error.admin_exist');
        } elseif (!is_really_writable(ROOTPATH . 'admin/Config/App.php')) {
            $this->error['warning'] = lang('Step_1.error.admin_writable');
        }

        if (!is_really_writable(FCPATH . '../images')) {
            $this->error['warning'] = lang('Step_1.error.image');
        }

        if (!is_really_writable(FCPATH . '../images/cache')) {
            $this->error['warning'] = lang('Step_1.error.image_cache');
        }

        if (!is_really_writable(ROOTPATH . 'storage/cache')) {
            $this->error['warning'] = lang('Step_1.error.cache');
        }

        if (!is_really_writable(ROOTPATH . 'storage/logs')) {
            $this->error['warning'] = lang('Step_1.error.log');
        }

        if (!is_really_writable(ROOTPATH . 'storage/download')) {
            $this->error['warning'] = lang('Step_1.error.download');
        }

        if (!is_really_writable(ROOTPATH . 'storage/uploads')) {
            $this->error['warning'] = lang('Step_1.error.upload');
        }

        return !$this->error;
    }
}
