<?
$header_args = array(
    'js_paths'=>array(
        'js/trip/map.js',
        //'js/trip/list.js',
        'js/trip/yelp.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/trip/invite.js',
        'js/trip/create.js',
        'js/trip/delete.js'
    ),
    'css_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>


<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
    var baseUrl = "<?php echo site_url(""); ?>";
    var staticUrl = "<?php echo static_url(""); ?>";
    var tripid = <?php echo $trip['tripid']; ?>;
    
    Map.lat = <?php echo $trip['lat']; ?>;
    Map.lng = <?php echo $trip['lng']; ?>;
    Map.sBound = <?php echo $trip['sbound']; ?>;
    Map.wBound = <?php echo $trip['wbound']; ?>;
    Map.nBound = <?php echo $trip['nbound']; ?>;
    Map.eBound = <?php echo $trip['ebound']; ?>;
</script>

<?php echo $this->load->view('core_header_end'); ?>

<body>
  
    <?php echo $this->load->view('core_banner'); ?>
  
    <div id="div_to_popup"></div>
  
    <div id="main" class="container_12">
        <div class="grid_6 push_3" id="trip-name" >
            <?php echo $trip['name']?>
        </div>
        <div class="grid_3">
            <input type="text" size="60" id="trip-where"
            onkeyup="Map.geocode()"
            autocomplete="off"
            title="Type placename or address" />
            <?php if($user_type == 'planner'): ?>
            <button type="button" onclick="Map.save()">save location</button>
            <?php endif; ?>

    	    <ol id="suggest-list"></ol>
        </div>
        <div class="clear"></div>

        <div class="grid_3">
        
        <?php if($user_type == 'planner'): ?>
        <div id="share-trip">
            <a href="javascript: Share.showShareDialog();">share this trip</a>
        </div>        
        <div>
            <a href="javascript: Delete.deleteTrip(); ">delete trip</a>
        </div>
        <?php endif; ?>
        
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
            <div id="wall" class="grid_9 push_3">
                
                <div class="wall-text-input-wrap">
                    <input type="text" id="wall-text-input">
                    <button id="submit-wall">post</button>
                    <button id="submit-suggestion">search</button>
                </div>
                
                <ol id="trip-wall-suggest-list"></ol>
                <?php echo $this->load->view('trip_wall', $wall_data); ?>
            </div>
        </div>
      
        <div id="footer">

        </div>
    </div>
</body> 
</html>