<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mc
{

    public function __construct()
    {
        // add servers here
        $this->memcache_servers = array(
            array('host' => 'localhost', 'port' => 11211),
        );
        $this->prefix = 'a0';
        // expires in a week
        $this->default_expire = 60*60*24*7;

        $this->connected_servers = array();
        $this->memcache = new Memcache();

        // turn off error reporting so memcache can die silently
        // if can't connect to servers
        $error_display = ini_get('display_errors');
        $error_reporting = ini_get('error_reporting');
        ini_set('display_errors', 'Off');
        ini_set('error_reporting', 0);

        foreach ($this->memcache_servers as $server)
        {
            if ($this->memcache->addServer($server['host'], $server['port']))
            {
                $this->connected_servers[] = $server;
            }
        }

        // turn error reporting back on
        ini_set('display_errors', $error_display);
        ini_set('error_reporting', $error_reporting);
    }


    public function get($key, $serialize=TRUE)
    {
        if (empty($this->connected_servers))
        {
            return FALSE;
        }
        $val = $this->memcache->get($this->prefix . $key);
        if ($serialize AND $val)
        {
            $val = unserialize($val);
        }
        //FOR DEBUG
        //return FALSE;
        return $val;
    }


    public function set($key, $val, $expire=FALSE, $serialize=TRUE)
    {
        if (empty($this->connected_servers))
        {
            return FALSE;
        }
        if ($serialize)
        {
            $val = serialize($val);
        }
        if ($expire === FALSE)
        {
            $expire = $this->default_expire;
        }
        $this->memcache->set($this->prefix . $key, $val, 0, $expire);
    }


    public function delete($key, $when=0)
    {
        if (empty($this->connected_servers))
        {
            return FALSE;
        }
        $this->memcache->delete($this->prefix . $key, $when);
    }


    public function increment($key)
    {
        if (empty($this->connected_servers))
        {
            return FALSE;
        }
        return $this->memcache->increment($this->prefix . $key);
    }

    
    public function decrement($key)
    {
        if (empty($this->connected_servers))
        {
            return FALSE;
        }
        return $this->memcache->decrement($this->prefix . $key);
    }
}

/* End of file Mc.php */
/* Location: ./application/libraries/Mc.php */