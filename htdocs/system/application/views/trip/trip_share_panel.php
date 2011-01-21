<div id="trip-share-popup">
    <div id="trip-share-header">Share your trip</div>
    <div id="trip-share-content">
        
        <div id="trip-share-friends">
            <div class="panel" id="trip-share-friend-panel">
            
                <div id="friend-selector">
            
                    <? 
                    $counter = 0;
                    foreach($user_friends as $friend) { 
                    if($counter && $counter%6 == 0){
                        echo('<br class="clear-both"/>');
                    }
                    $counter++;
                    ?>
                        <div uid="<?=$friend['uid']?>" class="friend-capsule">
                                <img class="square-50" src="http://graph.facebook.com/<?=$friend['fid']?>/picture?type=square" />
                            
                            <div class="friend-capsule-name"><?=$friend['name']?></div>
                        </div>
                    <? } ?>
            
                </div>
            </div>
            
                Tell them about your trip.(optional make this a dynamic drop down later)
                <br/>
                
                <input type="text" id="trip-share-textarea" placeholder="Add a personal message...">
        </div>

    </div>
    
    <div id="trip-share-toolbar">
        <a id="trip-share-confirm" class="nn-window-tb-button">Confirm</a>
        <a id="trip-share-cancel" class="nn-window-tb-button">Cancel</a>
    </div>
    
</div>