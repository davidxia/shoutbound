<div id="nn-sidebar">
    <?
        $available_navs = array('home', 'profile');
    ?>
    <div id="profile-poster">
        <img src="http://graph.facebook.com/<?=$profile_user['fid']?>/picture?type=large" />
        
        <div id="profile-name">
            <?=$profile_user['name']?> !
        </div>
        
    </div>    
        
    <div class="sidebar-list panel">
    <ul>
        <li>
            <div class="sidebar-title"><h3><?=first_name($profile_user['name'])?>'s Trips</h3><br/></div>
        </li>
        
        <? 
        if(!$current_trip) $current_trip = array();
        
        if(!sizeof($trips)){
            ?>
                <li class="sidebar-message">
                <?=first_name($profile_user['name'])?> doesn't have any trips yet...
                </li>
            <?
        }
        
        foreach($trips as $trip) { 
        ?>
            
        <li>

            <? if($trip['tripid'] == $current_trip['tripid']) { ?>    
                <div class="sidebar-item sidebar-item-selected">
                        <?=$trip['name']?>
                </div>  
            <? } else { ?>
                <div class="sidebar-item">
                    <a href="<?=site_url('trip/details/'.$trip['tripid'])?>">
                        <?=$trip['name']?>
                    </a>
                </div>
            <? } ?>
                
        </li>
        
        <? } ?>
    </ul>
    </div>
    
    
    
    
</div>