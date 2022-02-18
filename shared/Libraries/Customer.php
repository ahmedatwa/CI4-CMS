<?php

namespace Shared\Libraries;

class Customer
{
    protected $id;
    protected $groupID;
    protected $userName        = '';
    protected $name            = '';
    protected $email           = '';
    protected $image           = '';
    protected $table           = 'customer';
    protected $primaryKey      = 'customer_id';
    protected $tableGroup      = 'customer_group';
    protected $primaryGroupKey = 'customer_group_id';
    // Libs
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // Sync PHP and DB time zones
        $this->db->query("SET time_zone = " . $this->db->escape(date('P')));

        $this->session = \Config\Services::session();

        if ($loggedSessionID = $this->session->get($this->primaryKey)) {
            $builder = $this->db->table($this->db->prefixTable($this->table));
            $builder->where([
                $this->primaryKey => $loggedSessionID,
                'status' => 1
            ]);
            
            $row = $builder->get()
                           ->getRow();
            if ($row) {
                $this->id       = $row->{$this->primaryKey};
                $this->groupID  = $row->{$this->primaryGroupKey};
                $this->name     = $row->firstname . ' ' . $row->lastname;
                $this->userName = $row->username;
                $this->image    = $row->image;
                $this->email    = $row->email;
            } else {
                $this->logout();
            }
        }
    }

    public function login(string $email, string $password): bool
    {
        $builder = $this->db->table($this->table);
        $builder->select()
                ->where([
                    'email'  => $email,
                    'status' => 1,
                ]);

        $row = $builder->get()->getRow();
        
        if ($row) {
            // Verify stored hash against DB password
            if (password_verify($password, $row->password)) {
                $rehash = password_needs_rehash($row->password, PASSWORD_DEFAULT);
            } elseif (isset($row->salt) && $row->password == sha1($row->salt . sha1($row->salt . sha1($password)))) {
                $rehash = true;
            } elseif ($row->password == md5($password)) {
                $rehash = true;
            } else {
                return false;
            }

            if ($rehash) {
                $builder->where(['email'  => $email, 'status' => 1,])
                        ->set('password', password_hash($password, PASSWORD_DEFAULT))
                        ->update();
            }

            $this->id       = $row->{$this->primaryKey};
            $this->groupID  = $row->{$this->primaryGroupKey};
            $this->name     = $row->firstname . ' ' . $row->lastname;
            $this->username = $row->username;
            $this->image    = $row->image;
            $this->email    = $row->email;
            // Build Session Data
            $sessionData = [
                $this->primaryKey          => $this->id,
                $this->primaryGroupKey     => $this->groupID,
                'username'                 => $this->username,
                'name'                     => $this->name,
                'image'                    => $this->image,
                'email'                    => $this->email,
                'isLogged'                 => (bool) true,
                'online'                   => (bool) true,
            ];
            $this->session->set($sessionData);

            return true;
        } else {
            return false;
        }
    }

    public function LoginAccessVerify(string $email, string $code): bool
    {
        $builder = $this->db->table($this->db->prefixTable($this->table));
        $builder->where([
            'email'  => $email,
            'code'   => $code,
            'status' => 1,
        ]);
        $query = $builder->get();
        
        if ($builder->countAllResults() > 0) {
            $row = $query->getRow();
            $this->id       = $row->{$this->primaryKey};
            $this->groupID  = $row->{$this->primaryGroupKey};
            $this->name     = $row->firstname . ' ' . $row->lastname;
            $this->username = $row->username;
            $this->image    = $row->image;
            $this->email    = $row->email;
            // Build Session Data
            $sessionData = [
                $this->primaryKey          => $this->id,
                $this->primaryGroupKey     => $this->groupID,
                'username'                 => $this->username,
                'name'                     => $this->name,
                'image'                    => $this->image,
                'email'                    => $this->email,
                'isLogged'                 => (bool) true,
                'online'                   => (bool) true,
            ];
            // close any open sessions
            $this->session->set($sessionData);
            return true;
        } else {
            return false;
        }
    }

    // 2-step verification
    public function checkTwoStepVerification(string $email): bool
    {
        $builder = $this->db->table($this->db->prefixTable($this->table));
        $row = $builder->where('email', $email)
                       ->get()
                       ->getRow();
        if ($row && $row->two_step == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function editAccessCode(string $email, string $code)
    {
        $builder = $this->db->table($this->db->prefixTable($this->table));
        $builder->where('email', $email);
        $builder->set('code', $code)
                ->set('date_modified', 'NOW()', false)
                ->update();
        // trigger forgotton email event
        \CodeIgniter\Events\Events::trigger('mail_twostep_verification', $email, $code);
    }

    /**
     *
     * @return mixed int|null
    */
    public function getID(): ?int
    {
        return $this->id;
    }
    /**
     *
     * @return string
    */
    public function getUserName(): string
    {
        if (!empty($this->userName)) {
            return $this->userName;
        } else {
            return url_title($this->name, '_', true);
        }
    }
    /**
     *
     * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     *
     * @return void
    */
    public function logout(): void
    {
        $this->session->destroy();
        $this->id       = null;
        $this->groupID  = null;
        $this->userName = '';
    }
    /**
     *
     * @return mixed int|null
    */
    public function isLogged(): ?int
    {
        return $this->id;
    }
    /**
     *
     * @return mixed int|null
    */
    public function getGroupId(): ?int
    {
        return $this->groupID;
    }


    // _________________________________________________
}
