<?php
$header_args = array(
    'title' => 'New Wall | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url()?>";
</script>
  
</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>  
    
    USER NAME: <?=$user->name?>
    
    <br/><br/>
    
    TRIP NAME: <?=$trip->name?>
    
    <br/><br/>
    
    DESTINATIONS:
    <br/>
    <? foreach($destinations as $destination):?>
      <?=$destination->name?>
      <br/>
    <? endforeach;?>
    
    <br/>
    
    WALLITEMS:
    <br/>
    <? foreach ($wallitems as $wallitem):?>
      CONTENT: <?=$wallitem->content?> place: <? print_r($wallitem->places)?>
      <br/>
      <? foreach ($wallitem->replies as $reply):?>
        --------->CONTENT: <?=$reply->content?>
        <br/>
      <? endforeach;?>
    <? endforeach;?>
        
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->



  <? $this->load->view('footer')?>

<script type="text/javascript">
  
</script>

</body>
</head>