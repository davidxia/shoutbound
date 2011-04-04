<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FoursquareController extends CI_Controller
{

    public $foursquareObj;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('foursquare');
    }

    public function callback()
    {
      	// Please put in your keys here.
        //echo $_REQUEST['oauth_token']; echo '<br/><br/>';
      	$consumer_key = 'ALCPEQ3OQEJ2WHTJOAPL0YWWYB4KMFFFVK5WHDMIF0YMROYZ';
      	$consumer_secret = 'OZC0TGXEGSSPDBPWTCSKVUOZFF3B1JA1AOR3GF5DXM5AU34R';
        $foursquareObj = new $this->foursquare($consumer_key, $consumer_secret);
        //echo($_REQUEST['oauth_token']);
        $foursquareObj->setToken($_REQUEST['oauth_token'],$this->session->userdata('secret'));
        $token = $foursquareObj->getAccessToken();
        $foursquareObj->setToken($token->oauth_token, $token->oauth_token_secret);

        /*
        try
        {
            //Making a call to the API

            $history = $foursquareObj->get_history();
            $checkins = $history->response['checkins'];
            $number_of_checkins = count($checkins);
            
            echo "<p> Your total number of check ins is $number_of_checkins </p> ";
            echo "<p>";
            echo "<table border=\"1\" align=\"center\">";
            echo "<tr><th>Name</th>";
            echo "<th>Date</th>";
            echo "<th>Icon</th></tr>";
            
            for ( $counter = 0; $counter < $number_of_checkins; $counter += 1)
            {
                $checkin = $checkins[$counter];
                $checkin_venue = $checkin['venue'];
                $checkin_venue_name = $checkin_venue['name'];
                $checkin_date = $checkin['created'];
                $checkin_venue_pcategory = $checkin_venue['primarycategory'];
                $checkin_venue_pcategory_iconurl = $checkin_venue_pcategory['iconurl'];
            
                echo "<tr><td>";
                echo $checkin_venue_name;
                echo "</td><td>";
                echo $checkin_date;
                echo "</td><td>";
                echo "<img src=\"$checkin_venue_pcategory_iconurl\">";
                echo "</td></tr>";
            }
            echo "</table>";
            echo "</p>";
        }
        catch (Exception $e)
        {
            echo "Error: " . $e;
        }
        */
        $history = $foursquareObj->get_history();
        print_r($history);
        
  	}


    public function index()
    {
        try
        {
        // Please put in your keys here.
        $consumer_key = 'ALCPEQ3OQEJ2WHTJOAPL0YWWYB4KMFFFVK5WHDMIF0YMROYZ';
        $consumer_secret = 'OZC0TGXEGSSPDBPWTCSKVUOZFF3B1JA1AOR3GF5DXM5AU34R';
    
        $foursquareObj = new $this->foursquare($consumer_key, $consumer_secret);
        $results = $foursquareObj->getAuthorizeUrl();
    
        $loginurl = $results['url'] . "?oauth_token=" . $results['oauth_token'];
    
        $this->session->set_userdata('secret', $results['oauth_token_secret']);
        }
        catch (Execption $e)
        {
            //If there is a problem throw an exception
        }
    
        echo "<a href='" . $loginurl . "'>Login Via Foursquare</a>";
        //Display the Foursquare login link
        echo "<br/>";
    }

    
    public function test()
    {
        // Please put in your keys here.
        // oauth keys are for david@shoutbound.com on Foursquare
        $consumer_key = 'ALCPEQ3OQEJ2WHTJOAPL0YWWYB4KMFFFVK5WHDMIF0YMROYZ';
        $consumer_secret = 'OZC0TGXEGSSPDBPWTCSKVUOZFF3B1JA1AOR3GF5DXM5AU34R';
        $oauth_token = 'GS2KZJURCFBYBYOGXAWI2JMKTXKAXCL44NIJZ5KHOFE4RAG5';
        $oauth_token_secret = 'IQSJWRUGECBF40RPX0PFJAROATZKAV2YQFXUCMOURELFBQIK';
        
        $foursquareObj = new $this->foursquare($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
        $history = $foursquareObj->get_history();
        $checkins = $history->response['checkins'];
        
        foreach ($checkins as $checkin)
        {
            echo $checkin['venue']['name'].' '.
                $checkin['created'].' '.
                $checkin['venue']['geolat'].' '.
                $checkin['venue']['geolong'].'<br/><br/>';
        }
        
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/home.php */