<?
$header_args = array(
    'title' => $trip->name.' | Shoutbound',
    'css_paths'=>array(
        'css/jquery.countdown.css',
        'css/trip-page.css'
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
        'js/jquery/jquery.countdown.min.js'
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

	<div id="trip-content"><!--TRIPCONTENT START-->
			  
			<div id="trip-col-right"><!--TRIPCOLRIGHT START-->
				<div class="item-header"><h3>Itinerary</h3></div>
				<div id="itinerary"><!--ITINERARY START-->															
					<div class="right-item-content"><!--ITINERARY CONTENT-->         	
	          <? foreach ($destinations as $destination):?>
	            <p class="regular"><?=$destination->address?></p>
	          <? endforeach;?>
	          	
		       		<div id="destination-start-dates">
		          <p class="subtext"><? foreach ($destinations as $destination):?>
		            <? if ($destination->startdate AND $destination->enddate):?>
		              <?=date('n/d/y', $destination->startdate)?> to <?=date('n/d/y', $destination->enddate)?>
		            <? elseif ($destination->startdate AND ! $destination->enddate):?>
		              <?=date('n/d/y', $destination->startdate)?> to (No date set)
		            <? elseif ( ! $destination->startdate AND $destination->enddate):?>
		              (No date set) to <?=date('n/d/y', $destination->enddate)?>
		            <? else:?>
		              No dates set
		            <? endif;?>
		          	<? endforeach;?></p>
							</div>		          
	     			     			                          																							
							<div id="trip_goers"><!--TRIP GOERS-->         			
		          	<div id="num_trip_goers">          			              		
		              <? if (count($trip_goers) == 1):?>
		              <div id="num"><p class="subtext"><?=count($trip_goers)?> person is going on this trip.</div>                
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
								
			<div id="trip-col-left-shell"><!--TRIPCOLLEFTSHELL START-->				      
				<div id="trip-name">
					<h1><?=$trip->name?></h1>
				</div> 
				<div id="trip_description"><p class="description"><?=$trip->description?></p></div>							
						
				<div id="widget-and-wall"><!--WIDGET AND WALL START-->
						
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
		              You're being lame and said no, but you can still change your mind.
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
	              <div class="invsugg_btns">
	                <p class="regular">You can <a href="#" id="invite-others-button">Invite</a>  other people to join this trip.  You should <a href="#" id="get-suggestions-button">Share</a> this trip with other people to get advice, ideas and recommendations.
	              
			            <a href="#" id="rsvp_no_button">I'm out</a>
                           
		              <? if ($user_role == 3):?>
			            <a id="deletebutton" style="" href="<?=site_url('trips/delete').'/'.$trip->id?>">Delete this trip</a></p>                    
			         		<? endif;?>	              
		             </div>
		            
		          <? else:?>		          	
	          		<div class="invsugg_btns">
			          	<p class="regular">Help <a href="<?=site_url('profile/'.$creator->id)?>" style="text-decoration:none; color:navy;"><?=$creator->name?></a> plan this trip by adding your thoughts and <a href="#" id="get-suggestions-button">Sharing</a> this trip with other people.</p>
			          </div>
		          <? endif;?>	            				
						</div><!--WIDGET END-->									
															
						<div id="trip-wall"><!--WALL START-->
					 		<!-- WALL CONTENT -->
			        <ul id="wall-content">
			          <? foreach ($wall_items as $wall_item):?>
			            <? if ($wall_item->lat):?>
			              <li id="wall-suggestion-<?=$wall_item->id?>" class="suggestion">
			                <div class="wall-location-name"><?=$wall_item->name?></div>
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
			                <? if ($wall_item->likes[$user->id] != 1):?>
			                  <span class="like">Like</span>
			                <? else:?>
			                  <span class="unlike">Unlike</span>
			                <? endif;?>
			                <span class="num-likes">
			                <? if ($wall_item->num_likes == 1):?>
			                  1 person likes this
			                <? elseif ($wall_item->num_likes >= 1):?>
			                  <?=$wall_item->num_likes?> people like this
			                <? endif;?>
			                </span>
			                
			                <a href="#" class="reply">reply</a>
			                <ul class="wall-replies" style="margin-left:10px;">
			                  <? foreach ($wall_item->replies as $reply):?>
			                    <li id="wall-reply-<?=$reply->id?>" class="reply">
			                      <a href="<?=site_url('profile/'.$wall_item->user_id)?>" class="wall-item-author"><?=$reply->user_name?></a>: <?=$reply->text?>
			                      <br/>
			                      <abbr class="timeago" title="<?=$reply->created?>" style="color:#777; font-size: 12px;"><?=$reply->created?></abbr>
			                    </li>
			                  <? endforeach;?>
			                </ul>
			              </li>
			            <? else:?>
			              <li id="wall-message-<?=$wall_item->id?>" class="message">
			                <a href="<?=site_url('profile/'.$wall_item->user_id)?>" class="wall-item-author" style="text-decoration:none;"><?=$wall_item->user_name?></a>
			                <? if ($user_role >= 2):?>
			                  <div class="remove-wall-item" messageId="<?=$wall_item->id?>"></div>
			                <? endif;?>
			                <span class="wall-item-text"><?=$wall_item->text?></span>
			                <br/>
			                <abbr class="timeago" title="<?=$wall_item->created?>"><?=$wall_item->created?></abbr>
			                <? if ($wall_item->likes[$user->id] != 1):?>
			                  <span class="like" style="cursor:pointer;">Like</span>
			                <? else:?>
			                  <span class="unlike" style="cursor:pointer;">Unlike</span>
			                <? endif;?>
			                <span class="num-likes">
			                <? if ($wall_item->num_likes == 1):?>
			                  1 person likes this
			                <? elseif ($wall_item->num_likes >= 1):?>
			                  <?=$wall_item->num_likes?> people like this
			                <? endif;?>
			                </span>
			                
			                <a href="#" class="reply">reply</a>
			                <ul class="wall-replies">
			                  <? foreach ($wall_item->replies as $reply):?>
			                    <li id="wall-reply-<?=$reply->id?>" class="reply">
			                      <a href="<?=site_url('profile/'.$wall_item->user_id)?>" class="wall-item-author" style="text-decoration:none;"><?=$reply->user_name?></a>: <?=$reply->text?>
			                      <abbr class="timeago" title="<?=$reply->created?>"><?=$reply->created?></abbr>
			                    </li>
			                  <? endforeach;?>
			                </ul>
			              </li>
			            <? endif;?>
			          <? endforeach;?>		          
			          
			        </ul><!-- WALL CONTENT ENDS -->
	        	</div> <!--WALL ENDS-->
	        </div><!--WIDGET AND WALL ENDS-->  
	             
	        <div id="add-to-wall">
	        	<!-- WALL INPUT CONTAINER -->
		        <div id="wall-input-container;">
		        	<label for="message-box"><h2>Add Message:</h2></label>
		          	<div id="message-box-container">		            
		            	<textarea id="message-box"></textarea>
		        			
		        		</div>
		        		<div id="wall-post-button"><a href="#">Add</a></div>
		          </div>
		          
		                     
		          <!-- LOCATION SEARCH -->
		          <!-- <div id="location-search">
		            <label for="location-search-box"><span>Location (optional)</span></label>
		            <input type="hidden" class="location-data" id="location-name" name="location-name" />
		            <input type="hidden" class="location-data" id="location-phone" name="location-phone" />
		            <input type="hidden" class="location-data" id="location-lat" name="location-lat" />
		            <input type="hidden" class="location-data" id="location-lng" name="location-lng" />
		            <input type="text" id="location-search-box"/>-->
		            <!-- AUTO LOC LIST -->
		            <!--<div id="auto-loc-list">
		              <ul id="location-autosuggest"></ul>
		            </div>--><!-- AUTO LOC LIST ENDS -->
		            <!--<div id="marker-notification" style="position:absolute; top:-65px; right:-400px; z-index:1000; display:none; color:white; background-color:black; opacity:0.8; -moz-box-shadow: 2px 2px 5px black; -webkit-box-shadow: 2px 2px 5px black; box-shadow: 2px 2px 5px black; padding:10px;">You can drag and drop the pin anywhere you want.</div>
		            <div style="clear:both;"></div>
		          </div>--><!-- LOCATION SEARCH ENDS -->
		                        
		          <!--<div id="link-input">
		            <label for="link-input-box"><span>Link (optional)</span></label>
		            <input type="text" id="link-input-box"/>
		          </div>-->
		          
		        </div><!-- WALL INPUT CONTAINER -->
	        	
	        </div><!--ADD TO WALL END-->
		        	
				</div><!--TRIPCOLLEFTCONTENT END-->
			</div><!--TRIPCOLLEFTSHELL END-->
			
		</div><!--TRIPCONTENT END-->

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


  function textAreaAdjust(o) {
    o.style.height = "8px";
    o.style.height = (8+o.scrollHeight)+"px";
	}

  $(document).ready(function() {
    $('#message-box').labelFader();
    $('#location-search-box').labelFader();
    $('#link-input-box').labelFader();
  });
  
  /*Expand message box area dynamically*/
  
  $('#message-box').keyup(function() {
  	textAreaAdjust(this);
  });
  
  
  /*function expandMessageBox() {
    $('#message-box').html('').css('height', '50px');
    $('#location-search').show();
    $('#link-input').show();
    $('#wall-post-button').css('display', 'block');
  }*/
  
  
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