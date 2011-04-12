<?php
$header_args = array(
    'title'=>$profile->name.' | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
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

      <!-- LEFT COLUMN -->
      <div id="profile-left-col">
      
        <div id="profile-top-bar">
          <div id="profile-pic-container" style="position:relative; display:inline;">
            <a href="#" id="profile-pic" style="cursor:pointer;"><img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" width="110" height="110"/></a>
            <a href="<?=site_url('profile/edit')?>" id="edit-profile-pic" style="position:absolute; top:-95px; left:0px; font-size:12px; background-color:black; color:white; display:none;">change picture</a>
          </div>
          
          <h2><?=$profile->name?></h2>         
        </div>
            
        <div id="feed-container">Feed<!--FEED CONTAINER-->
          <div id="news-feed">
            <? if ( ! $news_feed_items):?>
              <div style="padding:0px 0px 20px 20px;">You haven't had any activity yet.  Get started by <a href="<?=site_url('trips/create')?>">creating a trip</a>.</div>
            <? else:?>
              <ul style="margin: 0px 20px 0px 20px;">
                <? foreach($news_feed_items as $news_feed_item):?>
                  <li id="wall-item-<?=$news_feed_item->id?>">
                  <? if ($news_feed_item->is_location):?>
                    <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>" style="float:left;"><img src="<?=static_sub('profile_pics/'.$news_feed_item->profile_pic)?>" height="50" width="50"/></a>
                    <div style="display:table-cell; line-height:18px;">
                      <?=$news_feed_item->user_name?> suggested <span style="font-weight:bold;"><?=$news_feed_item->name?></span>
                      <br/>
                      for <a href="<?=site_url('trips/'.($news_feed_item->trip_id))?>"><?=$news_feed_item->trip_name?></a>
                      <br/>
                      <abbr class="timeago" title="<?=$news_feed_item->created?>" style="font-size:10px;"><?=$news_feed_item->created?></abbr>
                    </div>
                  <? else:?>
                    <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>" style="float:left;"><img src="<?=static_sub('profile_pics/'.$news_feed_item->profile_pic)?>" height="50" width="50"/></a>
                    <div style="display:table-cell; line-height:18px;">
                      <?=$news_feed_item->user_name?> wrote <span style="font-weight:bold;"><?=$news_feed_item->text?></span>
                      <br/>
                      on <a href="<?=site_url('trips/'.($news_feed_item->trip_id))?>"><?=$news_feed_item->trip_name?></a>
                      <br/>
                      <abbr class="timeago" title="<?=$news_feed_item->created?>" style="font-size:10px;"><?=$news_feed_item->created?></abbr>
                    </div>
                  <? endif;?>
                  </li>
                <? endforeach;?>
              </ul>
            <? endif;?>
  			   </div><!-- NEWS FEED ENDS -->
        </div><!--FEED CONTAINER ENDS-->
             
      <!-- RIGHT COLUMN -->
      <div id="profile-right-col">
        <? if ($user AND $is_friend===0):?>
          <a href="#" id="add-friend-button">FOLLOW</a>
        <? elseif ($user AND $is_friend==1):?>
          You now follow [username]!
        <? elseif ($user AND $is_friend==2):?>
          YOU FOLLOW [username]
        <? endif;?>
        
        <!-- TRIPS CONTAINER -->
        <div id="profile-page-trips-container">
          <div id="profile-page-trips-list-header">
            Trips: (<?=count($trips)?>)
          </div>  
          <div id="profile-page-trips-list-content"><!-- TRIPS -->
            <? foreach ($trips as $trip):?>
              <h3><a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a></h3>
              <p><?=$trip->destinations[0]->address?></p>
            <? endforeach;?>
          </div><!-- TRIPS LIST END -->
        </div><!-- TRIPS CONTAINER ENDS -->

        <!-- FRIENDS CONTAINER -->
        <div>
          <div>
            Friends (<?=count($friends)?>)
          </div>
          <div>
            <? foreach ($friends as $friend):?>
            <h3><a href="<?=site_url('profile/'.$friend->id)?>"><?=$friend->name?></a></h3>
            <? endforeach;?>
          </div>
        </div><!-- FRIENDS CONTAINER END -->
          
      </div><!-- RIGHT COLUMN ENDS -->
      
      <div style="clear:both;"></div>
            
    </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->


  <?=$this->load->view('footer')?>

<script type="text/javascript">
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
</script>

</body> 
</html>