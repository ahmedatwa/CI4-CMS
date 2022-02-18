<?php

return [
    // Heading
    'heading_title'        => 'Configuration',
    // Text
    'text_step_3'            => 'Enter your database and administration details',
    'text_db_connection'     => '1. Please enter your database connection details.',
    'text_db_administration' => '2. Please enter a username and password for the administration.',
    'text_MySQLi'            => 'MySQLi',
    'text_mPDO'              => 'mPDO',
    'text_Postgre'           => 'PostgreSQL',
    'text_help'              => 'Information about setting up a databases on different platforms:',
    'text_cpanel'            => 'CPanel DB Setup',
    'text_plesk'             => 'Plesk DB Setup',
    // Entry
    'entry_db_driver'   => 'Driver',
    'entry_db_hostname' => 'Hostname',
    'entry_db_username' => 'Username',
    'entry_db_password' => 'Password',
    'entry_db_database' => 'Database',
    'entry_db_port'     => 'Port',
    'entry_db_prefix'   => 'Prefix',
    'entry_username'    => 'Username',
    'entry_password'    => 'Password',
    'entry_email'       => 'E-Mail',
    'button_continue'   => 'Finish',
    'button_back'       => 'Back',
    // Error
    'error' => [
        'db_driver'        => 'Database Driver required!',
        'db_hostname'      => 'Hostname required!',
        'db_username'      => 'Username required!',
        'db_database'      => 'Database Name required!',
        'db_port'          => 'Database Port required!',
        'db_prefix'        => 'DB Prefix can only contain lowercase characters in the a-z range, 0-9 and underscores',
        'db_connect'       => 'Error: Could not connect to the database please make sure the database server, username and password is correct!',
        'username'         => 'Username required!',
        'password'         => 'Password required!',
        'email'            => 'E-Mail Address does not appear to be valid!',
        'config'           => 'Error: Could not write to config.php please check you have set the correct permissions on: ',
    ],
];
