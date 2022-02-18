<?php

namespace Install\Controllers;

use Install\Models\InstallModel;

class Step_2 extends BaseController
{
    protected $error = [];

    public function index()
    {
        $this->document->setTitle(lang('Step_2.heading_title'));
        
        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            if ($this->checkDBConn($this->request->getPost())) {
                $installModel = new InstallModel();
                $installModel->databaseSetup($this->request->getPost());

                $adminUrl = str_replace('install', 'admin', HTTP_SERVER);
                $siteUrl = str_replace('install/', '', HTTP_SERVER);

                // ------------------------------
                // Catalog\Config\App.php
                // ------------------------------
                if (file_exists($catalogAppPath = ROOTPATH . 'catalog/Config/App.php')) {
                    file_put_contents($catalogAppPath, str_replace(
                        'http://localhost/',
                        $siteUrl,
                        file_get_contents($catalogAppPath)
                    ));
                }
                // ------------------------------
                // Admin\Config\App.php
                // ------------------------------
                if (file_exists($adminAppPath = ROOTPATH . 'admin/Config/App.php')) {
                    file_put_contents($adminAppPath, str_replace(
                        'http://localhost/admin/',
                        $adminUrl,
                        file_get_contents($adminAppPath)
                    ));
                }

                // ------------------------------
                // .env
                // ------------------------------
                if (file_exists($envPath = ROOTPATH . 'env')) {
                    $oldEnvVars = [
                        'app.adminURL = http://localhost/admin/',
                        'app.siteURL  = http://localhost/',
                        'database.default.hostname = hostname',
                        'database.default.database = database',
                        'database.default.username = username',
                        'database.default.password = password',
                        'database.default.DBDriver = DBDriver',
                        'database.default.DBPrefix = DBPrefix',
                    ];
                    

                    $newEnvVars = [
                        "app.adminURL = '{$adminUrl}'",
                        "app.siteURL = '{$siteUrl}'",
                        "database.default.hostname = {$this->request->getPost('db_hostname')}",
                        "database.default.database = {$this->request->getPost('db_database')}",
                        "database.default.username = {$this->request->getPost('db_username')}",
                        "database.default.password = {$this->request->getPost('db_password')}",
                        "database.default.DBDriver = {$this->request->getPost('db_driver')}",
                        "database.default.DBPrefix = {$this->request->getPost('db_prefix')}",
                    ];
                
                    file_put_contents($envPath, str_replace(
                        $oldEnvVars,
                        $newEnvVars,
                        file_get_contents($envPath)
                    ));

                    rename($envPath, ROOTPATH . '.env');
                }
            
                return redirect()->to(BASE_URL);
            }
        }


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['db_driver'])) {
            $data['error_db_driver'] = $this->error['db_driver'];
        } else {
            $data['error_db_driver'] = '';
        }

        if (isset($this->error['db_hostname'])) {
            $data['error_db_hostname'] = $this->error['db_hostname'];
        } else {
            $data['error_db_hostname'] = '';
        }

        if (isset($this->error['db_username'])) {
            $data['error_db_username'] = $this->error['db_username'];
        } else {
            $data['error_db_username'] = '';
        }

        if (isset($this->error['db_database'])) {
            $data['error_db_database'] = $this->error['db_database'];
        } else {
            $data['error_db_database'] = '';
        }
        
        if (isset($this->error['db_port'])) {
            $data['error_db_port'] = $this->error['db_port'];
        } else {
            $data['error_db_port'] = '';
        }
        
        if (isset($this->error['db_prefix'])) {
            $data['error_db_prefix'] = $this->error['db_prefix'];
        } else {
            $data['error_db_prefix'] = '';
        }

        if (isset($this->error['username'])) {
            $data['error_username'] = $this->error['username'];
        } else {
            $data['error_username'] = '';
        }

        if (isset($this->error['password'])) {
            $data['error_password'] = $this->error['password'];
        } else {
            $data['error_password'] = '';
        }

        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }

        $db_drivers = ['MySQLi', 'mPDO', 'Postgre'];

        $data['drivers'] = [];

        foreach ($db_drivers as $db_driver) {
            if (extension_loaded($db_driver)) {
                $data['drivers'][] = [
                    'text'  => lang('Step_2.text_' . $db_driver),
                    'value' => $db_driver
                ];
            }
        }

        if ($this->request->getPost('db_driver')) {
            $data['db_driver'] = $this->request->getPost('db_driver');
        } else {
            $data['db_driver'] = '';
        }

        if ($this->request->getPost('db_hostname')) {
            $data['db_hostname'] = $this->request->getPost('db_hostname');
        } else {
            $data['db_hostname'] = '127.0.0.1';
        }

        if ($this->request->getPost('db_username')) {
            $data['db_username'] = $this->request->getPost('db_username');
        } else {
            $data['db_username'] = 'root';
        }

        if ($this->request->getPost('db_password')) {
            $data['db_password'] = $this->request->getPost('db_password');
        } else {
            $data['db_password'] = '';
        }

        if ($this->request->getPost('db_database')) {
            $data['db_database'] = $this->request->getPost('db_database');
        } else {
            $data['db_database'] = '';
        }

        if ($this->request->getPost('db_port')) {
            $data['db_port'] = $this->request->getPost('db_port');
        } else {
            $data['db_port'] = 3306;
        }
        
        if ($this->request->getPost('db_prefix')) {
            $data['db_prefix'] = $this->request->getPost('db_prefix');
        } else {
            $data['db_prefix'] = 'ci_';
        }

        if ($this->request->getPost('username')) {
            $data['username'] = $this->request->getPost('username');
        } else {
            $data['username'] = 'admin';
        }

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        $data['config_name'] = 'CI4-App';

        $data['base']   = HTTP_SERVER;
        $data['back']   = base_url('index.php/step_1');
        $data['action'] = base_url('index.php/step_2');

        $data['footer'] = sprintf(lang('Footer.text_footer'), 'CI4-App');

        lang('Step_2');

        return $this->template->render('step_2', $data);
    }

    protected function validateForm()
    {
        if (!$this->request->getPost('db_hostname')) {
            $this->error['db_hostname'] = lang('Step_2.error.db_hostname');
        }

        if (!$this->request->getPost('db_username')) {
            $this->error['db_username'] = lang('Step_2.error.db_username');
        }

        if (!$this->request->getPost('db_database')) {
            $this->error['db_database'] = lang('Step_2.error.db_database');
        }

        if (!$this->request->getPost('db_port')) {
            $this->error['db_port'] = lang('Step_2.error.db_port');
        }

        if ($this->request->getPost('db_prefix') && preg_match('/[^a-z0-9_]/', $this->request->getPost('db_prefix'))) {
            $this->error['db_prefix'] = lang('Step_2.error.db_prefix');
        }

        if (!$this->request->getPost('username')) {
            $this->error['username'] = lang('Step_2.error.username');
        }

        if ((strlen($this->request->getPost('email')) > 96) || ! filter_var($this->request->getPost('email', FILTER_VALIDATE_EMAIL))) {
            $this->error['email'] = lang('Step_2.error.email');
        }

        if (! $this->request->getPost('password')) {
            $this->error['password'] = lang('Step_2.error.password');
        }

        if (!is_writable(ROOTPATH . 'catalog/Config/App.php')) {
            $this->error['warning'] = lang('Step_2.error.config') . ROOTPATH . 'catalog/Config/App.php!';
        }

        if (!is_writable(ROOTPATH . 'admin/Config/App.php')) {
            $this->error['warning'] = lang('Step_2.error.config') . ROOTPATH . 'admin/Config/App.php!';
        }

        return ! $this->error;
    }

    protected function checkDBConn(array $params = []): bool
    {
        $result = false;

        $custom = [
            'DSN'      => '',
            'hostname' => $params['db_hostname'],
            'username' => $params['db_username'],
            'password' => $params['db_password'],
            'database' => $params['db_database'],
            'DBDriver' => $params['db_driver'],
            'DBPrefix' => $params['db_prefix'],
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'cacheOn'  => false,
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => $params['db_port'],
            ];

        $db = \Config\Database::connect($custom, false);
        try {
            if ($db->persistentConnect()) {
                $result = true;
                $db->close();
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $this->error['warning'] = $e->getCode() . ': ' . $e->getMessage();
            $result = false;
        }
        return $result;
    }
    //  -------------------------------------------------
}
