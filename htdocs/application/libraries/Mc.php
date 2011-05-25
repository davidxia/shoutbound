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
    
    
    public function get_stats()
    {
        $status = $this->memcache->getStats();
        
        $table = '<table border="1">'.
            '<tr><td>Memcache Server version:</td><td> '.$status['version'].'</td></tr>'.
            '<tr><td>Process id of this server process </td><td>'.$status['pid'].'</td></tr>'.
            '<tr><td>Number of seconds this server has been running </td><td>'.$status['uptime'].'</td></tr>'.
            '<tr><td>Current Unix time according to this server </td><td>'.$status['time'].'</td></tr>'.
            '<tr><td>Accumulated user time for this process </td><td>'.$status['rusage_user'].' seconds</td></tr>'.
            '<tr><td>Accumulated system time for this process </td><td>'.$status['rusage_system'].' seconds</td></tr>'.
            '<tr><td>Total number of items stored by this server ever since it started </td><td>'.$status['total_items'].'</td></tr>'.
            '<tr><td>Number of open connections </td><td>'.$status['curr_connections'].'</td></tr>'.
            '<tr><td>Total number of connections opened since the server started running </td><td>'.$status['total_connections'].'</td></tr>'.
            '<tr><td>Number of connection structures allocated by the server </td><td>'.$status['connection_structures'].'</td></tr>'.
            '<tr><td>Cumulative number of retrieval requests </td><td>'.$status['cmd_get'].'</td></tr>'.
            '<tr><td> Cumulative number of storage requests </td><td>'.$status['cmd_set'].'</td></tr>';

        $percCacheHit = ((real) $status['get_hits'] / (real) $status['cmd_get'] * 100); 
        $percCacheHit = round($percCacheHit, 3); 
        $percCacheMiss = 100 - $percCacheHit; 

        $table .= '<tr><td>Number of keys that have been requested and found present </td><td>'.$status['get_hits'].' ('.$percCacheHit.'%)</td></tr>'.
            '<tr><td>Number of items that have been requested and not found </td><td>'.$status['get_misses'].'('.$percCacheMiss.'%)</td></tr>';

        $MBRead= (real) $status['bytes_read'] / (1024 * 1024); 
        $table .= '<tr><td>Total number of bytes read by this server from network </td><td>'.$MBRead.' Mega Bytes</td></tr>';
        
        $MBWrite=(real) $status['bytes_written'] / (1024 * 1024);
        $table .= '<tr><td>Total number of bytes sent by this server to network </td><td>'.$MBWrite.' Mega Bytes</td></tr>';

        $MBSize=(real) $status['bytes'] / (1024 * 1024);
        $table .= '<tr><td>Current number of bytes used by this server to store items.</td><td>'.$MBSize.' Mega Bytes</td></tr>';
        
        $MBSizeLimit=(real) $status['limit_maxbytes'] / (1024 * 1024);
        $percentMemUsage = $MBSize/$MBSizeLimit*100;
        $table .= '<tr><td>Number of bytes this server is allowed to use for storage.</td><td>'.$MBSizeLimit.' Mega Bytes</td></tr>'.
            '<tr><td><strong>Percent of memory limit used:</strong></td><td><strong>'.$percentMemUsage.'%</strong></td></tr>'.
            '<tr><td>Number of valid items removed from cache to free memory for new items.</td><td>'.$status['evictions'].'</td></tr>'.
            '</table>';
            
        return $table;
    } 
}

/* End of file Mc.php */
/* Location: ./application/libraries/Mc.php */