<?php
$header_args = array(
    'title'=>$profile->name.' | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/profile/profile_map.js',
        'js/jquery/timeago.js',
    )
);

$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  map.lat = <?=$profile->destinations[0]->lat?>;
  map.lng = <?=$profile->destinations[0]->lng?>;
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
</style>
  
</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

    <!-- RIGHT COLUMN -->
    <div id="profile-col-right" style="float:right;">
      <? if ($user AND !$is_self):?>
        <? if ( ! $is_following):?>
          <a href="#" id="follow">FOLLOW</a>
        <? else:?>
          Following
        <? endif;?>
      <? endif;?>
      
      <!-- MAP -->
      <div style="display:none;">
        <? foreach ($profile->destinations as $destination):?>
          <a class="destination" lat="<?=$destination->lat?>" lng="<?=$destination->lng?>"></a>
        <? endforeach;?>
      </div>
      <div id="map-shell" style="padding:5px;">
        <div class="right-item-content" style="background-color:white; padding:3px; border:1px solid #EAEAEA;">
          <div id="map-canvas" style="height:312px;"></div>
        </div>
      </div>
      
      <!-- TRIPS CONTAINER -->
      <div id="profile-page-trips-container" style="width:320px;">
        <div id="profile-page-trips-list-header">
          Trips: (<?=count($trips)?>)
        </div>  
        <div id="profile-page-trips-list-content"><!-- TRIPS -->
          <? foreach ($trips as $trip):?>
            <div class="trip">
              <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
              <? foreach ($trip->places as $place):?>
                <span class="destination" lat="<?=$place->lat?>" lng="<?=$place->lng?>"><?=$place->name?></span>
              <? endforeach;?>
            </div>
          <? endforeach;?>
        </div><!-- TRIPS LIST END -->
      </div><!-- TRIPS CONTAINER ENDS -->

      <!-- FOLLOWERS CONTAINER -->
      <div>
        <div>
          Followers (<?=count($profile->followers)?>)
        </div>
        <div>
          <? foreach ($profile->followers as $follower):?>
          <div class="follower">
            <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
          </div>
          <? endforeach;?>
        </div>
      </div><!-- FOLLOWERS CONTAINER ENDS -->
        
      <!-- FOLLOWING CONTAINER -->
      <div>
        <div>
          Following (<?=count($profile->following)?>)
        </div>
        <div>
          <? foreach ($profile->following as $following):?>
          <div class="following">
            <a href="<?=site_url('profile/'.$following->id)?>"><?=$following->name?></a>
          </div>
          <? endforeach;?>
        </div>
      </div><!-- FOLLOWING CONTAINER ENDS -->
    </div><!-- RIGHT COLUMN ENDS -->


    <!-- LEFT COLUMN -->
    <div id="profile-col-left" style="width:520px;">
    
      <div id="profile-top-bar">
        <div id="profile-pic-container" style="position:relative; display:inline;">
          <a href="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" id="profile-pic"><img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" width="110" height="110"/></a>
          <a href="<?=site_url('profile/edit')?>" id="edit-profile-pic" style="position:absolute; top:-95px; left:0px; font-size:12px; background-color:black; color:white; display:none;">change picture</a>
        </div>
        
        <h2><?=$profile->name?></h2>
      </div>
      
      <div id="profile-feed">
        <? foreach ($profile_feed_items as $profile_feed_item):?>
          <div class="profile-feed-item">
            <a href="<?=site_url('trips/'.$profile_feed_item->trip->id)?>"><?=$profile_feed_item->trip->name?></a>
            <div class="content">
              <?=$profile_feed_item->content?>
            </div>
            <abbr class="timeago" title="<?=$profile_feed_item->created?>"><?=$profile_feed_item->created?></abbr>
          </div>
        <? endforeach;?>
      </div>
    </div>
            
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->


  <? $this->load->view('footer')?>

<script type="text/javascript">
$(function() {
  $('abbr.timeago').timeago();
});

  $('#follow').click(function() {
    $.post('<?=site_url('friends/ajax_add_following')?>', {profileId: <?=$profile->id?>},
      function(data) {
        if (data == 1) {
          $('#follow').remove();
          $('#profile-col-right').prepend('Following');
        } else {
          alert('something broken, tell David');
        }
      });
    return false;
  });

  <? if ($is_self):?>
    $('#profile-pic').hover(
      function() {
        $('#edit-profile-pic').show();
      },
      function() {
        $('#edit-profile-pic').hide();
      }
    );
    $('#edit-profile-pic').hover(
      function() {
        $('#edit-profile-pic').show();
      },
      function() {
        $('#edit-profile-pic').hide();
      }
    );  
  <? endif;?>
</script>

</body> 
</html>