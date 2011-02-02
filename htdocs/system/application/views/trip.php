<?
$header_args = array(
    'js_paths'=>array(
        'js/trip/map.js',
        'js/trip/yelp.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/trip/invite.js',
        'js/trip/create.js',
        'js/trip/delete.js',
        'js/trip/extras.js'
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
    var when = "<?php echo $trip['when']; ?>";
    
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

        </div>
        <div class="clear"></div>

        <div class="grid_3">
        When: <?php echo $trip['when']; ?></br></br>
        Only
        <span id="years"><script language="javascript">countdown();</script></span>
        <span id="days"><script language="javascript">countdown();</script></span>
        <span id="hours"><script language="javascript">countdown();</script></span> 
        <span id="minutes"><script language="javascript">countdown();</script></span>
        and <span id="seconds"><script language="javascript">countdown();</script></span>
        left</br>
        
        <?php if($user_type == 'planner'):
            // date selection dropdowns
            $months = array("January", "February", "March",
                             "April", "May", "June", "July",
                             "August", "September", "October",
                             "Novemeber", "December");
            $days = range(1, 31);
            $years = range(2011, 2020);
            
            echo '<select id="trip-when-month">';
            foreach($months as $month) {
                echo '<option>'.$month.'</option>';
            }
            echo '</select>';
            
            echo '<select id="trip-when-day">';
            foreach($days as $day) {
                echo '<option>'.$day.'</option>';
            }
            echo '</select>';
            
            echo '<select id="trip-when-year">';
            foreach($years as $year) {
                echo '<option>'.$year.'</option>';
            }
            echo '</select>';
        ?>
        <button type="button" onclick="saveWhen()">save when</button> 
        </br></br>
        <?php endif; ?>
        
        Where:
        <?php if($user_type == 'planner'): ?>
        <input type="text" size="40" id="trip-where"
        onkeyup="Map.geocode()"
        autocomplete="off"
        title="Type placename or address" />
        <button type="button" onclick="Map.save()">save where</button>
        <?php endif; ?>
	    <ol id="suggest-list"></ol>
        
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