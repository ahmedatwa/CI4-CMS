<?php

namespace Install\Models;

use CodeIgniter\I18n\Time;

class InstallModel
{
    public function databaseSetup(array $data = [])
    {
        $custom = [
            'DSN'      => '',
            'hostname' => $data['db_hostname'],
            'username' => $data['db_username'],
            'password' => $data['db_password'],
            'database' => $data['db_database'],
            'DBDriver' => $data['db_driver'],
            'DBPrefix' => $data['db_prefix'],
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => $data['db_port']
        ];

        $db = \Config\Database::connect($custom, false);

        $file = ROOTPATH . 'install/install.sql';

        if (!file_exists($file)) {
            throw new \Exception("Could not load sql file: " . $file);
            exit();
        }

        $lines = file($file);

        if ($lines) {
            $sql = '';

            foreach ($lines as $line) {
                if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
                    $sql .= $line;

                    if (preg_match('/;\s*$/', $line)) {
                        $sql = str_replace("DROP TABLE IF EXISTS `ci_", "DROP TABLE IF EXISTS `" . $data['db_prefix'], $sql);
                        $sql = str_replace("CREATE TABLE `ci_", "CREATE TABLE `" . $data['db_prefix'], $sql);
                        $sql = str_replace("INSERT INTO `ci_", "INSERT INTO `" . $data['db_prefix'], $sql);

                        $db->query($sql);

                        $sql = '';
                    }
                }
            }

            helper('text');

            $db->query("SET CHARACTER SET utf8");

            $db->query("SET @@session.sql_mode = ''");
            // Admin User
            $userBuilder = $db->table($db->prefixTable('user'));
            $userBuilder->delete(['user_id' => 1]);
            $userData = [
                'user_id'       => '1',
                'user_group_id' => '1',
                'username'      => $data['username'],
                'salt'          => $salt = random_string('alnum', 9),
                'password'      => sha1($salt . sha1($salt . sha1($data['password']))),
                'firstname'     => 'John',
                'lastname'      => 'Doe',
                'email'         => $data['email'],
                'status'        => '1',
                'date_added'    => Time::now()->getTimestamp(),
            ];

            $userBuilder->insert($userData);
            // Settings
            $settingBuilder = $db->table($db->prefixTable('setting'));
            $settingBuilder->delete(['name' => 'config_email']);
            $settingData = [
                'code'    => 'config',
                'name'    => 'config_email',
                'setting' => $data['email']
            ];
            $settingBuilder->insert($settingData);
        }
    }
    // ----------------------------------------------------
}
