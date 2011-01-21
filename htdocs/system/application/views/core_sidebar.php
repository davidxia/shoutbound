<div id="sidebar" class="grid_3">
    <?
        $available_navs = array('home', 'profile');
    ?>
    <div id="avatar">
        <img src="http://graph.facebook.com/<?=$profile_user['fid']?>/picture?type=large" />
    </div>    
        
    <div id="home-trips">
        <div id="home-trips-title">Your trips</div>
        <ul>        
            <? if(!sizeof($trips)): ?>
            <li class="sidebar-message">You don't have any trips yet...</li>
            <? endif; ?>
        
            <? foreach($trips as $trip): ?>
            <li>
                <div class="home-trip">
                    <a href="<?=site_url('trip/details/'.$trip['tripid'])?>"><?=$trip['name']?></a>
                </div>
            </li>
            <? endforeach; ?>
        </ul>
        
    </div>
</div>