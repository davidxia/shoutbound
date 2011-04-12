<?
$header_args = array(
    'title' => $trip->name.' | Shoutbound',
    'css_paths'=>array(
        'css/jquery.countdown.css',
        'css/trip-page.css',
    ),
    'js_paths'=>array(
        'js/trip/map.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/jquery/popup.js',
        'js/trip/extras.js',
        'js/jquery/color.js',
        'js/jquery/scrollto.js',
        'js/jquery/timeago.js',
        'js/jquery/jquery.countdown.min.js',    
    )
);

$this->load->view('core_header', $header_args);
?>


<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url()?>";
  var staticSub = "<?=static_sub()?>";
  var tripId = <?=$trip->id?>;
  <? if ($user):?>
      var uid = <?=$user->id?>;
  <? endif;?>
  var isShared = <?=$is_shared?>;
  
  map.lat = <?=$destinations[0]->lat?>;
  map.lng = <?=$destinations[0]->lng?>;
</script>

</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
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
  
  <div id="div-to-popup" style="display:none;"></div>
			  
			<div id="trip-col-right"><!--TRIPCOLRIGHT START-->
				<div class="item-header"><h3>Itinerary</h3></div>
				<div id="itinerary"><!--ITINERARY START-->															
					<div class="right-item-content"><!--ITINERARY CONTENT-->         	
            <? foreach ($destinations as $destination):?>
              <div class="destination-dates">
  	            <a href="#"><?=$destination->name?></a>
  	            <p class="subtext">
  		            <? if ($destination->startdate AND $destination->enddate):?>
  		              <?=date('n/d/y', $destination->startdate)?> to <?=date('n/d/y', $destination->enddate)?>
  		            <? elseif ($destination->startdate AND ! $destination->enddate):?>
  		              <?=date('n/d/y', $destination->startdate)?> to (No date set)
  		            <? elseif ( ! $destination->startdate AND $destination->enddate):?>
  		              (No date set) to <?=date('n/d/y', $destination->enddate)?>
  		            <? else:?>
  		              No dates set
  		            <? endif;?>
  		          </p>
  		        </div>
	          <? endforeach;?>
	     			     			                          																							
						<div id="trip_goers"><!--TRIP GOERS-->  
	          	<div id="num_trip_goers">          			              		
	              <? if (count($trip_goers) == 1):?>
	              <span id="num"><p class="subtext"><?=count($trip_goers)?> person is going on this trip.</span>
	              <? else:?>              		
	              <div id="num"><p class="subtext"><?=count($trip_goers)?> people are going on this trip.</div>
	              <? endif;?>           
	          	</div>  
        	        		          			                     
					    <? if ($trip_goers):?>
		            <? foreach ($trip_goers as $trip_goer):?>
		            	<div class="trip_goer" uid="<?=$trip_goer->id?>">
		                <a href="<?=site_url('profile/'.$trip_goer->id)?>"><img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" height="35" width="35"/></a>
		              </div>
		            <? endforeach;?>
			         <? endif;?>
		          
		          <div style="clear:both;"></div>
		          
		          <p class="subtext">This trip was created by <a href="<?=site_url('profile/'.$creator->id)?>" style="text-decoration:none; color:navy;"><?=$creator->name?></a></p>	              			
  			
  					</div><!--TRIP GOERS END-->
    			</div><!--ITINERARY CONTENT END-->										
	    								
				</div><!--ITINERARY END-->
																	
				<!--MAP START-->
				<div id="map-container">
					<div class="item-header"><h3>Map</h3></div>	
					<div id="map-shell">
						<div class="right-item-content">				
							<div id="map-canvas"></div>
						</div>											
					</div>
				</div>
				<!--MAP END-->
				
			</div><!--TRIPCOLRIGHT END-->

    <!--TRIPCOLLEFTSHELL START-->
    <div id="trip-col-left-shell">
			<div id="trip-name">
				<h1><?=$trip->name?></h1>
			</div> 
			<div id="trip_description"><p><?=$trip->description?></p></div>							
				
    	<div id="trip-widget"><!--WIDGET START--> 
    		<!--IF USER IS INVITED, DISPLAY RSVP STATUS-->
    		<? if ($user_role >= 2):?>
          <div id="rsvp_status">    
            <? if ($user_rsvp == 3):?>
              <!--<h3>You're going on this trip</h3>-->
            <? elseif ($user_rsvp == 2):?>
              <p class="regular">You've been invited on this trip!</p>
            <? elseif ($user_rsvp == 1):?>
              <p class="regular">You've been invited on this trip!</p>
            <? endif;?>
          </div>
          
          <!--IF USER IS INVITED AND AWAITING RSVP, DISPLAY RSVP BUTTONS-->
          <? if ($user_rsvp == 2):?>
            <div id="rsvp_buttons">
              <a href="#" id="rsvp_yes_button">I'm in</a>
              <a href="#" id="rsvp_no_button">I'm out</a>		                
            </div>
            <div id="countdown-container"><p class="regular">Time left to respond:</p>
             	<div id="countdown"></div>                  
    				</div>
    			
    			<!--IF USER IS INVITED AND PREVIOUSLY RSVP'D NO, DISPLAY RSVP BUTTONS-->
    			<? elseif ($user_rsvp == 1):?>
            You said no, but you can still change your mind.
            <div id="rsvp_buttons">
              <a href="#" id="rsvp_yes_button">I'm in</a>
              <a href="#" id="rsvp_no_button">I'm out</a>		                
            </div>
            <div id="countdown-container"><p class="regular">Time left to respond:</p>
             	<div id="countdown"></div>                  
    				</div>
          <? endif;?>
          
        <? endif;?><!--END-->					
    	        
        <? if ($user_rsvp == 3):?>
          <div class="console">
            <p class="regular">Get advice, ideas and recommendations for this trip by <a href="#" id="get-suggestions-button">Sharing</a> it with other people. You can also <a href="#" id="invite-others-button">Invite</a>  other people to join you this trip.  	              
            <!--<a href="#" id="rsvp_no_button">I'm out</a>-->
                     
            <? if ($user_role == 3):?>
            <!--<a id="deletebutton" style="" href="<?=site_url('trips/delete').'/'.$trip->id?>">Delete this trip</a></p>-->                    
         		<? endif;?>	              
           </div>
          
        <? else:?>		          	
      		<div class="console">
          	<p class="regular">Help <a href="<?=site_url('profile/'.$creator->id)?>"><?=$creator->name?></a> plan this trip by adding your thoughts and <a href="#" id="get-suggestions-button">Sharing</a> this trip with other people.</p>
          </div>
        <? endif;?>	            				
    	</div><!--WIDGET END-->									
															

      <!-- WALL -->
      <div id="wall">
      <? foreach ($wallitems as $wallitem):?>
        <div class="wallitem" id="wallitem-<?=$wallitem->id?>">
          <div class="author">
            <?=$wallitem->user_name?>
          </div>
          <div class="content">
            <?=$wallitem->content?>
          </div>
          <abbr class="timeago" title="<?=$wallitem->created?>"><?=$wallitem->created?></abbr>
          <div class="like">LIKE</div>
          <div class="reply-button">REPLY</div>
          <? foreach ($wallitem->replies as $reply):?>
            <div class="reply" id="wallitem-<?=$wallitem->id?>">
              <div class="author">
                <?=$reply->user_name?>
              </div>
              <div class="content">
                <?=$reply->content?>
              </div>
              <abbr class="timeago" title="<?=$reply->created?>"><?=$reply->created?></abbr>
              <div class="like">LIKE</div>
            </div>
          <? endforeach;?>
        </div>
      <? endforeach;?>
      </div><!-- WALL ENDS -->
					 		
      <!-- WALLITEM INPUT CONTAINER -->
      <div id="wallitem-input-container;" style="position:relative;">
        <label for="wallitem-input" style="position:absolute; padding:5px;">
          <span>Add message</span>
        </label>
        <textarea id="wallitem-input"></textarea>
        <div id="wallitem-post-button"><a href="#">Add</a></div>
      </div><!-- WALLITEM INPUT CONTAINER ENDS -->
		        	
    </div><!-- TRIPCOLLEFTSHELL ENDS -->
			

	</div><!-- WRAPPER ENDS --> 
