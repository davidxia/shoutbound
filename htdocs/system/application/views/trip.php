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

<!--IS THIS JAVASCRIPT??-->
<script>
    Constants.Trip = {};
    Constants.Trip['id'] = "<?=$trip['tripid']?>";
</script>

<?php echo $this->load->view('core_header_end'); ?>



<body>
  
    <?php echo $this->load->view('core_banner'); ?>
  
    <div id="div_to_popup"></div>
  
    <div id="main" class="container_12">
        <div class="grid_6 push_3" id="trip-name" >
            <?php echo $trip['name']?>
        </div>
        
        <div class="clear"></div>

        <div class="grid_3">
        <div id="share-trip">
            <? if($user_type == 'planner'): ?>
                <a href="javascript: Share.showShareDialog();">share this trip</a>
            <? endif; ?>
        </div>
        <div id="invite-trip">
			<?php echo $this->load->view('trip_friends'); ?>
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
                <?php echo $this->load->view('trip_list', $list_data); ?>
            </div>
            <div id="wall" class="grid_9">
                <?php echo $this->load->view('trip_wall', $wall_data); ?>
            </div>
        </div>
      
        <div id="foot">

        </div>
      

  </div>


</body> 
</html>