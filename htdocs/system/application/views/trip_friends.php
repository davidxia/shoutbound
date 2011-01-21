<?php
$num_friends = 0;
foreach($in_users as $x) {
    $num_friends++;
}
?>

<div id="attending-friends">
<? if($num_friends == 1): ?>
    <?=$num_friends?> person is going
<? else: ?>
    <?=$num_friends?> people are going
<? endif; ?>

    <?foreach($in_users as $in_user): ?>
        <div class="attending-friend">
            <a class="user-link" href="<?=site_url('profile/details/'.$in_user['uid']);?>">
                <!--<img class="square-50" src="http://graph.facebook.com/<?=$in_user['fid']?>/picture?type=square" />-->
                <?=$in_user['name']?>
            </a>
        </div>
    <? endforeach; ?>
</div>

    <? if($user['uid'] == $trip_user['uid']): ?>
        <div id="invite-button">
            <!--replace with img onClick later -->
            <div onclick="javascript: Invite.showInviteDialog();">invite friends</div>
        </div>
    <? endif; ?>