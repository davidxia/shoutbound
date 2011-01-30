<?
$header_args = array(
    'js_paths'=>array(
        'js/trip/map.js',
        'js/trip/list.js',
        'js/trip/yelp.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/trip/invite.js',
        'js/trip/create.js',
    ),
    'css_paths'=>array(
        'css/trip.css',
        'css/grid.css',
    )
);

$this->load->view('core_header', $header_args);

$latlngbounds = explode(" ", $trip['latlngbounds']);
$mapcenter = explode(" ", $trip['map_center']);
?>

<script type="text/javascript">
    var tripid = <?php echo $trip['tripid']; ?>;
    
    Map.lat = <?php echo $mapcenter[0] ?>;
    Map.lng = <?php echo $mapcenter[1]; ?>;
    Map.sBound = <?php echo $latlngbounds[0]; ?>;
    Map.wBound = <?php echo $latlngbounds[1]; ?>;
    Map.nBound = <?php echo $latlngbounds[2]; ?>;
    Map.eBound = <?php echo $latlngbounds[3]; ?>;
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
            onkeyup="geocode()"
            autocomplete="off"
            title="Type placename or address" />
            <button type="button" onclick="save()">save location</button>

    	    <ol id="suggest-list"></ol>
        </div>
        <div class="clear"></div>

        <div class="grid_3">
        <div id="share-trip">
            <? if($user_type == 'planner'): ?>
                <a href="javascript: Share.showShareDialog();">share this trip</a>
            <? endif; ?>
        </div>
        <div>
            <a href="<?php echo site_url('trip/delete/'.$trip['tripid']); ?>">delete trip</a>
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
                <div id="trip-list-body">

                    <div>suggest something</div>
                    <div id="trip-wall-control-suggest-edit">
                        <form name="suggestion">

                            <div class="suggestion-input-wrap">
                                <input id="term" class="suggestion-input">
                                <button id="submit-suggestion">search</button>
                            </div>
                        </form>
                        <ol id="trip-wall-suggest-list"></ol>
                    </div>

                </div>

            </div>
            
            <div id="wall" class="grid_9">
                <?php echo $this->load->view('trip_wall', $wall_data); ?>
            </div>
        </div>
      
        <div id="footer">

        </div>
    </div>
</body> 
</html>