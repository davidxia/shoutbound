<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sendgrid_email
{

    function send_mail($to_array, $subject, $html_body, $text_body,
                       $from='notifications@shoutbound.com')
    {
        $url = 'http://sendgrid.com/';
        $user = 'david@shoutbound.com';
        $pass = 'tEdRAmu6';

        $json_string = array(
            'to' => $to_array,
            'category' => 'test_category'
        );


        $params = array(
            'api_user'  => $user,
            'api_key'   => $pass,
            'x-smtpapi' => json_encode($json_string),
            'to'        => 'david@shoutbound.com',
            'subject'   => $subject,
            'html'      => $html_body,
            'text'      => $text_body,
            'from'      => $from,
        );

        $request =  $url.'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);

        // print everything out
        //print_r($response);
        
        // return the JSON response
        return $response;
    }
}