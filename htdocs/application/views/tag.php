<?php
$header_args = array(
    'title' => $tag->name.' | Shoutbound',
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

  <h1>Showing features tagged with &ldquo;<?=$tag->name?>&rdquo;</h1>
  
  <? foreach($tag->articles as $article):?>
  <div>
    <h2><a href="<?=site_url('feature/'.$article->id)?>"><?=$article->title?></h2></a>
    <h3 style="font-weight:normal;"><?=$article->tagline?></h3>
  </div>
  <? endforeach;?>
  
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
<script>
</script>
</body>
</html>