<?
$header_args = array(
    'js_paths'=>array(
        //'js/jquery/popup.js',
        'js/trip/map.js',
        //'js/trip/yelp.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/trip/invite.js',
        //'js/trip/create.js',
        'js/trip/delete.js',
        'js/trip/extras.js',
        'js/jquery/color.js',
        'js/jquery/scrollto.js'
    ),
    'css_paths'=>array(
        'css/common.css'
    )
);

$this->load->view('core_header', $header_args);
?>


<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
    var baseUrl = "<?=site_url("")?>";
    var staticUrl = "<?=static_url("")?>";
    var tripid = <?=$trip->id?>;
    <? if ($trip->trip_startdate):?>
        var tripStartDate = <?=$trip->trip_startdate?>;
    <? endif; ?>
    <? if ($user):?>
        var uid = <?=$user->id?>;
        var fid = <?=$user->fid?>;
    <? endif;?>
    
    Map.lat = <?=$trip->lat?>;
    Map.lng = <?=$trip->lng?>;
    Map.sBound = <?=$trip->sbound?>;
    Map.wBound = <?=$trip->wbound?>;
    Map.nBound = <?=$trip->nbound?>;
    Map.eBound = <?=$trip->ebound?>;
</script>

<style type="text/css">
  #invite-others-button{
    display: inline-block;
    font-size: 0.75em;
    background: #2B72CC url(/david/static/images/blueButton.png) repeat-x 0 0;
    height: 40px;
  }
  #invite-others-button:hover{
    background: url(/david/static/images/blueButton.png) repeat-x 0 -40px;
  }
  #invite-others-button:active{
    background: url(/david/static/images/blueButton.png) repeat-x 0 -80px;
  }
  #get-suggestions-button{
    display: inline-block;
    font-size: 0.75em;
    background: #2B72CC url(/david/static/images/blueButton.png) repeat-x 0 0;
    height: 40px;
  }
  #get-suggestions-button:hover{
    background: url(/david/static/images/blueButton.png) repeat-x 0 -40px;
  }
  #get-suggestions-button:active{
    background: url(/david/static/images/blueButton.png) repeat-x 0 -80px;
  }
  .moved{
    text-align: right;
  }
  #share-trip {
    font-size: 1.5em;
    margin-top: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #EDEDED;
  }
  #share-trip a:link {
    text-decoration: none;
  }
#make-suggestion:hover, #write-message:hover{
    text-decoration: underline;
}
#input-container{
    border: 1px solid black;
    float: left;
    position: relative;
    display: inline;
    width: 99.5%;
}
#location-autosuggest{
    text-align: left;
    padding-left: 12px;
}
#place-type-dropdown{
    float: left;
    position: relative;
    margin-top: 20px;
    margin-left: 10px;
    text-align: left;
    width: 95%;
}
#place-good-for{
  float: left;
  margin-left: 10px;
  margin-top: 20px;
  text-align: left;
  width: 95%;
}
#comment-container{
  position: relative;
  float: left;
  margin-left: 10px;
  margin-top: 20px;
  margin-bottom: 20px;
  width: 95%;
  text-align: left;
}
#comment-input{
  width: 96%;
}
#submit-wall{
  float: right;
  border: 1px solid black;
}
#auto-loc-list ul li a{
  display: block;
  text-decoration: none;
  color: #000000;
  line-height: 1.5em;
  border-bottom: 1px solid #CCCCCC;
  padding-left: 10px;
  cursor: pointer;
}
#auto-loc-list ul li a:hover{
  background-color: #E0E0FF;
}

#wall-text-input {
  width: 50%;
}
.infowindow-text{
  font-size: .75em;
}
#wall-content {
  overflow-y: auto;
  overflow-x: hidden;
  height: 541px;
  padding: 20px 10px 0px 10px;
  background-color: #CCFFCC;
}
li.location-based {
  cursor: pointer;
  background: white;
  -webkit-transition: background-color linear .2s;
  -moz-transition: background-color linear .2s;
  -o-transition: background-color linear .2s;
  transition: background-color linear .2s;
}
li.location-based:hover{
  background: #EAEAEA;
	-webkit-transition: background-color linear .2s;
	-moz-transition: background-color linear .2s;
  -o-transition: background-color linear .2s;
  transition: background-color linear .2s;
}
li.location-based.highlighted{
  background: #EAEAEA;
	-webkit-transition: background-color linear .2s;
	-moz-transition: background-color linear .2s;
  -o-transition: background-color linear .2s;
  transition: background-color linear .2s;
}
.remove-wall-item {
  display: inline-block;
  background-image: url(/david/static/images/delete_button.png);
  height: 17px;
  width: 17px;
  opacity: 0;
  cursor: pointer;
}
.remove-wall-item:hover {
  opacity: 1;
}
#map-shell {
  font-size: 14px;
}
#map-shell input {
  padding: 4px;
  font-size: 14px;
  width: 200px;
}

