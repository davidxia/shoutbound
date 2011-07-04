<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feature extends CI_Controller
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
		

    public function index($article_id = NULL)
    {
        if ( ! $article_id)
        {
            redirect('/');
        }
        
        $article = new Article_m($article_id);
        //check if article exists is active
        if ( ! $article->is_active)
        {
            custom_404();
            return;
        }
        
        $article->get_prev_article_id()
                ->get_next_article_id()
                ->get_venues();
/*         echo '<pre>'; print_r($article); echo '</pre>'; */

        $data = array(
            'article' => $article,
            'user' => $this->user,
        );
        $this->load->view('feature', $data);
    }
}

/* End of file feature.php */
/* Location: ./application/controllers/feature.php */