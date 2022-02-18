<?php

namespace Admin\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DashboardSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'darth',
            'email'    => 'darth@theempire.com'
    ];

        // Simple Queries
        $this->db->query("INSERT INTO users (username, email) VALUES(:username:, :email:)", $data);

        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}
