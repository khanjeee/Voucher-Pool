<?php

namespace App\Helper;
 
use Predis\Client as Redis;

class RedisHelper
{
    private $_client;
    /**
     * RedisHelper constructor.
     */
    public function __construct()
    {
        $this->_client = new Redis();
    }

    public function get($key='')
    {
        return $this->_client->get($key);
    }

    public function set($sKey='', $sValue)
    {
        return $this->_client->set($sKey,$sValue);
    }

}
