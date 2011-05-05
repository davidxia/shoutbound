<?
$header_args = array(
    'title' => $trip->name.' | Shoutbound',
    'css_paths'=>array(
        //'css/jquery.countdown.css',
        'css/trip-page.css',
    ),
    'js_paths'=>array(
        'js/jquery/jquery.ba-bbq.min.js',
        'js/user/loginSignup.js',
        'js/trip/map.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/jquery/popup.js',
        'js/jquery/jquery.color.js',
        'js/jquery/timeago.js',
        //'js/jquery/jquery.countdown.min.js',    
    )
);
$this->load->view('core_header', $header_args);
?>


<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var staticSub = '<?=static_sub()?>';
  var tripId = <?=$trip->id?>;
  
  map.lat = <?=$trip->places[0]->lat?>;
  map.lng = <?=$trip->places[0]->lng?>;
  map.swLat = <?=$trip->places[0]->sw_lat?>;
  map.swLng = <?=$trip->places[0]->sw_lng?>;
  map.neLat = <?=$trip->places[0]->ne_lat?>;
  map.neLng = <?=$trip->places[0]->ne_lng?>;
</script>

</head>

<body>

<div id="sticky-footer-wrapper">

  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

      <div id="top-bar"><!--TOP BAR-->
        
        <div id="trip-info">     

          <div class="top-bar-header"><?=$trip->name?></div>
          
          <div class="destinationbar">
          
            <? $prefix=''; foreach ($trip->places as $destination):?>
              <div class="destination-dates">
                <?=$prefix;?>
  	            <a class="destination tag" lat="<?=$destination->lat?>" lng="<?=$destination->lng?>" href="<?=site_url('places/'.$destination->id)?>"><?=$destination->name?></a>
  		            <? if ($destination->startdate AND $destination->enddate):?>
  		              <span class="subtext"><?=date('F j, Y', $destination->startdate)?> - <?=date('F j, Y', $destination->enddate)?></span>
  		            <? elseif ($destination->startdate AND ! $destination->enddate):?>
  		              <span class="subtext"><?=date('F j, Y', $destination->startdate)?>
  		            <? elseif ( ! $destination->startdate AND $destination->enddate):?>
  		              <span class="subtext"> - <?=date('F j, Y', $destination->enddate)?>
  		            <? endif;?>
  		        </div>
  		        <? $prefix = '<span class="bullet" style="margin-left:3px; display:none">&#149</span>'?>
            <? endforeach;?>
          </div>     

          <div id="trip-description"><?=$trip->description?></div>
                          			        
      </div><!--TOP BAR END-->
      
      <div id="follow-and-stats-container" style="display:none"><!--FOLLOW BUTTON + STATS-->     
      
        <div id="num_trip_goers">          			              		
          <? $num_trip_goers = count($trip->goers); if ($num_trip_goers == 1):?>
          <span id="num"><?=$num_trip_goers?></span> person is going on this trip.
          <? else:?>              		
          <span id="num"><?=$num_trip_goers?></span> people are going on this trip.
          <? endif;?>           
      	</div>
        
        <? if ( ! $user_role):?>
          <? if ($user_rsvp == 0):?>
            <a href="#" class="follow">Follow</a>
          <? elseif ($user_rsvp == 3):?>
            <a href="#" class="unfollow">Unfollow</a><a href="#" id="share">Share</a>
          <? endif;?>
        <? elseif ($user_role == 5):?>
          <? if ($user_rsvp == 0):?>
            <a href="#" id="rsvp_yes_button">I'm in</a><a href="#" class="follow">Follow</a><a href="#" id="share">Share</a>
          <? elseif ($user_rsvp == 3):?>
            <a href="#" id="rsvp_yes_button">I'm in</a><a href="#" class="unfollow">Unfollow</a><a href="#" id="share">Share</a>
          <? elseif ($user_rsvp == 6):?>
            <a href="#" id="rsvp_yes_button">I'm in</a><a href="#" id="rsvp_no_button">I'm out</a><a href="#" id="share">Share</a>
          <? elseif ($user_rsvp == 9):?>
            <a href="#" id="rsvp_no_button">I'm out</a><a href="#" id="share">Share</a>
          <? endif;?>
        <? elseif ($user_role == 10):?>
          <a href="#" id="invite-others-button">Invite others</a><a href="#" id="share">Share</a>
          <a id="delete-trip" href="#">Delete</a>
        <? endif;?>
        
        <div id="trip-widget"><!--WIDGET START-->
          
          <div id="trip_goers"><!--TRIP GOERS-->  
    			        	        		          			                     
            <? foreach ($trip->goers as $trip_goer):?>
            	<div class="streamitem-avatar-container baritem" uid="<?=$trip_goer->id?>">
                <a href="<?=site_url('profile/'.$trip_goer->id)?>">
                  <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="tooltip" alt="<?=$trip_goer->name?>" height="35" width="35"/>
                </a>
              </div>
            <? endforeach;?>
	          
	          <div style="clear:both;"></div>
	          
	          <!--<div>This trip was created by <a href="<?=site_url('profile/'.$trip->creator->id)?>"><?=$trip->creator->name?></a></div>-->	       
					</div><!--TRIP GOERS END-->
	          
	         </div>
         
          <div id="countdown-container">Time left to respond:
            <div id="countdown"></div>                  
    		  </div>
          <div class="console">
            Get advice, ideas and recommendations for this trip by sharing it.
          </div>
          Related trips: (list other trips within X distance)
    	   </div><!--WIDGET END-->	
                
      </div><!-- FOLLOW BUTTON + STATS END-->  
    
    <div style="clear:both"></div>  

    <!-- LEFT COLUMN -->
    <div id="col-left">    
      
      <!--LEFT CONTENT-->      
      <div id="left-content-container">
      
        <ul id="main-tabs">
          <li><a href="#posts">Posts</a></li>
          <li><a href="#followers">Followers</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
        
          <!-- POSTS TAB -->
          <div id="posts-tab" class="main-tab-content main-tab-default">
            
            <? $first=TRUE; foreach ($wallitems as $wallitem):?>            
              <div id="wallitem-<?=$wallitem->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem"><!--POSTITEM START-->
              
                <div class="streamitem-avatar-container">
                  <a href="<?=site_url('profile/'.$wallitem->user_id)?>">
                    <img src="<?=static_sub('profile_pics/'.$wallitem->user->profile_pic)?>" class="tooltip" height="25" width="25" alt="<?=$trip_goer->name?>"/>
                  </a>
                </div>
                
                <!--POSTITEM CONTENT CONTAINER-->
                <div class="streamitem-content-container">                
                  <div class="streamitem-name">
                    <a href="<?=site_url('profile/'.$wallitem->user_id)?>">
                      <?=$wallitem->user->name?>
                    </a>               
                  </div>                           
                  <div class="streamitem-content">
                    <?=$wallitem->content?>
                  </div>             
                  
                  <!--ACTIONBAR START-->                 
                  <div class="actionbar">
                    <div id="repost-postitem" class="bar-item">
                      <a href="#">Add to trip</a>                      
                    </div>
                    <span class="bullet">&#149</span>
                    <div class="bar-item">
                      <a class="show-comments" href="#"><? $num_comments=count($wallitem->replies); echo $num_comments.' comment'; if($num_comments!=1){echo 's';}?></a>
                    </div>
                    <span class="bullet">&#149</span>                    
                    <div class="bar-item">
                      <a class="show-trips" href="#"><? $num_trips=count($wallitem->trips); echo $num_trips.' trip'; if($num_trips!=1){echo 's';}?></a>
                    </div>
                    <span class="bullet">&#149</span>                        
                    <div class="bar-item">
                      <abbr class="timeago subtext" title="<?=$wallitem->created?>"><?=$wallitem->created?></abbr>
                    </div>                        
                  </div><!--ACTIONBAR END-->
                    
                  <!--COMMENTS CONTAINER START-->
                  <div class="comments-container" style="display:none;">
                  
                    <? foreach ($wallitem->replies as $comment):?>                  
                    <div class="comment"><!--COMMENT START-->
                      <div class="streamitem-avatar-container">
                        <a href="<?=site_url('profile/'.$comment->user_id)?>">
                          <img src="<?=static_sub('profile_pics/'.$comment->user->profile_pic)?>" height="25" width="25"/>
                        </a>
                      </div>
                      
                      <!--COMMENT CONTENT START-->                      
                      <div class="comment-content-container">
                        <div class="streamitem-name">
                          <a href="<?=site_url('profile/'.$comment->user_id)?>"><?=$comment->user->name?></a>
                        </div> 
                        <div class="comment-content">
                          <?=$comment->content?>
                        </div>
                        <div class="comment-timestamp">
                          <abbr class="timeago subtext" title="<?=$comment->created?>"><?=$comment->created?></abbr>
                        </div>                      
                      </div><!--COMMENT CONTENT END-->
                                          
                    </div><!--COMMENT END-->                     
                    <? endforeach;?>
                                       
                    <div class="comment-input-container">
                      <textarea class="comment-input-area"/></textarea>
                      <a class="add-comment-button" href="#">Add comment</a>
                    </div> 
                     
                  </div><!--COMMENT CONTAINER END-->

                  <!--TRIP LISTING CONTAINER START-->
                  <div class="trip-listing-container" style="display:none;">
                  
                  <? foreach ($wallitem->trips as $trip):?>
                    <div class="streamitem"><!--TRIP-LISTING-START-->
                    
                      <div class="streamitem-name">
                        <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
                      </div>
                      <div class="destinationbar">
                        <? $prefix=''; foreach ($trip->places as $place):?>
                          <span class="place bar-item"><a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a></span>
                          <?=$prefix?>
                          <? $prefix = '<span class="bullet">&#149</span>'?>
                        <? endforeach;?>
                      </div>
                    </div>
                  <? endforeach;?>
                  
                  </div><!--TRIP LISTING CONTAINER END-->
                  
                </div><!--POSTITEM CONTENT CONTAINER END-->
                  
              </div><!--POSTITEM END-->
            <? endforeach;?> 
            
            <!--OLD LIKES/DISLIKES CODE-->                              
              <!--<? $is_liked = 0; foreach ($wallitem->likes as $like):?><? if (isset($user) AND $like->user_id==$user->id AND $like->is_like==1):?>
                <? $is_liked = 1;?>
              <? endif;?><? endforeach;?>
              <? if ($is_liked == 0):?>
                <a class="like-button" href="#">Like</a>
              <? else:?>
                <a class="unlike-button" href="#">Unlike</a>
              <? endif;?>
              <? $num_likes = 0; foreach($wallitem->likes as $like) {if ($like->is_like==1) {$num_likes++;}}?><? if ($num_likes == 1):?><span class="num-likes"><?=$num_likes?> person likes this</span><? elseif ($num_likes > 1):?><span class="num-likes"><?=$num_likes?> people like this</span><? endif;?>-->
            <!--OLD LIKES/DISLIKES CODE END--> 
            
            <!--OLD REMOVE WALLITEM COMMENTS START-->                             
              <!--<div class="remove-wallitem"></div>
              <? foreach ($wallitem->replies as $reply):?>
                <div class="wallitem reply" id="wallitem-<?=$reply->id?>">
                  <div class="postcontent">
                    <?=$reply->content?>
                  </div>                     
              <? endforeach;?>-->
            <!--OLD REMOVE WALLITEM COMMENTS END--> 
                            
          </div><!--POSTS TAB ENDS-->          
          
        </div><!--TAB CONTAINER END-->
                   
      </div><!--LEFT CONTENT END-->
      
      <!-- WALLITEM INPUT CONTAINER -->
      <div id="wallitem-input-container">
        <div contenteditable="true" id="wallitem-input" style="border:1px solid #333; min-height:60px;color:#333;"><br/></div>
        <div id="wallitem-post-button"><a href="#">Add</a></div>
      </div><!-- WALLITEM INPUT CONTAINER ENDS -->
		        	
      <div id="autocomplete-box" style="background:#222; position:absolute; z-index:99; padding:3px;display:none;">
        <input id="autocomplete-input" type="text" style="width:150px;border:none;border-radius:2px; -moz-border-radius:2px; -webkit-border-radius:2px; padding:3px;"/>
        <img class="loading-places" src="<?=site_url('images/ajax-loader.gif')?>" width="16" height="16" style="position:absolute; right:20px; top:7px;"/>
        <a id="autocomplete-close" href="#">
          <img alt="close" src="<?=site_url('images/white_x.png')?>" width="10" height="9"/>
        </a>
        <div id="autocomplete-results" style="display:none; position:absolute; top:28px; width:400px; border:1px solid #DDD; cursor:pointer; padding:2px; z-index:100; background:white; font-size:13px;"></div>
      </div>

    </div><!--LEFT COLUMN END-->
    
    <!-- RIGHT COLUMN -->
    <div id="col-right">      
      
      <!-- MAP -->
      <div id="map-shell">
        <div id="map-canvas"></div>
      </div><!--MAP ENDS-->
      
    </div><!-- RIGHT COLUMN ENDS -->
            
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  			  
</div><!--END STICKY FOOTER WRAPPER-->
<? $this->load->view('footer')?>

