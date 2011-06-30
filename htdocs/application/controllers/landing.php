<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller
{

    public function index()
    {
      	$session_id = $this->session->userdata('session_id');
      	
      	$data = array(
            'session_id' => $session_id,
      	);

      	$this->load->view('landing', $data);
    }
    
    
    public function sendgrid_test()
    {
        // Sendgrid params
        $sendgrid_url = 'http://sendgrid.com/api/mail.send.json';
        $sendgrid_user = 'david@shoutbound.com';
        $sendgrid_pw = 'tEdRAmu6';
        $emails = array('david@shoutbound.com', 'james@shoutbound.com', 'david.xia2@gmail.com');

        $json_string = array(
            'to' => $emails,
            'category' => 'testing_sendgrid',
        );
        $params = array(
            'api_user'  => $sendgrid_user,
            'api_key'   => $sendgrid_pw,
            'x-smtpapi' => json_encode($json_string),
            'to'        => 'david@shoutbound.com',
            'subject'   => 'testing stuff',
            'html'      => 'this is a test of sendgrids <a href="http://www.shoutbound.com">link</a> tracking',
            'text'      => 'this is a test of sendgrids <a href="http://www.shoutbound.com">link</a> tracking',
            'from'      => 'hello@shoutbound.com',
            'fromname'  => 'Shoutbound',
            'replyto'   => 'noreply@shoutbound.com',
        );

        $ch = curl_init($sendgrid_url);
        curl_setopt ($ch, CURLOPT_POST, TRUE);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $r = curl_exec($ch);
        curl_close($ch);
        // return Sendgrid's JSON response
        var_dump($r);
    }
    
}

/* End of file landing.php */
/* Location: ./application/controllers/landing.php */