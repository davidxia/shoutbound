<?php
$header_args = array(
    'title' => 'Oh Snap! | Shoutbound',
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

<body style="font-family:helvetica neue, helvetica, arial, sans-serif; font-size:14px; color:#333; overflow-x:hidden; overflow-y:hidden;">
   
  <div style="width:100%"> 
    <div style="margin:45px auto 0px auto; width:800px; border-bottom:1px solid #CACACA; padding-bottom:25px;">
      <div style="font-size:30px; font-weight:bold; line-height:32px; border-bottom:1px solid #CACACA; padding-bottom:10px; margin-bottom:15px;">Oh no! My cousin ate the page you ordered...</div>       

      <div style="float:right; width:400px; padding:8px; background-color: #E8E7E3; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2); -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2);-webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2); text-align:center;">
        <img style="margin-bottom:3px;" src="<?=static_sub('chenchen_face_small.jpg')?>" width="400" height="345"/>       
        <br>"Sorry I ate your page" - my cousin.
      </div>

      <div style="width:350px;">Please check the webpage address to make sure it's correct. If you were trying to view a trip, the trip may have  been cancelled.<br><br>If it's clear that there's something wrong with Still hungry for Shoutbound?<br><br>  
        <a href="#" class="home">Take me home!</a>
      </div>
      
      <div style="clear:both"></div>

    </div>
  </div> 

  

      

</body>
</head>