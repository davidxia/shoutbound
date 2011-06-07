<?
$header_args = array(
    'title' => 'Getting Started | Shoutbound',
    'css_paths' => array(
        'css/onboarding.css',
        'css/excite-bike/jquery-ui-1.8.13.custom.css',
    ),
    'js_paths' => array(
        'js/common.js',
        'js/jquery/jquery-ui-1.8.13.custom.min.js',
        'js/jquery/jquery-dynamic-form.js',
        'js/jquery/validate.min.js',
    )
);

$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var swLat = -50;
  var swLng = -180;
  var neLat = 50;
  var neLng = 180;
</script>
</head>
	
<body style="overflow-y: hidden; overflow-x:hidden;">

<div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>

<!--
  <div id="intro-box">
    <div id="welcome-line">Welcome to Shoutbound!</div>
    <div id="welcome-text">To get you started, we're going to ask you to complete a few simple steps and answer some questions.  This will help you get the most of your Shoutbound experience. The whole process should take just a few minutes.</div>
    <a href="#" id="get-started-button">Let's get started!</a>
  </div>
  
  <div id="hide-wrapper" style="display:none">
-->

  <!--LEFT NAVBAR-->
  <ul id="onboarding-navbar">
    <li class="activeheader">Dream</li>
    <li>Follow</li>
    <li>Profile</li>
    <li class="filler"></li>
  </ul>
  <!--LEFT NAVBAR END-->

  <!--MAIN-->
  <div class="onboarding-main">
      <div id="onboarding-subtitle">What are your dream travel destinations?</div>
      <div id="onboarding-copy">Enter all of the destinations you dream of traveling to. Be ambitious and list as many as you can! We'll connect you to these places on Shoutbound. This will also help other people find and get to know you. </div>  
       
      <div id="onboarding-left">  
        <div id="left-content-container">
          <div id="onboarding-item-subtitle">I dream of going to:</div>
          <? foreach($user->future_places as $future_place):?>
          <div><span class="place" lat="<?=$future_place->lat?>" lng="<?=$future_place->lng?>"><?=$future_place->name?><? if($future_place->country){echo ', '.$future_place->country;}?></span> <a href="#" class="remove-place" id="place-<?=$future_place->id?>">remove</a></div>
          <? endforeach;?>
          <form id="bucket-list" action="<?=site_url('signup/save_bucket_list')?>" method="post">
          <fieldset>
            <div id="place" style="position:relative;">
              <a id="add-place" href="#" style="position:absolute;left:-20px;top:15px; color:white;">[+]</a>
              <a id="subtract-place" href="#" style="position:absolute;left:-20px;top:30px;color:white;">[-]</a>
              <span class="label-and-errors">
                <label for="place_name0"></label>
                <span class="error-message" style="float:right;height:19px;"><span style="color:white">a</span></span>
              </span>
              <input type="text" id="place_name" class="place-input" name="place_name" autocomplete=off/>
              <input type="hidden" id="place_id" class="place_ids" name="place_id"/>
            </div>
          </fieldset>
          </form>
        </div><!--LEFT CONTENT CONTAINER END-->
        
        <div id="map-shell">
          <div id="map-canvas"></div>
        </div>
              
    </div><!--ONBOARDING LEFT END-->
  </div><!--ONBOARDING MAIN END-->    
  
</div><!-- CONTENT ENDS -->

</div><!-- WRAPPER ENDS -->

</div><!--STICK FOOTER WRAPPER ENDS-->

<!--STICKY-BAR-->
<div id="sticky-bar">  
  <div id="progress-buttons-container">
    <a href="<?=site_url('signup/follow')?>" class="next-button">Next</a> 
  </div>        
</div>
<!-- </div> --><!--HIDE WRAPPER ENDS-->

<script type="text/javascript">
  $(function() {
    $('#place_name').focus();
    
    $('input.place-input').live('keyup.autocomplete', function(){
      $(this).autocomplete({
  			source: function(request,response) {
          $.post(baseUrl+'places/ajax_autocomplete', {term:request.term},
            function(data) {var r = $.parseJSON(data); response( $.map(r, function(item) {
  							return {
  								label: item.name,
  								value: item.name,
  								id: item.id,
  								lat: item.lat,
  								lng: item.lng
  							}
  						}));
  					});
          },
  			minLength: 2,
  			delay: 200,
  			appendTo: '#place',
  			select: function(event,ui) {
  				$.post(baseUrl+'places/ajax_edit_fut_place', {placeId:ui.item.id, isFuture:1},
  				  function(d) {
  				  }
  				)
		      $(this).after('<div><span class="place" lat="'+ui.item.lat+'" lng="'+ui.item.lng+'">'+ui.item.label+'</span> <a href="#" class="remove-place" id="place-'+ui.item.id+'">remove</div>');
  				$('#add-place').click();
  				$(this).parent().next().children('input.place-input').focus();
		      $(this).remove();
  			}
  		})
		});
		  
		  
    // dynamic form plugin for multiple places
    $('#place').dynamicForm('#add-place', '#subtract-place', {});
    

    $('.remove-place').click(function() {
      var placeId = $(this).attr('id').match(/^place-(\d+)$/)[1];
      $.post(baseUrl+'places/ajax_edit_fut_place', {placeId:placeId, isFuture:0},
        function(d) {
          $('#place-'+placeId).parent().remove();
        });
      return false;
    });
  });
  
  
/*
  addMarker = function(lat, lng) {
    var marker = po.geoJson()
        .features([
            {geometry: {type:'Point', coordinates:[parseFloat(lng), parseFloat(lat)]}}
        ])
        .on('load', po.stylist().attr('fill', 'red'));
    map.add(marker);
    
  }
*/
</script>
</body>
</html>