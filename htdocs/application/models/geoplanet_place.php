<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Geoplanet_place extends DataMapper
{
    
    public $has_many = array('user', 'trip', 'wallitem');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
        

    public function get_num_posts()
    {
        $this->stored->num_posts = $this->wallitems->where_join_field($this, 'is_active', 1)->count();
    }


    public function get_num_trips()
    {
        $this->stored->num_trips = $this->trips->where('active', 1)->count();
    }
    

    public function get_num_followers()
    {
        $this->stored->num_followers = $this->user->where_join_field($this, 'is_following', 1)->count();
    }
}

/* End of file place.php */
/* Location: ./application/models/place.php */