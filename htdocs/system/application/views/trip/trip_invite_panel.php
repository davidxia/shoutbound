<div id="trip-share-window">
    <div id="trip-share-content">
        <h1>Invite Friends</h1>
        <h2><?=$trip['name']?></h2>
        <br/>
        
        
        <div class="" id="trip-share-friends">
            <div class="panel" id="trip-share-friend-panel">
            
                <h3>Select some peeps.</h3>
                <br/>
            
                <div id="friend-selector">
            
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
            
            </div>
            
            <div class="panel">
                <h3>Why should they care?</h3>
                <br/>
                
                <textarea id="trip-share-textarea">If you don't come with me on <?=$trip['name']?>, I'll never speak with you again!</textarea>
            </div>
        </div>
    </div>
    
    <div id="trip-share-toolbar">
        
        <a id="trip-share-confirm" class="nn-window-tb-button">
            Send Invite
        </a>
        
        <a id="trip-share-cancel" class="nn-window-tb-button">
            Cancel
        </a>
    </div>
</div>