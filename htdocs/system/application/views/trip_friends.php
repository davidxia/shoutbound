<h3>Invited Friends</h3>

    <div id="profile-friends" class="panel">
        <?foreach($invited_users as $invited_user): ?>
            <div class="friend-capsule">
                <a class="nn-link-home" href="<?=site_url('profile/details/'.$invited_user['uid']);?>">
                    <img class="square-50" src="http://graph.facebook.com/<?=$invited_user['fid']?>/picture?type=square" /><?=$invited_user['name']?>
                </a>
            </div>
        <? endforeach; ?>
    </div>