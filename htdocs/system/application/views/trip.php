<?
$header_args = array(
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/trip/map.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/trip/invite.js',
        //'js/trip/delete.js',
        'js/trip/extras.js',
        'js/jquery/color.js',
        'js/jquery/scrollto.js',
        'js/jquery/timeago.js'
    )
);

$this->load->view('core_header', $header_args);
?>


<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
    var baseUrl = "<?=site_url("")?>";
    var staticUrl = "<?=static_url("")?>";
    var tripId = <?=$trip->id?>;
    <? if ($trip->trip_startdate):?>
        var tripStartDate = <?=$trip->trip_startdate?>;
    <? endif; ?>
    <? if ($user):?>
        var uid = <?=$user->id?>;
        var fid = <?=$user->fid?>;
    <? endif;?>
    
    map.lat = <?=$trip->lat?>;
    map.lng = <?=$trip->lng?>;
    map.sBound = <?=$trip->sbound?>;
    map.wBound = <?=$trip->wbound?>;
    map.nBound = <?=$trip->nbound?>;
    map.eBound = <?=$trip->ebound?>;
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
#wall-content {
  overflow-y: auto;
  overflow-x: hidden;
  height: 541px;
  padding: 20px 10px 0px 10px;
  background-color: #CCFFCC;
}
li.suggestion {
  cursor: pointer;
  background: white;
  -webkit-transition: background-color linear .2s;
  -moz-transition: background-color linear .2s;
  -o-transition: background-color linear .2s;
  transition: background-color linear .2s;
}
li.suggestion:hover{
  background: #EAEAEA;
	-webkit-transition: background-color linear .2s;
	-moz-transition: background-color linear .2s;
  -o-transition: background-color linear .2s;
  transition: background-color linear .2s;
}
li.suggestion.highlighted{
  background: #EAEAEA;
	-webkit-transition: background-color linear .2s;
	-moz-transition: background-color linear .2s;
  -o-transition: background-color linear .2s;
  transition: background-color linear .2s;
}
.remove-wall-suggestion {
  background-image: url(/david/static/images/delete_button.png);
  height: 15px;
  width: 15px;
  opacity: 0;
  cursor: pointer;
  position: absolute;
  top: 0;
  right: 0;
}
#map-shell {
  font-size: 14px;
}
#map-shell input {
  padding: 4px;
  font-size: 14px;
  width: 200px;
}
.checkbox-name {
  text-align: right;
  padding-right: 10px;
}
.padding-right {
  padding-right: 20px;
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
                <input type="hidden" class="location-data" id="location-name" name="location-name" />
                <input type="hidden" class="location-data" id="location-phone" name="location-phone" />
                <input type="hidden" class="location-data" id="location-lat" name="location-lat" />
                <input type="hidden" class="location-data" id="location-lng" name="location-lng" />
                <input type="text" id="location-search-box" size="39" />
                <!-- AUTO LOC LIST -->
                <div id="auto-loc-list" style="position:absolute; top:60px; left:0px; background:white; opacity:0.8; width:350px;">
                  <ul id="location-autosuggest"></ul>
                  <div id="place-type-dropdown" style="display:none;"></div>
                </div><!-- AUTO LOC LIST ENDS -->
                <div id="marker-notification" style="position:absolute; top:-40px; right:-480px; z-index:1000; display:none; color:white; background-color:black; opacity:0.8; -moz-box-shadow: 2px 2px 5px black; -webkit-box-shadow: 2px 2px 5px black; box-shadow: 2px 2px 5px black; padding:15px;">You can drag and drop the pin anywhere you want.</div>
              </div><!-- LOCATION SEARCH ENDS -->
              
              <!-- CATEGORY -->
              <div id="category" style="display:none; margin-left:20px;">
                Category<br/>
                <table style="border-collapse:collapse;">
                  <tbody>
                    <tr>
                      <td class="checkbox-name"><label for="accommodation">Accommodation</label></td>
                      <td class="padding-right"><input type="checkbox" name="accommodation" id="accommodation" value="accommodation" /></td>
                      <td class="checkbox-name"><label for="local-attractions">Local attractions</label></td>
                      <td class="padding-right"><input type="checkbox" name="local-attractions" id="local-attractions" value="local-attractions" /></td>
                    </tr>
                    <tr>
                      <td class="checkbox-name"><label for="restaurants">Restaurants</label></td>
                      <td class="padding-right"><input type="checkbox" name="restaurants" id="restaurants" value="accommodation" /></td>
                      <td class="checkbox-name"><label for="bars-nightlife">Bars/nightlife</label></td>
                      <td class="padding-right"><input type="checkbox" name="bars-nightlife" id="bars-nightlife" value="bars-nightlife" /></td>
                    </tr>
                    <tr>
                      <td class="checkbox-name"><label for="landmarks">Landmarks</label></td>
                      <td class="padding-right"><input type="checkbox" name="landmarks" id="landmarks" value="accommodation" /></td>
                      <td class="checkbox-name"><label for="activities-events">Activities/events</label></td>
                      <td class="padding-right"><input type="checkbox" name="activities-events" id="activities-events" value="activities-events" /></td>
                    </tr>
                    <tr>
                      <td class="checkbox-name"><label for="shopping">Shopping</label></td>
                      <td class="padding-right"><input type="checkbox" name="shopping" id="shopping" value="accommodation" /></td>
                      <td class="checkbox-name"><label for="blah">blah</label></td>
                      <td class="padding-right"><input type="checkbox" name="blah" id="blah" value="blah" /></td>
                    </tr>
                  </tbody>
                </table>
                <textarea id="category-other" style="width:200px; height:40px;">other</textarea>
              </div><!-- CATEGORY ENDS -->

              <!-- GOOD FOR -->
              <div id="good-for" style="display:none; margin-left:20px;">
                Good for<br/>
                <table style="border-collapse:collapse;">
                  <tbody>
                    <tr>
                      <td class="checkbox-name"><label for="input-1">input-1</label></td>
                      <td class="padding-right"><input type="checkbox" name="input-1" id="input-1" value="input-1" /></td>
                      <td class="checkbox-name"><label for="input-2">input-2</label></td>
                      <td class="padding-right"><input type="checkbox" name="input-2" id="input-2" value="input-2" /></td>
                    </tr>
                    <tr>
                      <td class="checkbox-name"><label for="input-3">input-3</label></td>
                      <td class="padding-right"><input type="checkbox" name="input-3" id="input-3" value="input-3" /></td>
                      <td class="checkbox-name"><label for="input-4">input-4</label></td>
                      <td class="padding-right"><input type="checkbox" name="input-4" id="input-4" value="input-4" /></td>
                    </tr>
                  </tbody>
                </table>
                <textarea id="good-for-other" style="width:200px; height:40px;">other</textarea>
              </div><!-- GOOD FOR ENDS -->
              
              <div id="link-input" style="display:none;">
                Link
                <input type="text" id="link-input-box" size="39" value="http://" />
              </div>
              
              <div id="wall-post-button" style="padding-left:330px; display:none;"><a href="#" id="post-to-wall" style="text-decoration:none;">Post</a></div>
              
            </div><!-- WALL INPUT CONTAINER -->

            <!-- WALL CONTENT -->
            <ul id="wall-content">
              <? if ($wall_items):?>
                <? foreach ($wall_items as $wall_item):?>
                  <? if ($wall_item->is_location):?>
                    <li id="wall-suggestion-<?=$wall_item->id?>" class="suggestion" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA; position:relative;">
                      <div class="wall-location-name"style="font-weight:bold;"><?=$wall_item->name?></div>
                      <div>Suggested by <a href="#" class="wall-comment-author" style="text-decoration:none;"><?=$wall_item->user_name?></a></div>
                      <span class="wall-location-address" style="display:none;"><?=$wall_item->address?></span>
                      <span class="wall-location-phone" style="display:none;"><?=$wall_item->phone?></span>
                      
                      Accomodation, landmark, restaurant<br/>
                      Good for: seeing new york like a local, food, burgers<br/>
                      <? if ($wall_item->text):?>
                        <br/>
                        <?=$wall_item->text?>
                      <? endif;?>
                      <div class="rating-panel">
                        Like Dislike
                      </div>
                      <? if ($user_role == 2):?>
                        <div class="remove-wall-suggestion" suggestionId="<?=$wall_item->id?>"></div>
                      <? endif;?>
                      <abbr class="timeago" title="<?=$wall_item->created?>" style="color:#777; font-size: 12px;"><?=$wall_item->created?></abbr>
                    </li>
                  <? else:?>
                    <li id="wall-message-<?=$wall_item->id?>" class="" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA;">
                      <a href="#"><img src="http://graph.facebook.com/<?=$wall_item->user_fid?>/picture?type=square" /></a>
                      <? if ($user_role == 2):?>
                        <div class="remove-wall-message" messageId="<?=$wall_item->id?>"></div>
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
          {"suggestionId": <?=$suggestions[$i]->id?>, "lat": <?=$suggestions[$i]->lat?>, "lng": <?=$suggestions[$i]->lng?>}
          <? if($i < $count-1):?>
              ,
          <? endif;?>
      <? endfor;?>
  ];
  
  
  // expand post area
  $('#message-box').click(function() {
    $(this).html('').css('height', '50px');
    $('#location-search').show();
    $('#link-input').show();
    $('#wall-post-button').show();
  });
  
  
  $('#link-input-box').click(function() {
    $(this).val('');
  });
  
  
  // change background color of wall item on hover
  $('li.suggestion').hover(
    function() {
      $(this).children('.remove-wall-suggestion').css('opacity', 1);
    },
    function() {
      $(this).children('.remove-wall-suggestion').css('opacity', 0);
    }
  );
  
  // convert unix timestamps to time ago
  $('abbr.timeago').timeago();
  
  
  $(document).ready(function() {
    $('#post-to-wall').click(function() {
      // distinguish between message and suggestion
      if ($('#location-name').val().length==0 || $('#location-lat').val().length==0 || $('#location-lng').val().length==0) {
        alert('this will be saved as a message not a suggestion');
        return false;
        
      } else {
      
        $.ajax({
          type: 'POST',
          url: baseUrl+'users/ajax_get_logged_in_status',
          success: function(response) {
            var r = $.parseJSON(response);
            // if user is logged in, save the suggestion
            if (r['loggedin']) {
              var userId = r['loggedin'];

              var postData = {
                userId: userId,
                tripId: tripId,
                name: $('#location-name').val(),
                text: $('#message-box').val(),
                lat: $('#location-lat').val(),
                lng: $('#location-lng').val(),
                address: $('#location-search-box').val(),
                phone: $('#location-phone').val()
              };
              console.log(postData);
              
              $.ajax({
                type: 'POST',
                url: baseUrl+'suggestions/ajax_save_suggestion',
                data: postData,
                success: function(response) {
                  console.log(response);
                  var r = $.parseJSON(response);
                  alert('suggestion saved, please refresh page to see it; suggestion id'+r['id']);
                }
              });
              
            } else {
              alert('please login to post on the wall');
            }
          }
        });
        
        return false;
      }
      
    });
  });

  // ajax delete wall items
  $('.remove-wall-suggestion').click(function() {
    // TODO: ask user to confirm removal
    var suggestionId = $(this).attr('suggestionId');
    $.ajax({
      type: 'POST',
      url: baseUrl+'suggestions/remove_suggestion',
      data: {
        suggestionId: suggestionId
      },
      success: function(response){
        var r = $.parseJSON(response);
        $('#wall-suggestion-'+r.suggestionId).fadeOut(1000);
      }
    });
  });

</script>
</body> 
</html>