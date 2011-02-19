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
    var baseUrl = "<?=site_url("")?>";
    var staticUrl = "<?=static_url("")?>";
    var tripid = <?=$trip['tripid']?>;
    <? if($trip['trip_startdate']){ ?>
        var tripStartDate = <?=$trip['trip_startdate']?>;
    <? } ?>
    var uid = <?=$this->user['uid']?>;
    var fid = <?=$this->user['fid']?>;
    
    Map.lat = <?=$trip['lat']?>;
    Map.lng = <?=$trip['lng']?>;
    Map.sBound = <?=$trip['sbound']?>;
    Map.wBound = <?=$trip['wbound']?>;
    Map.nBound = <?=$trip['nbound']?>;
    Map.eBound = <?=$trip['ebound']?>;
</script>

<meta name="title" content="<?=$trip['name']?>" />
<meta name="description" content="<?=$trip['name']?>" />
<?=$this->load->view('core_header_end')?>



<body>

    <?=$this->load->view('core_banner')?>
  
    <div id="div_to_popup"></div>
  
    <div id="main" class="container_12">
        <div id="top_container2"><div id="top_container1">
            <div id="trip_summary">
                <div id="trip_name" >
                    <?=$trip['name']?>
                </div>
                <div id="trip_creator">
                    created by John Smith
                </div>
                <div id="trip_description">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
                <div id="trip_goers">
                    <? if($trip_goers):?>
                        <? foreach($trip_goers as $trip_goer):?>
                            <div class="trip_goer" uid="<?=$trip_goer['uid']?>">
                                <img class="square-50" src="http://graph.facebook.com/<?=$trip_goer['fid']?>/picture?type=square" />
                                <? //$trip_goer['name']?>
                            </div>
                        <? endforeach; ?>
                    <? endif; ?>
                    
                    <span id="num_trip_goers">
                        <? if(count($trip_goers) == 1):?>
                            <span id="num"><?=count($trip_goers)?></span> person is in
                        <? else:?>
                            <span id="num"><?=count($trip_goers)?></span> people are in
                        <? endif;?>
                    </span>
                </div>
                <div id="trip_places">
                    Boston, MA<br/>
                    New York, NY<br/>
                    Washington DC<br/>
                    Miami, FL<br/>
                </div>
                <div id="trip_start_times">
                    March 2-11, 2011<br/>
                    March 12-14, 2011<br/>
                    March 15-19, 2011<br/>
                    March 20-21, 2011<br/>
                </div>
                <div id="need_advice_on">
                    Interested in:<br/>
                    <span class="indented">hiking, exploring, seeing New York like a local</span><br/>
                    Want suggestions for:<br/>
                    <span class="indented">Accommodations, landmarks, restaurants</span>
                </div>
            
            
            </div>
            <div id="trip_widget">
            <? if($user_type == 'planner'):?>
                <span id="rsvp_status">
                <? if($user_rsvp == 'awaiting'):?>
                    You're invited
                <? elseif($user_rsvp == 'yes'):?>
                    You're in
                <? elseif($user_rsvp == 'no'):?>
                    You're out, but you can still change your mind
                <? endif; ?>
                </span>
                
                <? if($user_rsvp == 'awaiting'):?>
                <div id="rsvp_buttons">
                    <a href="#" id="rsvp_yes_button">I'm in</a>
                    <a href="#" id="rsvp_no_button">I'm out</a>
                </div>
                <? elseif($user_rsvp == 'yes'):?>
                <div id="rsvp_buttons" class="moved">
                    <div id="invsugg_btn_cont">
                        <div id="invite_others_button">invite other people</div>
                        <div id="get_suggestions_button">get more suggestions</div>
                    </div>
                    <a href="#" id="rsvp_no_button">I'm out</a>
                </div>
                <? elseif($user_rsvp == 'no'):?>
                <div id="rsvp_buttons">
                    <a href="#" id="rsvp_yes_button">I'm in</a>
                </div>
                <? endif; ?>
            <? endif;?>
            </div>
        </div></div>

        <div class="clear"></div>

        <div class="grid_3">
        
            <br/>
            
            <br/>
            
            <? if($trip['trip_startdate']){ ?>
                When: <span id="trip-local-start-date">
                    <script type="text/javascript">convertTripStartTime();</script>
                    </span><br/><br/>
                <span id="years"><script type="text/javascript">countdown();</script></span>
                <span id="days"></span>
                <span id="hours"></span> 
                <span id="minutes"></span>
                <span id="seconds"></span>
                <br/>
            <? } else { ?>
                When: no date set yet
            <? } ?>
        
        <? if($user_type == 'planner'):
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
        <br/><br/>
        <? endif; ?>
        
        Where:
            <? if($user_type == 'planner'):?>
            <input type="text" size="40" id="trip-where"
            onkeyup="Map.geocode()"
            autocomplete="off"
            title="Type placename or address" />
            <button type="button" onclick="Map.save()">save where</button>
            <? endif; ?>
    	    <ol id="suggest-list"></ol>
        
        <? if($user_type == 'planner'): ?>
        <div id="share-trip">
            <a href="javascript: Share.showShareDialog();">share this trip</a>
        </div>
        <a href="#" onclick="facebookShare()">Facebook</a>
        <br/>
        <a href="#" onclick="twitterShare('Help me plan my <?=$trip['name']; ?> trip on #shoutbound <?=site_url('trip/details').'/'.$trip['tripid']; ?>')">Twitter</a>
        <br/>
        <!--<a href="#" onclick='setFBStatus(); return false;'>publish to facebook</a>
        <br/>-->
        <a href="mailto:?subject=<?=rawurlencode('Help me plan my '.$trip['name'].' trip'); ?>&body=<?=rawurlencode('Hey, I\'m going to '.$trip['name'].' from '.$trip['trip_startdate'].' to... Help me plan my trip here: '.site_url('trip/details').'/'.$trip['tripid']); ?>">Email</a>
        <div>
            <a href="javascript: Delete.deleteTrip(); ">delete trip</a>
        </div>
        <? endif; ?>
        
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
            <div id="wall" class="grid_9 push_3">
                
                <div class="wall-text-input-wrap">
                    <input type="text" id="wall-text-input">
                    <button id="submit-wall">post</button>
                    <button id="submit-suggestion">search</button>
                </div>
                
                <ol id="trip-wall-suggest-list"></ol>
                <? $wall_view = array('wall_data' => $wall_data,
                                      'user_type' => $user_type,
                                     );
                                      
                   echo $this->load->view('trip_wall', $wall_view); ?>
            </div>
        </div>
      
        <div id="footer">

        </div>
    </div>


<script type="text/javascript">
    // output wall markers to page so Map.display_wall_markers function can display them once google map loads
    // only put a comma after each item in the array if it's not the last one
    // TODO: is there a better way to do the comma thing?
    Wall.wall_markers = [
        <? for($i=0, $count=count($location_based_items); $i<$count; $i++): ?>
            {"itemid": <?=$location_based_items[$i]['itemid']?>, "lat": <?=$location_based_items[$i]['lat']?>, "lng": <?=$location_based_items[$i]['lng']?>}
            <? if($i < $count-1): ?>
                ,
            <? endif; ?>
        <? endfor; ?>
    ];
</script>
</body> 
</html>