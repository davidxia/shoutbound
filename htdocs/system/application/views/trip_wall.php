<div id="trip-wall-body">
    
    <div id="trip-wall-control">
        <!--
        <ul id="trip-wall-control-tab-list">
            <li class="trip-wall-control-tab"><h3>Search for a Location to Suggest</h3></li>
        </ul>-->
        
      
        
        
        
    </div>

    
    <div id="trip-wall-content">
        <h3> Wall </h3><br/>
        
        <div id="trip-wall-comment">

            

                <div class="wall-textarea-wrap">
                    <textarea id="wall-comment" class="wall-textarea"></textarea>
                    <div class="right"><button id="submit-wall">post</button></div>
                    <div class="clear-both"></div>
                    
                </div>


            


        </div>
        
        <div id="trip-wall-items">
        
        <? foreach($wall_items as $item):?>

            <div id="wall-item-<?=$item[itemid]?>" class="wall-item">
            
                <div class="wall-comment">
                    <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?=$item['user']['fid']?>/picture?type=square" /></div>
                      <div class="wall-text left">
                        <span class="wall-comment-username"> <?=$item['user']['name']?> </span>
                        <?php if($item['islocation']): ?>
                            <span class="wall-comment-text">
                                suggested <span id="wall-location-name-<?=$item['itemid']?>" class="wall-location-text"></span>
                                <? if ($item['body']) { ?>
                                    
                                    
                                    <br/><br/>"<?=$item['body']?>"
                                    
                                    
                                <? } ?>
                            </span>
                        <? else:?>
                            <span class="wall-comment-text"> "<?=$item['body'];?>" </span>
                        <? endif;?>
                        <br/>
                        <span class="wall-timestamp"><?=date("m/d/y",strtotime($item['created']))?></span>
                        <br/>
                        
                      </div>
                    <div class="clear-both"></div>
                </div>
            </div>


            <div id="replies_<?=$item['itemid']?>">
            <? foreach($item['replies'] as $reply): ?>
                <div id="wall-item-<?=$reply[itemid]?>" class="wall-item">
                    <div class="wall-comment wall-reply">
                        <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?=$reply['user']['fid']?>/picture?type=square" /></div>
                        <div class="wall-text left">
                            <span class="wall-comment-username"> <?=$reply['user']['name']?> </span>
                            <span class="wall-comment-text"> "<?=$reply['body'];?>" </span>
                            <br/>
                            <span class="wall-timestamp"><?=date("m/d/y",strtotime($item['created']))?></span>
                        </div>
                        <div class="clear-both"></div>
                    </div>
                </div>
            <? endforeach; ?>
                        
            </div>
            
            <div class="reply-box">
                <a href="#" class="show_reply_button" postid="<?=$item['itemid']?>">reply</a>
            </div>

            
        <? endforeach;?>
        
        </div>
        

        
        
    </div>
</div>