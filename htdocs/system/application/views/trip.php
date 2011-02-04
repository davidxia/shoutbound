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
    <?php if($trip['trip_startdate']){ ?>
        var tripStartDate = <?php echo $trip['trip_startdate']; ?>;
    <?php } ?>
    
    Map.lat = <?php echo $trip['lat']; ?>;
    Map.lng = <?php echo $trip['lng']; ?>;
    Map.sBound = <?php echo $trip['sbound']; ?>;
    Map.wBound = <?php echo $trip['wbound']; ?>;
    Map.nBound = <?php echo $trip['nbound']; ?>;
    Map.eBound = <?php echo $trip['ebound']; ?>;
</script>
<?php echo $this->load->view('core_header_end'); ?>



<body>

<div id="fb-root"></div>
<script>
    FB.init({ appId:'136139119767617', cookie:true, status:true, xfbml:true });
</script>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId: '136139119767617', status: true,
            cookie: true, xfbml: true
        });
    };
    (function() {
            var e = document.createElement('script'); e.async = true;
            e.src = document.location.protocol +
                '//connect.facebook.net/en_US/all.js';
            document.getElementById('fb-root').appendChild(e);
    }());

    function setStatus(){
        // check if user is logged in:
    	FB.getLoginStatus(function(response) {
    	    if (response.session) {
    			new_status = 'after watching the movie Sanctum, Im going cave diving! Yargh!';
    			FB.api(
    		        {
    				    method: 'status.set',
    				    status: new_status
    			    },
        		    function(response) {
        		        if (response == 0){
        					alert('Your facebook status not updated. Give Status Update Permission.');
        				} else{
        					alert('Your facebook status updated');
        				}
        		    }
    			);
    	    } else {
    			alert('please log in first');
    	    }
        });
    }
</script>

    <?php echo $this->load->view('core_banner'); ?>
  
    <div id="div_to_popup"></div>
  
    <div id="main" class="container_12">
        <div class="grid_6 push_1" id="trip-name" >
            <?php echo $trip['name']?>
        </div>
        <div class="grid_3">

        </div>
        <div class="clear"></div>

        <div class="grid_3">
            
            <?php if($trip['trip_startdate']){ ?>
                When: <span id="trip-local-start-date"><script type="text/javascript">convertUnixTime();</script></span></br></br>
                <span id="years"><script type="text/javascript">countdown();</script></span>
                <span id="days"><script type="text/javascript">countdown();</script></span>
                <span id="hours"><script type="text/javascript">countdown();</script></span> 
                <span id="minutes"><script type="text/javascript">countdown();</script></span>
                <span id="seconds"><script type="text/javascript">countdown();</script></span>
                </br>
            <?php } else { ?>
                When: no date set yet
            <?php } ?>
        
        <?php if($user_type == 'planner'):
            // date selection dropdowns
            $months = array("January", "February", "March",
                             "April", "May", "June", "July",
                             "August", "September", "October",
                             "November", "December");
            $days = range(1, 31);
            $years = range(2011, 2020);
            $hours = range(0, 60);
            $minutes = range(0, 60);
            
            echo '<select id="trip-start-month">';
            foreach($months as $month) {
                echo '<option>'.$month.'</option>';
            }
            echo '</select>';
            
            echo '<select id="trip-start-day">';
            foreach($days as $day) {
                echo '<option>'.$day.'</option>';
            }
            echo '</select>';
            
            echo '<select id="trip-start-year">';
            foreach($years as $year) {
                echo '<option>'.$year.'</option>';
            }
            echo '</select>';
            
            echo '<select id="trip-start-hour">';
            foreach($hours as $hour) {
                echo '<option>'.$hour.'</option>';
            }
            echo '</select>';
            
            echo '<select id="trip-start-minute">';
            foreach($minutes as $minute) {
                echo '<option>'.$minute.'</option>';
            }
            echo '</select>';
        ?>
        <button type="button" onclick="saveTripDate()">save when</button> 
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
            <a href="#" onclick='setStatus(); return false;'>publish to facebook</a>
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