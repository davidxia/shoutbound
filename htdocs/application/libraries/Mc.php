<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mc {

    function Mc() {
        /* Customize Here! */

        $this->memcache_servers = array(
            array('host' => 'localhost', 'port' => 11211),
        );
        $this->prefix = 'a0';
        $this->default_expire = 60*60*24*7;
        
        /* End Customization */


        $this->connected_servers = array();
        $this->memcache = new Memcache;

        // must turn off error reporting.
        // so memcache can die silently if
        // it can't connect to a server.
        $error_display = ini_get('display_errors');
        $error_reporting = ini_get('error_reporting');
        ini_set('display_errors', "Off");
        ini_set('error_reporting', 0);

        foreach ( $this->memcache_servers as $server ) {
            if ( $this->memcache->addServer($server['host'], $server['port']) ) {
                $this->connected_servers[] = $server;
            }
        }

        // back on again!
        ini_set('display_errors', $error_display);
        ini_set('error_reporting', $error_reporting);
    }


    function get($key, $serialize=True) {
        if(empty($this->connected_servers))
            return False;
        $val = $this->memcache->get($this->prefix . $key);
        if($serialize && $val) {
            $val = unserialize($val);
        }
        //FOR DEBUG
        return False;
        return $val;
    }


    function set($key, $val, $expire=False, $serialize=True)  {
        if(empty($this->connected_servers))
            return False;
        if($serialize)
            $val = serialize($val);
        if($expire === False)
            $expire = $this->default_expire;
        $this->memcache->set($this->prefix . $key, $val, 0, $expire);
    }


    function delete($key, $when=0) {
        if(empty($this->connected_servers))
            return False;
        $this->memcache->delete($this->prefix . $key, $when);
    }


    function increment($key) {
        if(empty($this->connected_servers))
            return False;
        return $this->memcache->increment($this->prefix . $key);
    }

    
    function decrement($key) {
        if(empty($this->connected_servers))
            return False;
        return $this->memcache->decrement($this->prefix . $key);
    }

}

