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
    <div class="rightside" style="float:right;margin-top:30px;">
      <div class="gallery">
        <a rel="http://www.shoutbound.com/static/images/james_portrait.jpg" href="http://www.shoutbound.com/static/images/james_portrait.jpg"><img src="http://www.shoutbound.com/static/images/james_portrait.jpg" alt="Here goes some caption for the above photo"></a>
        <a rel="http://www.shoutbound.com/static/images/paris.jpeg" href="http://www.shoutbound.com/static/images/paris.jpeg"><img src="http://www.shoutbound.com/static/images/paris.jpeg" alt="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."></a>
        <a rel="http://www.shoutbound.com/static/images/puerto_rico.jpeg" href="http://www.shoutbound.com/static/images/puerto_rico.jpeg"><img src="http://www.shoutbound.com/static/images/puerto_rico.jpeg" alt="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."></a>
      </div>
    </div>
    
    <div class="content" style="width:320px;">
      <div class="venue" style="background-color:#ADD;border:1px solid #f2f8f8;">
        <? foreach($article->venues as $venue):?>
          <h3 class="venue-name"><?=$venue->name?></h3>
          <ul>
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
  
  <div class="nutshell">
    <div>NUTSHELL</div>
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
<script>
</script>
</body>
</html>