<script type="text/javascript">
  // show countdown clock
  //var deadline = new Date(<?=$trip->response_deadline?>*1000);
  //$('#countdown').countdown({until: deadline});
  

  $(function() {
    $('#delete-trip').click(function() {
      if (confirm ('Are you sure you want to delete this awesome trip?')) {
        window.location = "<?=site_url('trips/delete').'/'.$trip->id?>";
      }
      return false;
    });
  });
  
  
  $(function() {
    var delay;
    $('.tooltip').live('mouseover mouseout', function(e) {
      if (e.type == 'mouseover') {
        var img = $(this);
        
        delay = setTimeout(function() {
          var title = img.attr('alt');
    
          // element location and dimensions
          var element_offset = img.offset(),
              element_top = element_offset.top,
              element_left = element_offset.left,
              element_height = img.height(),
              element_width = img.width();
          
          var tooltip = $('<div class="tooltip_container"><div class="tooltip_interior">'+title+'</div></div>');
          $('body').append(tooltip);
      
          // tooltip dimensions
          var tooltip_height  = tooltip.height();
          var tooltip_width = tooltip.width();
          tooltip.css({ top: (element_top + element_height + 3) + 'px' });
          tooltip.css({ left: (element_left - (tooltip_width / 2) + (element_width / 2)) + 'px' });
        }, 200);
      } else {
        $('.tooltip_container').remove();
        clearTimeout(delay);
      }
    });
  });
</script>

</body> 
</html>