<?php
$header_args = array(
    'title' => $article->title.' | '.$article->tagline.' | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/common.js',
        'js/jquery/galleria-1.2.4.min.js',
        'css/galleria/themes/classic/galleria.classic.min.js',
    )
);

$this->load->view('templates/core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  <? if($user):?>
  var loggedin = true;
  <? endif;?>
</script>
</head>
<body>
<? $this->load->view('templates/header')?>
<? $this->load->view('templates/content')?>

  <div class="article" style="position:relative;">
    <h1 style="display:inline-block;margin-right:20px;"><?=$article->title?></h1>
    <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -23px;display:inline-block;padding-left:25px;vertical-align:2px;margin-right:10px;font-size:18px;color:#F93;"><?=$article->num_wishers?></div>
    <br/>
    <h2 style="width:640px;margin-right:320px;"><?=$article->tagline?></h2>

    <div style="position:absolute;left:660px;top:40px;">
      <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -63px;display:inline-block;padding-left:28px;vertical-align:middle;margin-right:10px;">
        <a href="#" class="share" style="color:#F93;font-weight:bold;">Share</a>
      </div>
      <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -43px;display:inline-block;padding-left:28px;vertical-align:middle;">
        <? if(array_key_exists($article->id, $user->favorite_ids['articles'])):?>
        <a href="#" class="unfavorite" id="article-<?=$article->id?>" style="color:#F93;font-weight:bold;">Remove from wishlist</a>
        <? else:?>
        <a href="#" class="favorite" id="article-<?=$article->id?>" style="color:#F93;font-weight:bold;">Add to wishlist</a>
        <? endif;?>
      </div>
    </div>

    <div class="content" style="float:right;width:300px;">
      <div class="nutshell" style="height:293px;">
        <? foreach($article->venues as $venue):?>
          <h3 class="venue-name"><?=$venue->name?></h3>
          <div class="address">
            <div><?=$venue->address?></div>
            <div>
            <? if($venue->admin2){echo $venue->admin2;}
               if($venue->admin2 AND $venue->admin1){echo ', ';}
               if($venue->admin1){echo $venue->admin1;}
               if($venue->admin1 AND $venue->postal){echo ', ';}
               if($venue->postal){echo $venue->postal;}
            ?>
            </div>
            <div><?=$venue->country?></div>
          </div>
          <div class="phone"><?=$venue->phone?></div>
          <? if($venue->url):?>
            <div class="url"><a href="<?=$venue->url?>" target="_blank">official website</a></div>
          <? endif;?>

          <ul>
            <li><?=$venue->description?></li>
            <li>this is the shit</li>
            <li>this is the shit</li>
            <li>this is the shit</li>
          </ul>
        <? endforeach;?>
      </div>
    </div>

    <div class="rightside" style="margin-top:20px;width:640px;position:relative;">
      <div class="gallery">
        <? foreach($article->venues as $venue):?>
          <? foreach($venue->photos as $photo):?>
          <a rel="<?=static_subdom('images/venues/'.$photo->venue_id.'_'.$photo->name)?>" href="<?=static_subdom('images/venues/'.$photo->venue_id.'_'.$photo->name)?>">
            <img src="<?=static_subdom('images/venues/'.$photo->venue_id.'_'.$photo->name)?>" alt="<?=$photo->caption?>">
          </a>
          <? endforeach;?>
        <? endforeach;?>
      </div>
      <div class="photo-caption" style="margin-top:20px;position:absolute;top:263px;background-color:rgba(0,0,0,.5);z-index:10;color:#EEE;width:598px;padding:10px 16px;height:20px;"></div>
      <div style="margin-top:30px;"><?=$article->content?></div>
      <div class="tags">
        <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -84px;display:inline-block;padding-left:40px;vertical-align:bottom;margin-right:7px;height:22px;"></div>
        <? $prefix=''?><? foreach($article->tags as $tag):?>
        <a href="<?=site_url('tag/'.$tag->uri_seg)?>"><?=$prefix.$tag->name?></a>
        <? $prefix=', '?>
        <? endforeach;?>
      </div>
    </div>
    
<!--     <div><?=date('F j, Y', $article->created)?></div> -->
  </div>
  
  
  <div>
    <a href="http://www.facebook.com/sharer/sharer.php?t=<?=$article->title?>&u=<?=urlencode(current_url())?>" target="_blank">Facebook</a>
    <a href="http://twitter.com/intent/tweet?url=<?=urlencode(current_url())?>&text=Check+out+this+place+on+Shoutbound!&via=shoutbound" target="_blank">Twitter</a> 
  </div>
  
  <? if($article->prev_article_id):?>
  <div><a href="<?=site_url('feature/'.$article->prev_article_id)?>">Previous</a></div>
  <? endif;?>
  <? if($article->next_article_id):?>
  <div><a href="<?=site_url('feature/'.$article->next_article_id)?>">Next</a></div>
  <? endif;?>
  
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
<script>
</script>
</body>
</html>