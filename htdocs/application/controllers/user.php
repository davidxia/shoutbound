<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{

    private $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User_m();
        $u->get_logged_in_user();
        if ($u->id)
        {
            $this->user = $u;
        }
        else
        {
            json_error();
            exit();
        }
		}


    public function ajax_set_favorite()
    {
        $article_id = $this->input->post('articleId');
        $is_favorite = (int) $this->input->post('isFavorite');

        if ($this->user->set_favorite($article_id, $is_favorite))
        {
            json_success(array('isFavorite' => $is_favorite));
        }
        else
        {
            json_error();
        }
    }
    
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */