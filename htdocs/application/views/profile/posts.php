<div id="posts-tab" class="main-tab-content">
  <? foreach ($profile->posts as $post):?>
    <div class="postitem">
      <div class="postcontent">
        <?=$post->content?>
      </div>
      <? foreach ($post->trips as $trip):?>
      <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
      <? endforeach;?>              
      <abbr class="timeago" title="<?=$post->created?>"><?=$post->created?></abbr>
    </div>
  <? endforeach;?>
</div>
