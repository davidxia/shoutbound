<h3>Who's In</h3>

    <div id="profile-friends" class="panel">
        <?foreach($in_users as $in_user): ?>
            <div class="friend-capsule">
                <a class="nn-link-home" href="<?=site_url('profile/details/'.$in_user['uid']);?>">
                    <img class="square-50" src="http://graph.facebook.com/<?=$in_user['fid']?>/picture?type=square" /><?=$in_user['name']?>
                </a>
            </div>
        <? endforeach; ?>
        
        <? if($user['uid'] == $trip_user['uid']): ?>
            <a href="javascript: Invite.showInviteDialog();">Invite People</a>
        <? endif; ?>
    </div>