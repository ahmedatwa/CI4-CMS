<?php

namespace Shared\Libraries;

class User
{
    protected $id;
    protected $groupID;
    protected $userName        = '';
    protected $name            = '';
    protected $email           = '';
    protected $image           = '';
    protected $permission      = [];
    protected $table           = 'user';
    protected $primaryKey      = 'user_id';
    protected $tableGroup      = 'user_group';
    protected $primaryGroupKey = 'user_group_id';
    // Libs
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();

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

                // Permission Query
                $builderGroup = $this->db->table($this->db->prefixTable($this->tableGroup));
                $builderGroup->select('permission')
                             ->where($this->primaryGroupKey, $this->groupID);
                $builderGroupRow = $builderGroup->get()
                                                ->getRow();
                $permissions = json_decode($builderGroupRow->permission, true);
                if (is_array($permissions)) {
                    foreach ($permissions as $key => $value) {
                        $this->permission[$key] = $value;
                    }
                }
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
                ])->orWhere([
                    'username' => $email,
                    'status'   => 1,
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

    /**
     * check access permission
     *
     * @param string $key
     * @param string|array $value
     *
     * @return Boolean
    */
    public function hasPermission(string $key, $value): bool
    {
        if (isset($this->permission[$key])) {
            if (is_array($value)) {
                return count(array_intersect($value, $this->permission[$key])) ? true : false;
            } else {
                return in_array($value, $this->permission[$key]);
            }
        } else {
            return false;
        }
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
