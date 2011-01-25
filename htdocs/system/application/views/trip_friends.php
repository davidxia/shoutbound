<div id="attending-friends">
    
    <?php if(count($yes_users) == 1): ?>
        <?php echo count($yes_users); ?> person is going
    <?php else: ?>
        <?php echo count($yes_users); ?> people are going
    <?php endif; ?>

    <?php if($yes_users): ?>
        <?php foreach($yes_users as $yes_user): ?>
            <div class="yes-users">
                <a class="user-link" href="<?=site_url('profile/details/'.$in_user['uid']);?>">
                    <!--<img class="square-50" src="http://graph.facebook.com/<?=$in_user['fid']?>/picture?type=square" />-->
                    <?php echo $yes_user['name']; ?>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<?php if($user_type == 'planner'): ?>
    <div id="invite-button">
        <!--replace with img onClick later -->
        <div onclick="javascript: Invite.showInviteDialog();">invite friends</div>
    </div>
<?php endif; ?>