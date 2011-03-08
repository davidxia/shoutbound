<div id="trip-invite-popup" style="width:400px; padding:10px; background:rgba(82, 82, 82, 0.7); border-radius: 8px; -webkit-border-radius:8px; border-top-left-radius: 8px 8px; border-top-right-radius: 8px 8px; border-bottom-right-radius: 8px 8px; border-bottom-left-radius: 8px 8px;">
  <div style="background-color:white; padding:10px; height:400px; overflow-y:auto;">
    <div style="margin-bottom:10px; font-size:20px;">Invite friends</div>

    <? if (count($fb_friends)):?>
      <div id="trip-invite-friend-panel" style="float:left; overflow-y: auto;">
          <? $counter = 0;?>
          <? foreach ($fb_friends as $fb_friend):?>
            <? if ($counter && $counter%5 == 0):?>
              <br/>
            <? endif;?>
            <? $counter++;?>
            <div fbid="<?=$fb_friend->facebook_id?>" class="friend-capsule" style="width:70px; margin-bottom:50px; cursor:pointer; float:left;">
              <img style="height:50px; width:50px; margin-left:10px; margin-top:20px;" src="http://graph.facebook.com/<?=$fb_friend->facebook_id?>/picture?type=square" />
              <div style="font-size:12px; text-align:center;"><?=$fb_friend->name?></div>
            </div>
          <? endforeach;?>
    	</div>
    
      <div style="clear:both;"></div>
      Add a message...
      <br/>
      <input type="text" id="trip-invite-textarea" size="40" />
      
      <div id="trip-invite-toolbar" style="margin-left">
        <a href="#" id="trip-invite-confirm">invite</a>
        <a href="#" id="trip-invite-cancel">cancel</a>
      </div>
    <? else:?>
      You've already invited all your friends.
    <? endif;?>
  
  </div>
</div>