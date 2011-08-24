<div class="comment">
  <div class="streamitem-avatar-container">
    <a href="<? if($user->username){echo site_url($user->username);}else{echo site_url('profile/'.$user->id);}?>">
      <img src="<?=static_sub('profile_pics/'.$user->profile_pic)?>" height="28" width="28">
    </a>
  </div>                      
  <div class="streamitem-content-container">
    <div class="streamitem-name">
      <a href="<? if($user->username){echo site_url($user->username);}else{echo site_url('profile/'.$user->id);}?>"><?=$user->name?></a>
    </div>
    <div class="comment-content"><?=$post->content?></div>
    <div class="comment-timestamp"><abbr class="timeago subtext" title="<? time()-72?>"><? time()-72?></abbr></div>                      
  </div>
</div>