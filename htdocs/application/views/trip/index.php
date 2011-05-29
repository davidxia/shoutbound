<?
$header_args = array(
    'title' => $trip->name.' | Shoutbound',
    'css_paths'=>array(
        'css/trip-page.css',
    ),
    'js_paths'=>array(
        'js/jquery/jquery.ba-bbq.min.js',
        'js/user/loginSignup.js',
        'js/jquery/nicEdit.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/follow.js',
        'js/savepost.js',
        'js/common.js',
        'js/actionbar.js',
    )
);
$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var staticUrl = '<?=static_sub()?>';
  var tripId = <?=$trip->id?>;
  
  var lat = <?=$trip->places[0]->lat?>;
  var lng = <?=$trip->places[0]->lng?>;
  var swLat = <?=$trip->places[0]->sw_lat?>;
  var swLng = <?=$trip->places[0]->sw_lng?>;
  var neLat = <?=$trip->places[0]->ne_lat?>;
  var  neLng = <?=$trip->places[0]->ne_lng?>;
</script>
</head>

<body>
<div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>

  <div id="top-section">
    <div id="top-bar"><!--TOP BAR-->       
      <div id="trip-info">     
        <div id="tagbar">
          <? foreach ($trip->places as $destination):?>
          <a class="destination tag" lat="<?=$destination->lat?>" lng="<?=$destination->lng?>" href="<?=site_url('places/'.$destination->id)?>"><?=$destination->name?></a>
          <? endforeach;?>
        </div>          
        <div class="top-bar-header"><?=$trip->name?></div>   
        <div id="trip-description"><?=$trip->description?></div>          
       </div><!--TRIP INFO END-->                           			        

  		  <div id="trip-goers"><!--TRIP GOERS-->      	        		          			                     
          <? foreach ($trip->goers as $trip_goer):?>
        	<div class="goer-avatar" uid="<?=$trip_goer->id?>">
            <a href="<?=site_url('profile/'.$trip_goer->id)?>">
              <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="tooltip" alt="<?=$trip_goer->name?>" height="48" width="48"/>
            </a>
          </div>
          <? endforeach;?>       
          <!--<div>This trip was created by <a href="<?=site_url('profile/'.$trip->creator->id)?>"><?=$trip->creator->name?></a></div>-->       
        </div><!--TRIP GOERS END-->        	       

    </div><!--TOP BAR END-->  
    
    <div id="right-widgets">
    
      <div class="right-widget-container">
        <div id="actions-container"><!--ACTIONS CONTAINER-->                    
          <? if ($user_role == 5):?>
            <? if ($user_rsvp == 0):?>
              <a href="#" id="share" class="share left">Share</a><a href="#" class="follow middle" id="trip-<?=$trip->id?>">Follow</a><a href="#" id="rsvp_yes_button" class="gray_rsvp_yes_button right">I'm in</a>
            <? elseif ($user_rsvp == 3):?>
              <a href="#" id="rsvp_yes_button" class="gray_rsvp_yes_button right">I'm in</a><a href="#" class="unfollow right" id="trip-<?=$trip->id?>">Unfollow</a><a href="#" id="share" class="share left">Share</a>
            <? elseif ($user_rsvp == 6):?>
              <a href="#" id="rsvp_yes_button" class="rsvp_yes_button left">I'm in</a><a href="#" id="rsvp_no_button" class="gray_rsvp_no_button right">I'm out</a><a href="#" id="share" class="share left">Share</a>
            <? elseif ($user_rsvp == 9):?>
              <a href="#" id="rsvp_no_button" class="gray_rsvp_no_button right">I'm out</a><a href="#" id="share" class="share left">Share</a>
            <? endif;?>
          <? elseif ($user_role == 10):?>
            <a href="#" id="invite-others-button" class="edit-trip-button">Invite others</a><a href="#" id="share" class="share left">Share</a>
            <a id="delete-trip" href="#">Delete</a>
          <? endif;?> 
        <? if (!$user_role):?>
          <? if ($user_rsvp == 0):?>
            <a href="#" class="follow left" id="trip-<?=$trip->id?>">Follow</a>
          <? elseif ($user_rsvp == 3):?>
            <a href="#" class="unfollow left" id="trip-<?=$trip->id?>">Unfollow</a><a href="#" id="share">Share</a>
          <? endif;?>
        <? endif;?>               
        </div><!--ACTIONS CONTAINER END-->
      </div>	

      <div class="right-widget-container">
        <div id="stats-container" class="right-widget-interior"><!--STATS-->
          <ul class="stats-list">
            <li><a style="cursor:default;" class="goers-count"><?=$trip->num_goers?><span class="stat-label">People</span></a></li>
            <li class="border-left"><a href="#posts" class="post-count"><?=count($posts)?><span class="stat-label">Posts</span></a></li>
            <li class="border-left"><a href="#followers" class="followers-count"><?=$trip->num_followers?><span class="stat-label">Followers</span></a></li>
          </ul>     
          <div style="clear:both"></div>   
        </div><!--STATS END-->
      </div>
        
    </div><!--RIGHT WIDGETS END-->
    
  </div><!--TOP SECTION END-->

    <!-- LEFT COLUMN -->
    <div id="col-left">
      
      <!--LEFT CONTENT-->      
      <div id="left-content-container">
      
        <ul id="main-tabs">
          <li><a href="#posts">Posts</a></li>
          <li><a href="#followers">Followers</a></li>
          <li><a href="#related_trips">Related Trips</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
        
          <!-- POSTS TAB -->
          <div id="posts-tab" class="main-tab-content main-tab-default">
            
            <? $prefix1='first-item'; foreach ($posts as $post):?>
              <!--POST START-->
              <div id="post-<?=$post->id?>" class="<?=$prefix1?> streamitem <? if($user_role == 10):?>deleteable<? endif;?>">
                <? $prefix1=''?>
                <? if($user_role == 10):?><div class="delete"></div><? endif;?>
                <div class="streamitem-avatar-container">
                  <a href="<?=site_url('profile/'.$post->user_id)?>">
                    <img src="<?=static_sub('profile_pics/'.$post->user->profile_pic)?>" height="25" width="25"/>
                  </a>
                </div>
                
                <!--POST CONTENT CONTAINER-->
                <div class="streamitem-content-container">                
                  <div class="streamitem-name">
                    <a href="<?=site_url('profile/'.$post->user_id)?>"><?=$post->user->name?></a>
                  </div>
                  <? if (isset($post->added_by) AND $post->added_by):?>
                    <div>Added by <a href="<?=site_url('profile/'.$post->added_by->id)?>"><?=$post->added_by->name?></a></div>
                  <? endif;?>
                  <div class="streamitem-content">
                    <?=$post->content?>
                  </div>             
                  
                  <!--ACTIONBAR START-->                 
                  <div class="actionbar">
                    <div id="repost-post" class="bar-item">
                      <a class="add-to-trip" href="#">Add to trip</a>                      
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
                    
                  <!-- ADD TO TRIP -->
                  <div class="add-to-trip-cont" style="display:none;">
                    <select multiple="multiple" size=5>
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
                    <a class="post-to-trip" href="#">Post</a>
                  </div>
                  <!-- ADD TO TRIP END -->
            
                  <!--COMMENTS START-->
                  <div class="comments-container" style="display:none;">
                    <? foreach ($post->replies as $comment):?>
                    <div class="comment">
                      <div class="streamitem-avatar-container">
                        <a href="<?=site_url('profile/'.$comment->user_id)?>">
                          <img src="<?=static_sub('profile_pics/'.$comment->user->profile_pic)?>" height="28" width="28"/>
                        </a>
                      </div>                      
                      <div class="streamitem-content-container">
                        <div class="streamitem-name">
                          <a href="<?=site_url('profile/'.$comment->user_id)?>"><?=$comment->user->name?></a>
                        </div>
                        <div class="comment-content"><?=$comment->content?></div>
                        <div class="comment-timestamp"><abbr class="timeago subtext" title="<?=$comment->created?>"><?=$comment->created?></abbr></div>                      
                      </div>
                    </div>
                    <? endforeach;?>
                    <div class="comment-input-container">
                      <textarea class="comment-input-area"/></textarea>
                      <a class="add-comment-button" href="#">Add comment</a>
                    </div>  
                  </div><!--END COMMENT CONTAINER-->
              
                  <!--TRIP LISTING CONTAINER START-->
                  <div class="trip-listing-container" style="display:none;">
                  <? foreach ($post->trips as $trip):?>
                    <div class="trip-listing">
                      <div class="trip-listing-name"><a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a></div>
                      <div class="trip-listing-destination-container">
                      <? $prefix=''; foreach ($trip->places as $place):?>
                        <?=$prefix?>
                        <span class="trip-listing-destination"><a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a></span>
                        <span class="subtext"><? if($place->startdate){echo date('F j, Y',$place->startdate);} if($place->startdate AND $place->enddate){echo ' - ';} if ($place->enddate){echo date('F j, Y', $place->enddate);}?></span>
                        <? $prefix = '<span class="bullet">&#149</span>'?>
                      <? endforeach;?>
                      </div>
                    </div>
                  <? endforeach;?>
                  </div><!--TRIP LISTING CONTAINER END-->
                  
                </div><!--POST CONTENT CONTAINER END-->
                  
              </div><!--POST END-->
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
            
            <!--OLD REMOVE POST COMMENTS START-->                             
              <!--<div class="remove-post"></div>
              <? foreach ($post->replies as $reply):?>
                <div class="post reply" id="post-<?=$reply->id?>">
                  <div class="postcontent">
                    <?=$reply->content?>
                  </div>                     
              <? endforeach;?>-->
            <!--OLD REMOVE POST COMMENTS END--> 
                            
          </div><!--POSTS TAB ENDS-->          
          
        </div><!--TAB CONTAINER END-->
                   
      </div><!--LEFT CONTENT END-->

      <!--POST CONTAINER-->
      <div class="input-container">
        <form class="save-post-form">
          <fieldset>
            <span class="input-header">New post</span>
            <div contenteditable="true" id="post-input"></div>
            <div style="display:none;">
              <span class="input-header">Places</span><span class="input-instructions">(e.g., "Bangkok, Chiang Mai, Thailand")</span>
              <div contenteditable="true" class="tag-input"></div>
              <span class="input-header">Trips</span><br>
              <select id="trip-selection" name="trip-selection" multiple="multiple" size=5>
                <? foreach ($user->rsvp_yes_trips as $t):?>
                <option value="<?=$t->id?>"><?=$t->name?>
                <? endforeach;?>
                <? foreach ($user->rsvp_awaiting_trips as $t):?>
                <option value="<?=$t->id?>"><?=$t->name?>
                <? endforeach;?>
                <? foreach ($user->following_trips as $t):?>
                <option value="<?=$t->id?>"><?=$t->name?>
                <? endforeach;?>
                </select>
            </div>
          </fieldset>
        </form>
        <a id="save-post-button">Post</a>
      </div><!--END POST CONTAINER-->

		        	
      <div id="autocomplete-box" style="background:#222; position:absolute; z-index:99; padding:3px;display:none;">
        <input id="autocomplete-input" type="text" style="width:150px;border:none;border-radius:2px; -moz-border-radius:2px; -webkit-border-radius:2px; padding:3px;"/>
        <img class="loading-places" src="<?=site_url('static/images/ajax-loader.gif')?>" width="16" height="16" style="position:absolute; right:20px; top:7px;"/>
        <a id="autocomplete-close" href="#">
          <img alt="close" src="<?=site_url('static/images/white_x.png')?>" width="10" height="9"/>
        </a>
        <div id="autocomplete-results" style="display:none; position:absolute; top:28px; width:400px; border:1px solid #DDD; cursor:pointer; padding:2px; z-index:100; background:white; font-size:13px;"></div>
      </div>

    </div><!--LEFT COLUMN END-->

  <!-- RIGHT COLUMN -->
  <div id="col-right">      

    <!--RIGHT CONTENT-->      
    <div id="right-content-container">
    
      <!-- GALLERY AND MAP-->
      <ul id="right-tabs">
        <li style="cursor:pointer;" tab="map">Map</li>
        <li style="cursor:pointer;" tab="itinerary">Itinerary</li>
      </ul>
      
      <div class="right-tab-container">          
        <div id="map-tab" class="right-tab-content">
          <div id="map-canvas"></div>     
        </div>
        <div id="itinerary-tab" class="right-tab-content" style="display:none">
          <? $prefix=''; foreach ($trip->places as $destination):?>
          <?=$prefix;?>
            <span class="destination" lat="<?=$destination->lat?>" lng="<?=$destination->lng?>" href="<?=site_url('places/'.$destination->id)?>" title="<?=$destination->name?>"><?=$destination->name?></span>  
            <? if ($destination->startdate AND $destination->enddate):?>
              <span class="subtext"><?=date('F j, Y', $destination->startdate)?> - <?=date('F j, Y', $destination->enddate)?></span><br>
            <? elseif ($destination->startdate AND ! $destination->enddate):?>
              <span class="subtext"><?=date('F j, Y', $destination->startdate)?></span><br>
            <? elseif ( ! $destination->startdate AND $destination->enddate):?>
              <span class="subtext"> - <?=date('F j, Y', $destination->enddate)?></span><br>
            <? endif;?>
          <? $prefix = '<span class="bullet" style="margin-left:3px; display:none">&#149</span>'?>   
          <? endforeach;?>
        </div>
      </div>
                                      

      </div><!--RIGHT CONTENT END-->

      
    </div><!-- RIGHT COLUMN ENDS -->
                
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  			  
</div><!--END STICKY FOOTER WRAPPER-->
<? $this->load->view('templates/footer')?>

<script type="text/javascript">
  // show countdown clock
  //var deadline = new Date(<?=$trip->response_deadline?>*1000);
  //$('#countdown').countdown({until: deadline});
  

  $(function() {
    $('#delete-trip').click(function() {
      if (confirm('Are you sure you want to delete this awesome trip?')) {
        window.location = '<?=site_url('trips/delete/'.$trip->id)?>';
      }
      return false;
    });
    
    $('#right-tabs').children(':first').addClass('active');
  });
</script>
</body> 
</html>