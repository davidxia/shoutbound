<div id="trip-invite-popup">
    <div id="trip-invite-header">Invite friends</div>
        
    <div id="trip-invite-friend-panel">
      <?
      $counter = 0;
      foreach ($uninvited_users as $uninvited_user)
      {
          if ($counter && $counter%6 == 0){
              echo('<br class="clear-both"/>');
      }
      $counter++;
      ?>
      <div uid="<?=$uninvited_user->id?>" class="friend-capsule">
          <img class="square-50" src="http://graph.facebook.com/<?=$uninvited_user->fid?>/picture?type=square" />
          <div class="friend-capsule-name"><?=$uninvited_user->name?></div>
      </div>
      <? } ?>
		</div>


    <input type="text" id="trip-invite-textarea" placeholder="Add a personal message...">
    
    <div id="trip-invite-toolbar">
        <a id="trip-invite-confirm">invite</a>
        <a id="trip-invite-cancel">cancel</a>
    </div>
</div>