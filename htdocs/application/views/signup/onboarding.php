<?
$header_args = array(
    'title' => 'Onboarding | Shoutbound',
    'css_paths' => array(
    ),
    'js_paths' => array(
    )
);

$this->load->view('core_header', $header_args);
?>
</head>
	
<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
  
  <div class="settings-item">
    <input type="text" id="url" style="width:275px; height:20px;" value="<?=$user->url?>"/><br/>
    <span class="subtext">Have your own website or blog? Put the address here.</span>        
  </div>

  <div class="settings-item">
    <div class="settings-item-name">Picture</div>
    <div class="settings-item-content">
      <div id="change-photo">
        <a href="#" id="file_upload" name="file_upload" type="file"></a>
        <div class="subtext">Maximum size: 700kb</div>
        <div id="custom-queue"></div>
      </div>        
      <div id="current-profile-pic" class="profile-pic-container">
        <a href="<?=static_sub('profile_pics/'.$user->profile_pic)?>" id="profile-pic"><img src="<?=static_sub('profile_pics/'.$user->profile_pic)?>" width="125" height="125"/></a>
      </div>
    </div>
  </div>

  <div class="settings-item">
    <div class="settings-item-content">
      <input type="text" id="url" style="width:275px; height:20px;" value="<?=$user->url?>"/><br/>
      <span class="subtext">Have your own website or blog? Put the address here.</span>        
    </div>
  </div>
  
  <div class="settings-item">
    <div class="settings-item-name">Bio</div>
    <div class="settings-item-content">
      <textarea id="bio" style="width:415px; height:125px;"><?=$user->bio?></textarea><br/>
      <span class="subtext">Describe yourself in 250 characters or less. Characters remaining: <span id="chars-remaining"></span></span>
    </div>
  </div>
  
  We've automatically followed for you these people on Shoutbound whom we think are your friends and the trips they're planning.
  <? foreach ($user->following as $following):?>
  <div>
    <a href="<?=site_url('profile/'.$following->id)?>" target="_blank"><?=$following->name?></a>
    <a class="unfollow" id="user-<?=$following->id?>" href="#">Unfollow</a>
    <? foreach ($following->trips as $trip):?>
    <div style="margin-left:20px;">
      <a href="<?=site_url('trips/'.$trip->id)?>" target="_blank"><?=$trip->name?></a>
      <? foreach ($trip->goers as $goer):?>
      <a href="<?=site_url('profile/'.$goer->id)?>" target="_blank"><img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" width="35" height="35" alt="<?=$goer->name?>"/>
      <? endforeach;?>
      <a class="unfollow" id="trip-<?=$trip->id?>">Unfollow</a>
    </div>
    <? endforeach;?>
  </div>
  <? endforeach;?>
  
  
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  <? $this->load->view('footer')?>

<script type="text/javascript">
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