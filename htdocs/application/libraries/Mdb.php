<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'MDB2.php';

class Mdb
{

    function _mdb_conn($target='localhost')
    {
        switch($target)
        {
            case 'localhost':
                $dbhost = 'localhost';
                $dbuser = 'web';
                $dbpass = 'moardatatoday';
                $dbname = 'shoutbound';
                break;
        }

        $driver = 'mysqli://'.$dbuser.':'.$dbpass.'@'.$dbhost.'/'.$dbname;
        $conn =& MDB2::singleton($driver);
        if (PEAR::isError($conn))
        {
            die('Error connecting to database');
        }
        return $conn;
    }
    

    public function select($sql, $values=array(), $target='localhost')
    {
        if ( ! isset($sql))
        {
            return array();
        }

        $conn = $this->_mdb_conn($target);
        $exec = $conn->prepare($sql,array(),MDB2_PREPARE_RESULT);
        if (PEAR::isError($exec))
        {
            show_error($exec->getMessage()."\n<br/>".$exec->getUserInfo());
            return false;
        }
        $res  = $exec->execute($values);
        if(PEAR::isError($res))
        {
            show_error($res->getMessage()."\n<br/>".$res->getUserInfo());
            return false;
        }
        $exec->free();
        $ret = array();
        while($row = $res->fetchRow(MDB2_FETCHMODE_OBJECT))
        {
            $ret[] = $row;
        }
        return $ret;
    }


    public function alter($sql, $values, $target='localhost')
    {
        if ( !isset($sql))
        {
            return FALSE;
        }

        $conn = $this->_mdb_conn($target);
        $exec = $conn->prepare($sql,array(),MDB2_PREPARE_MANIP);
        if ( PEAR::isError($exec))
        {
            show_error($exec->getMessage()."\n<br/>".$exec->getUserInfo());
            return FALSE;
        }
        $res  = $exec->execute($values);
        if (PEAR::isError($res))
        {
            show_error($res->getMessage()."\n<br/>".$res->getUserInfo());
            return FALSE;
        }
        //return $conn->lastInsertID();
        return $res;
    }


    public function batch_alter($sql, $batches, $target='localhost') {
        if (!isset($sql) || !$batches) { return false; }

        $conn = $this->_mdb_conn($target);
        $exec = $conn->prepare($sql,array(),MDB2_PREPARE_MANIP);
        if (PEAR::isError($exec))
        {
            show_error($exec->getMessage()."\n<br/>".$exec->getUserInfo());
            return false;
        }
        foreach($batches as $values)
        {
            $res = $exec->execute($values);
            if (PEAR::isError($res))
            {
                show_error($res->getMessage()."\n<br/>".$res->getUserInfo());
                $error = True;
            }
        }
        if ($error)
            return FALSE;
        return TRUE;
    }


    //////////////////////////////////////////////////////////////
    // Insert/Update string helpers

    public function insert_string($table, $values) {
        $sql = 'INSERT INTO `'.$table.'` (';
        $final_values = array();
        foreach ($values as $col => $val) {
            $columns[] = '`'.$col.'`';
            $holders[] = '?';
            $final_values[] = $val;
        }
        $sql .= join(', ', $columns). ') VALUES (';
        $sql .= join(', ', $holders). ')';
        return array($sql, $final_values);
    }


    public function update_string($table, $values, $wheres) {
        $sql = 'UPDATE `'.$table.'` SET ';
        $final_values = array();
        
        foreach ($values as $col => $val)
        {
            $sets[] = '`'.$col.'` = ?';
            $final_values[] = $val;
        }
        
        $sql .= join(', ', $sets). ' WHERE ';
        foreach($wheres as $col => $val)
        {
            $conds[] = '`'.$col.'` = ?';
            $final_values[] = $val;
        }
        $sql .= join(' AND ', $conds);
        return array($sql, $final_values);
    }


}


/* End of file Mdb.php */
/* Location: ./application/models/Mdb.php */