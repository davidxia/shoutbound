<div id="wall_content">
  <? foreach ($wall_items as $item):?>
    <? if ($item->is_location):?>
      <div id="wall-item-<?=$item->id?>" class="wall-item location_based">
        <span class="wall_location_name"><?=$item->name?></span><br/>
        <span class="wall_location_address" style="display:none;"><?=$item->address?></span>
        <span class="wall_location_phone" style="display:none;"><?=$item->phone?></span>
        Suggested by <span class="wall_comment_author"><?=$item->user_name?></span><br/>
        Accomodation, landmark, restaurant<br/>
        Good for: seeing new york like a local, food, burgers<br/>
        <div class="rating-panel">
            Like Dislike
            <br/>
        </div>
        <? if ($user_role == 2):?>
            <div class="remove-wall-item" itemid="<?=$item->id?>"></div>
        <? endif;?>
        <? if ($item->text):?>
            <br/>
            <?=$item->text?>
        <? endif;?>
      </div>
    <? else:?>
      <div id="wall-item-<?=$item->id?>" class="wall-item">
        <div><img src="http://graph.facebook.com/<?=$item->user_fid?>/picture?type=square" /></div>
        <? if ($user_role == 2):?>
            <div class="remove-wall-item" itemid="<?=$item->id?>"></div>
        <? endif;?>
        <span class="wall_comment_author"><?=$item->user_name?></span>
    
        <span class="wall-comment-text"><?=$item->text?></span>
      </div>
    <? endif;?>
  
          
  <? endforeach;?>
</div>