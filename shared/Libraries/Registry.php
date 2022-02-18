<?php

namespace Shared\Libraries;

class Registry
{
    /**
	 * Data
	 *
	 * @var array
	 */
    protected $data = [];

    public function __construct()
    {
        log_message('info', "Registry: Class initialized using 'Shared\Libraries\Registry'.");
    }

    /**
     *  
     * @var string|array $key
     * @return mixed string|null
     * 
     */ 
    public function get($key)
    {
        
        if (is_array($key)) {
            $result = [];

            foreach ($key as $k) {
                $result[$k] = $this->get($k);
            }
            return $result;
        }
        
        if ($key && array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return null;
    }

    /**
     *  
     * @var 
     * @return array
     * 
     */ 
    public function getAll(): array
    {
        return $this->data;
    }
    /**
     *  
     * @var string|array $key 
     * @return object
     * 
     */ 
    public function set($key, $value = null): object
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
            $this->data[$k] = $v;
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }
    /**
     *  
     * @var string $key 
     * @return bool
     * 
     */ 
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }
    /**
     *  
     * @var string|array $key 
     * @return object
     * 
     */ 
    public function remove($key): object
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                $this->remove($k);
            }
        }

        if (array_key_exists($key, $this->data)) {
            unset($this->data[$key]);
        }
        return $this;
    }

    // --------------------------------------------------------
}
