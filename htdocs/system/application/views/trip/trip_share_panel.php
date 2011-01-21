<div id="trip-share-popup">
    <div id="trip-share-header">Share your trip</div>

		<div id="trip-share-friend-panel">
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
                     
		<input type="text" id="trip-share-textarea" placeholder="Tell them about your trip.(optional make this a dynamic drop down later)">

    
    <div id="trip-share-toolbar">
        <a id="trip-share-confirm">confirm</a>
        <a id="trip-share-cancel">cancel</a>
    </div>
    
</div>