</style>


<?=$this->load->view('core_header_end')?>



<body>
  <!-- WRAPPER -->
  <div id="wrapper" style="margin: 0 auto; width:960px;">
    <?=$this->load->view('header')?>



    <!-- MAIN -->
    <div id="main">
        
          <!-- TRIP SUMMARY -->
          <div id="trip_summary" style="width:700px; background-color:#FFCCCC; float:left; padding:10px 10px 20px 10px;">
            <div id="trip_name" style="font-size:1.5em;font-weight: bold;">
              <?=$trip->name?>
            </div>
            <div id="trip_creator" style="font-size: 0.75em; border-bottom: 1px solid black;">
              created by John Smith
            </div>
            <div id="trip_description" style="border-bottom: 1px solid black;">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </div>
            <!-- TRIP GOERS -->
            <div id="trip_goers" style="border-bottom: 1px solid black;">
              <? if ($trip_goers):?>
                <? foreach ($trip_goers as $trip_goer):?>
                  <div class="trip_goer" uid="<?=$trip_goer->id?>" style="display:inline-block;">
                    <img class="square-50" src="http://graph.facebook.com/<?=$trip_goer->fid?>/picture?type=square" />
                  </div>
                <? endforeach;?>
              <? endif;?>
              <span id="num_trip_goers">
                <? if (count($trip_goers) == 1):?>
                  <span id="num"><?=count($trip_goers)?></span> person is in
                <? else:?>
                  <span id="num"><?=count($trip_goers)?></span> people are in
                <? endif;?>
              </span>
            </div><!-- TRIP GOERS ENDS -->
            
            <div id="trip-places" style="width:20%; display:inline-block; float:left; font-size:0.75em;">
              Boston, MA<br/>
              New York, NY<br/>
              Washington DC<br/>
              Miami, FL<br/>
            </div>
            <div id="trip-start-times" style="width:20%; display:inline-block; float:left; font-size:0.75em;">
              March 2-11, 2011<br/>
              March 12-14, 2011<br/>
              March 15-19, 2011<br/>
              March 20-21, 2011<br/>
            </div>
            <div id="need-advice-on" style="width:60%; display:inline-block; float:left; font-size:0.75em;">
              Interested in:<br/>
              <span style="padding-left: 20px;">hiking, exploring, seeing New York like a local</span><br/>
              Want suggestions for:<br/>
              <span style="padding-left: 20px;">Accommodations, landmarks, restaurants</span>
            </div>
          </div><!-- TRIP SUMMARY ENDS -->
            
            
            
            <!-- WIDGET -->
            <div id="trip-widget" style="width:220px; background-color:#CCCCFF; float:left; padding:10px 10px 0px;">
              <? if ($user_role == 2):?>
                <span id="rsvp_status">
                <? if ($user_rsvp == 2):?>
                    You're invited
                <? elseif ($user_rsvp == 3):?>
                    You're in
                <? elseif ($user_rsvp == 1):?>
                    You're out, but you can still change your mind
                <? endif;?>
                </span>
                  
                <? if ($user_rsvp == 2):?>
                <div id="rsvp_buttons">
                    <a href="#" id="rsvp_yes_button">I'm in</a>
                    <a href="#" id="rsvp_no_button">I'm out</a>
                </div>
                <? elseif ($user_rsvp == 3):?>
                <div id="rsvp_buttons" class="moved">
                    <div id="invsugg_btn_cont">
                        <div id="invite-others-button">
                            <a href="#" id="invite-others-link">invite other people</a>
                        </div>
                        <div id="get-suggestions-button">
                            <a href="#" id="get-suggestions-link">get more suggestions</a>
                        </div>
                    </div>
                    <a href="#" id="rsvp_no_button">I'm out</a>
                </div>
                <? elseif ($user_rsvp == 1):?>
                <div id="rsvp_buttons">
                    <a href="#" id="rsvp_yes_button">I'm in</a>
                </div>
                <? endif;?>
              <? endif;?>
            </div><!-- WIDGET ENDS -->
        
        <div style="clear:both;"</div>

        <!-- CONSOLE -->
        <div id="console">
          <!-- WALL -->
          <div id="wall" style="float:left; width:40%; height: 650px;">
            <!-- WALL INPUT CONTAINER -->
            <div id="wall-input-container" style="padding:10px;">
              <textarea id="message-box" style="width:340px; height:15px;">Write a message</textarea>
              
              <!-- LOCATION SEARCH -->
              <div id="location-search" style="display:none; position:relative;">
                Location
                <input type="text" id="location-search-box" size="39" />
                <!-- AUTO LOC LIST -->
                <div id="auto-loc-list" style="position:absolute; top:60px; left:0px; background:white; opacity:0.8; width:350px;">
                  <ul id="location_autosuggest"></ul>
                  <div id="place-type-dropdown" style="display:none;"></div>
                </div><!-- AUTO LOC LIST ENDS -->
                <div id="marker-notification" style="position:absolute; top:-40px; right:-480px; z-index:1000; display:none; color:white; background-color:black; opacity:0.8; -moz-box-shadow: 2px 2px 5px black; -webkit-box-shadow: 2px 2px 5px black; box-shadow: 2px 2px 5px black; padding:15px;">You can drag and drop the pin anywhere you want.</div>
                
              </div><!-- LOCATION SEARCH ENDS -->
              
              <div id="link-input" style="display:none;">
                Link
                <input type="text" id="link-input-box" size="39" value="http://" />
              </div>
              
              <div id="wall-post-button" style="padding-left:330px; display:none;"><a href="#" style="text-decoration:none;">Post</a></div>
              
            </div><!-- WALL INPUT CONTAINER -->

            <!-- WALL CONTENT -->
            <ul id="wall-content">
              <? if ($wall_items):?>
                <? foreach ($wall_items as $wall_item):?>
                  <? if ($wall_item->is_location):?>
                    <li id="wall-item-<?=$wall_item->id?>" class="location-based" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA;">
                      <div class="wall-location-name"style="font-weight:bold;"><?=$wall_item->name?></div>
                      <div>Suggested by <a href="#" class="wall-comment-author" style="text-decoration:none;"><?=$wall_item->user_name?></a></div>
                      <span class="wall-location-address" style="display:none;"><?=$wall_item->address?></span>
                      <span class="wall-location-phone" style="display:none;"><?=$wall_item->phone?></span>
                      
                      Accomodation, landmark, restaurant<br/>
                      Good for: seeing new york like a local, food, burgers<br/>
                      <div class="rating-panel">
                        Like Dislike
                      </div>
                      <? if ($user_role == 2):?>
                        <div class="remove-wall-item" itemid="<?=$wall_item->id?>"></div>
                      <? endif;?>
                      <? if ($wall_item->text):?>
                        <br/>
                        <?=$wall_item->text?>
                      <? endif;?>
                      <span class="wall-timestamp" style="color:#777; font-size: 12px;"><?=$wall_item->created?></span>
                    </li>
                  <? else:?>
                    <li id="wall-item-<?=$wall_item->id?>" class="" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA;">
                      <a href="#"><img src="http://graph.facebook.com/<?=$wall_item->user_fid?>/picture?type=square" /></a>
                      <? if ($user_role == 2):?>
                        <div class="remove-wall-item" itemid="<?=$wall_item->id?>"></div>
                      <? endif;?>
                      <span class="wall_comment_author"><?=$wall_item->user_name?></span>
                      <span class="wall-comment-text"><?=$wall_item->text?></span>
                      <span style="color:#777; font-size: 12px;"><?=$wall_item->created?></span>
                    </li>
                  <? endif;?>
                <? endforeach;?>
              <? endif;?>
              
              
            </ul><!-- WALL CONTENT ENDS -->
          </div><!-- WALL ENDS -->
          
          
          <div id="map-shell" style="display:inline; float:left; position:relative; width:60%;">
            <div id="map-canvas" style="height: 650px;"></div>
          </div>
          
        </div><!-- CONSOLE ENDS -->
        
        
        
      
        <?=$this->load->view('footer')?>
    </div><!-- MAIN ENDS -->
  </div><!-- WRAPPER ENDS -->

<script type="text/javascript">
  // output wall markers to page so Map.display_wall_markers function can display them once google map loads
  // only put a comma after each item in the array if it's not the last one
  // TODO: is there a better way to do the comma thing?
  Wall.wall_markers = [
      <? for($i=0, $count=count($suggestions); $i<$count; $i++):?>
          {"itemid": <?=$suggestions[$i]->id?>, "lat": <?=$suggestions[$i]->lat?>, "lng": <?=$suggestions[$i]->lng?>}
          <? if($i < $count-1):?>
              ,
          <? endif;?>
      <? endfor;?>
  ];
  
  $('#message-box').click(function() {
    $(this).html('').css('height', '50px');
    $('#location-search').show();
    $('#link-input').show();
    $('#wall-post-button').show();
  });
  
  $('#link-input-box').click(function() {
    $(this).val('');
  });
    
</script>
</body> 
</html>