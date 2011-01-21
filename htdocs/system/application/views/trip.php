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
        </div>
        
        <div class="clear"></div>
        <div id="trip-creator" class="grid_6 push_3">
            Created by <?=$trip_data['user_name']?>
        </div>
        <div class="clear"></div>

        <div class="grid_3">
        <div id="share-trip">
            <? if($user['uid'] == $trip_user['uid']) { ?>
                <a href="javascript: Share.showShareDialog();">share this trip</a>
            <? } ?>
        </div>
        <div id="invite-trip">
			<?=$this->load->view('trip_friends')?>
		</div>
		</div>     
        <div class="grid_9">
            <div id="map-shell">
                <div id="map-canvas"></div>
            </div>
        </div>
        <div class="clear"></div>
        
        <div id="console">
            <div id="list" class="grid_3">
                <?=$this->load->view('trip_list', $list_data, true)?>
            </div>
            <div id="wall" class="grid_9">
                <?=$this->load->view('trip_wall', $wall_data, true)?>
            </div>
        </div>
      
        <div id="foot">

        </div>
      

  </div>
    
   









</body> 
</html>