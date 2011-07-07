<?php
$header_args = array(
    'title' => $article->title.' | '.$article->tagline.' | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/common.js',
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
    <div><?=date('F j, Y', $article->created)?></div>
    <div><?=$article->content?></div>
  </div>
  
  <div class="nutshell">
    <div>NUTSHELL</div>
    <div class="venue">
      <? foreach($article->venues as $venue):?>
        <div class="venue-name"><?=$venue->name?></div>
        <? if($venue->url):?>
          <div class="venue-url"><a href="<?=$venue->url?>" target="_blank">official website</a></div>
        <? endif;?>
        <div class="venue-address">
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
        <div class="venue-phone"><?=$venue->phone?></div>
        <div class="venue-description">
          <?=$venue->description?>
        </div>
      <? endforeach;?>
    </div>
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
  
  <? if($article->prev_article_id):?>
  <div><a href="<?=site_url('feature/'.$article->prev_article_id)?>">Previous</a></div>
  <? endif;?>
  <? if($article->next_article_id):?>
  <div><a href="<?=site_url('feature/'.$article->next_article_id)?>">Next</a></div>
  <? endif;?>
  
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>