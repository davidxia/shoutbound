<?php
$header_args = array(
    'title'=>$profile->name.' | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/jquery/timeago.js',
    )
);

$this->load->view('core_header', $header_args);
?>

<style type="text/css">
#add-friend-button {
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
#add-friend-button:hover {
  background: #ffad32;
  background: -webkit-gradient(linear, left top, left bottom, from(#ffad32), to(#ff8132));
  background: -moz-linear-gradient(top,  #ffad32,  #ff8132);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffad32', endColorstr='#ff8132');
}
#add-friend-button:active {
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
    <div id="profile-right-col" style="float:right;">
      <? if ($user AND $is_friend===0):?>
        <a href="#" id="add-friend-button">FOLLOW</a>
      <? elseif ($user AND $is_friend==1):?>
        You now follow <?=$profile->name?>
      <? elseif ($user AND $is_friend==2):?>
        YOU FOLLOW <?=$profile->name?> and he stalks you
      <? endif;?>
      
      <!-- TRIPS CONTAINER -->
      <div id="profile-page-trips-container">
        <div id="profile-page-trips-list-header">
          Trips: (<?=count($trips)?>)
        </div>  
        <div id="profile-page-trips-list-content"><!-- TRIPS -->
          <? foreach ($trips as $trip):?>
            <h3><a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a></h3>
            <? foreach ($trip->places as $place):?>
              <?=$place->name?>
            <? endforeach;?>
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
          <h3><a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a></h3>
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
          <h3><a href="<?=site_url('profile/'.$following->id)?>"><?=$following->name?></a></h3>
          <? endforeach;?>
        </div>
      </div><!-- FOLLOWING CONTAINER ENDS -->
    </div><!-- RIGHT COLUMN ENDS -->


    <!-- LEFT COLUMN -->
    <div id="profile-left-col" style="width:520px;">
    
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
  $('abbr.timeago').timeago();

  $('#add-friend-button').click(function() {
    var postData = {
      friendId: <?=$profile->id?>
    };
    
    $.ajax({
      type: 'POST',
      url: '<?=site_url('friends/ajax_add_friend')?>',
      data: postData,
      success: function(data) {
        if (data == 1) {
          $('#add-friend-button').remove();
          $('#rightcol').prepend('FRIEND REQUEST SENT');
        } else {
          alert('something broken, tell David');
        }
      }
    });
    return false;
  });
  
  if (<?=$is_friend?> == -1) {
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
  }
</script>

</body> 
</html>