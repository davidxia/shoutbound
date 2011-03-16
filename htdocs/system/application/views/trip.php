<?
$header_args = array(
    'title' => $trip->name.' | Shoutbound',
    'css_paths'=>array(
        'css/jquery.countdown.css'
    ),
    'js_paths'=>array(
        'js/trip/map.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/trip/invite.js',
        'js/jquery/popup.js',
        'js/trip/extras.js',
        'js/jquery/color.js',
        'js/jquery/scrollto.js',
        'js/jquery/timeago.js',
        'js/jquery/jquery.countdown.min.js'
    )
);

$this->load->view('core_header', $header_args);
?>


<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url('')?>";
  var staticUrl = "<?=static_url('')?>";
  var tripId = <?=$trip->id?>;
  <? if ($user):?>
      var uid = <?=$user->id?>;
      <? if ($user->fid):?>
          var fid = <?=$user->fid?>;
      <? endif;?>
  <? endif;?>
  
  map.lat = <?=$destinations[0]->lat?>;
  map.lng = <?=$destinations[0]->lng?>;
</script>

<style type="text/css">
#invite-others-button, #get-suggestions-button {
  color:white;
  display:block;
  height:30px;
  line-height:30px;
  text-align:center;
  font-weight:bold;
  font-size:11px;
  text-decoration:none;
  background:-webkit-gradient(linear, left top, left bottom, from(#F90), to(#FF6200));
  background:-moz-linear-gradient(top, #F90, #FF6200);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#F90', endColorstr='#FF6200');
  border: 1px solid #E55800;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  margin-bottom: 13px;
}
#invite-others-button:hover, #get-suggestions-button:hover {
  background: #ffad32;
  background: -webkit-gradient(linear, left top, left bottom, from(#ffad32), to(#ff8132));
  background: -moz-linear-gradient(top,  #ffad32,  #ff8132);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffad32', endColorstr='#ff8132');
}
#invite-others-button:active, #get-suggestions-button:active {
  background: #ff8132;
  background: -webkit-gradient(linear, left top, left bottom, from(#ff8132), to(#ffad32));
  background: -moz-linear-gradient(top,  #ff8132,  #ffad32);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff8132', endColorstr='#ffad32');
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
#auto-loc-list ul li a:hover {
  background-color: #E0E0FF;
}

#wall-text-input {
  width: 50%;
}
#wall-content {
  overflow-y: auto;
  overflow-x: hidden;
  height: 541px;
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
.remove-wall-item {
  background-image: url(/david/images/delete_button.png);
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
.friend-capsule .friend-name {
  color:#222;
}
.friend-capsule:hover {
  background: #e7ebf5;
  border-radius: 3px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
}
.friend-capsule:hover .friend-name {
  color: #000;
}
.friend-capsule.share-selected {
  background: #526ea6;
}
.friend-capsule.share-selected .friend-name {
  color: #fff;
}
#wall-post-button {
  width: 50px;
  cursor: pointer;
  display:none;
  line-height:30px;
  text-align:center;
  text-decoration:none;
	color: white;
	border: solid 1px #0076a3;
	background: #0095cd;
	background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
	background: -moz-linear-gradient(top,  #00adee,  #0078a5);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#00adee', endColorstr='#0078a5');
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  margin: 0;
}
#wall-post-button:hover {
	background: #007ead;
	background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
	background: -moz-linear-gradient(top,  #0095cc,  #00678e);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0095cc', endColorstr='#00678e');
}
#wall-post-button:active {
	color: #80bed6;
	background: -webkit-gradient(linear, left top, left bottom, from(#0078a5), to(#00adee));
	background: -moz-linear-gradient(top,  #0078a5,  #00adee);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0078a5', endColorstr='#00adee');
}
</style>

</head>



<body style="background-color:#1B272C; min-width:960px;">
	<div id="fb-root"></div>
	<script>
    window.fbAsyncInit = function() {
      FB.init({appId: '136139119767617', status: true, cookie: true, xfbml: true});
    };
    (function() {
      var e = document.createElement('script'); e.async = true;
      e.src = document.location.protocol +
        '//connect.facebook.net/en_US/all.js';
      document.getElementById('fb-root').appendChild(e);
    }());
	</script>
	
	  <div id="div-to-popup" style="display:none;">
    <div id="trip-invite-popup" style="width:466px; padding:10px; background:rgba(82, 82, 82, 0.7); border-radius: 5px; -webkit-border-radius:5px; border-top-left-radius: 5px 5px; border-top-right-radius: 5px 5px; border-bottom-right-radius: 5px 5px; border-bottom-left-radius: 5px 5px;">
      <fb:serverfbml id="fb_invite" width="615"></fb:serverfbml>
    </div>
  </div>

  <?=$this->load->view('header')?>
  

  <!-- WRAPPER -->
  <div class="wrapper" style="background:white url('<?=site_url('images/trip_page_background.png')?>') repeat-x 0 0;">
    <!-- MAIN -->
    <div class="content" style="margin: 0 auto; width:960px; padding:20px 0 80px;">
      <div style="border: 1px solid #ced7de; background-color:#FFFFFF; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; min-height:300px;">
          <!-- TRIP SUMMARY -->
          <div id="trip_summary" style="width:688px; float:left; margin:10px 10px 10px 10px;  padding:10px; border: 1px solid #ced7de; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;">
            <div id="trip_name" style="font-size:1.5em;font-weight: bold; color:#026eb0; margin-bottom:5px;">
              <?=$trip->name?>
            </div>
            <div id="trip_creator" style="font-size: 0.75em; margin-bottom:10px; ">
              created by <a href="<?=site_url('profile/'.$creator->id)?>" style="text-decoration:none;"><?=$creator->name?></a>
            </div>
            <div id="trip_description" style="border-bottom: 1px solid #ced7de; padding-bottom:10px; margin-right:5px;">
              <?=$trip->description?>
            </div>
            <!-- TRIP GOERS -->
            <div id="trip_goers" style="border-bottom: 1px solid #ced7de; margin-top:10px; padding-bottom:10px;">
              <? if ($trip_goers):?>
                <? foreach ($trip_goers as $trip_goer):?>
                  <div class="trip_goer" uid="<?=$trip_goer->id?>" style="float:left; margin-right:10px;">
                    <a href="<?=site_url('profile/'.$trip_goer->id)?>"><img class="square-50" src="http://graph.facebook.com/<?=$trip_goer->fid?>/picture?type=square"/></a>
                  </div>
                <? endforeach;?>
              <? endif;?>
              <div style="clear:both;"></div>
              <div id="num_trip_goers" style="float:left; margin-top: 3px; font-size: 0.75em">
                <? if (count($trip_goers) == 1):?>
                  <span id="num"><?=count($trip_goers)?></span> person is in
                <? else:?>
                  <span id="num"><?=count($trip_goers)?></span> people are in
                <? endif;?>
              </div>
              
              <div style="clear:both;"></div>

            </div><!-- TRIP GOERS ENDS -->
            
            <div style="margin-top:10px;">
              <div id="trip-destinations" style="width:30%; display:inline-block; float:left; font-size:1em;">
                <? foreach ($destinations as $destination):?>
                  <?=$destination->address?><br/>
                <? endforeach;?>
              </div>
              <div id="destination-start-dates" style="width:20%; display:inline-block; float:left; font-size:1em;">
                <? foreach ($destinations as $destination):?>
                  <? if ($destination->startdate):?>
                    <?=date('n/d/y', $destination->startdate)?><br/>
                  <? else:?>
                    no date set yet<br/>
                  <? endif;?>
                <? endforeach;?>
              </div>
              <!--<div id="need-advice-on" style="width:50%; display:inline-block; float:left; font-size:1em;">
                Interested in:<br/>
                <span style="padding-left: 10px;">interest go here</span><br/>
                Want suggestions for:<br/>
                <span style="padding-left: 10px;">suggestion categories go here</span>
              </div>-->
            </div>
          </div><!-- TRIP SUMMARY ENDS -->
            
            
            
            <!-- WIDGET -->
            <div id="trip-widget" style="width:208px; float:left; padding:10px 10px 0px;">
              <? if ($user_role >= 2):?>
                <span id="rsvp_status">
                <? if ($user_rsvp == 2):?>
                    You're invited
                    <div id="countdown"></div>
                <? elseif ($user_rsvp == 3):?>
                    You're in
                <? elseif ($user_rsvp == 1):?>
                    You're out, but you can still change your mind
                    <div id="countdown"></div>
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
                        <a href="#" id="invite-others-button">INVITE OTHER PEOPLE</a>
                        <a href="#" id="get-suggestions-button">GET SUGGESTIONS</a>
                    </div>
                    <a href="#" id="rsvp_no_button">I'm out</a>
                </div>
                <? elseif ($user_rsvp == 1):?>
                <div id="rsvp_buttons">
                    <a href="#" id="rsvp_yes_button">I'm in</a>
                </div>
                <? endif;?>
                
                <? if ($user_role == 3):?>
                  <div>
                    <a href="<?=site_url('trips/delete').'/'.$trip->id?>">Delete</a>
                  </div>
                <? endif;?>
                
              <? endif;?>
              
              
            </div><!-- WIDGET ENDS -->
        
        <div style="clear:both;"></div>

        <!-- CONSOLE -->
        <div id="console">
          <!-- WALL -->
          <div id="wall" style="float:left; width:40%; height: 650px;">
            <!-- WALL INPUT CONTAINER -->
            <div id="wall-input-container" style="padding-left:10px;">
              <div style="height:80px;">
                <label for="message-box" style="position:absolute; color:#888; z-index:1; background-color:white; line-height:40px; padding-left:10px;"><span>Write a message</span></label>
                <textarea id="message-box" style="position:absolute; z-index:2; background:transparent; width:340px; height:20px;"></textarea>
              </div>
              
              <!-- LOCATION SEARCH -->
              <div id="location-search" style="display:none; position:relative; height:40px;">
                <label for="location-search-box" style="position:absolute; color:#888; z-index:1; background-color:white; line-height:40px; padding-left:10px;"><span>Location</span></label>
                <input type="hidden" class="location-data" id="location-name" name="location-name" />
                <input type="hidden" class="location-data" id="location-phone" name="location-phone" />
                <input type="hidden" class="location-data" id="location-lat" name="location-lat" />
                <input type="hidden" class="location-data" id="location-lng" name="location-lng" />
                <input type="text" id="location-search-box" style="position:absolute; z-index:2; background:transparent; width:340px;"/>
                <!-- AUTO LOC LIST -->
                <div id="auto-loc-list" style="position:absolute; top:60px; left:0px; background:white; opacity:0.8; width:350px; z-index:3;">
                  <ul id="location-autosuggest"></ul>
                </div><!-- AUTO LOC LIST ENDS -->
                <div id="marker-notification" style="position:absolute; top:-40px; right:-480px; z-index:1000; display:none; color:white; background-color:black; opacity:0.8; -moz-box-shadow: 2px 2px 5px black; -webkit-box-shadow: 2px 2px 5px black; box-shadow: 2px 2px 5px black; padding:15px;">You can drag and drop the pin anywhere you want.</div>
                <div style="clear:both;"></div>
              </div><!-- LOCATION SEARCH ENDS -->
              
              
              <div id="link-input" style="display:none; height:40px;">
                <label for="link-input-box" style="position:absolute; color:#888; z-index:1; background-color:white; line-height:40px; padding-left:10px;"><span>http://</span></label>
                <input type="text" id="link-input-box" style="position:absolute; z-index:2; background:transparent; width:340px;"/>
              </div>
              
              <a href="#" id="wall-post-button">Post</a>
              
            </div><!-- WALL INPUT CONTAINER -->

            <!-- WALL CONTENT -->
            <ul id="wall-content">
              <? if ($wall_items):?>
                <? foreach ($wall_items as $wall_item):?>
                  <? if ($wall_item->lat):?>
                    <li id="wall-suggestion-<?=$wall_item->id?>" class="suggestion" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA; position:relative;">
                      <div class="wall-location-name"style="font-weight:bold;"><?=$wall_item->name?></div>
                      <div>Suggested by <a href="<?=site_url('profile/'.$wall_item->user_id)?>" class="wall-item-author" style="text-decoration:none;"><?=$wall_item->user_name?></a></div>
                      <span class="wall-location-address" style="display:none;"><?=$wall_item->address?></span>
                      <span class="wall-location-phone" style="display:none;"><?=$wall_item->phone?></span>
                      
                      <? if ($wall_item->text):?>
                        <br/>
                        <?=$wall_item->text?>
                      <? endif;?>
                      <!--<div class="rating-panel">
                        <a href="#" class="like">Like</a>
                        <span class="num-likes"><?=$wall_item->votes?></span> likes
                      </div>-->
                      <? if ($user_role >= 2):?>
                        <div class="remove-wall-item" suggestionId="<?=$wall_item->id?>"></div>
                      <? endif;?>
                      <abbr class="timeago" title="<?=$wall_item->created?>" style="color:#777; font-size: 12px;"><?=$wall_item->created?></abbr>
                    </li>
                  <? else:?>
                    <li id="wall-message-<?=$wall_item->id?>" class="message" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA; position:relative;">
                      <a href="<?=site_url('profile/'.$wall_item->user_id)?>" class="wall-item-author" style="text-decoration:none;"><?=$wall_item->user_name?></a>
                      <? if ($user_role >= 2):?>
                        <div class="remove-wall-item" messageId="<?=$wall_item->id?>"></div>
                      <? endif;?>
                      <span class="wall-item-text"><?=$wall_item->text?></span>
                      <br/>
                      <abbr class="timeago" title="<?=$wall_item->created?>" style="color:#777; font-size: 12px;"><?=$wall_item->created?></abbr>
                    </li>
                  <? endif;?>
                <? endforeach;?>
              <? endif;?>
              
              
            </ul><!-- WALL CONTENT ENDS -->
          </div><!-- WALL ENDS -->
          
          
          <div id="map-shell" style="display:inline; float:left; position:relative; width:60%;">
            <div id="map-canvas" style="height: 650px;"></div>
          </div>
          
          <div style="clear:both;"></div>
          
        </div><!-- CONSOLE ENDS -->
      </div>
    </div><!-- MAIN ENDS -->
  </div><!-- WRAPPER ENDS -->


  <?=$this->load->view('footer')?>


<script type="text/javascript">
  // output wall markers to page so Map.display_wall_markers function can display them once google map loads
  // only put a comma after each item in the array if it's not the last one
  // TODO: is there a better way to do the comma thing?
  map.destination_markers = [
      <? for($i=0, $count=count($destinations); $i<$count; $i++):?>
          {"lat": <?=$destinations[$i]->lat?>, "lng": <?=$destinations[$i]->lng?>}
          <? if($i < $count-1):?>
              ,
          <? endif;?>
      <? endfor;?>
  ];

  Wall.wall_markers = [
      <? for($i=0, $count=count($suggestions); $i<$count; $i++):?>
          {"suggestionId": <?=$suggestions[$i]->id?>, "lat": <?=$suggestions[$i]->lat?>, "lng": <?=$suggestions[$i]->lng?>}
          <? if($i < $count-1):?>
              ,
          <? endif;?>
      <? endfor;?>
  ];
  
  
  // expand post area
  $('#message-box').focus(function() {
    expandMessageBox();
  });
  
  $.fn.labelFader = function() {
    var f = function() {
      var $this = $(this);
      if ($this.val()) {
        $this.siblings('label').children('span').hide();
      } else {
        $this.siblings('label').children('span').fadeIn('fast');
      }
    };
    this.focus(f);
    this.blur(f);
    this.keyup(f);
    this.change(f);
    this.each(f);
    return this;
  };

  $(document).ready(function() {
    $('#message-box').labelFader();
    $('#location-search-box').labelFader();
    $('#link-input-box').labelFader();
  });
  
  
  function expandMessageBox() {
    $('#message-box').html('').css('height', '50px');
    $('#location-search').show();
    $('#link-input').show();
    $('#wall-post-button').css('display', 'block');
  }
  
  
  // change background color of wall item on hover
  $('#wall-content').children('li').hover(
    function() {
      $(this).children('.remove-wall-item').css('opacity', 1);
    },
    function() {
      $(this).children('.remove-wall-item').css('opacity', 0);
    }
  );
  
  // convert unix timestamps to time ago
  $('abbr.timeago').timeago();
  
  
  $(document).ready(function() {
    $('#wall-post-button').click(function() {
      // distinguish between message and suggestion
      if ($('#location-name').val().length==0 || $('#location-lat').val().length==0 || $('#location-lng').val().length==0) {
        $.ajax({
          type: 'POST',
          url: baseUrl+'users/ajax_get_logged_in_status',
          success: function(response) {
            var r = $.parseJSON(response);
            if (r.loggedin) {
              var userId = r.loggedin;
              var postData = {
                userId: userId,
                tripId: tripId,
                text: $('#message-box').val(),
              }
              
              $.ajax({
                type: 'POST',
                url: baseUrl+'messages/ajax_save_message',
                data: postData,
                success: function(response) {
                  var r = $.parseJSON(response);
                  displayMessage(r);
                  $('abbr.timeago').timeago();
                  
                }
              });
              
            } else {
              alert('please login to post on the wall');
            }
          }
        });
        return false;
        
      } else {
      
        $.ajax({
          type: 'POST',
          url: baseUrl+'users/ajax_get_logged_in_status',
          success: function(response) {
            var r = $.parseJSON(response);
            console.log(r);
            // if user is logged in, save the suggestion
            if (r.loggedin) {
              var userId = r.loggedin;

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
              
              $.ajax({
                type: 'POST',
                url: baseUrl+'suggestions/ajax_save_suggestion',
                data: postData,
                success: function(response) {
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
  
  
  function displayMessage(r) {
    var html = [];
    html[0] = '<li id="wall-message-'+r.id+'" class="" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA; position:relative;">';
    html[1] = '<a href="#" class="wall-item-author" style="text-decoration:none;">';
    html[2] = 'David Xia';
    html[3] = '</a>';
    html[4] = ' <div class="remove-wall-item" messageId="'+r.id+'"></div>';
    html[5] = '<span class="wall-item-text">'+r.text+'</span>';
    html[6] = '<br/>';
    html[7] = '<abbr class="timeago" title="'+r.created+'" style="color:#777; font-size: 12px;">'+r.created+'</abbr>';
    html[8] = '</li>';
    html = html.join('');
    
    $('#wall-content').prepend(html);
  }

  // ajax remove wall items
  $('.remove-wall-item').click(function() {
    // TODO: ask user to confirm removal
    // remove wall item
    if ($(this).attr('suggestionId')) {
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
      // also remove corresponding map marker
      map.markers[suggestionId].setMap(null);
    } else if ($(this).attr('messageId')) {
      var messageId = $(this).attr('messageId');
      $.ajax({
        type: 'POST',
        url: baseUrl+'messages/remove_message',
        data: {
          messageId: messageId
        },
        success: function(response){
          var r = $.parseJSON(response);
          $('#wall-message-'+r.messageId).fadeOut(1000);
        }
      });
    }
  });
  
  // show countdown clock
  var deadline = new Date(<?=$trip->response_deadline?>*1000);
  $('#countdown').countdown({until: deadline});
  
  $('a.like').click(function() {
    var suggestionId = $(this).parent().parent().attr('id');
    suggestionId = suggestionId.match(/\d/)[0];
    var numLikes = $(this).siblings('.num-likes');
    
    var postData = {
      suggestionId: suggestionId
    };
    
    $.ajax({
      type: 'POST',
      url: baseUrl+'suggestions/ajax_like_suggestion',
      data: postData,
      success: function(response) {
        var r = $.parseJSON(response);
        if (r.success) {
          var n = parseInt(numLikes.html());
          numLikes.html(n+1);
        } else {
          alert('something\'s broken. Tell David to fix it.');
        }
      }
    });
    return false;
  });
</script>

</body> 
</html>