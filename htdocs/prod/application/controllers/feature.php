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
		

    public function index($uri_seg = NULL)
    {
        if ( ! $uri_seg)
        {
            redirect('/');
        }
        
        $article = new Article_m();
        $article->get_by_uri_seg($uri_seg);
        //check if article exists is active
        if ( ! $article->is_active)
        {
            custom_404();
            return;
        }
        
        $article->get_prev_article_uri_seg()
                ->get_next_article_uri_seg()
                ->get_venues()
                ->get_num_wishers()
                ->get_tags()
                ->get_related_articles();
        $this->user->get_favorite_ids();

        $data = array(
            'article' => $article,
            'user' => $this->user,
        );
        $this->load->view('feature', $data);
/*         echo '<pre>';print_r($article);echo '</pre>'; */
    }
    
    
    public function alt($uri_seg = NULL)
    {
        if ( ! $uri_seg)
        {
            redirect('/');
        }
        
        $article = new Article_m();
        $article->get_by_uri_seg($uri_seg);
        //check if article exists is active
        if ( ! $article->is_active)
        {
            custom_404();
            return;
        }
        
        $article->get_prev_article_uri_seg()
                ->get_next_article_uri_seg()
                ->get_venues()
                ->get_num_wishers()
                ->get_tags()
                ->get_related_articles();
        $this->user->get_favorite_ids();

        $data = array(
            'article' => $article,
            'user' => $this->user,
        );
        $this->load->view('feature3', $data);
    }
}

/* End of file feature.php */
/* Location: ./application/controllers/feature.php */