<div id="trip-wall-content">
    <?php foreach($wall_data['wall_items'] as $item): ?>


        <div id="wall-item-<?php echo $item[itemid]; ?>" class="wall-item">
            
            <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?php echo $item['user']['fid']; ?>/picture?type=square" /></div>
            <?php if($user_type == 'planner'){ ?>
                <div class="remove-wall-item" itemid="<?php echo $item['itemid']; ?>"></div>
            <?php } ?>
            <span class="wall-comment-username"><?php echo $item['user']['name']; ?></span>
                        
            <?php if($item['islocation']): ?>
                <span class="wall-comment-text">dropped a pin on <?php echo $item['title']; ?>
                    <?php if($item['body']): ?>
                        <br/><?php echo $item['body']; ?>
                    <?php endif; ?>
                </span>
                        
            <?php else: ?>
                <span class="wall-comment-text"><?php echo $item['body']; ?></span>
            <?php endif; ?>
            <br/>
            <span class="wall-timestamp"><?php echo $item['created']; ?></span>
            <br/>
                    
            <div class="clear"></div>
        </div>


        <div id="replies_<?php echo $item['itemid']; ?>">
        <?php foreach($item['replies'] as $reply): ?>
            <div id="wall-item-<?php echo $reply[itemid]; ?>" class="wall-item">
                <div class="wall-comment wall-reply">
                    <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?php echo $reply['user']['fid']; ?>/picture?type=square" /></div>
                    <?php if($user_type == 'planner'){ ?>
                        <div class="remove-wall-item" itemid="<?php echo $reply[itemid]; ?>"></div>
                    <?php } ?>
                    <span class="wall-comment-username"> <?php echo $reply['user']['name']; ?> </span>
                    <span class="wall-comment-text"> <?php echo $reply['body']; ?> </span>
                    <br/>
                    <span class="wall-timestamp"><?php echo $item['created']; ?></span>
                    <div class="clear"></div>
                </div>
            </div>
        <? endforeach; ?>
        </div>
        
        <div class="reply-box">
            <a href="#" class="show_reply_button" postid="<?php echo $item['itemid']; ?>">reply</a>
        </div>

            
    <? endforeach; ?>
</div>