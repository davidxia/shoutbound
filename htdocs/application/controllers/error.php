<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller
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
		}
		

  	public function error_404()
  	{
        custom_404();
        return;
  	}
  	
  	
  	public function bug_report()
  	{
        $bug_report = trim($this->input->post('bug-report'));
        if ( ! $bug_report)
        {
            redirect('/');
        }
        
        if ( ! $this->user)
        {
           $this->user = new User_m();
           $this->user->id = 0;
           $this->user->name = 'anonymous user';
        }
        
        $params = array('email_type' => 99);
        $this->load->library('sendgrid', $params);
        $this->sendgrid->get_emails();
        $this->sendgrid->compose_email($this->user, $bug_report);
        if ($this->sendgrid->send_email())
        {
            json_success(array());
        }
        else
        {
            json_error();
        }
        //redirect('/');
  	}
}


/* End of file error.php */
/* Location: ./application/controllers/error.php */