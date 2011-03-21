<div id="trip-invite-popup" style="width:466px; padding:10px; background:rgba(82, 82, 82, 0.7); border-radius: 8px; -webkit-border-radius:8px; border-top-left-radius: 8px 8px; border-top-right-radius: 8px 8px; border-bottom-right-radius: 8px 8px; border-bottom-left-radius: 8px 8px;">


  <div style="background-color:white;">
    <div style="margin-bottom:10px; font-size:20px;">Invite friends</div>
    
    <div id="sb-friends" style=" display:none;">
      <ul style=" height:400px; overflow-y:auto;">
        <? foreach ($uninvited_sb_friends as $sb_friend):?>
          <li sbid="<?=$sb_friend->id?>" class="friend-capsule" style="height:64px; width:134px; margin:3px; cursor:pointer; float:left;">
            <a href="#" style="display:block; height:56px; padding:4px; border-spacing:0; text-decoration:none;">
              <span style="border:1px solid #E0E0E0; margin-right:5px; padding:2px; display:block; height:50px; width:50px; background-image: url(http://graph.facebook.com/<?=$sb_friend->fid?>/picture?type=square); background-position:2px 2px; background-repeat:no-repeat; float:left;"></span>
              <span class="friend-name" style="font-size:11px; float:left; display:block; width:65px; margin-top:2px;"><?=$sb_friend->name?></span>
            </a>
          </li>
        <? endforeach;?>
    	</ul>

      <div id="trip-invite-toolbar" style="margin-left">
        <a href="#" id="trip-invite-confirm">invite</a>
        <a href="#" id="trip-invite-cancel">cancel</a>
      </div>
    </div>

    <div id="invite-methods">
      <a href="#" id="shoutbound-invite">Shoutbound</a>
      <br/>
      <a href="#" id="facebook-invite">Facebook</a>
      <br/>
      <a href="#" id="email-invite">E-mails</a>
    </div>
    
  
  </div>
</div>

<script type="text/javascript">

</script>