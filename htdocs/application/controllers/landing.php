<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller
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


    public function index()
    {
        if ($this->user)
        {
            $article = new Article_m();
            $article->get_recent_articles(5);
            
            $data = array(
                'article' => $article,
                'user' => $this->user,
            );
          	$this->load->view('home', $data);
        }
        else
        {
          	$this->load->view('landing');
        }
    }
    
        
}

/* End of file landing.php */
/* Location: ./application/controllers/landing.php */