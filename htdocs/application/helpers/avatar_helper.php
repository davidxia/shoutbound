<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function save_fb_photo($user_id=NULL, $fbid=NULL, $size='large')
{
    if ( ! $fbid OR !$user_id)
    {
        return FALSE;
    }
    
    $fb_pic_url = 'https://graph.facebook.com/'.$fbid.'/picture?type='.$size;
    $tempFilePath = tempnam('/var/www/static/profile_pics', $user_id.'_');
    $fh = fopen($tempFilePath, 'w');
    
    $options = array(
        CURLOPT_FILE => $fh,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HEADER => FALSE,
        CURLOPT_FOLLOWLOCATION => TRUE,
        CURLOPT_MAXREDIRS => 5,
    );
    $curl = curl_init($fb_pic_url);
    curl_setopt_array($curl, $options);
    curl_exec($curl);
    curl_close($curl);
    fclose($fh);

    if (rename($tempFilePath, $tempFilePath.'.jpg'))
    {
        return basename($tempFilePath.'.jpg');
    }
    else
    {
        return FALSE;
    }
}

/* End of file avatar_helper.php */
/* Location: ./system/application/helpers/avatar_helper.php */