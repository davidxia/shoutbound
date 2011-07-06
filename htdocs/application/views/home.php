<?php
$header_args = array(
    'title' => 'Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/home.js',
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

  <? foreach($article->recent_articles as $article):?>
  <div>
    <div><a href="<?=site_url('feature/'.$article->id)?>"><?=$article->title?></a></div>
    <div><?=$article->tagline?></div>
    <div><?=date('F j, Y', $article->created)?></div>
    <div><?=$article->content?></div>
    <div>
      <? if(array_key_exists($article->id, $user->favorite_ids['articles'])):?>
      <a href="#" class="unfavorite" id="article-<?=$article->id?>">Unfavorite</a>
      <? else:?>
      <a href="#" class="favorite" id="article-<?=$article->id?>">Favorite</a>
      <? endif;?>
    </div>
  </div>
  <? endforeach;?>
      
  <p><br />Page rendered in {elapsed_time} seconds</p>
  
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>

</body>
</html>