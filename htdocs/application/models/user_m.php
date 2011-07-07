<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_m extends CI_Model
{
    public $id;
    public $first_name;
    public $last_name;
    public $onboarding_step;
    
    function __construct($id = NULL)
    {
        parent::__construct();
        if (is_numeric($id))
        {
            $this->get_by_id($id);
        }
    }
    
    
    public function login()
    {
        if (is_null($this->id))
        {
            return FALSE;
        }
        set_cookie('uid', $this->id, 259200);
        $key = mt_rand(100000, 999999);
        $sig = $this->get_sig($this->id, $key);
        set_cookie('key', $key, 259200);
        set_cookie('sig', $sig, 259200);
        return TRUE;
    }


    public function logout()
    {
        delete_cookie('uid');
        delete_cookie('key');
        delete_cookie('sig');
        return TRUE;
    }


    public function get_logged_in_user()
    {
        $user_id = $this->get_logged_in_user_id();
        if ($user_id)
        {
            $this->get_by_id($user_id);
        }
        return $this;
    }
    
    
    public function verify_email_password($email, $password)
    {
        $this->get_by_email($email);
        if ( ! $this->id)
        {
            return FALSE;
        }
        
        $this->get_password();
        if ($this->password != md5('davidxia'.$password.'isgodamongmen'))
        {
            $this->clear();
            return FALSE;
        }
        
        return $this->id;
    }
    

    private function get_logged_in_user_id()
    {
        $user_id = get_cookie('uid');
        if ( ! $user_id)
        {
            return FALSE;
        }
        $key = get_cookie('key');
        $sig = get_cookie('sig');
        if ($sig == $this->get_sig($user_id, $key))
        {
            set_cookie('uid', $user_id, 259200);
            set_cookie('key', $key, 259200);
            set_cookie('sig', $sig, 259200);
            return $user_id;
        }
    }


    private function get_sig($user_id, $key)
    {
        return md5($user_id . '~turbothatshit~' . $key);
    }
    

    public function get_by_id($id)
    {
        $key = 'user_by_user_id:'.$id;
        $this->mc->get($key);
        $user = $this->mc->get($key);
        if ($user === FALSE)
        {
            $sql = 'SELECT * FROM `users` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $user = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $user);
        }
        
        $this->row2obj($user);
        return $this;
    }
        

    public function get_by_email($email)
    {
        $key = 'user_by_email:'.$email;
        $user = $this->mc->get($key);
        
        if ($user === FALSE)
        {
            $sql = 'SELECT * FROM `users` WHERE email = ?';
            $v = array($email);
            $rows = $this->mdb->select($sql, $v);
            $user = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $user);
        }

        $this->row2obj($user);
        return $this;
    }
    
    
    public function get_email()
    {
        $key = 'email_by_user_id:'.$this->id;
        $email = $this->mc->get($key);
        
        if ($email === FALSE)
        {
            $sql = 'SELECT `email` FROM `users` WHERE id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $email = (isset($rows[0])) ? $rows[0]->email : NULL;
            $this->mc->set($key, $email);
        }
        
        $this->email = $email;
        return $this;
    }


    public function set_email($email = NULL)
    {
        if ( ! $email)
        {
            return FALSE;
        }
        
        $sql = 'UPDATE `users` SET `email`=?, `updated`=? WHERE `id` = ?';
        $values = array($email, time(), $this->id);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    public function get_password()
    {
        $key = 'password_by_user_id:'.$this->id;
        $password = $this->mc->get($key);
        
        if ($password === FALSE)
        {
            $sql = 'SELECT `password` FROM `users` WHERE `id` = ?';
            $values = array($this->id);
            $rows = $this->mdb->select($sql, $values);
            $password = (isset($rows[0])) ? $rows[0]->password : NULL;
            $this->mc->set($key, $password);
        }
        
        $this->password = $password;
        return $this;
    }


    public function set_password($password = NULL)
    {
        if ( ! $password)
        {
            return FALSE;
        }
        
        $password = md5('davidxia'.$password.'isgodamongmen');
        $sql = 'UPDATE `users` SET `password`=?, `updated`=? WHERE `id` = ?';
        $values = array($password, time(), $this->id);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            $this->mc->replace('password_by_user_id:'.$this->id, $password);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    
    public function create($params = array())
    {
        $email = (isset($params['email'])) ? $params['email'] : NULL;
        $password = (isset($params['password'])) ? md5('davidxia'.$params['password'].'isgodamongmen') : NULL;
        $created = time() - 72;
        $updated = time() - 72;
        
        if (!isset($email) OR !isset($password))
        {
            return array('success' => FALSE, 'message' => 'You didn\'t fill in a required field.');
        }
        
        $this->get_by_email($email);
        if ($this->id)
        {
            $this->clear();
            return array('success' => FALSE, 'message' => 'This e-mail has already subscribed. Did you forget your password?');
        }

        $this->mc->delete('user_by_email:'.$email);

        $sql = 'INSERT INTO `users` (`email`, `password`, `created`, `updated`) VALUES (?,?,?,?)';
        $values = array($email, $password, $created, $updated);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            $user_id = $r['last_insert_id'];
            
            $values = array();
            $this->load->model('Setting_m');
            $s = new Setting_m();
            $settings = $s->get_all_settings();
            foreach ($settings as $setting)
            {
                $values[] = array($setting->id, $user_id);
            }
            $sql = 'INSERT INTO `settings_users` (`setting_id`, `user_id`) VALUES (?,?)';
            $num_affected = $this->mdb->batch_alter($sql, $values);
            
            $this->id = $r['last_insert_id'];
            $this->email = $email;
            return array('success' => TRUE);
        }
        
        return array('success' => FALSE, 'message' => 'something broke');
    }


    public function get_settings()
    {
        $key = 'settings_by_user_id:'.$this->id;
        $settings = $this->mc->get($key);
        
        if ($settings === FALSE)
        {
            $settings = array();
            $sql = 'SELECT su.setting_id,su.is_on FROM `settings_users` su, `users` u WHERE u.id = su.user_id  AND u.id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $settings[$row->setting_id] = $row->is_on;
            }
            $this->mc->set($key, $settings);
        }
        
        $this->settings = $settings;
        return $this;
    }
    
    
    public function set_setting_by_setting_id($setting_id, $is_on = 1)
    {
        $sql = 'UPDATE `settings_users` SET `is_on` = ? WHERE `user_id` = ? AND `setting_id` = ?';
        $values = array($is_on, $this->id, $setting_id);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    
    public function get_profile_info()
    {
        $key = 'profile_info_by_user_id:'.$this->id;
        $profile_info = $this->mc->get($key);
        
        if ($profile_info === FALSE)
        {
            $profile_info = array();
            $sql = 'SELECT `gender`,`income_range`,`bday`,`zipcode` FROM `users` WHERE id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $profile_info['gender'] = (isset($rows[0])) ? $rows[0]->gender : NULL;
            $profile_info['income_range'] = (isset($rows[0])) ? $rows[0]->income_range : NULL;
            $profile_info['bday'] = (isset($rows[0])) ? $rows[0]->bday : NULL;
            $profile_info['zipcode'] = (isset($rows[0])) ? $rows[0]->zipcode : NULL;
            $this->mc->set($key, $profile_info);
        }
        
        $this->gender = $profile_info['gender'];
        $this->income_range = $profile_info['income_range'];
        $this->bday = $profile_info['bday'];
        $this->zipcode = $profile_info['zipcode'];
        return $this;
    }


    public function set_profile_info($params = array())
    {
        $this->get_profile_info();
        
        $first_name = (isset($params['first_name'])) ? trim($params['first_name']) : $this->first_name;
        $last_name = (isset($params['last_name'])) ? trim($params['last_name']) : $this->last_name;
        $gender = (isset($params['gender'])) ? $params['gender'] : $this->gender;
        $income_range = (isset($params['income_range'])) ? $params['income_range'] : $this->income_range;
        $bday = (isset($params['bday'])) ? $params['bday'] : $this->bday;
        
        if (isset($params['bday']))
        {
            $bday = date_parse_from_format('n/j/Y', $params['bday']);
            if (checkdate($bday['month'], $bday['day'], $bday['year']))
            {
                $bday = strtotime($bday['year'].'-'.$bday['month'].'-'.$bday['day']);
            }
        }
                
        if ($first_name==$this->first_name AND $last_name==$this->last_name AND $gender==$this->gender AND $income_range==$this->income_range AND $bday==$this->bday)
        {
            return TRUE;
        }

        $sql = 'UPDATE `users` SET `first_name`=?, `last_name`=?, `gender`=?, `income_range`=?, `bday`=?, `updated`=? WHERE `id`=?';
        $values = array($first_name, $last_name, $gender, $income_range, $bday, time(), $this->id);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {   
            $this->first_name = $first_name;
            $this->last_name = $last_name;
                 
            $this->mc->delete('user_by_user_id:'.$this->id);
            $this->get_email();
            $this->mc->delete('user_by_email:'.$this->email);
            
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
        
    
    public function set_onboarding_step($n = 1)
    {
        $sql = 'UPDATE `users` SET `onboarding_step` = ? WHERE `id` = ?';
        $v = array($n, $this->id);
        $r = $this->mdb->alter($sql, $v);
        
        if ($r['num_affected'] == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    
    public function set_pw_reset()
    {
        $hash = md5(time().'caimaoshuangquan');
        $expiration = time()+259200;
        
        $sql = 'INSERT INTO `pw_resets_users` (`user_id`, `hash`, `expiration`) VALUES (?,?,?)';
        $v = array($this->id, $hash, $expiration);
        $r = $this->mdb->alter($sql, $v);
        
        if ($r['num_affected'] == 1)
        {
            $this->pw_reset_hash = $hash;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    
    public function claim_pw_reset($user_id, $hash)
    {        
        $sql = 'UPDATE `pw_resets_users` SET `is_claimed`=1 WHERE `user_id`=? AND `hash`=? AND `expiration`>? AND `is_claimed`=0 LIMIT 1';
        $v = array($user_id, $hash, time());
        $r = $this->mdb->alter($sql, $v);
        
        if ($r['num_affected'] == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    public function get_favorite_ids()
    {
        $key = 'favorite_ids_by_user_id:'.$this->id;
        $favorite_ids = $this->mc->get($key);
        
        if ($favorite_ids === FALSE)
        {
            $favorite_ids = array('articles' => array());
            $sql = 'SELECT au.article_id FROM `articles_users` au, `articles` a WHERE a.id = au.article_id  AND a.is_active=1 AND au.is_favorite=1 AND au.user_id=?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $favorite_ids['articles'][$row->article_id] = 1;
            }
            $this->mc->set($key, $favorite_ids);
        }
        
        $this->favorite_ids = $favorite_ids;
        return $this;
    }


    public function get_favorites()
    {
        $key = 'favorite_ids_by_user_id:'.$this->id;
        $favorite_ids = $this->mc->get($key);
        
        if ($favorite_ids === FALSE)
        {
            $favorite_ids = array('articles' => array());
            $sql = 'SELECT au.article_id FROM `articles_users` au, `articles` a WHERE a.id = au.article_id  AND a.is_active=1 AND au.is_favorite=1 AND au.user_id=?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $favorite_ids['articles'][$row->article_id] = 1;
            }
            $this->mc->set($key, $favorite_ids);
        }
        
        $this->favorites = array('articles' => array());
        foreach ($favorite_ids['articles'] as $favorite_article_id=>$v)
        {
            $article = new Article_m($favorite_article_id);
            $this->favorites['articles'][] = $article;
        }
        
        return $this;
    }


    public function set_favorite($article_id, $is_favorite = 1)
    {
        if ( ! $article_id)
        {
            return FALSE;
        }
        
        $sql = 'SELECT * FROM `articles_users` au WHERE au.`article_id`=? AND au.`user_id`=?';
        $values = array($article_id, $this->id);
        $rows = $this->mdb->select($sql, $values);
        
        if (isset($rows[0]))
        {
            $sql = 'UPDATE `articles_users` SET `is_favorite`=? WHERE `article_id`=? AND `user_id`=?';
            $v = array($is_favorite, $article_id, $this->id);
            $r = $this->mdb->alter($sql, $v);
        }
        else
        {
            $article = new Article_m($article_id);
            if ($article->id)
            {
                $sql = 'INSERT INTO `articles_users` (`article_id`, `user_id`, `is_favorite`) VALUES (?,?,?)';
                $v = array($article_id, $this->id, $is_favorite);
                $r = $this->mdb->alter($sql, $v);
            }
        }

        if ($r['num_affected'] == 1)
        {
            $this->mc->delete('favorite_ids_by_user_id:'.$this->id);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    
    public function increment_invites_clicked()
    {
        $sql = 'UPDATE `users` SET `invites_clicked` = `invites_clicked`+1 WHERE `id` = ?';
        $v = array($this->id);
        $r = $this->mdb->alter($sql, $v);
        
        if ($r['num_affected'] == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    public function set_active($is_active = 1)
    {
        $sql = 'UPDATE `users` SET `is_active` = ? WHERE `id` = ?';
        $v = array($is_active, $this->id);
        $r = $this->mdb->alter($sql, $v);
        
        if ($r['num_affected'] == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    

    private function row2obj($row)
    {
        if ( ! is_null($row))
        {
            $this->reset_properties();
            foreach (get_object_vars($this) as $k => $v)
            {
                $this->$k = $row->$k;
            }
        }
        else
        {
            $this->clear();
        }
    }
    

    private function clear()
    {
        foreach (get_object_vars($this) as $k => $v)
        {
            $this->$k = NULL;
        }
    }
    
    
    private function reset_properties()
    {
        foreach (get_object_vars($this) as $k => $v)
        {
            if ( ! in_array($k, array('id', 'first_name', 'last_name', 'onboarding_step')))
            {
                unset($this->$k);
            }
        }
    }
}

/* End of file user_m.php */
/* Location: ./application/models/user_m.php */