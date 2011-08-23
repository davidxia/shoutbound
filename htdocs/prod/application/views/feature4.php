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

  <div class="article">
    <h1><?=$article->title?></h1>
    <h2><?=$article->tagline?></h2>
    <div class="rightside" style="float:right;margin-top:20px;width:582px;">
      <div class="gallery">
        <? foreach($article->venues as $venue):?>
          <? foreach($venue->photos as $photo):?>
          <a rel="<?=static_subdom('images/venues/'.$photo->venue_id.'_'.$photo->name)?>" href="<?=static_subdom('images/venues/'.$photo->venue_id.'_'.$photo->name)?>">
            <img src="<?=static_subdom('images/venues/'.$photo->venue_id.'_'.$photo->name)?>" alt="<?=$photo->caption?>">
          </a>
          <? endforeach;?>
        <? endforeach;?>
      </div>
      <div class="photo-caption" style="margin-top:20px;border-bottom:2px solid #CCC;padding-bottom:20px;min-height:50px;"></div>
      <div class="venue-vitals" style="margin-top:20px;">
        <? foreach($article->venues as $venue):?>
        <h3 class="venue-name" style="margin-bottom:5px;"><?=$venue->name?></h3>
        <div class="icon" style="background:url(<?=static_subdom('images/sprites.png')?>) no-repeat 0px 0px;display:inline-block;width:23px;height:23px;margin-right:5px;vertical-align:middle;"></div>
        <span style="color:#E80;">Vitals</span>
          <span class="venue-address">
          <? echo $venue->address;
             if($venue->address AND $venue->admin2){echo ', ';}
             if($venue->admin2){echo $venue->admin2;}
             if($venue->admin2 AND $venue->admin1){echo ', ';}
             if($venue->admin1){echo $venue->admin1;}
             if($venue->admin1 AND $venue->postal){echo ', ';}
             if($venue->postal){echo $venue->postal;}
             echo ' '.$venue->country;
          ?>
          </span>
          <span class="venue-phone"><?=$venue->phone?></span>
        <? if($venue->url):?>
          <span class="venue-url"><a href="<?=$venue->url?>" target="_blank">official website</a></span>
        <? endif;?>
        <? endforeach;?>
      </div>
    </div>
    
    <div class="content" style="width:320px;">
      <div class="nutshell">
        <? foreach($article->venues as $venue):?>
          <h3 class="venue-name"><?=$venue->name?></h3>
          <ul>
            <li><?=$venue->description?></li>
            <li>this is the shit</li>
            <li>this is the shit</li>
            <li>this is the shit</li>
          </ul>
        <? endforeach;?>
      </div>
      <div><?=$article->content?></div>
    </div>
<!--     <div><?=date('F j, Y', $article->created)?></div> -->
  </div>
  
  <div>
    <? if(array_key_exists($article->id, $user->favorite_ids['articles'])):?>
    <a href="#" class="unfavorite" id="article-<?=$article->id?>">Unfavorite</a>
    <? else:?>
    <a href="#" class="favorite" id="article-<?=$article->id?>">Favorite</a>
    <? endif;?>
  </div>
  
  <div>
    <div>Share</div>
    <a href="http://www.facebook.com/sharer/sharer.php?t=<?=$article->title?>&u=<?=urlencode(current_url())?>" target="_blank">Facebook</a>
    <a href="http://twitter.com/intent/tweet?url=<?=urlencode(current_url())?>&text=Check+out+this+place+on+Shoutbound!&via=shoutbound" target="_blank">Twitter</a> 
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
</body>
</html>