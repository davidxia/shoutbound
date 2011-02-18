<div id="trip-wall-content">
    <? foreach($wall_data['wall_items'] as $item): ?>

        <? if($item['islocation']): ?>
            <div id="wall-item-<?=$item[itemid]?>" class="wall-item location_based">
                <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?=$item['user']['fid']?>/picture?type=square" /></div>
                <? if($user_type == 'planner'): ?>
                    <div class="remove-wall-item" itemid="<?=$item['itemid']?>"></div>
                <? endif; ?>
                <span class="wall-comment-username"><?=$item['user']['name']?></span>
            
                dropped a pin on <span class="wall_location_name"><?=$item['title']?></span>
                <? if($item['body']): ?>
                    <br/><?=$item['body']?>
                <? endif; ?>
            </div>
            
            
        <? else: ?>
            <div id="wall-item-<?=$item[itemid]?>" class="wall-item">
                <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?=$item['user']['fid']?>/picture?type=square" /></div>
                <? if($user_type == 'planner'): ?>
                    <div class="remove-wall-item" itemid="<?=$item['itemid']?>"></div>
                <? endif; ?>
                <span class="wall-comment-username"><?=$item['user']['name']?></span>
            
                <span class="wall-comment-text"><?=$item['body']?></span>
            </div>
        <? endif; ?>
        
        
            <br/>
            <span class="wall-timestamp"><?=$item['created']?></span>                    
            <div class="clear"></div>


        <div id="replies_<?=$item['itemid']?>">
        <? foreach($item['replies'] as $reply): ?>
            <div id="wall-item-<?=$reply[itemid]?>" class="wall-item">
                <div class="wall-comment wall-reply">
                    <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?=$reply['user']['fid']?>/picture?type=square" /></div>
                    <? if($user_type == 'planner'): ?>
                        <div class="remove-wall-item" itemid="<?=$reply[itemid]?>"></div>
                    <? endif; ?>
                    <span class="wall-comment-username"> <?=$reply['user']['name']?> </span>
                    <span class="wall-comment-text"> <?=$reply['body']?></span>
                    <br/>
                    <span class="wall-timestamp"><?=$item['created']?></span>
                    <div class="clear"></div>
                </div>
            </div>
        <? endforeach; ?>
        </div>
        
        <div class="reply-box">
            <a href="#" class="show_reply_button" postid="<?=$item['itemid']?>">reply</a>
        </div>

            
    <? endforeach; ?>
</div>