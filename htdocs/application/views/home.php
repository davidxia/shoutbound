<?php
$header_args = array(
    'title' => 'Shoutbound',
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

  <div class="home-left" style="width:640px;">
    <? foreach($article->recent_articles as $article):?>
    <div class="article">
      <h1><a href="<?=site_url('feature/'.$article->uri_seg)?>"><?=$article->title?></a></h1>
      <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -23px;display:inline-block;padding-left:25px;vertical-align:2px;margin-right:10px;font-size:18px;color:#F93;"><?=$article->num_wishers?></div>
      <h2 style="margin-top:0px;"><?=$article->tagline?></h2>
  <!--     <div><?=date('F j, Y', $article->created)?></div> -->
      <div style="margin-top:10px;"><?=$article->content?></div>
      <div>
        <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -63px;display:inline-block;padding-left:28px;vertical-align:middle;margin-right:10px;">
          <a href="#" class="share" style="color:#F93;font-weight:bold;">Share</a>
        </div>
        <div class="icon" style="background: url(http://static.shoutbound.com/images/sprites.png) no-repeat 0px -43px;display:inline-block;padding-left:28px;vertical-align:middle;height:21px">
          <? if(array_key_exists($article->id, $user->favorite_ids['articles'])):?>
          <a href="#" class="unfavorite" id="article-<?=$article->id?>">Remove from wishlist</a>
          <? else:?>
          <a href="#" class="favorite" id="article-<?=$article->id?>">Add to wishlist</a>
          <? endif;?>
        </div>
      </div>
    </div>
    <? endforeach;?>
  </div>
  
</div><!-- CONTENT ENDS -->
<div class="push"></div>
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>