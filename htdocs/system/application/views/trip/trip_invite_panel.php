<div id="trip-invite-popup" style="width:466px; padding:10px; background:rgba(82, 82, 82, 0.7); border-radius: 8px; -webkit-border-radius:8px; border-top-left-radius: 8px 8px; border-top-right-radius: 8px 8px; border-bottom-right-radius: 8px 8px; border-bottom-left-radius: 8px 8px;">

  <div id="filter-dropmenu" style="display:none; position:absolute; top:58px; left:10px; width:150px; z-index:10;">
    <div style="background:white; border:1px solid black; padding:5px 0; overflow:auto; font-size:11px;">
      <ul>
        <li>
          <a id="show-fb-friends" style="display:block; padding:3px 10px; text-decoration:none; cursor:pointer;">Facebook</a>
        </li>
        <li>
          <a id="show-sb-friends" style="display:block; padding:3px 10px; text-decoration:none; cursor:pointer;">Shoutbound</a>
        </li>
      </ul>
    </div>
  </div>

  <div style="background-color:white;">
    <div style="margin-bottom:10px; font-size:20px;">Invite friends</div>
    
    <div id="filter" style="border-width:1px 0; border-style:solid; border-color:#C1C1C1;">
      <div style="float:left; font-size:11px;">
        <a href="#" id="filter-selector" style="padding:5px 8px 6px; width:90px; background: transparent url(<?=site_url('images/down_triangle.gif')?>) no-repeat right 5px;">Filter Friends</a>
      </div>
      <div style="float:right; padding:3px 10px 3px; font-size:11px;">
        <ul>
          <li style="padding-right:4px; float:left;">
            <a href="#" id="show-all-friends">All</a>
          </li>
          <li style="padding-right:4px; float:left;">
            <a href="#" id="show-selected-friends">Selected</a>
          </li>
        </ul>
      </div>
      <div style="clear:both;"></div>
    </div>
    
    <div style="clear:both;"></div>

    <ul id="friends" style=" height:400px; overflow-y:auto;">
        <? foreach ($fb_friends as $fb_friend):?>
          <li fbid="<?=$fb_friend->facebook_id?>" class="friend-capsule" style="height:64px; width:134px; margin:3px; cursor:pointer; float:left;">
            <a href="#" style="display:block; height:56px; padding:4px; border-spacing:0; text-decoration:none;">
              <span style="border:1px solid #E0E0E0; margin-right:5px; padding:2px; display:block; height:50px; width:50px; background-image: url(http://graph.facebook.com/<?=$fb_friend->facebook_id?>/picture?type=square); background-position:2px 2px; background-repeat:no-repeat; float:left;"></span>
              <span class="friend-name" style="font-size:11px; float:left; display:block; width:65px; margin-top:2px;"><?=$fb_friend->name?></span>
            </a>
          </li>
        <? endforeach;?>
        <? foreach ($uninvited_sb_friends as $sb_friend):?>
          <li sbid="<?=$sb_friend->id?>" class="friend-capsule" style="height:64px; width:134px; margin:3px; cursor:pointer; float:left;">
            <a href="#" style="display:block; height:56px; padding:4px; border-spacing:0; text-decoration:none;">
              <span style="border:1px solid #E0E0E0; margin-right:5px; padding:2px; display:block; height:50px; width:50px; background-image: url(http://graph.facebook.com/<?=$sb_friend->fid?>/picture?type=square); background-position:2px 2px; background-repeat:no-repeat; float:left;"></span>
              <span class="friend-name" style="font-size:11px; float:left; display:block; width:65px; margin-top:2px;"><?=$sb_friend->name?></span>
            </a>
          </li>
        <? endforeach;?>
  	</ul>
  
    <div style="clear:both;"></div>
    Add a message...
    <br/>
    <input type="text" id="trip-invite-textarea" size="40" />
    
    <div id="trip-invite-toolbar" style="margin-left">
      <a href="#" id="trip-invite-confirm">invite</a>
      <a href="#" id="trip-invite-cancel">cancel</a>
    </div>
  
  </div>
</div>

<script type="text/javascript">
  $(document).click(function() {
    $('#filter-dropmenu').hide();
  });

  $('#filter-selector').click(function() {
    $('#filter-dropmenu').toggle();
    return false;
  });
  
  $('#show-sb-friends').click(function() {
    $('#friends').empty();
    var html = 'helloo!!!';
    $('#friends').append(html);
    $('#filter-dropmenu').hide();
    // TODO: this method is soo slow, how to make it faster??
    /*
    $('#friends').children('li').each(function() {
      var attr = $(this).attr('uid');
      if (typeof attr == 'undefined' || attr == false) {
        $(this).hide();
      }
    });
    */
    return false;
  });
</script>