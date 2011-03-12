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

  <?=$this->load->view('header')?>


  <div class="wrapper" style="margin:0 auto; width:960px;">
    <div class="content" style="margin-top:20px; padding-bottom:80px;">
      
      <!-- LEFT COLUMN -->
      <div style="float:left; width:640px; margin-right:20px;">
        <div style="background-color: #F9F9F9; border:1px solid #CCC; margin-bottom:13px; padding:10px; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px;">
          <div style="float:left; margin-right:10px; padding:5px; background-color:white; border: 1px solid #CCC;">
            <a href="#" style="background:transparent url('<?=site_url('images/sample_profile_pic.png')?>') no-repeat 0 0; display:block; text-indent:-10000px; width:110px; height:110px;">profile picture</a>
          </div>
          <div style="background-color:#E6E6E6; padding:10px; margin-left:133px; height:102px;">
            <h1 style="color:#444; font-size:20px; font-weight:bold; margin-left:7px;"><?=$profile->name?></h1>
            <h2 style="color:#666; font-size:13px; margin:3px 8px 0 8px;">current location</h2>
            <div style="border-bottom: 1px solid #CCC; margin-top:8px; height:1px;"></div>
            <ul style="border-top: 1px solid white;">
              <li style="float:left; width:147px; margin:5px 0 0 8px; border-right:1px dotted #CCC;">
                <span style="font-size:8.5px;">TRIPS PLANNED</span>
                <strong style="color:#444; font-size:39px; font-weight:bold; display:block;">
                  <?=count($trips)?>
                </strong>
              </li>
              <li style="float:left; width:146px; margin:5px 0 0 8px; border-right:1px dotted #CCC;">
                <span style="font-size:8.5px;">TRIPS DONE</span>
                <strong style="color:#444; font-size:39px; font-weight:bold; display:block;">12</strong>
              </li>
              <li style="float:left; width:146px; margin:5px 0 0 8px;">
                <span style="font-size:8.5px;">DISSIDENTS KILLED</span>
                <strong style="color:#444; font-size:39px; font-weight:bold; display:block;">139</strong>
              </li>
            </ul>
          </div>
        </div>
        
        <!-- NEWS FEED CONTAINER -->
        <div>
          <!-- CONTAINER HEADER -->
          <div style="background: #0CBADF; border-bottom: 1px solid rgba(0, 0, 0, .1); font-weight: bold; height: 16px; padding: 8px 10px; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; border-radius: 5px 5px 0px 0px; border-radius: 5px 5px 0px 0px;">
            <p style="border-right: 1px solid #329CC3; line-height: 15px; float:left; font-size:15px; text-align:center; padding:0 15px; color:white;">
              <a href="#" style="color:white; text-decoration:none;">Posts</a>
            </p>
          
          </div><!-- CONTAINER HEADER ENDS -->
          <div style="border-left: 1px solid #CCC; border-right: 1px solid #CCC;">
            <div style="padding-bottom:5px; background: #F9F9F9; border-bottom: 1px solid #CCC; border-top: 1px solid white; padding: 15px;">
              stuff goes here
            </div>
          </div>
        </div>
        
      </div><!-- LEFT COLUMN ENDS -->
      
      
      <!-- RIGHT COLUMN -->
      <div id="rightcol" style="float:left; width:300px;">
        <? if ($user AND $is_friend===0):?>
          <a href="#" id="add-friend-button">ADD AS FRIEND</a>
        <? elseif ($user AND $is_friend==1):?>
          FRIEND REQUEST SENT; put a link here to cancel
        <? elseif ($user AND $is_friend==2):?>
          YOU ARE FRIENDS; put link here to edit friends
        <? endif;?>
        <!-- TRIPS CONTAINER -->
        <div>
          <div style="background: #0CBADF; border-bottom: 1px solid rgba(0, 0, 0, .1); font-weight: bold; padding: 8px 10px; border-radius: 5px 5px 0 0; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; -webkit-border-radius:5px 5px 0 0; -webkit-text-stroke: 1px transparent; color:white;">
            Trips (<?=count($trips)?>)
          </div>
          <!-- TRIPS -->
          <div style="border-radius:0 0 5px 5px; background-color: #F9F9F9; border: 1px solid #CCC; margin-bottom: 13px;">
            <div style="border-bottom: 1px solid #CCC; border-top: 1px solid white; padding: 10px;">
              <? foreach ($trips as $trip):?>
              <h3 style="font-size: 13px; height: 14px; line-height: 14px; margin:1px 0 2px;">
                <a href="<?=site_url('trips/'.$trip->id)?>" style="text-decoration:none; font-weight:bold; color: #2398C9;"><?=$trip->name?></a>
              </h3>
              <p style="font-size:13px;"><?=$trip->destinations[0]->address?></p>
              <? endforeach;?>
            </div>
          </div><!-- TRIPS END -->
        </div><!-- TRIPS CONTAINER ENDS -->

        <!-- FRIENDS CONTAINER -->
        <div>
          <div style="background: #0CBADF; border-bottom: 1px solid rgba(0, 0, 0, .1); font-weight: bold; padding: 8px 10px; border-radius: 5px 5px 0 0; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; -webkit-border-radius:5px 5px 0 0; -webkit-text-stroke: 1px transparent; color:white;">
            Friends (<?=count($friends)?>)
          </div>
          <!-- TRIPS -->
          <div style="border-radius:0 0 5px 5px; background-color: #F9F9F9; border: 1px solid #CCC; margin-bottom: 13px;">
            <div style="border-bottom: 1px solid #CCC; border-top: 1px solid white; padding: 10px;">
              <? foreach ($friends as $friend):?>
              <h3 style="font-size: 13px; height: 14px; line-height: 14px; margin:1px 0 2px;">
                <a href="<?=site_url('profile/'.$friend->id)?>" style="text-decoration:none; font-weight:bold; color: #2398C9;"><?=$friend->name?></a>
              </h3>
              <? endforeach;?>
            </div>
          </div><!-- FRIENDS END -->
        </div><!-- TRIPS CONTAINER ENDS -->
      </div><!-- RIGHT COLUMN ENDS -->
      
      
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
</script>

</body> 
</html>