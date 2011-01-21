<div id="trip-invite-popup">
    <div id="trip-invite-header">Invite friends</div>
        
        <div id="trip-invite-friend-panel">
            <? 
            $counter = 0;
            foreach($not_invited_users as $not_invited_user) { 
            if($counter && $counter%6 == 0){
                echo('<br class="clear-both"/>');
            }
            $counter++;
            ?>
                <div uid="<?=$not_invited_user['uid']?>" class="friend-capsule">
                    <img class="square-50" src="http://graph.facebook.com/<?=$not_invited_user['fid']?>/picture?type=square" />
                    <div class="friend-capsule-name"><?=$not_invited_user['name']?></div>
                </div>
            <? } ?>
		</div>


        <div id="trip-invited-friends">
            <div id="trip-invited-friends-header">you've invited</div>
            <? 
            $counter = 0;
            foreach($invited_users as $invited_user) { 
            	if($counter && $counter%6 == 0){
            		echo('<br class="clear-both"/>');
                }
            $counter++;
            ?>
                <div uid="<?=$invited_user['uid']?>" class="friend-capsule">
                    <img class="square-50" src="http://graph.facebook.com/<?=$invited_user['fid']?>/picture?type=square" />
                    <div class="friend-capsule-name"><?=$invited_user['name']?></div>
                </div>
            <? } ?>
        </div>
            <input type="text" id="trip-invite-textarea" placeholder="Add a personal message...">
    
    <div id="trip-invite-toolbar">
        <a id="trip-invite-confirm">invite</a>
        <a id="trip-invite-cancel">cancel</a>
    </div>
</div>