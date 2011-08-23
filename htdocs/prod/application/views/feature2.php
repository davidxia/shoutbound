<?php
$header_args = array(
    'title' => $article->title.' | '.$article->tagline.' | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/common.js',
        'js/jquery/galleria-1.2.4.min.js',
        'css/galleria/themes/classic/galleria.classic.min.js',
        'js/jquery/jquery.carouFredSel-4.3.0-packed.js',
    )
);

$this->load->view('templates/core_header', $header_args);
?>
<style type="text/css">
div.pagination a{
  background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -106px;
  display: inline-block;
  height: 15px;
  width: 15px;
  margin: 0 5px 0 0;
}
div.pagination a.selected{
  background-position-x: -17px; 
}
div.pagination a span{
  display:none;
}
</style>

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

  <div class="article" style="position:relative;margin-bottom:20px;">    
    <div class="content" style="float:right;width:300px;">
      <div class="nutshell">
        <? foreach($article->venues as $venue):?>
          <h3 class="venue-name"><?=$venue->name?></h3>
          <ul>
            <? $lis=explode('.', $venue->description);?>
            <? foreach($lis as $li):?><? if($li):?>
            <li><?=$li?></li>
            <? endif;?><? endforeach;?>
          </ul>

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
        <? endforeach;?>
      </div>
    </div>

    <div class="left-col" style="margin-top:20px;width:640px;position:relative;">
      <div style="border:1px solid #DDD; background-color:#EEE;">
        <div style="padding:10px;">
          <h1><?=$article->title?></h1>
          <h2><?=$article->tagline?></h2>
          <div style="margin:5px 0px 10px;">
            <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -63px;display:inline-block;padding-left:28px;vertical-align:middle;margin-right:10px;">
              <a href="#" class="share" style="color:#F93;font-weight:bold;">Share</a>
            </div>
            <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -43px;display:inline-block;padding-left:28px;vertical-align:middle;margin-right:10px;">
              <? if(array_key_exists($article->id, $user->favorite_ids['articles'])):?>
              <a href="#" class="unfavorite" id="article-<?=$article->id?>" style="color:#F93;font-weight:bold;">Remove from wishlist</a>
              <? else:?>
              <a href="#" class="favorite" id="article-<?=$article->id?>" style="color:#F93;font-weight:bold;">Add to wishlist</a>
              <? endif;?>
            </div>
            <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -23px;display:inline-block;padding-left:25px;vertical-align:middle;margin-right:10px;font-size:18px;color:#F93;"><?=$article->num_wishers?></div>
          </div>
        </div>
        <div class="gallery">
          <? foreach($article->venues as $venue):?>
            <? foreach($venue->photos as $photo):?>
            <a rel="<?=static_subdom('images/venues/'.$photo->venue_id.'_'.$photo->name)?>" href="<?=static_subdom('images/venues/'.$photo->venue_id.'_'.$photo->name)?>">
              <img src="<?=static_subdom('images/venues/'.$photo->venue_id.'_'.$photo->name)?>" alt="<?=$photo->caption?>">
            </a>
            <? endforeach;?>
          <? endforeach;?>
        </div>
        <div class="photo-caption" style="margin-top:20px;position:absolute;top:378px;background-color:rgba(0,0,0,.5);z-index:10;color:#EEE;width:606px;padding:10px 16px;height:20px;"></div>
      </div>
      <div style="margin-top:30px;"><?=$article->content?></div>
      <div class="tags">
        <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -84px;display:inline-block;padding-left:40px;vertical-align:bottom;margin-right:7px;height:22px;"></div>
        <? $prefix=''?><? foreach($article->tags as $tag):?>
        <?=$prefix?><a href="<?=site_url('tag/'.$tag->uri_seg)?>"><?=$tag->name?></a>
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
  

  <div style="border:1px solid #DDD;background-color:#EEE;padding:10px;">
    <div style="margin-left:-10px;margin-top:10px;background: url(http://static.shoutbound.com/images/triangle.png) no-repeat 165px 0px;width:180px;">
      <div style="padding:5px 5px 5px 10px;width:150px;font-weight:bold;background-color:#CCC;">You may also like...</div>
    </div>
    
    <div style="margin:30px 50px;position:relative;">
      <div id="carousel">
        <img src="http://static.shoutbound.com/images/venues/2_taipei.jpg" width="140" height="140"/>
        <img src="http://static.shoutbound.com/images/venues/2_pier.jpg" width="140" height="140"/>
        <img src="http://static.shoutbound.com/images/venues/2_pier.jpg" width="140" height="140"/>
      </div>
      <a class="prev" id="carousel-prev" href="#" style="position:absolute;top:60px;left:-50px;display:block;width:35px;height:35px;background: url(http://dev.shoutbound.com/david/static/css/galleria/themes/classic/classic-map.png) no-repeat 0px 0px;text-indent:-9999px">previous</a>
      <a class="next" id="carousel-next" href="#" style="position:absolute;top:60px;right:-50px;display:block;width:35px;height:35px;background: url(http://dev.shoutbound.com/david/static/css/galleria/themes/classic/classic-map.png) no-repeat -288px 0px;text-indent:-9999px">next</a>
      <div class="pagination" id="foo2_pag" style="text-align:center;"></div>
    
      <? foreach($article->related_articles as $related_article):?>
      <div>
        <div><?=$related_article->title?></div>
        <div><?=$related_article->tagline?></div>
      </div>
      <? endforeach;?>
    </div>
  </div>
  
  <? if($article->prev_article_uri_seg):?>
  <div><a href="<?=site_url('feature/'.$article->prev_article_uri_seg)?>">Previous</a></div>
  <? endif;?>
  <? if($article->next_article_uri_seg):?>
  <div><a href="<?=site_url('feature/'.$article->next_article_uri_seg)?>">Next</a></div>
  <? endif;?>
  
</div><!-- CONTENT ENDS -->
<div class="push"></div>
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
<script type="text/javascript">
  $('#carousel').carouFredSel({
    auto: {
      play: false,
    },
    circular: false,
    items: {
      visible:1,
      minimum:1
    },
/*     width: 'variable', */
    prev: {
      button: '#carousel-prev',
      key: 'left'
    },
    next: {
      button: '#carousel-next',
      key: 'right'
    },
    pagination: '#foo2_pag',
    debug: true
  });

</script>
</body>
</html>