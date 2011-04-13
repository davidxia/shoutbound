<?
$header_args = array(
    'title' => $trip->name.' | Shoutbound',
    'css_paths'=>array(
        'css/jquery.countdown.css',
        'css/trip-page.css',
    ),
    'js_paths'=>array(
        'js/user/loginSignup.js',
        'js/trip/map.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/jquery/popup.js',
        'js/trip/extras.js',
        'js/jquery/color.js',
        'js/jquery/scrollto.js',
        'js/jquery/timeago.js',
        'js/jquery/jquery.countdown.min.js',    
        'js/jquery/validate.min.js',
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
				<div class="item-header">Itinerary</div>
				<div id="itinerary"><!--ITINERARY START-->															
					<div class="right-item-content"><!--ITINERARY CONTENT-->         	
            <? foreach ($destinations as $destination):?>
              <div class="destination-dates">
  	            <a href="#"><?=$destination->name?></a>
  		            <? if ($destination->startdate AND $destination->enddate):?>
  		              <?=date('n/d/y', $destination->startdate)?> to <?=date('n/d/y', $destination->enddate)?>
  		            <? elseif ($destination->startdate AND ! $destination->enddate):?>
  		              <?=date('n/d/y', $destination->startdate)?> to (No date set)
  		            <? elseif ( ! $destination->startdate AND $destination->enddate):?>
  		              (No date set) to <?=date('n/d/y', $destination->enddate)?>
  		            <? else:?>
  		              No dates set
  		            <? endif;?>
  		        </div>
	          <? endforeach;?>
	     			     			                          																							
						<div id="trip_goers"><!--TRIP GOERS-->  
	          	<div id="num_trip_goers">          			              		
	              <? if (count($trip_goers) == 1):?>
	              <span id="num"><?=count($trip_goers)?></span> person is going on this trip.
	              <? else:?>              		
	              <span id="num"><?=count($trip_goers)?></span> people are going on this trip.
	              <? endif;?>           
	          	</div>  
        	        		          			                     
					    <? if ($trip_goers):?>
		            <? foreach ($trip_goers as $trip_goer):?>
		            	<div class="trip_goer" uid="<?=$trip_goer->id?>">
		                <a href="<?=site_url('profile/'.$trip_goer->id)?>"><img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" height="30" width="30"/></a>
		              </div>
		            <? endforeach;?>
			         <? endif;?>
		          
		          <div style="clear:both;"></div>
		          
		          <div>This trip was created by <a href="<?=site_url('profile/'.$creator->id)?>"><?=$creator->name?></a></div>	       
       			
  			
  					</div><!--TRIP GOERS END-->
    			</div><!--ITINERARY CONTENT END-->										
	    								
				</div><!--ITINERARY END-->
																	
				<!--MAP START-->
				<div id="map-container">
					<div class="item-header">Map</div>	
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
				<?=$trip->name?>
			</div> 
			<div id="trip_description"><?=$trip->description?></div>							
				
    	<div id="trip-widget"><!--WIDGET START--> 
    		<!--IF USER IS INVITED, DISPLAY RSVP STATUS-->
    		<? if ($user_role >= 2):?>
          <div id="rsvp_status">    
            <? if ($user_rsvp == 3):?>
              <!--You're going on this trip-->
            <? elseif ($user_rsvp == 2):?>
              You've been invited on this trip!
            <? elseif ($user_rsvp == 1):?>
              You can change your mind copy goes here
            <? endif;?>
          </div>
          
          <!--IF USER IS INVITED AND AWAITING RSVP, DISPLAY RSVP BUTTONS-->
          <? if ($user_rsvp == 2):?>
            <div id="rsvp_buttons">
              <a href="#" id="rsvp_yes_button">I'm in</a>
              <a href="#" id="rsvp_no_button">I'm out</a>		                
            </div>
            <div id="countdown-container">Time left to respond:
             	<div id="countdown"></div>                  
    				</div>
    			
    			<!--IF USER IS INVITED AND PREVIOUSLY RSVP'D NO, DISPLAY RSVP BUTTONS-->
    			<? elseif ($user_rsvp == 1):?>
            <div id="rsvp_buttons">
              <a href="#" id="rsvp_yes_button">I'm in</a>	                
            </div>
            <div id="countdown-container">Time left to respond:
             	<div id="countdown"></div>                  
    				</div>
          <? endif;?>
          
        <? endif;?><!--END-->					
    	        
        <? if ($user_rsvp == 3):?>
          <div class="console">
            Get advice, ideas and recommendations for this trip by <a href="#" id="get-suggestions-button">Sharing</a> it with other people. You can also <a href="#" id="invite-others-button">Invite</a>  other people to join you this trip.  	              
            <a href="#" id="rsvp_no_button">I'm out</a>
                     
            <? if ($user_role == 3):?>
            <a id="deletebutton" style="" href="<?=site_url('trips/delete').'/'.$trip->id?>">Delete this trip</a>                    
         		<? endif;?>	              
           </div>
          
        <? else:?>		          	
      		<div class="console">
          	Help <a href="<?=site_url('profile/'.$creator->id)?>"><?=$creator->name?></a> plan this trip by adding your thoughts and <a href="#" id="get-suggestions-button">Sharing</a> this trip with other people.
          </div>
        <? endif;?>	            				
    	</div><!--WIDGET END-->									
															

      <!-- WALL -->
      <div id="wall">
      <? foreach ($wallitems as $wallitem):?>
        <div class="wallitem" id="wallitem-<?=$wallitem->id?>">
          <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" height="30" width="30"/>
          <div class="author" style="margin-left:2px;">
            <?=$wallitem->user->name?>
          </div>
          <div class="content">
            <?=$wallitem->content?>
          </div>
          <div class="actionbar">
            <a class="reply-button" href="#">Add comment</a>           
            <a class="like-button" href="#">Like</a>
            <span class="num-likes">num-likes people like this</span>
            <abbr class="timeago" title="<?=$wallitem->created?>"><?=$wallitem->created?></abbr>            
          </div>
          <div class="remove-wallitem"></div>
          <? foreach ($wallitem->replies as $reply):?>
            <div class="wallitem reply" id="wallitem-<?=$reply->id?>">
              <span class="author">
                <?=$reply->user->name?>:
              </span>
              <span class="content">
                <?=$reply->content?>
              </span>
              <div class="actionbar">               
                <a class="like-button" href="#">Like</a>
                <span class="num-likes">num-likes people like this</span>
                <abbr class="timeago" title="<?=$reply->created?>"><?=$reply->created?></abbr>
              </div>
              <div class="remove-wallitem"></div>
            </div>
          <? endforeach;?>
        </div>
      <? endforeach;?>
      </div><!-- WALL ENDS -->
      
					 		
      <!-- WALLITEM INPUT CONTAINER -->
      <div id="wallitem-input-container">
        <label for="wallitem-input" id="wallitem-input-label">
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

  
  function loginSignupSuccess() {
    $('#div-to-popup').empty();
    wall.postWallitem();
  }

  
  // show countdown clock
  var deadline = new Date(<?=$trip->response_deadline?>*1000);
  $('#countdown').countdown({until: deadline});
  
  

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