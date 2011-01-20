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
  
    <div id="nn-body" class="container_12">
        <div class="grid_4" id="trip-name" >
            <h1><?=$trip_data['name']?></h1>
        </div>
        <div class="grid_4" id="trip-creator">
            <h2>by <?=$trip_data['user_name']?></h2>
        </div>
        <div class="grid_4" id="share-trip">
            <? if($user['uid'] == $trip_user['uid']) { ?>
            <br />
            <a href="javascript: Share.showShareDialog();">Share this trip</a>
            <? } ?>
        </div>
        <div class="clear"></div>
        
        <div id="map-shell" class="grid_9">
            <div id="map-canvas"></div>
        </div>
        <div id="invited-friends" class="grid_3">
			<?=$this->load->view('trip_friends', $invited_uids)?>
		</div>
        <div class="clear"></div>
        
        <div id="console">

		
        <div id="list">
            
            <?=$this->load->view('trip_list', $list_data, true)?>
            
        </div>
        <div id="wall">
            
            <?=$this->load->view('trip_wall', $wall_data, true)?>
            
        </div>
      </div>
      
        <div id="foot">

        </div>
      

  </div>
    
   









</body> 
</html>