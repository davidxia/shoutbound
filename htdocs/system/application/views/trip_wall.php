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
        
        <?php foreach($wall_items as $item):?>

            <div id="wall-item-<?=$item[itemid]?>" class="wall-item">
            
            <?php if($item['islocation']){ ?>
                
                <div class="wall-comment wall-root-comment">
                    
                    <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?=$item['user']['fid']?>/picture?type=square" /></div>
                      <div class="wall-text left">
                          <span class="wall-comment-username"> <?=$item['user']['name']?> </span>
                          <span class="wall-comment-text"> suggested <span id="wall-location-name-<?=$item['itemid'];?>" class="wall-location-text"></span> </span>
                          <br/>
                          <span class="wall-timestamp">timestamp</span>
                      </div>
                    
                    
                    
                    <div class="clear-both"></div>
                </div>
                
            <?} else {?>
                
                <div class="wall-comment wall-reply-comment">
                    
                    <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?=$item['user']['fid']?>/picture?type=square" /></div>
                      <div class="wall-text left">
                          <span class="wall-comment-username"> <?=$item['user']['name']?> </span>
                          <span class="wall-comment-text"> "<?=$item['body'];?>" </span>
                          <br/>
                          <span class="wall-timestamp">timestamp</span>
                      </div>
                    
                    
                    
                    <div class="clear-both"></div>
                </div>
                <?
            }
            
            ?></div>
            
        <?php endforeach;?>
        
        </div>
        

        
        
    </div>
</div>