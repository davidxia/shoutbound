<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_m extends CI_Model
{
    public $id;
    public $name;
    public $bio;
    public $website;
    public $profile_pic;
    public $is_onboarded;
    
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
    
    
    public function verify_email_pw($email, $pw)
    {
        $this->get_by_email($email);
        if ( ! $this->id)
        {
            return FALSE;
        }
        
        $this->get_password();
        if ($this->password != md5('davidxia'.$pw.'isgodamongmen'))
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
        return md5($user_id . '~nokonmyballz~' . $key);
    }
    

    public function get_by_id($id)
    {
        $key = 'user_by_user_id:'.$id;
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


    public function get_by_fid($fid)
    {
        $key = 'user_by_user_fid:'.$fid;
        $user = $this->mc->get($key);
        if ($user === FALSE)
        {
            $sql = 'SELECT * FROM `users` WHERE fid = ?';
            $v = array($fid);
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
        
        $sql = 'UPDATE `users` SET `email` = ? WHERE `id` = ?';
        $values = array($email, $this->id);
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
        $sql = 'UPDATE `users` SET `password` = ? WHERE `id` = ?';
        $values = array($password, $this->id);
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
        $name = (isset($params['name'])) ? $params['name'] : NULL;
        $email = (isset($params['email'])) ? $params['email'] : NULL;
        $password = (isset($params['password'])) ? md5('davidxia'.$params['password'].'isgodamongmen') : NULL;
        $profile_pic = (isset($params['profile_pic'])) ? $params['profile_pic'] : 'default_avatar'.mt_rand(1, 8).'.png';
        $created = time() - 72;
        $fid = (isset($params['fid'])) ? $params['fid'] : NULL;
        
        if (!isset($name) OR !isset($email) OR !isset($password))
        {
            return FALSE;
        }
        
        $this->get_by_email($email);
        if ($this->id)
        {
            $this->clear();
            return array('success' => 0, 'message' => 'duplicate email');
        }
        
        $sql = 'INSERT INTO `users` (`fid`, `name`, `email`, `password`, `profile_pic`, `created`) VALUES (?, ?, ?, ?, ?, ?)';
        $values = array($fid, $name, $email, $password, $profile_pic, $created);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            $user_id = $r['last_insert_id'];
            $values = array();
            $s = new Setting_m();
            $settings = $s->get_all_settings();
            foreach ($settings as $setting)
            {
                $values[] = array($setting->id, $user_id);
            }
            $sql = 'INSERT INTO `settings_users` (`setting_id`, `user_id`) VALUES (?,?)';
            $num_affected = $this->mdb->batch_alter($sql, $values);
            
            $this->id = $r['last_insert_id'];
            $this->name = $name;
            $this->email = $email;
            $this->profile_pic = $profile_pic;
            return TRUE;
        }
        
        return FALSE;
    }


    public function get_trips()
    {
        if (!$this->id) return FALSE;
        $key = 'trip_ids_by_user_id:'.$this->id;
        $trip_ids = $this->mc->get($key);
        
        if ($trip_ids === FALSE)
        {
            $trip_ids = array();
            $sql = 'SELECT tu.trip_id FROM `trips_users` tu, `trips` t WHERE tu.trip_id = t.id AND t.is_active = 1 AND tu.role IN (5,10) AND tu.rsvp >= 6 AND tu.user_id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $trip_ids[] = $row->trip_id;
            }
            $this->mc->set($key, $trip_ids);
        }
        
        $this->trips = array();
        foreach ($trip_ids as $trip_id)
        {
            $trip = new Trip_m($trip_id);
            $this->trips[] = $trip;
        }
        
        return $this;
    }


    public function get_num_rsvp_yes_trips()
    {
        $key = 'num_rsvp_yes_trips_by_user_id:'.$this->id;
        $num_rsvp_yes_trips = $this->mc->get($key);
        
        if ($num_rsvp_yes_trips === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `trips_users` tu, `trips` t WHERE t.id = tu.trip_id AND t.is_active = 1 AND tu.user_id = ? AND tu.rsvp = 9';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_rsvp_yes_trips = $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_rsvp_yes_trips);
        }

        $this->num_rsvp_yes_trips = $num_rsvp_yes_trips;
        return $this;
    }


    public function get_rsvp_yes_trips($user_id = NULL)
    {
        $key = 'rsvp_yes_trip_ids_by_user_id:'.$this->id;
        $rsvp_yes_trip_ids = $this->mc->get($key);
        
        if ($rsvp_yes_trip_ids === FALSE)
        {
            $rsvp_yes_trip_ids = array();
            $sql = 'SELECT tu.trip_id FROM `trips_users` tu, `trips` t WHERE t.id = tu.trip_id AND t.is_active = 1 AND tu.user_id = ? AND tu.rsvp = 9';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $rsvp_yes_trip_ids[] = $row->trip_id;
            }
            $this->mc->set($key, $rsvp_yes_trip_ids);
        }
        
        $this->rsvp_yes_trips = array();
        foreach ($rsvp_yes_trip_ids as $rsvp_yes_trip_id)
        {
            $trip = new Trip_m($rsvp_yes_trip_id);
            $trip->get_goers()
                 ->get_places();
            if ($user_id)
            {
                $trip->get_rsvp_by_user_id($user_id);
            }
            $this->rsvp_yes_trips[] = $trip;
        }
        return $this;
    }


    public function get_num_rsvp_awaiting_trips()
    {
        $key = 'num_rsvp_awaiting_trips_by_user_id:'.$this->id;
        $num_rsvp_awaiting_trips = $this->mc->get($key);
        
        if ($num_rsvp_awaiting_trips === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `trips_users` tu, `trips` t WHERE t.id = tu.trip_id AND t.is_active = 1 AND tu.user_id = ? AND tu.rsvp = 6';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_rsvp_awaiting_trips = $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_rsvp_awaiting_trips);
        }

        $this->num_rsvp_awaiting_trips = $num_rsvp_awaiting_trips;
        return $this;
    }


    public function get_rsvp_awaiting_trips($user_id = NULL)
    {
        $key = 'rsvp_awaiting_trip_ids_by_user_id:'.$this->id;
        $rsvp_awaiting_trip_ids = $this->mc->get($key);
        
        if ($rsvp_awaiting_trip_ids === FALSE)
        {
            $rsvp_awaiting_trip_ids = array();
            $sql = 'SELECT tu.trip_id FROM `trips_users` tu, `trips` t WHERE t.id = tu.trip_id AND t.is_active = 1 AND tu.user_id = ? AND tu.rsvp = 6';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $rsvp_awaiting_trip_ids[] = $row->trip_id;
            }
            $this->mc->set($key, $rsvp_awaiting_trip_ids);
        }
        
        $this->rsvp_awaiting_trips = array();
        foreach ($rsvp_awaiting_trip_ids as $rsvp_awaiting_trip_id)
        {
            $trip = new Trip_m($rsvp_awaiting_trip_id);
            $trip->get_goers();
            $trip->get_places();
            if ($user_id)
            {
                $trip->get_rsvp_by_user_id($user_id);
            }
            $this->rsvp_awaiting_trips[] = $trip;
        }
        return $this;
    }


    public function get_num_following_users()
    {
        $key = 'num_following_users_by_user_id:'.$this->id;
        $this->mc->delete($key);
        $num_following_users = $this->mc->get($key);
        
        if ($num_following_users === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `related_users_users` uu, `users` u WHERE u.id = uu.related_user_id AND u.is_active = 1 AND uu.user_id = ? AND uu.is_following = 1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_following_users = $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_following_users);
        }

        $this->num_following_users = $num_following_users;
        return $this;
    }


    public function get_following_users($user_id = NULL)
    {
        $key = 'following_user_ids_by_user_id:'.$this->id;
        $following_user_ids = $this->mc->get($key);
        
        if ($following_user_ids === FALSE)
        {
            $following_user_ids = array();
            $sql = 'SELECT uu.related_user_id FROM `related_users_users` uu, `users` u WHERE u.id = uu.related_user_id AND u.is_active = 1 AND uu.user_id = ? AND uu.is_following = 1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $following_user_ids[] = $row->related_user_id;
            }
            $this->mc->set($key, $following_user_ids);
        }
        
        $this->following_users = array();
        foreach ($following_user_ids as $following_user_id)
        {
            $user = new User_m($following_user_id);
            if ($user_id)
            {
                $user->get_follow_status_by_user_id($user_id);
            }
            $this->following_users[] = $user;
        }
        return $this;
    }


    public function get_num_following_trips()
    {
        $key = 'num_following_trips_by_user_id:'.$this->id;
        $num_following_trips = $this->mc->get($key);
        
        if ($num_following_trips === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `trips_users` tu, `users` u, `trips` t WHERE tu.trip_id = t.id AND t.is_active = 1 AND u.id = tu.user_id AND tu.user_id = ? AND tu.rsvp = 3';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_following_trips = $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_following_trips);
        }

        $this->num_following_trips = $num_following_trips;
        return $this;
    }


    public function get_following_trips($user_id = NULL)
    {
        $key = 'following_trip_ids_by_user_id:'.$this->id;
        $following_trip_ids = $this->mc->get($key);
        
        if ($following_trip_ids === FALSE)
        {
            $following_trip_ids = array();
            $sql = 'SELECT tu.trip_id FROM `trips_users` tu, `trips` t WHERE tu.trip_id = t.id AND t.is_active = 1 AND tu.user_id = ? AND tu.rsvp = 3';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $following_trip_ids[] = $row->trip_id;
            }
            $this->mc->set($key, $following_trip_ids);
        }
        
        $this->following_trips = array();
        foreach ($following_trip_ids as $following_trip_id)
        {
            $trip = new Trip_m($following_trip_id);
            $trip->get_goers()->get_places();
            if ($user_id)
            {
                $trip->get_rsvp_by_user_id($user_id);
                $trip->get_role_by_user_id($user_id);
            }
            $this->following_trips[] = $trip;
        }
        return $this;
    }
    
    
    public function get_rsvp_role_by_trip_id($trip_id = NULL)
    {
        $key = 'rsvp_role_by_user_id_trip_id:'.$this->id.':'.$trip_id;
        $rsvp_role = $this->mc->get($key);
        
        if ($rsvp_role === FALSE)
        {
            $sql = 'SELECT tu.rsvp,tu.role FROM `trips_users` tu WHERE tu.user_id = ? AND tu.trip_id = ?';
            $v = array($this->id, $trip_id);
            $rows = $this->mdb->select($sql, $v);
            $rsvp = (isset($rows[0])) ? $rows[0]->rsvp : NULL;
            $role = (isset($rows[0])) ? $rows[0]->role : NULL;
            $rsvp_role = array('rsvp' => $rsvp, 'role' => $role);
            $this->mc->set($key, $rsvp_role);
        }
        
        $this->rsvp = $rsvp_role['rsvp'];
        $this->role = $rsvp_role['role'];
        return $this;
    }
    
    
    public function set_rsvp_role_for_trip_id($trip_id = NULL, $rsvp = NULL, $role = NULL)
    {
        if ( !isset($trip_id) AND !isset($rsvp) AND !isset($role))
        {
            return FALSE;
        }
        
        $sql = 'INSERT INTO `trips_users` (`user_id`, `trip_id`, `rsvp`, `role`) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE `rsvp` = ?, `role` = ?';
        $values = array($this->id, $trip_id, $rsvp, $role, $rsvp, $role);
        $r = $this->mdb->alter($sql, $values);
        
        if ($r['num_affected'] == 1 OR $r['num_affected'] == 2)
        {
            $this->mc->replace('rsvp_role_by_user_id_trip_id:'.$this->id.':'.$trip_id, array('rsvp' => $role, 'role' => $role));
            $this->mc->replace('role_by_trip_id_user_id:'.$trip_id.':'.$this->id, $role);
            $this->mc->replace('rsvp_by_trip_id_user_id:'.$trip_id.':'.$this->id, $rsvp);
            $this->mc->delete('num_followers_by_trip_id:'.$trip_id);
            $this->mc->delete('follower_ids_by_trip_id:'.$trip_id);
            $this->mc->delete('num_goers_by_trip_id:'.$trip_id);
            $this->mc->delete('goer_ids_by_trip_id:'.$trip_id);
            return $r['num_affected'];
        }
        else
        {
            return 0;
        }
    }


    public function get_num_following_places()
    {
        $key = 'num_following_places_by_user_id:'.$this->id;
        $num_following_places = $this->mc->get($key);
        
        if ($num_following_places === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `places_users` pu, `users` u WHERE u.id = pu.user_id AND pu.user_id = ? AND pu.is_following = 1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_following_places = $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_following_places);
        }

        $this->num_following_places = $num_following_places;
        return $this;
    }


    public function get_following_places($user_id = NULL)
    {
        $key = 'following_place_ids_by_user_id:'.$this->id;
        $following_place_ids = $this->mc->get($key);
        
        if ($following_place_ids === FALSE)
        {
            $following_place_ids = array();
            $sql = 'SELECT pu.place_id FROM `places_users` pu, `users` u WHERE u.id = pu.user_id AND pu.user_id = ? AND pu.is_following = 1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $following_place_ids[] = $row->place_id;
            }
            $this->mc->set($key, $following_place_ids);
        }

        $this->following_places = array();
        foreach ($following_place_ids as $following_place_id)
        {
            $place = new Place_m($following_place_id);
            if ($user_id)
            {
                $place->get_follow_status_by_user_id($user_id);
            }
            $this->following_places[] = $place;
        }
        return $this;
    }


    public function edit_follow_for_place_id($place_id = NULL, $is_following = 1)
    {
        $sql = 'INSERT INTO `places_users` (`place_id`, `user_id`, `is_following`) VALUES (?,?,?) ON DUPLICATE KEY UPDATE is_following = ?';
        $values = array($place_id, $this->id, $is_following, $is_following);
        $r = $this->mdb->alter($sql, $values);
        
        if ($r['num_affected'] == 1 OR $r['num_affected'] == 2)
        {
            $this->mc->replace('follow_status_by_place_id_user_id:'.$place_id.':'.$this->id, $is_following);
            $this->mc->delete('following_place_ids_by_user_id:'.$this->id);
            return $r['num_affected'];
        }
        else
        {
            return 0;
        }
    }
        
    
    public function get_num_followers()
    {
        $key = 'num_followers_by_user_id:'.$this->id;
        $num_followers = $this->mc->get($key);
        
        if ($num_followers === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `related_users_users` uu, `users` u WHERE u.id = uu.user_id AND u.is_active = 1 AND uu.related_user_id = ? AND uu.is_following = 1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_followers = $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_followers);
        }

        $this->num_followers = $num_followers;
        return $this;
    }


    public function get_followers($user_id = NULL)
    {
        $key = 'follower_ids_by_user_id:'.$this->id;
        $follower_ids = $this->mc->get($key);
        
        if ($follower_ids === FALSE)
        {
            $follower_ids = array();
            $sql = 'SELECT uu.user_id FROM `related_users_users` uu, `users` u WHERE u.id = uu.user_id AND u.is_active = 1 AND uu.related_user_id = ? AND uu.is_following = 1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $follower_ids[] = $row->user_id;
            }
            $this->mc->set($key, $follower_ids);
        }
        
        $this->followers = array();
        foreach ($follower_ids as $follower_id)
        {
            $user = new User_m($follower_id);
            if ($user_id)
            {
                $user->get_follow_status_by_user_id($user_id);
            }
            $this->followers[] = $user;
        }
        return $this;
    }
    
    
    public function get_num_posts()
    {
        $key = 'num_posts_by_user_id:'.$this->id;
        $num_posts = $this->mc->get($key);
        
        if ($num_posts === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `posts` p WHERE p.is_active = 1 AND p.user_id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_posts = $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_posts);
        }

        $this->num_posts = $num_posts;
        return $this;
    }


    public function get_posts()
    {
        $key = 'post_ids_by_user_id:'.$this->id;
        $post_ids = $this->mc->get($key);
        
        if ($post_ids === FALSE)
        {
            $post_ids = array();
            $sql = 'SELECT p.id FROM `posts` p WHERE p.user_id = ? AND p.is_active = 1 ORDER BY p.created DESC LIMIT 20';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $post_ids[] = $row->id;
            }
            $this->mc->set($key, $post_ids);
        }
        
        $this->posts = array();
        foreach ($post_ids as $post_id)
        {
            $post = new Post_m($post_id);
            $post->convert_nl()
                 ->get_places()
                 ->get_replies()
                 ->get_trips();
            $this->posts[] = $post;
        }
        return $this;
    }

    
    public function get_follow_status_by_user_id($user_id)
    {
        $key = 'follow_status_by_user_id:'.$this->id.':'.$user_id;
        $status = $this->mc->get($key);
        
        if ($status === FALSE)
        {
            $sql = 'SELECT is_following FROM `related_users_users` WHERE user_id = ? AND related_user_id = ?';
            $v = array($user_id, $this->id);
            $rows = $this->mdb->select($sql, $v);
            $status = (isset($rows[0])) ? $rows[0]->is_following : NULL;
            $this->mc->set($key, $status);
        }
        
        $this->is_following = $status;
        return $this;
    }
    
    
    public function set_follow_for_user_id($user_id, $is_following)
    {
        $sql = 'INSERT INTO `related_users_users` (`user_id`, `related_user_id`, `is_following`) VALUES (?,?,?) ON DUPLICATE KEY UPDATE `is_following` = ?';
        $v = array($this->id, $user_id, $is_following, $is_following);
        $r = $this->mdb->alter($sql, $v);
        
        if ($r['num_affected'] == 1 OR $r['num_affected'] == 2)
        {
            if ($is_following)
            {
                $this->mc->delete('num_following_users_by_user_id:'.$this->id);
                $this->mc->delete('num_followers_by_user_id:'.$user_id);
            }
            else
            {
                $this->mc->delete('num_following_users_by_user_id:'.$this->id);
                $this->mc->delete('num_followers_by_user_id:'.$user_id);
            }
            $this->mc->delete('following_user_ids_by_user_id:'.$this->id);
            $this->mc->delete('follower_ids_by_user_id:'.$user_id);
            $this->mc->delete('follow_status_by_user_id:'.$user_id.':'.$this->id);
            
            $this->get_trips();
            foreach ($this->trips as $trip)
            {
                $this->mc->delete('uninvited_user_ids_by_trip_id_user_id:'.$trip->id.':'.$this->id);
            }
            return $r['num_affected'];
        }
        else
        {
            return 0;
        }
    }
    

    public function get_future_places()
    {
        $key = 'future_place_ids_by_user_id:'.$this->id;
        $future_place_ids = $this->mc->get($key);
        
        if ($future_place_ids === FALSE)
        {
            $future_place_ids = array();
            $sql = 'SELECT place_id FROM `places_users` WHERE user_id = ? AND is_future = 1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $future_place_ids[] = $row->place_id;
            }
            $this->mc->set($key, $future_place_ids);
        }
        
        $this->future_places = array();
        foreach ($future_place_ids as $future_place_id)
        {
            $place = new Place_m($future_place_id);
            $this->future_places[] = $place;
        }
        return $this;
    }


    public function edit_future_place_by_place_id($place_id = NULL, $is_future = 1)
    {
        $sql = 'INSERT INTO `places_users` (`place_id`, `user_id`, `is_future`) VALUES (?,?,?) ON DUPLICATE KEY UPDATE `is_future` = ?';
        $values = array($place_id, $this->id, $is_future, $is_future);
        $r = $this->mdb->alter($sql, $values);
        
        if ($r['num_affected'] == 1 OR $r['num_affected'] == 2)
        {
            $this->mc->delete('future_place_ids_by_user_id:'.$this->id);
            return $r['num_affected'];
        }
        else
        {
            return 0;
        }
    }


    public function get_current_place()
    {
        $key = 'current_place_id_by_user_id:'.$this->id;
        $current_place_id = $this->mc->get($key);
        
        if ($current_place_id === FALSE)
        {
            $sql = 'SELECT place_id FROM `places_users` pu '.
                       'WHERE pu.user_id = ? AND pu.`timestamp` = ('.
                           'SELECT MAX(`places_users`.`timestamp`) FROM `places_users` '.
                           'WHERE `places_users`.`user_id` = ?)';
            $v = array($this->id, $this->id);
            $rows = $this->mdb->select($sql, $v);
            $current_place_id = (isset($rows[0])) ? $rows[0]->place_id : NULL;
            $this->mc->set($key, $current_place_id);
        }
        
        if ($current_place_id)
        {
            $place = new Place_m($current_place_id);
            $this->current_place = $place;
        }
        else
        {
            $this->current_place = NULL;
        }
        return $this;
    }


    public function get_past_places()
    {
        $key = 'past_place_ids_by_user_id:'.$this->id;
        $past_place_ids = $this->mc->get($key);
        
        if ($past_place_ids === FALSE)
        {
            $past_place_ids = array();
            $sql = 'SELECT `place_id` FROM `places_users` WHERE `user_id` = ? AND `is_past` = 1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $past_place_ids[] = $row->place_id;
            }
            $this->mc->set($key, $past_place_ids);
        }
        
        $this->past_places = array();
        foreach ($past_place_ids as $past_place_id)
        {
            $place = new Place_m($past_place_id);
            $place->get_timestamp_by_user_id($this->id);
            $this->past_places[] = $place;
        }
        return $this;
    }
    
    
    public function set_past_place($place_id, $timestamp = NULL)
    {
        $sql = 'INSERT INTO `places_users` (`place_id`, `user_id`, `timestamp`, `is_past`) VALUES (?,?,?,1) ON DUPLICATE KEY UPDATE `timestamp` = ?, `is_past` = 1';
        $v = array($place_id, $this->id, $timestamp, $timestamp);
        $r = $this->mdb->alter($sql, $v);
        
        if ($r['num_affected'] == 1 OR $r['num_affected'] == 2)
        {
            $this->mc->delete('past_place_ids_by_user_id:'.$this->id);
            $this->mc->delete('timestamp_by_place_id_user_id:'.$place_id.':'.$this->id);
            
            return $r['num_affected'];
        }
        else
        {
            return 0;
        }
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


    public function get_first_name()
    {
        $a = explode(' ', $this->name);
        $this->first_name = $a[0];
    }


    public function get_news_feed_items()
    {
        $key = 'news_feed_post_ids_by_user_id:'.$this->id;
        $news_feed_post_ids = $this->mc->get($key);
        
        if ($news_feed_post_ids === FALSE)
        {
            $news_feed_post_ids = array();
            $sql =
                // get ids of posts that are not replies from people user follows
                '(SELECT p.id, p.created FROM `posts` p WHERE p.parent_id IS NULL AND p.user_id IN '.
                    '(SELECT uu.related_user_id FROM `related_users_users` uu, `users` u WHERE u.id = uu.related_user_id AND u.is_active = 1 AND uu.user_id = ? AND uu.is_following = 1) '.
                    'ORDER BY p.created DESC) '.
                'UNION '.
                // get ids of trips user is following, awaiting rsvp, or rsvp yes
                // get these trips' most recent posts that aren't replies excluding those posted or added by this user
                '(SELECT p.id,p.created FROM `posts_trips` pt, `trips` t, `posts` p WHERE pt.trip_id = t.id AND p.id = pt.post_id AND p.parent_id IS NULL AND p.user_id != ? AND t.is_active = 1 AND p.is_active = 1 AND pt.is_active = 1 AND pt.trip_id IN '.
                    '(SELECT tu.trip_id FROM `trips_users` tu, `trips` t WHERE tu.trip_id = t.id AND t.is_active = 1 AND tu.rsvp >= 3 AND tu.user_id = ?) AND (pt.added_by != ? OR pt.added_by IS NULL) '.
                'ORDER BY p.created DESC) '.
                // TODO: get posts from places user is following
                'ORDER BY created DESC LIMIT 20';
            $v = array($this->id, $this->id, $this->id, $this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $news_feed_post_ids[] = $row->id;
            }
            $this->mc->set($key, $news_feed_post_ids);
        }

        $this->news_feed_items = array();
        foreach ($news_feed_post_ids as $news_feed_post_id)
        {
            $post = new Post_m($news_feed_post_id);
            $post->convert_nl();
            $post->get_author();
            $post->get_trips();
            $post->get_places();
            $post->get_replies();
            $this->news_feed_items[] = $post;
        }
        return $this;
    }
    
    
    public function get_recent_activity()
    {
        $key = 'recent_activity_ids_by_user_id:'.$this->id;
        $recent_activity_ids = $this->mc->get($key);
        
        if ($recent_activity_ids === FALSE)
        {
            $recent_activity_ids = array();
            $sql = 'SELECT `id` FROM `activities` WHERE `user_id` = ? AND `is_active` = 1 ORDER BY `timestamp` DESC LIMIT 20';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $recent_activity_ids[] = $row->id;
            }
            $this->mc->set($key, $recent_activity_ids);
        }
        
        $this->recent_activities = array();
        foreach ($recent_activity_ids as $recent_activity_id)
        {
            $this->load->model('Activity_m');
            $activity = new Activity_m($recent_activity_id);
            $activity->get_source()->get_parent();
            $this->recent_activities[] = $activity;
        }
        return $this;
    }


    public function set_current_place_by_place_id($place_id = NULL)
    {
        $timestamp = time()-72;
        $sql = 'INSERT INTO `places_users` (`place_id`, `user_id`, `timestamp`) VALUES (?,?,?) ON DUPLICATE KEY UPDATE `timestamp` = ?';
        $values = array($place_id, $this->id, $timestamp, $timestamp);
        $r = $this->mdb->alter($sql, $values);
        
        if ($r['num_affected'] == 1 OR $r['num_affected'] == 2)
        {
            $this->mc->delete('current_place_id_by_user_id:'.$this->id);
            return $r['num_affected'];
        }
        else
        {
            return 0;
        }
    }


    public function set_profile_info($params = array())
    {
        $bio = (isset($params['bio'])) ? $params['bio'] : $this->bio;
        $website = (isset($params['website'])) ? $params['website'] : $this->website;
        $profile_pic = (isset($params['profile_pic'])) ? $params['profile_pic'] : $this->profile_pic;
        
        if ($bio==$this->bio AND $website==$this->website AND $profile_pic==$this->profile_pic)
        {
            return FALSE;
        }

        $sql = 'UPDATE `users` SET `bio`=?, `website`=? WHERE `id` = ?';
        $values = array($bio, $website, $this->id);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            $this->bio = $bio;
            $this->website = $website;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
        
    
    public function set_like_for_post_id($post_id = NULL, $is_like = 1)
    {
        if ( ! $post_id)
        {
            return FALSE;
        }
        
        $sql = 'INSERT INTO `likes` (`user_id`, `post_id`, `is_like`) VALUES (?,?,?) ON DUPLICATE KEY UPDATE `is_like` = ?';
        $values = array($this->id, $post_id, $is_like, $is_like);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1 OR $r['num_affected'] == 2)
        {
            $this->mc->delete('like_ids_by_post_id:'.$post_id);
            return $r['num_affected'];
        }
        else
        {
            return 0;
        }
    }


    public function update_fb_friends()
    {
        $this->load->library('facebook');
        // get this user's Facebook friends from Facebook
        $fbdata = $this->facebook->api('/me?fields=friends');
        if ($fbdata)
        {
            $fb_friends = array();
            foreach ($fbdata['friends']['data'] as $friend)
            {
                $fb_friends[$friend['id']] = $friend['name'];
            }
        }
        
        // get this user's Facebook friends from friends table        
        $sb_friends = array();
        $sql = 'SELECT f.facebook_id, f.name FROM `friends` f, `friends_users` fu WHERE fu.friend_id = f.id AND fu.user_id = ?';
        $v = array($this->id);
        $rows = $this->mdb->select($sql, $v);
        foreach ($rows as $row)
        {
            $sb_friends[$row->facebook_id] = $row->name;
        }
        
        // get current Facebook friends not in friends table and add them
        $fb_friends = array_diff($fb_friends, $sb_friends);
        $this->diff = $fb_friends;
        
        $this->load->model('Friend_m');
        $f = new Friend_m();
        foreach ($fb_friends as $k => $v)
        {
            // check if this Facebook user is already in friends table
            $f->get_by_facebook_id($k);
            // insert new record if not found
            if ( ! $f->id)
            {
                $f->create(array('facebook_id' => $k, 'name' => $v));
            }
            
            // create new relation in friends_users table
            if ($f->id)
            {
                $this->add_friend_by_friend_id($f->id);
            }
        }
    }
    
    
    public function add_friend_by_friend_id($friend_id)
    {
        $sql = 'INSERT INTO `friends_users` (`user_id`, `friend_id`) VALUES (?,?)';
        $values = array($this->id, $friend_id);
        $this->mdb->alter($sql, $values);
    }


    public function get_onboarding_users()
    {
        $user_ids = array();
        $sql = 'SELECT DISTINCT u.id FROM `related_users_users` ruu, `users` u WHERE u.is_active= 1 AND u.id NOT IN (SELECT related_user_id FROM `related_users_users` WHERE user_id = ? AND is_following = 1) AND u.id != ?';
        $v = array($this->id, $this->id);
        $rows = $this->mdb->select($sql, $v);
        foreach ($rows as $row)
        {
            $user_ids[] = $row->id;
        }
        
        $this->onboarding_users = array();
        foreach ($user_ids as $user_id)
        {
            $user = new User_m($user_id);
            $this->onboarding_users[] = $user;
        }
        return $this;
    }


    public function get_onboarding_trips()
    {
        $trip_ids = array();
        $sql = 'SELECT DISTINCT pt.trip_id FROM `places_trips` pt, `trips` t WHERE t.is_active = 1 AND pt.trip_id = t.id AND pt.trip_id NOT IN (SELECT trip_id FROM `trips_users` WHERE user_id = ? AND rsvp = 3)';
        $v = array($this->id);
        $rows = $this->mdb->select($sql, $v);
        foreach ($rows as $row)
        {
            $trip_ids[] = $row->trip_id;
        }
        
        $this->onboarding_trips = array();
        foreach ($trip_ids as $trip_id)
        {
            $trip = new Trip_m($trip_id);
            $trip->get_goers();
            $trip->get_places();
            $this->onboarding_trips[] = $trip;
        }
        return $this;
    }


    public function get_onboarding_places()
    {
        $place_ids = array();
        $sql = 'SELECT pt.place_id FROM `places_trips` pt WHERE pt.place_id NOT IN (SELECT pu.place_id FROM `places_users` pu WHERE pu.user_id = ? AND pu.is_following = 1)';
        $v = array($this->id);
        $rows = $this->mdb->select($sql, $v);
        foreach ($rows as $row)
        {
            $place_ids[] = $row->place_id;
        }

        $this->onboarding_places = array();
        foreach ($place_ids as $place_id)
        {
            $place = new Place_m($place_id);
            $this->onboarding_places[] = $place;
        }
        return $this;
    }
    
    
    public function set_onboarding_status($is_onboarded = 0)
    {
        $sql = 'UPDATE `users` SET `is_onboarded` = ? WHERE `id` = ?';
        $v = array($is_onboarded, $this->id);
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
}

/* End of file user_m.php */
/* Location: ./application/models/user_m.php */