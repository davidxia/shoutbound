<?php
$header_args = array(
    'title' => 'My Account | Shoutbound',
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

  <h2>my account page</h2>
  
  <div>
    My favorites:
    <? foreach($user->favorites['articles'] as $article):?>
    <div class="favorite-feature">
      <div><a href="<?=site_url('feature/'.$article->uri_seg)?>"><?=$article->title?></a></div>
      <div><?=$article->tagline?></div>
      <a href="#" class="unfavorite" id="article-<?=$article->id?>">Unfavorite</a>
    </div>
    <? endforeach;?>
  </div>
  
  <div>
    <a href="<?=site_url('my_account/invite')?>">Invite friends</a>
  </div>
    
  <div>
    <a href="<?=site_url('my_account/settings')?>">My account settings</a>
  </div>  

</div><!-- CONTENT ENDS -->
<div class="push"></div>
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>