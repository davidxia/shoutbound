<?
    $header_args = array();
    echo($this->load->view('core_header',$header_args));
?>    


</head> 
<body>
    <?
        $banner_args = array('user'=>$user);
        echo($this->load->view('core_banner',$banner_args));
    ?>
  
    <div id="nn-body">
        
        <?
            $sidebar_args = array(
                'user'=>$user,
                'trips'=>$trips,
            );
            echo($this->load->view('core_sidebar',$header_args));
        ?>
        
        <div id="nn-main">
        <ul>
            <?php foreach($trips as $trip):?>

                <li>
                    <a href=<?=site_url("trip/details/".$trip['tripid'])?>>Go to trip <?=$trip['name']?></a>
                </li>

            <?php endforeach;?>
        </ul>
        </div>
        
        <div class="clear-both"></div>
  </div>
    
   









</body> 
</html>