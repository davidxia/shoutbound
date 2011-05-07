<?
$header_args = array(
    'title' => $trip->name.' | Shoutbound',
    'css_paths'=>array(
        //'css/jquery.countdown.css',
        'css/trip-page.css',
        'css/excite-bike/jquery-ui-1.8.11.custom.css',

    ),
    'js_paths'=>array(
        'js/jquery/jquery.ba-bbq.min.js',
        'js/user/loginSignup.js',
        'js/trip/map.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/follow.js',
        'js/jquery/jquery.color.js',
        'js/jquery/timeago.js',
        //'js/jquery/jquery.countdown.min.js',    
        'js/jquery/jquery-ui-1.8.11.custom.min.js',
        'js/jquery/multiselect.min.js',
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

    <!-- RIGHT COLUMN -->
    <div id="col-right">      

      <div id="itinerary"><!--ITINERARY-->  
        <? $prefix=''; foreach ($trip->places as $destination):?>
          <?=$prefix;?>
            <span class="destination" lat="<?=$destination->lat?>" lng="<?=$destination->lng?>" href="<?=site_url('places/'.$destination->id)?>"><?=$destination->name?></span>  
            <? if ($destination->startdate AND $destination->enddate):?>
              <span class="subtext"><?=date('F j, Y', $destination->startdate)?> - <?=date('F j, Y', $destination->enddate)?></span><br>
            <? elseif ($destination->startdate AND ! $destination->enddate):?>
              <span class="subtext"><?=date('F j, Y', $destination->startdate)?></span><br>
            <? elseif ( ! $destination->startdate AND $destination->enddate):?>
              <span class="subtext"> - <?=date('F j, Y', $destination->enddate)?></span><br>
            <? endif;?>
          <? $prefix = '<span class="bullet" style="margin-left:3px; display:none">&#149</span>'?>   
        <? endforeach;?>
      </div><!--ITINERARY END-->
        
      <!--<span id="num_trip_goers">          			              		
        <? $num_trip_goers = count($trip->goers); if ($num_trip_goers == 1):?>
        <span id="num"><?=$num_trip_goers?></span> person is going.
        <? else:?>              		
        <span id="num"><?=$num_trip_goers?></span> people are going.
        <? endif;?>           
    	</span>-->
      			           
      <div id="trip-actions-container"><!--TRIP ACTIONS CONTAINER-->                  
        <? if (!$user_role):?>
          <? if ($user_rsvp == 0):?>
            <a href="#" class="follow" id="trip-<?=$trip->id?>">Follow</a>
          <? elseif ($user_rsvp == 3):?>
            <a href="#" class="unfollow" id="trip-<?=$trip->id?>">Unfollow</a><a href="#" id="share">Share</a>
          <? endif;?>
        <? elseif ($user_role == 5):?>
          <? if ($user_rsvp == 0):?>
            <a href="#" id="rsvp_yes_button">I'm in</a><a href="#" class="follow" id="trip-<?=$trip->id?>">Follow</a><a href="#" id="share">Share</a>
          <? elseif ($user_rsvp == 3):?>
            <a href="#" id="rsvp_yes_button">I'm in</a><a href="#" class="unfollow" id="trip-<?=$trip->id?>">Unfollow</a><a href="#" id="share">Share</a>
          <? elseif ($user_rsvp == 6):?>
            <a href="#" id="rsvp_yes_button">I'm in</a><a href="#" id="rsvp_no_button">I'm out</a><a href="#" id="share">Share</a>
          <? elseif ($user_rsvp == 9):?>
            <a href="#" id="rsvp_no_button">I'm out</a><a href="#" id="share">Share</a>
          <? endif;?>
        <? elseif ($user_role == 10):?>
          <a href="#" id="invite-others-button">Invite others</a><a href="#" id="share">Share</a>
          <a id="delete-trip" href="#">Delete</a>
        <? endif;?>        
      </div><!-- TRIP ACTIONS CONTAINER END-->	
                              
      <!-- MAP -->
      <div id="map-shell">
        <div id="map-canvas"></div>
      </div><!--MAP ENDS-->
      
    </div><!-- RIGHT COLUMN ENDS -->


      <div id="top-bar"><!--TOP BAR-->       
        <div id="trip-info">     
          <div id="tagbar">          
            <? $prefix=''; foreach ($trip->places as $destination):?>
              <?=$prefix;?>
	            <a class="destination tag" lat="<?=$destination->lat?>" lng="<?=$destination->lng?>" href="<?=site_url('places/'.$destination->id)?>"><?=$destination->name?></a>
            <? endforeach;?>
              <a href="#" class="activity tag">Hiking</a>
              <a href="#" class="activity tag">Exploring</a>
              <a href="#" class="activity tag">Local culture</a>
              <a href="#" class="activity tag">Adventure</a>
          </div>          
          <div class="top-bar-header"><?=$trip->name?></div>   
          <div id="trip-description"><?=$trip->description?></div>          
         </div><!--TRIP INFO END-->                           			        

    		  <div id="trip-goers"><!--TRIP GOERS-->      	        		          			                     
            <? foreach ($trip->goers as $trip_goer):?>
            	<div class="streamitem-avatar-container bar-item" uid="<?=$trip_goer->id?>">
                <a href="<?=site_url('profile/'.$trip_goer->id)?>">
                  <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="tooltip" alt="<?=$trip_goer->name?>" height="48" width="48"/>
                </a>
              </div>
            <? endforeach;?>       
            <!--<div>This trip was created by <a href="<?=site_url('profile/'.$trip->creator->id)?>"><?=$trip->creator->name?></a></div>-->       
          </div><!--TRIP GOERS END-->        	       

      </div><!--TOP BAR END-->

    <!-- LEFT COLUMN -->
    <div id="col-left">    
      
      <!--LEFT CONTENT-->      
      <div id="left-content-container">
      
        <ul id="main-tabs">
          <li><a href="#posts">Posts</a></li>
          <li><a href="#followers">Followers</a></li>
          <li><a href="#related-trips">Related Trips</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
        
          <!-- POSTS TAB -->
          <div id="posts-tab" class="main-tab-content main-tab-default">
            
            <? $prefix1='first-item'; foreach ($wallitems as $post):?>
              <!--POSTITEM START-->
              <div id="post-<?=$post->id?>" class="<?=$prefix1?> streamitem <? if($user_role == 10):?>deleteable<? endif;?>">
                <? $prefix1=''?>
                <? if($user_role == 10):?><div class="delete"></div><? endif;?>
                <div class="streamitem-avatar-container">
                  <a href="<?=site_url('profile/'.$post->user_id)?>">
                    <img src="<?=static_sub('profile_pics/'.$post->user->profile_pic)?>" height="25" width="25"/>
                  </a>
                </div>
                
                <!--POSTITEM CONTENT CONTAINER-->
                <div class="streamitem-content-container">                
                  <div class="streamitem-name">
                    <a href="<?=site_url('profile/'.$post->user_id)?>">
                      <?=$post->user->name?>
                    </a>               
                  </div>                           
                  <div class="streamitem-content">
                    <?=$post->content?>
                  </div>             
                  
                  <!--ACTIONBAR START-->                 
                  <div class="actionbar">
                    <div id="repost-postitem" class="bar-item">
                      <a href="#">Add to trip</a>                      
                    </div>
                    <span class="bullet">&#149</span>
                    <div class="bar-item">
                      <a class="show-comments" href="#"><? $num_comments=count($post->replies); echo $num_comments.' comment'; if($num_comments!=1){echo 's';}?></a>
                    </div>
                    <span class="bullet">&#149</span>                    
                    <div class="bar-item">
                      <a class="show-trips" href="#"><? $num_trips=count($post->trips); echo $num_trips.' trip'; if($num_trips!=1){echo 's';}?></a>
                    </div>
                    <span class="bullet">&#149</span>                        
                    <div class="bar-item">
                      <abbr class="timeago subtext" title="<?=$post->created?>"><?=$post->created?></abbr>
                    </div>                        
                  </div><!--ACTIONBAR END-->
                    
                  <!--COMMENTS CONTAINER START-->
                  <div class="comments-container" style="display:none;">
                  
                    <? foreach ($post->replies as $comment):?>                  
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
                  
                  <? foreach ($post->trips as $trip):?>
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
              <!--<? $is_liked = 0; foreach ($post->likes as $like):?><? if (isset($user) AND $like->user_id==$user->id AND $like->is_like==1):?>
                <? $is_liked = 1;?>
              <? endif;?><? endforeach;?>
              <? if ($is_liked == 0):?>
                <a class="like-button" href="#">Like</a>
              <? else:?>
                <a class="unlike-button" href="#">Unlike</a>
              <? endif;?>
              <? $num_likes = 0; foreach($post->likes as $like) {if ($like->is_like==1) {$num_likes++;}}?><? if ($num_likes == 1):?><span class="num-likes"><?=$num_likes?> person likes this</span><? elseif ($num_likes > 1):?><span class="num-likes"><?=$num_likes?> people like this</span><? endif;?>-->
            <!--OLD LIKES/DISLIKES CODE END--> 
            
            <!--OLD REMOVE WALLITEM COMMENTS START-->                             
              <!--<div class="remove-wallitem"></div>
              <? foreach ($post->replies as $reply):?>
                <div class="wallitem reply" id="wallitem-<?=$reply->id?>">
                  <div class="postcontent">
                    <?=$reply->content?>
                  </div>                     
              <? endforeach;?>-->
            <!--OLD REMOVE WALLITEM COMMENTS END--> 
                            
          </div><!--POSTS TAB ENDS-->          
          
        </div><!--TAB CONTAINER END-->
                   
      </div><!--LEFT CONTENT END-->

      <div id="wallitem-input-container"><!--WALLITEM INPUT CONTAINER-->
       <div class="input-container">

          <form id="item-post-form">
            <fieldset>
              <span class="input-header">New post</span>
              <div contenteditable="true" id="wallitem-input" class="postitem-input-form"></div>
              <span class="input-header">Places</span><span class="input-instructions">(e.g., "Bangkok, Chiang Mai, Thailand")</span>
              <div contenteditable="true" id="tag-input" class="tag-input-form"></div>
              <span class="input-header">Trips</span><br>
              <select id="trip-selection" name="trip-selection" multiple="multiple" size=5>
                <? foreach ($user->rsvp_yes_trips as $trip):?>
                <option value="<?=$trip->id?>"><?=$trip->name?>
                <? endforeach;?>
                <? foreach ($user->rsvp_awaiting_trips as $trip):?>
                <option value="<?=$trip->id?>"><?=$trip->name?>
                <? endforeach;?>
                <? foreach ($user->following_trips as $trip):?>
                <option value="<?=$trip->id?>"><?=$trip->name?>
                <? endforeach;?>
                </select>
            </fieldset>
          </form>
          <a id="post-item" class="new-postitem">Post</a>

         </div>

      </div><!--END POSTITEM CONTAINER-->

		        	
      <div id="autocomplete-box" style="background:#222; position:absolute; z-index:99; padding:3px;display:none;">
        <input id="autocomplete-input" type="text" style="width:150px;border:none;border-radius:2px; -moz-border-radius:2px; -webkit-border-radius:2px; padding:3px;"/>
        <img class="loading-places" src="<?=site_url('images/ajax-loader.gif')?>" width="16" height="16" style="position:absolute; right:20px; top:7px;"/>
        <a id="autocomplete-close" href="#">
          <img alt="close" src="<?=site_url('images/white_x.png')?>" width="10" height="9"/>
        </a>
        <div id="autocomplete-results" style="display:none; position:absolute; top:28px; width:400px; border:1px solid #DDD; cursor:pointer; padding:2px; z-index:100; background:white; font-size:13px;"></div>
      </div>

    </div><!--LEFT COLUMN END-->
                
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