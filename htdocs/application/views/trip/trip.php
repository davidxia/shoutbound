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
  
  map.lat = <?=$destinations[0]->lat?>;
  map.lng = <?=$destinations[0]->lng?>;
</script>

<style type="text/css">
#follow {
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
#follow:hover {
  background: #ffad32;
  background: -webkit-gradient(linear, left top, left bottom, from(#ffad32), to(#ff8132));
  background: -moz-linear-gradient(top,  #ffad32,  #ff8132);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffad32', endColorstr='#ff8132');
}
#follow:active {
  background: #ff8132;
  background: -webkit-gradient(linear, left top, left bottom, from(#ff8132), to(#ffad32));
  background: -moz-linear-gradient(top,  #ff8132,  #ffad32);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff8132', endColorstr='#ffad32');
}

#unfollow, #share {
  color:white;
  display:inline-block;
  width:150px;
  height:30px;
  line-height:30px;
  text-align:center;
  font-weight:bold;
  font-size:11px;
  text-decoration:none;
  background:-webkit-gradient(linear, left top, left bottom, from(#F42A2A), to(#DA0D0D));
  background:-moz-linear-gradient(top, #F42A2A, #DA0D0D);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#F42A2A', endColorstr='#DA0D0D');
  border: 1px solid #E55800;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  margin-bottom: 13px;
}
#unfollow:hover, #share:hover {
  background: #ffad32;
  background: -webkit-gradient(linear, left top, left bottom, from(#F42A2A), to(#DA0D0D));
  background: -moz-linear-gradient(top,  #F42A2A,  #DA0D0D);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#F42A2A', endColorstr='#DA0D0D');
}
#unfollow:active, #share:active {
  background: #ff8132;
  background: -webkit-gradient(linear, left top, left bottom, from(#F42A2A), to(#DA0D0D));
  background: -moz-linear-gradient(top,  #F42A2A,  #DA0D0D);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#F42A2A', endColorstr='#DA0D0D');
}
</style>

</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
  
  <div id="div-to-popup" style="display:none;"></div>
			  
			<div id="trip-col-right"><!--TRIPCOLRIGHT START-->
        <? if ( ! $user_role):?>
          <? if ($user_rsvp == 0):?>
            <a href="#" id="follow">FOLLOW</a>
          <? elseif ($user_rsvp == 3):?>
            <a href="#" id="unfollow">UNFOLLOW</a><a href="#" id="share">SHARE</a>
          <? endif;?>
        <? elseif ($user_role == 5):?>
          <? if ($user_rsvp == 0):?>
            <a href="#" id="rsvp_yes_button">I'M IN</a><a href="#" id="follow">FOLLOW</a><a href="#" id="share">SHARE</a>
          <? elseif ($user_rsvp == 3):?>
            <a href="#" id="rsvp_yes_button">I'M IN</a><a href="#" id="unfollow">UNFOLLOW</a><a href="#" id="share">SHARE</a>
          <? elseif ($user_rsvp == 6):?>
            <a href="#" id="rsvp_yes_button">I'M IN</a><a href="#" id="rsvp_no_button">I'M OUT</a><a href="#" id="share">SHARE</a>
          <? elseif ($user_rsvp == 9):?>
            <a href="#" id="rsvp_no_button">I'M OUT</a><a href="#" id="share">SHARE</a>
          <? endif;?>
        <? elseif ($user_role == 10):?>
          <a href="#" id="invite-others-button">INVITE OTHERS</a><a href="#" id="share">SHARE</a>
          <a id="delete-trip" href="#">DELETE</a>
        <? endif;?>
        
				<div class="item-header">Itinerary</div>
				<div id="itinerary"><!--ITINERARY START-->															
					<div class="right-item-content"><!--ITINERARY CONTENT-->         	
            <? foreach ($destinations as $destination):?>
              <div class="destination-dates">
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
		                <a href="<?=site_url('profile/'.$trip_goer->id)?>">
		                  <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="avatar" alt="<?=$trip_goer->name?>" height="38" width="38"/>
		                </a>
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
          <!--IF USER IS INVITED AND AWAITING RSVP, DISPLAY RSVP BUTTONS-->
          <? if ($user_rsvp == 2):?>
            <div id="countdown-container">Time left to respond:
             	<div id="countdown"></div>                  
    				</div>
    			<? elseif ($user_rsvp == 1):?>
            <div id="countdown-container">Time left to respond:
             	<div id="countdown"></div>                  
    				</div>
          <? endif;?>
        <? endif;?>
    	        
        <? if ($user_rsvp == 9):?>
          <div class="console">
            Get advice, ideas and recommendations for this trip by sharing it.
          </div>
          
        <? else:?>		          	
      		<div class="console">
          	Help <a href="<?=site_url('profile/'.$creator->id)?>"><?=$creator->name?></a> plan this trip by adding your thoughts and share this trip with other people.
          </div>
        <? endif;?>	            				
    	</div><!--WIDGET END-->									
															

      <!-- WALL -->
      <div id="wall">
      <? foreach ($wallitems as $wallitem):?>
        <div class="wallitem" id="wallitem-<?=$wallitem->id?>">
          <div class="content">
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
              <div class="content">
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
      </div><!-- WALL ENDS -->
      
					 		
      <!-- WALLITEM INPUT CONTAINER -->
      <div id="wallitem-input-container">
        <div contenteditable="true" id="wallitem-input" style="border:1px solid #333; min-height:60px;color:#333;"><br/></div>
        <div id="wallitem-post-button"><a href="#">Add</a></div>
      </div><!-- WALLITEM INPUT CONTAINER ENDS -->
		        	
    </div><!-- TRIPCOLLEFTSHELL ENDS -->
			
    <div id="autocomplete-box" style="background:#222; position:absolute; z-index:99; padding:3px;display:none;">
      <input id="autocomplete-input" type="text" style="width:150px;border:none;border-radius:2px; -moz-border-radius:2px; -webkit-border-radius:2px; padding:3px;"/>
      <img id="loading-places" src="<?=site_url('images/ajax-loader.gif')?>" width="16" height="16" style="position:absolute; right:20px; top:7px;"/>
      <a id="autocomplete-close" href="#">
        <img alt="close" src="<?=site_url('images/white_x.png')?>" width="10" height="9"/>
      </a>
      <div id="autocomplete-results" style="display:none; position:absolute; top:28px; width:400px; border:1px solid #DDD; cursor:pointer; padding:2px; z-index:100; background:white; font-size:13px;"></div>
    </div>

	</div><!-- WRAPPER ENDS --> 
</div><!-- CONTENT ENDS -->

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