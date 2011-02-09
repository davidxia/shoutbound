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

<meta name="title" content="<?php echo $trip['name']; ?>" />
<meta name="description" content="<?php echo $trip['name']; ?>" />
<?php echo $this->load->view('core_header_end'); ?>



<body>

<!--<div id="fb-root"></div>
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
</script>-->

    <?php echo $this->load->view('core_banner'); ?>
  
    <div id="div_to_popup"></div>
  
    <div id="main" class="container_12">
        <div class="grid_6 push_1" id="trip-name" >
            <?php echo $trip['name']?>
        </div>
        <div class="clear"></div>

        <div class="grid_3">
        
            <span id="rsvp_status"><?php 
                if($user_rsvp == 'yes'){ echo "I'm in"; }
                elseif($user_rsvp == 'awaiting'){ echo "I still have to decide"; }
                elseif($user_rsvp == 'no'){ echo "I'm missing out"; }
            ?></span>
            <br/>
            
            <span id="rsvp_button">
            <?php if($user_rsvp != 'yes' && $user_type == 'planner'){ ?>
                <a href="#" onclick="Invite.joinTrip(<?php echo $user['uid']; ?>);">Count me in</a><br/>
            <?php } elseif($user_rsvp == 'yes' && $user_type == 'planner'){ ?>
                <a href="#" onclick="Invite.leaveTrip(<?php echo $user['uid']; ?>);">I'm lame and can't go :(</a><br/>
            <?php } ?>
            </span>
            <br/>
            
            <?php if($trip['trip_startdate']){ ?>
                When: <span id="trip-local-start-date">
                    <script type="text/javascript">convertTripStartTime();</script>
                    </span></br></br>
                <span id="years"><script type="text/javascript">countdown();</script></span>
                <span id="days"></span>
                <span id="hours"></span> 
                <span id="minutes"></span>
                <span id="seconds"></span>
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
            $hours = range(0, 23);
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
        <a href="#" onclick="facebookShare()">Facebook</a>
        <br/>
        <a href="#" onclick="twitterShare('Help me plan my <?php echo $trip['name']; ?> trip on #shoutbound <?php echo site_url('trip/details').'/'.$trip['tripid']; ?>')">Twitter</a>
        <br/>
        <!--<a href="#" onclick='setFBStatus(); return false;'>publish to facebook</a>
        <br/>-->
        <a href="mailto:?subject=<?php echo rawurlencode('Help me plan my '.$trip['name'].' trip'); ?>&body=<?php echo rawurlencode('Hey, I\'m going to '.$trip['name'].' from '.$trip['trip_startdate'].' to... Help me plan my trip here: '.site_url('trip/details').'/'.$trip['tripid']); ?>">Email</a>
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
                <?php
                    $wall_view = array('wall_data' => $wall_data,
                                       'user_type' => $user_type,
                                      );
                                      
                    echo $this->load->view('trip_wall', $wall_view); ?>
                <?php //print_r($wall_view); ?>
            </div>
        </div>
      
        <div id="footer">

        </div>
    </div>
</body> 
</html>