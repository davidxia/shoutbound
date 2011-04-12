		         
			       </div><!--WALL ITEM END-->   
			        
			          <? foreach ($wall_items as $wall_item):?>
			          
			            <? if (isset($wall_item->lat)):?><!--SUGGESTIONS-->
			              <li id="wall-suggestion-<?=$wall_item->id?>" class="suggestion">
			                <p class="regular"><a href="<?=site_url('profile/'.$wall_item->user_id)?>" class="wall-item-author"><?=$wall_item->user_name?></a></p>
			                <div class="wall-location-name"><p class="regular"><?=$wall_item->name?></p></div>
			                
			                <span class="wall-location-address" style="display:none;"><?=$wall_item->address?></span>
			                <span class="wall-location-phone" style="display:none;"><?=$wall_item->phone?></span>
			                
			                <? if ($wall_item->text):?>
			                  <p class="regular"><?=$wall_item->text?></p>
			                <? endif;?>
			                <!--<div class="rating-panel">
			                  <a href="#" class="like">Like</a>
			                  <span class="num-likes"><?=$wall_item->votes?></span> likes
			                </div>-->
			                <? if ($user_role >= 2):?>
			                  <div class="remove-wall-item" suggestionId="<?=$wall_item->id?>"></div>
			                <? endif;?>
			                <abbr class="timeago" title="<?=$wall_item->created?>"
			                 <p class="subtext"><?=$wall_item->created?></p></abbr>
			                <? if (isset($user) AND isset($wall_item->likes[$user->id]) AND $wall_item->likes[$user->id] != 0):?>
			                  <span class="unlike"><p class="regular">Unlike</p></span>
			                <? else:?>
			                  <span class="like"><p class="regular">Like</p></span>
			                <? endif;?>
			                <span class="num-likes">
			                <? if ($wall_item->num_likes == 1):?>
			                  <p class="subtext">1 person likes this</p>
			                <? elseif ($wall_item->num_likes >= 1):?>
			                  <p class="subtext"><?=$wall_item->num_likes?> people like this</p>
			                <? endif;?>
			                </span>
			                
			                <a href="#" class="reply">reply</a>
			                <ul class="wall-replies" style="margin-left:10px;">
			                  <? foreach ($wall_item->replies as $reply):?>
			                    <li id="wall-reply-<?=$reply->id?>" class="reply">
			                      <a href="<?=site_url('profile/'.$wall_item->user_id)?>" class="wall-item-author"><?=$reply->user_name?></a>: <?=$reply->text?>
			                      <br/>
			                      <abbr class="timeago" title="<?=$reply->created?>" style="color:#777; font-size: 12px;"><?=$reply->created?></abbr>
			                    </li>
			                  <? endforeach;?>
			                </ul>
			              </li>
			            <? else:?>
			              <li id="wall-message-<?=$wall_item->id?>" class="message">
			                <a href="<?=site_url('profile/'.$wall_item->user_id)?>" class="wall-item-author" style="text-decoration:none;"><?=$wall_item->user_name?></a>
			                <? if ($user_role >= 2):?>
			                  <div class="remove-wall-item" messageId="<?=$wall_item->id?>"></div>
			                <? endif;?>
			                <span class="wall-item-text"><p class="regular"><?=$wall_item->text?></p></span>
			                <br/>
			                <abbr class="timeago" title="<?=$wall_item->created?>"><?=$wall_item->created?></abbr>
			                <? if (isset($user) AND isset($wall_item->likes[$user->id]) AND $wall_item->likes[$user->id] != 0):?>
			                  <span class="unlike" style="cursor:pointer;">Unlike</span>
			                <? else:?>
			                  <span class="like" style="cursor:pointer;">Like</span>
			                <? endif;?>
			                <span class="num-likes">
			                <? if ($wall_item->num_likes == 1):?>
			                  1 person likes this
			                <? elseif ($wall_item->num_likes >= 1):?>
			                  <?=$wall_item->num_likes?> people like this
			                <? endif;?>
			                </span>
			                
			                <a href="#" class="reply">reply</a>
			                <ul class="wall-replies">
			                  <? foreach ($wall_item->replies as $reply):?>
			                    <li id="wall-reply-<?=$reply->id?>" class="reply">
			                      <a href="<?=site_url('profile/'.$wall_item->user_id)?>" class="wall-item-author" style="text-decoration:none;"><?=$reply->user_name?></a>: <?=$reply->text?>
			                      <abbr class="timeago" title="<?=$reply->created?>"><?=$reply->created?></abbr>
			                    </li>
			                  <? endforeach;?>
			                </ul>
			              </li>
			            <? endif;?>
			          <? endforeach;?>		          
			          
			        </ul><!-- WALL CONTENT ENDS -->
	        	</div> <!--WALL ENDS-->