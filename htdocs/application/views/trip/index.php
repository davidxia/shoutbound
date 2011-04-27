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
        'js/jquery/jquery.color.js',
        'js/jquery/timeago.js',
        'js/jquery/jquery.countdown.min.js',    
        'js/jquery/validate.min.js',
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
</script>

</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

      <div id="top-bar"><!--TOP BAR-->
        
        <div id="trip-info">
          <h1><?=$trip->name?></h1>
    			<div id="trip_description"><?=$trip->description?></div>
    			
    			<div id="trip_goers"><!--TRIP GOERS-->  
    			        	        		          			                     
	            <? foreach ($trip->goers as $trip_goer):?>
	            	<div class="trip_goer" uid="<?=$trip_goer->id?>">
	                <a href="<?=site_url('profile/'.$trip_goer->id)?>">
	                  <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="avatar" alt="<?=$trip_goer->name?>" height="38" width="38"/>
	                </a>
	              </div>
	            <? endforeach;?>
		          
		          <div style="clear:both;"></div>
		          
		          <!--<div>This trip was created by <a href="<?=site_url('profile/'.$trip->creator->id)?>"><?=$trip->creator->name?></a></div>-->	       
  					</div><!--TRIP GOERS END-->
    				         	
            <? foreach ($trip->places as $destination):?>
              <span class="destination-dates">
  	            <a class="destination" lat="<?=$destination->lat?>" lng="<?=$destination->lng?>" href="#"><?=$destination->name?></a>
  		            <? if ($destination->startdate AND $destination->enddate):?>
  		              <?=date('n/d/y', $destination->startdate)?> to <?=date('n/d/y', $destination->enddate)?>
  		            <? elseif ($destination->startdate AND ! $destination->enddate):?>
  		              <?=date('n/d/y', $destination->startdate)?> to (No date set)
  		            <? elseif ( ! $destination->startdate AND $destination->enddate):?>
  		              (No date set) to <?=date('n/d/y', $destination->enddate)?>
  		            <? else:?>
  		              No dates set
  		            <? endif;?>
  		        </span>
	          <? endforeach;?>
	          
	         </div>
        
      </div><!--TOP BAR END-->
      
      <div id="follow-and-stats-container"><!--FOLLOW BUTTON + STATS-->     
      
      <div id="num_trip_goers">          			              		
	              <? $num_trip_goers = count($trip->goers); if ($num_trip_goers == 1):?>
	              <span id="num"><?=$num_trip_goers?></span> person is going on this trip.
	              <? else:?>              		
	              <span id="num"><?=$num_trip_goers?></span> people are going on this trip.
	              <? endif;?>           
	          	</div>
        
        <? if ( ! $user_role):?>
          <? if ($user_rsvp == 0):?>
            <a href="#" id="follow">Follow</a>
          <? elseif ($user_rsvp == 3):?>
            <a href="#" id="unfollow">Unfollow</a><a href="#" id="share">Share</a>
          <? endif;?>
        <? elseif ($user_role == 5):?>
          <? if ($user_rsvp == 0):?>
            <a href="#" id="rsvp_yes_button">I'm in</a><a href="#" id="follow">Follow</a><a href="#" id="share">Share</a>
          <? elseif ($user_rsvp == 3):?>
            <a href="#" id="rsvp_yes_button">I'm in</a><a href="#" id="unfollow">Unfollow</a><a href="#" id="share">Share</a>
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
          <div id="countdown-container">Time left to respond:
            <div id="countdown"></div>                  
    		  </div>
          <div class="console">
            Get advice, ideas and recommendations for this trip by sharing it.
          </div>                  				
    	   </div><!--WIDGET END-->	
                
      </div><!-- FOLLOW BUTTON + STATS END-->  
    
    <div style="clear:both"></div>  

    <!-- LEFT COLUMN -->
    <div id="col-left">    
      
      <!--MAIN CONTENT-->      
      <div id="main-content-container">
      
        <ul id="main-tabs">
          <li><a href="#wall">Posts</a></li>
          <li><a href="#followers">Followers</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
        
          <!-- WALL TAB -->
          <div id="wall-tab" class="main-tab-content main-tab-default">
            <? foreach ($wallitems as $wallitem):?>
              <div class="wallitem" id="wallitem-<?=$wallitem->id?>">
                <div class="postcontent">
                  <?=$wallitem->content?>
                </div>             
                
                <div class="actionbar">
                  <a class="wallitem-profile-pic" href="<?=site_url('profile/'.$wallitem->user_id)?>">
                    <img src="<?=static_sub('profile_pics/'.$wallitem->user->profile_pic)?>" class="avatar" height="22" width="22" alt="<?=$trip_goer->name?>"/>
                  </a>
                  
                  <a href="<?=site_url('profile/'.$wallitem->user_id)?>" class="author">
                    <?=$wallitem->user->name?>
                  </a> 
                  <a class="reply-button" href="#">Add comment</a>           
                  <? $is_liked = 0; foreach ($wallitem->likes as $like):?><? if (isset($user) AND $like->user_id==$user->id AND $like->is_like==1):?>
                    <? $is_liked = 1;?>
                  <? endif;?><? endforeach;?>
                  <? if ($is_liked == 0):?>
                    <a class="like-button" href="#">Like</a>
                  <? else:?>
                    <a class="unlike-button" href="#">Unlike</a>
                  <? endif;?>
                  <? $num_likes = 0; foreach($wallitem->likes as $like) {if ($like->is_like==1) {$num_likes++;}}?><? if ($num_likes == 1):?><span class="num-likes"><?=$num_likes?> person likes this</span><? elseif ($num_likes > 1):?><span class="num-likes"><?=$num_likes?> people like this</span><? endif;?>
                  <abbr class="timeago" title="<?=$wallitem->created?>"><?=$wallitem->created?></abbr>            
      
                </div> 
                <div class="remove-wallitem"></div>
                <? foreach ($wallitem->replies as $reply):?>
                  <div class="wallitem reply" id="wallitem-<?=$reply->id?>">
                    <div class="postcontent">
                      <?=$reply->content?>
                    </div>
                    <div class="actionbar">
                      <a href="<?=site_url('profile/'.$reply->user_id)?>" class="author"><?=$reply->user->name?></a>             
                      <? $is_liked = 0; foreach ($reply->likes as $like):?><? if (isset($user) AND $like->user_id==$user->id AND $like->is_like==1):?>
                        <? $is_liked = 1;?>
                      <? endif;?><? endforeach;?>
                      <? if ($is_liked == 0):?>
                        <a class="like-button" href="#">Like</a>
                      <? else:?>
                        <a class="unlike-button" href="#">Unlike</a>
                      <? endif;?>
                  <? $num_likes = 0; foreach($reply->likes as $like) {if ($like->is_like==1) {$num_likes++;}}?><? if ($num_likes == 1):?><span class="num-likes"><?=$num_likes?> person likes this</span><? elseif ($num_likes > 1):?><span class="num-likes"><?=$num_likes?> people like this</span><? endif;?>
                      <abbr class="timeago" title="<?=$reply->created?>"><?=$reply->created?></abbr>
                    </div>
                    <div class="remove-wallitem"></div>
                  </div>
                <? endforeach;?>
              </div>
            <? endforeach;?>
          </div><!--WALL TAB ENDS-->          
          
        </div><!--TAB CONTAINER END-->
                   
      </div><!--MAIN CONTENT END-->
      
      <!-- WALLITEM INPUT CONTAINER -->
      <div id="wallitem-input-container">
        <div contenteditable="true" id="wallitem-input" style="border:1px solid #333; min-height:60px;color:#333;"><br/></div>
        <div id="wallitem-post-button"><a href="#">Add</a></div>
      </div><!-- WALLITEM INPUT CONTAINER ENDS -->
		        	
      <div id="autocomplete-box" style="background:#222; position:absolute; z-index:99; padding:3px;display:none;">
        <input id="autocomplete-input" type="text" style="width:150px;border:none;border-radius:2px; -moz-border-radius:2px; -webkit-border-radius:2px; padding:3px;"/>
        <img id="loading-places" src="<?=site_url('images/ajax-loader.gif')?>" width="16" height="16" style="position:absolute; right:20px; top:7px;"/>
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
  
  <div id="div-to-popup" style="display:none;"></div>
			  

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
    $('.avatar').mouseover(function() {
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
    }).mouseout(function() {
      $('.tooltip_container').remove();
      clearTimeout(delay);
    });
  });
</script>

</body> 
</html>