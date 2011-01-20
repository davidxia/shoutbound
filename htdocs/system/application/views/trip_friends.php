<?php
$num_friends = 0;
foreach($in_users as $x) {
    $num_friends++;
}
?>

<? if($num_friends == 1): ?>
    <h3><?=$num_friends?> person is going</h3>
<? else: ?>
    <h3><?=$num_friends?> people are going</h3>
<? endif; ?>

    <?foreach($in_users as $in_user): ?>
        <div class="invited-friend">
            <a class="user-link" href="<?=site_url('profile/details/'.$in_user['uid']);?>">
                <!--<img class="square-50" src="http://graph.facebook.com/<?=$in_user['fid']?>/picture?type=square" />-->
                <?=$in_user['name']?>
            </a>
        </div>
    <? endforeach; ?>
    
    <? if($user['uid'] == $trip_user['uid']): ?>
        <div id="invite-button">
            <!--replace with img onClick later -->
            <div onclick="javascript: Invite.showInviteDialog();">Invite Friends</div>
        </div>
    <? endif; ?>