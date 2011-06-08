<div id="posts-tab" class="main-tab-content">
  <? if ( ! $profile->posts):?>
    <div class="nothingyet-copy"><?=$profile->name?> hasn't posted anything yet.</div>
  <? endif;?>
    
  <? $prefix1='first-item'; foreach ($profile->posts as $post):?>
  <div id="post-<?=$post->id?>" class="<?=$prefix1?> streamitem"><? $prefix1=''?>
  
    <div class="author-container">
      <div class="streamitem-name">
        <a href="<? if($profile->username){echo site_url($profile->username);}else{echo site_url('profile/'.$profile->id);}?>">
          <?=$profile->name?>
        </a>
      </div>
    </div>
    
    <div class="streamitem-avatar-container">
      <a href="<? if($profile->username){echo site_url($profile->username);}else{echo site_url('profile/'.$profile->id);}?>">
        <img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" height="25" width="25"/>
      </a>
    </div>
    <div style="clear:both"></div>


    <div class="streamitem-content">
      <?=$post->content?>
    </div>             
  
    <div class="streamitem-tagbar placeleftpull">
      <? foreach($post->trips as $t):?>
      <a href="<?=site_url('trips/'.$t->id)?>" class="tripname tag"><?=$t->name?></a>
      <? endforeach;?>
    </div>
      
    <div class="actionbar">
      <? if(isset($user->id)):?>
      <a href="#" class="bar-item">Recommend</a>
      <span class="bullet">&#149;</span>
      <? endif;?>
      <a class="bar-item show-comments" href="#"><? $num_comments=count($post->replies); echo $num_comments.' comment'; if($num_comments!=1){echo 's';}?></a>
      <span class="bullet">&#149;</span>
      <abbr class="bar-item timeago" title="<?=$post->created?>"><?=$post->created?></abbr>
    </div>
    
    <!--COMMENTS START-->
    <div class="comments-container" style="display:none;">
      <? foreach ($post->replies as $comment):?>
      <div class="comment">
        <div class="streamitem-avatar-container">
          <a href="<?=site_url('profile/'.$comment->user_id)?>">
            <img src="<?=static_sub('profile_pics/'.$comment->author->profile_pic)?>" height="28" width="28"/>
          </a>
        </div>                      
        <div class="streamitem-content-container">
          <div class="streamitem-name">
            <a href="<?=site_url('profile/'.$comment->user_id)?>"><?=$comment->author->name?></a>
          </div> 
          <div class="comment-content"><?=$comment->content?></div>
          <div class="comment-timestamp"><abbr class="timeago subtext" title="<?=$comment->created?>"><?=$comment->created?></abbr></div>                      
        </div>
      </div>
      <? endforeach;?>
      <div class="comment-input-container">
        <textarea class="comment-input-area"/></textarea>
        <a class="add-comment-button" href="#">Add comment</a>
      </div>  
    </div><!--END COMMENT CONTAINER-->
  
  </div><!--END POST-->
  <? endforeach;?>
  
</div><!--END TAB-->

<script type="text/javascript">
$(function () {
  jqMultiselect();
});
</script>