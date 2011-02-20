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
        'js/trip/extras.js',
        'js/jquery/color.js',
        'js/jquery/scrollto.js'
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
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
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



        <div id="console">
            <div id="wall">
                <div id="wall_input_wrapper">
                    <div id="make_suggestion">Make a suggestion</div>
                    <div id="write_message">Write a message</div>
                    <div id="input_container">
                        <input type="radio" name="location_control" value="Search for a place" checked />Search for a place
                        <input type="radio" name="location_control" value="Drop your own pin" />Drop your own pin
                        <input type="text" id="location_search_box" autocomplete="off" title="Type in placename or address" />
                        near
                        <select>
                            <option value="Boston, MA">Boston, MA</option>
                            <option value="New York, NY">New York, NY</option>
                            <option value="Washington DC">Washington DC</option>
                            <option value="Miami, FL">Miami, FL</option>
                            <option value="other">other</option>
                        </select><br/>
                        <div id="auto_loc_list">
                            <ul id="location_autosuggest"></ul>
                        </div>
                        <div id="place_type_dropdown" class="hidden">
                            <span class="place_name"></span> is a:<br/>
                            <select>
                                <option value="restaurant">restaurant</option>
                                <option value="bar">bar</option>
                                <option value="park">park</option>
                                <option value="landmark">landmark</option>
                                <option value="store">store</option>
                                <option value="fucking cool place">fucking cool place</option>
                            </select>
                        </div>
                        <div id="place_good_for" class="hidden">
                            <span class="place_name"></span> is good for:<br/>
                            <select>
                                <option value="seeing new york like a local">seeing new york like a local</option>
                                <option value="burgers">burgers</option>
                            </select>
                        </div>
                        <br/>
                        <div id="comment_container" class="hidden">
                            <input type="text" id="comment_input" value="write a comment..."/>
                            <a id="submit-wall" class="hidden">Suggest</a>
                        </div>
                        <!--<button type="button" onclick="Map.save()">save where</button>
                	    
                        <button id="submit-wall">post</button>
                        <button id="submit-suggestion">search</button>-->
                    </div>
                </div>
                <ol id="trip-wall-suggest-list"></ol>

                <? $wall_view = array('wall_data' => $wall_data,
                                      'user_type' => $user_type,
                                     );
                                      
                   echo $this->load->view('trip_wall', $wall_view); ?>
            </div>
    
    
    		  
            <div id="map-shell">
                <div id="map-canvas"></div>
            </div>
        </div>
        
        
        
      
        <div id="footer"> </div>
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