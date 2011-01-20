<!-- HEADER -->
<?
$header_args = array(
    'js_paths'=>array(
        'js/trip/trip.js',
        'js/trip/list.js',
        'js/trip/yelp.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/trip/invite.js',
    ),
    'css_paths'=>array(
        'css/trip.css',
        'css/grid.css',
    )
);

$this->load->view('core_header', $header_args);

?>

<script>
    Constants.Trip = {};
    Constants.Trip['id'] = "<?=$trip_data['id']?>";
</script>

<?=$this->load->view('core_header_end')?>



<body>
  
    <?
        $banner_args = array('user'=>$user);
        echo($this->load->view('core_banner',$banner_args));
    ?>
  
    <div id="div_to_popup"></div>
  
    <div id="body" class="container_12">
        <div class="grid_6 push_3" id="trip-name" >
            <?=$trip_data['name']?>
            <div id="trip-creator">
                Created by <?=$trip_data['user_name']?>
            </div>
        </div>

        <? if($user['uid'] == $trip_user['uid']) { ?>
        <div class="grid_3 push_3" id="share-trip">
            <br />
            <a href="javascript: Share.showShareDialog();">share this trip</a>
        </div>
        <? } ?>
        <div class="clear"></div>

        <div id="invited-friends" class="grid_3">
			<?=$this->load->view('trip_friends')?>
		</div>       
        <div class="grid_9">
            <div id="map-shell">
                <div id="map-canvas"></div>
            </div>
        </div>
        <div class="clear"></div>
        
        <div id="console" class="grid_12">
            <div id="list" class="grid_3">
                <?=$this->load->view('trip_list', $list_data, true)?>
            </div>
            <div id="wall" class="grid_8">
                <?=$this->load->view('trip_wall', $wall_data, true)?>
            </div>
        </div>
      
        <div id="foot">

        </div>
      

  </div>
    
   









</body> 
</html>