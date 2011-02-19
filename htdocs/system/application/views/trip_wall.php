<div id="trip-wall-content">
    <? foreach($wall_data['wall_items'] as $item): ?>

        <? if($item['islocation']): ?>
            <div id="wall-item-<?=$item[itemid]?>" class="wall-item location_based">
                <span class="wall_location_name"><?=$item['name']?></span><br/>
                <span class="wall_location_address" style="display:none;"><?=$item['address']?></span>
                <span class="wall_location_phone" style="display:none;"><?=$item['phone']?></span>
                Suggested by <span class="wall_comment_author"><?=$item['user']['name']?></span><br/>
                Accomodation, landmark, restaurant<br/>
                Good for: seeing new york like a local, food, burgers<br/>
                <div class="rating_panel">
                    Like Dislike<br/>
                </div>
                <? if($user_type == 'planner'): ?>
                    <div class="remove-wall-item" itemid="<?=$item['itemid']?>"></div>
                <? endif; ?>
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
                <span class="wall_comment_author"><?=$item['user']['name']?></span>
            
                <span class="wall-comment-text"><?=$item['body']?></span>
            </div>
        <? endif; ?>
        
        
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