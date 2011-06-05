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
            <a href="<? if($trip_goer->username){echo site_url($trip_goer->username);}else{echo site_url('profile/'.$trip_goer->id);}?>">
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
          <? if ($user->role == 5):?>
            <? if ($user->rsvp == 0):?>
              <a href="#" id="share" class="share left">Share</a><a href="#" class="follow middle" id="trip-<?=$trip->id?>">Follow</a><a href="#" id="rsvp_yes_button" class="gray_rsvp_yes_button right">I'm in</a>
            <? elseif ($user->rsvp == 3):?>
              <a href="#" id="rsvp_yes_button" class="gray_rsvp_yes_button right">I'm in</a><a href="#" class="unfollow right" id="trip-<?=$trip->id?>">Unfollow</a><a href="#" id="share" class="share left">Share</a>
            <? elseif ($user->rsvp == 6):?>
              <a href="#" id="rsvp_yes_button" class="rsvp_yes_button left">I'm in</a><a href="#" id="rsvp_no_button" class="gray_rsvp_no_button right">I'm out</a><a href="#" id="share" class="share left">Share</a>
            <? elseif ($user->rsvp == 9):?>
              <a href="#" id="rsvp_no_button" class="gray_rsvp_no_button right">I'm out</a><a href="#" id="share" class="share left">Share</a>
            <? endif;?>
          <? elseif ($user->role == 10):?>
            <a href="#" id="invite-others-button" class="edit-trip-button">Invite others</a><a href="#" id="share" class="share left">Share</a>
            <a id="delete-trip" href="#">Delete</a>
          <? endif;?> 
        <? if (!$user->role):?>
          <? if ($user->rsvp == 3):?>
            <a href="#" class="unfollow left" id="trip-<?=$trip->id?>">Unfollow</a><a href="#" id="share">Share</a>
          <? else:?>
            <a href="#" class="follow left" id="trip-<?=$trip->id?>">Follow</a>
          <? endif;?>
        <? endif;?>               
        </div><!--ACTIONS CONTAINER END-->
      </div>	

      <div class="right-widget-container">
        <div id="stats-container" class="right-widget-interior"><!--STATS-->
          <ul class="stats-list">
            <li><a style="cursor:default;" class="goers-count"><?=$trip->num_goers?><span class="stat-label">People</span></a></li>
            <li class="border-left"><a href="#posts" class="post-count"><?=count($trip->posts)?><span class="stat-label">Posts</span></a></li>
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
            
            <? $prefix1='first-item'; foreach ($trip->posts as $post):?>
              <!--POST START-->
              <div id="post-<?=$post->id?>" class="<?=$prefix1?> streamitem <? if(isset($user->id) AND ($user->role==10 OR ($post->added_by->id==$user->id))):?>deleteable<? endif;?>">
                <? $prefix1=''?>
                <? if(isset($user->id) AND ($user->role==10 OR ($post->added_by->id==$user->id))):?><div class="delete"></div><? endif;?>
                <div class="streamitem-avatar-container">
                  <a href="<? if($post->author->username){echo site_url($post->author->username);}else{echo site_url('profile/'.$post->user_id);}?>">
                    <img src="<?=static_sub('profile_pics/'.$post->author->profile_pic)?>" height="25" width="25"/>
                  </a>
                </div>
                
                <!--POST CONTENT CONTAINER-->
                <div class="streamitem-content-container">                
                  <div class="streamitem-name">
                    <a href="<? if($post->author->username){echo site_url($post->author->username);}else{echo site_url('profile/'.$post->author->id);}?>"><?=$post->author->name?></a>
                  </div>
                  <? if ($post->added_by->id):?>
                    <div>Added by <a href="<? if($post->added_by->username){echo site_url($post->added_by->username);}else{echo site_url('profile/'.$post->added_by->id);}?>"><?=$post->added_by->name?></a></div>
                  <? endif;?>
                  <div class="streamitem-content">
                    <?=$post->content?>
                  </div>             
                  
                  <!--ACTIONBAR START-->                 
                  <div class="actionbar">
                    <? if(isset($user->id)):?>
                    <div id="repost-post" class="bar-item">
                      <a class="add-to-trip" href="#">Add to trip</a>                      
                    </div>
                    <span class="bullet">&#149</span>
                    <? endif;?>
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
                  
                  <? if(isset($user->id)):?>
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
                  <? endif;?>
            
                  <!--COMMENTS START-->
                  <div class="comments-container" style="display:none;">
                    <? foreach ($post->replies as $comment):?>
                    <div class="comment">
                      <div class="streamitem-avatar-container">
                        <a href="<?=site_url('profile/'.$comment->user_id)?>">
                          <img src="<?=static_sub('profile_pics/'.$comment->author->profile_pic)?>" height="28" width="28"/>
                        </a>
                      </div>                      
                      <div class="streamitem-content-container">
                        <div class="streamitem-name">
                          <a href="<?=site_url('profile/'.$comment->user_id)?>"><?=$comment->author->name?></a>
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
                        <span class="subtext"><? if($place->dates['startdate']){echo date('F j, Y',$place->dates['startdate']);} if($place->dates['startdate'] AND $place->dates['enddate']){echo ' - ';} if ($place->dates['enddate']){echo date('F j, Y', $place->dates['enddate']);}?></span>
                        <? $prefix = '<span class="bullet">&#149</span>'?>
                      <? endforeach;?>
                      </div>
                    </div>
                  <? endforeach;?>
                  </div><!--TRIP LISTING CONTAINER END-->
                  
                </div><!--POST CONTENT CONTAINER END-->
                  
              </div><!--POST END-->
            <? endforeach;?> 
                                                    
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
              <? if(isset($user->id)):?>
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
              <? endif;?>
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
          <? foreach ($trip->places as $place):?>
          <div>
            <span class="destination" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>" title="<?=$place->name?>"><?=$place->name?></span>  
            <span class="subtext"><? if($place->dates['startdate']){echo date('F j, Y',$place->dates['startdate']);} if($place->dates['startdate'] AND $place->dates['enddate']){echo ' - ';} if ($place->dates['enddate']){echo date('F j, Y', $place->dates['enddate']);}?></span>
          </div>
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
  //var deadline = new Date(<?//$trip->response_deadline?>*1000);
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