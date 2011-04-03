<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Altitoid extends CI_Controller
{
    
    public $user;

    function __construct()
    {
        parent::__construct();
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ($uid)
        {
            $u->get_by_id($uid);
            $this->user = $u->stored;
        }
    }


    function index()
    {
        $up = new Upload();
        $up->get();
        
        $uploads = array();
        foreach ($up as $upload)
        {
            $uploads[] = $upload->stored;
        }
        
        $view_data = array(
            'user' => $this->user,
            'uploads' => $uploads,
        );
        
        $this->load->view('altitoid', $view_data);
    }
    
        
    function uploadify()
    {
        if ( ! empty($_FILES)) {
        	$tempFile = $_FILES['Filedata']['tmp_name'];
        	list($width, $height, $type, $attr) = getimagesize($_FILES['Filedata']['tmp_name']);
        	
          $path = explode('/',__FILE__);
        	$targetPath = $_SERVER['DOCUMENT_ROOT'].'/'.$path[2].'/images/uploads/';
        	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];

      		$up = new Upload();
      		$up->user_id = $this->input->post('uid');
      		$up->path = $_FILES['Filedata']['name'];
      		$up->width = $width;
      		$up->height = $height;
      		$up->save();

        	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
        	// $fileTypes  = str_replace(';','|',$fileTypes);
        	// $typesArray = split('\|',$fileTypes);
        	// $fileParts  = pathinfo($_FILES['Filedata']['name']);
        	
        	// if (in_array($fileParts['extension'],$typesArray)) {
        		// Uncomment the following line if you want to make the directory if it doesn't exist
        		// mkdir(str_replace('//','/',$targetPath), 0755, true);
        		
        		move_uploaded_file($tempFile,$targetFile);
        		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);

        	// } else {
        	// 	echo 'Invalid file type.';
        	// }
        }
    }
}

/* End of file altitoid.php */
/* Location: ./application/controllers/altitoid.php */