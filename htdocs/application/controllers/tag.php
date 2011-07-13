<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Controller
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
            if ($this->user->onboarding_step)
            {
                redirect('/signup/step/'.$this->user->onboarding_step);
            }
        }
		}
		

    public function index($uri_seg = NULL)
    {
        if ( ! $uri_seg)
        {
            redirect('/');
        }
        
        $this->load->model('Tag_m');
        $tag = new Tag_m();
        $tag->get_by_uri_seg($uri_seg)
            ->get_articles();

        $this->user->get_favorite_ids();

        $data = array(
            'tag' => $tag,
            'user' => $this->user,
        );
        $this->load->view('tag', $data);
/*         echo '<pre>';print_r($tag);echo '</pre>'; */
    }
    
    
}

/* End of file tag.php */
/* Location: ./application/controllers/tag.php */