</div><!-- CONTENT ENDS -->

<? $this->load->view('footer')?>

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

  /*
  Wall.wall_markers = [
    <? for ($i=0, $count=count($suggestions); $i<$count; $i++):?>
      {"suggestionId": <?=$suggestions[$i]->id?>, "lat": <?=$suggestions[$i]->lat?>, "lng": <?=$suggestions[$i]->lng?>}
      <? if($i < $count-1):?>
        ,
      <? endif;?>
    <? endfor;?>
  ];
  */
    
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
    $('#wallitem-input').labelFader();
  });
  
  
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
    // if trip isn't shared, trigger invite others popup
    if (isShared == 0) {
      $('#invite-others-button').trigger('click');
    }
    
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
                //userId: userId,
                tripId: tripId,
                text: $('#message-box').val()
              }
              
              $.ajax({
                type: 'POST',
                url: baseUrl+'messages/ajax_save_message',
                data: postData,
                success: function(response) {
                  var r = $.parseJSON(response);
                  displayMessage(r);
                  $('abbr.timeago').timeago();
                  $('#message-box').val('');
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
            // if user is logged in, save the suggestion
            if (r.loggedin) {
              var userId = r.loggedin;

              var postData = {
                //userId: userId,
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
    html[2] = r.userName;
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
  
  
  // reply to wall posts
  $('.reply').click(function() {
    $(this).siblings('.reply-box').remove();
    var parentElement = $(this).parent();
    var parentId = parentElement.attr('id');
    
    var regex = /^.+-(.+)-(\d+)/;
    var match = regex.exec(parentId);
    if (match[1] == 'message') {
      var messageId = match[2];
    } else if (match[1] == 'suggestion') {
      var suggestionId = match[2];
    }
    var replyBox = $('<div class="reply-box"><textarea style="height:14px; display:block; overflow:hidden; resize:none; line-height:13px; width:300px;"></textarea></div>');
    $(this).after(replyBox);
    replyBox.children('textarea').focus();

    // hitting enter posts the reply
    replyBox.children('textarea').keydown(function(e) {
      var keyCode = e.keyCode || e.which,
          enter = 13;
      if (keyCode == enter) {
        e.preventDefault();
        var replyText = replyBox.children('textarea').val();

        $.ajax({
          type: 'POST',
          url: baseUrl+'users/ajax_get_logged_in_status',
          success: function(response) {
            var r = $.parseJSON(response);
            if (r.loggedin) {
              var postData = {
                userId: r.loggedin,
                messageId: messageId,
                suggestionId: suggestionId,
                text: replyText
              };
              
              $.ajax({
                type: 'POST',
                url: baseUrl+'replies/ajax_save_reply',
                data: postData,
                success: function(r) {
                  var r = $.parseJSON(r);
                  $('.reply-box').remove();
                  var html = [];
                  html[0] = '<li id="wall-reply-'+r.id+'" class="reply">';
                  html[1] = '<a href="'+baseUrl+'profile/'+r.uid+'" class="wall-item-author" style="text-decoration:none;">';
                  html[2] = r.userName;
                  html[3] = '</a>';
                  html[4] = ': '+r.text;
                  html[5] = ' <abbr class="timeago" title="'+r.created+'" style="color:#777; font-size: 12px;">'+r.created+'</abbr>';
                  html[6] = '</li>';
                  html = html.join('')
                  
                  parentElement.children('.wall-replies').prepend(html);
                  $('abbr.timeago').timeago();
                }
              });
            }
          }
        });
        
      }
    });
    
    return false;
  });
  
  
  $('.like, .unlike').click(function() {
    var likeElement = $(this),
        isLike;
    likeElement.hasClass('like') ? isLike=1 : isLike=0;
    var wallItem = $(this).parent();
    var wallItemId = wallItem.attr('id');
    
    var regex = /^.+-(.+)-(\d+)/;
    var match = regex.exec(wallItemId);
    if (match[1] == 'message') {
      var messageId = match[2];
    } else if (match[1] == 'suggestion') {
      var suggestionId = match[2];
    }
    
    $.ajax({
      type: 'POST',
      url: baseUrl+'users/ajax_get_logged_in_status',
      success: function(r) {
        var r = $.parseJSON(r);
        if (r.loggedin) {
          var postData = {
            userId: r.loggedin,
            messageId: messageId,
            suggestionId: suggestionId,
            isLike: isLike
          };
          
          $.ajax({
            type: 'POST',
            url: baseUrl+'likes/ajax_save_like',
            data: postData,
            success: function(r) {
              var r = $.parseJSON(r);
              likeElement.toggleClass('like');
              likeElement.toggleClass('unlike');
              if (isLike) {
                likeElement.html('Unlike');
                var numLikes = likeElement.next().html();
                if (numLikes != '') {
                  regex = /^(\d+).*/;
                  match = regex.exec(numLikes);
                  numLikes = parseInt(match[1])+1;
                  likeElement.next().html(numLikes+'people like this');
                } else {
                  likeElement.next().html('1 person likes this');
                }
              } else {
                likeElement.html('Like');
                var numLikes = likeElement.next().html();
                regex = /^(\d+).*/;
                match = regex.exec(numLikes);
                numLikes = parseInt(match[1])-1;
                if (numLikes >= 2) {
                  likeElement.next().html(numLikes+'people like this');
                } else if (numLikes == 2) {
                  likeElement.next().html('1 person likes this');
                }
              }
            }
          });
        }
      }
    });
  });
  
</script>

</body> 
</html>