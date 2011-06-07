<?
$header_args = array(
    'title' => 'Getting Started | Shoutbound',
    'css_paths' => array(
        'css/onboarding.css',
    ),
    'js_paths' => array(
        'js/common.js',
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
              <a id="add-place" href="" style="position:absolute;left:-20px;top:15px; color:white;">[+]</a><a id="subtract-place" href="" style="position:absolute;left:-20px;top:30px;color:white;">[-]</a>
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
    <a href="#" class="next-button">Next</a> 
  </div>        
</div>
<!-- </div> --><!--HIDE WRAPPER ENDS-->

<script type="text/javascript">
  $(function() {
    $('#place_name').focus();
  
    $('input.place-input').live('keyup', function(e) {
      var keyCode = e.keyCode || e.which,
          q = $.trim($(this).val()),
          ele = $(this);
      // ignore arrow keys
      if (keyCode!==37 && keyCode!==38 && keyCode!==39 && keyCode!==40 && q.length>2) {
        var f = function () {geocoder(q, ele);};
        delay(f, 200);
      }
    });

    $('#place-autocomplete > li').live('click', function() {
      var a = $(this).children('a'),
          name = a.text(),
          id = a.attr('id').match(/^place-(\d+)$/)[1];
      $(this).parent().siblings('.place-input').val(name);
      $(this).parent().siblings('.place_ids').val(id);
      $('#place-autocomplete').remove();
      $('#add-place').click();
      addMarker(a.attr('lat'), a.attr('lng'));
      return false;
    });


    $('.place-input').focus();
    // dynamic form plugin for multiple places
    $('#place').dynamicForm('#add-place', '#subtract-place', {
      limit: 10,
      afterClone: function(clone) {
        clone.find('input').val('');
      }
    });
    
  
    // allows user to use up/down arrows to select from autosuggest list
    $('.place-input').live('keyup', function(e) {
      var ele = $(this);
      var keyCode = e.keyCode || e.which,
          arrow = {up: 38, down: 40};
        
      /*key navigation through elements*/
      if (keyCode == arrow.up || keyCode == arrow.down) {
        var results = $('#place-autocomplete li');
    
        var current = results.filter('.selected'),
            next;
        
        switch (keyCode) {
          case arrow.up:
            next = current.prev();
            break;
          case arrow.down:
            if (!results.hasClass('selected')) {
              results.first().addClass('selected');
            }
            next = current.next();
            break;
        }
    
        //only check next element if up and down key pressed
        if (next.is('li')) {
          current.removeClass('selected');
          next.addClass('selected');
        }
    
        //update text in searchbar
        if (results.hasClass('selected')) {
          var a = $('.selected').children('a'),
              name = a.text();
              //id = a.attr('id').match(/^place-(\d+)$/)[1];
          ele.val(name);
          //ele.siblings('.place_ids').val(id);
        }
    
        //set cursor position
        if (keyCode === arrow.up) {
          return false;
        }
  
        return;
      }
    });
  
  
    $('.place-input').live('keydown keypress', function(e) {
      var keyCode = e.keyCode || e.which,
        arrow = {up: 38, enter: 13};
      
      if (keyCode == arrow.up || keyCode == arrow.enter) {
        e.preventDefault();
      }
      if (keyCode == arrow.enter) {
        var list = $('#place-autocomplete');
        var id = $(list.children('.selected')[0]).children('a').attr('id').match(/^place-(\d+)$/)[1];
        $(this).siblings('.place_ids').val(id);
        list.remove();
        $('#add-place').click();
        //addMarker(a.attr('lat', a.attr('lng')))
      }
    });
  

    $('.next-button').click(function() {
      var ids = $('.place_ids').map(function() {return $(this).val();}).get();
      $('#bucket-list').submit();
      return false;
    });


    $('.remove-place').click(function() {
      var placeId = $(this).attr('id').match(/^place-(\d+)$/)[1];
      $.post(baseUrl+'places/ajax_edit_fut_place', {placeId:placeId, follow:0},
        function(d) {
          $('#place-'+placeId).parent().remove();
        });
      return false;
    });
  });
  

  delay = (function() {
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    };
  })();


  geocoder = function(q, ele) {      
    $.post(baseUrl+'places/ajax_autocomplete', {query:q},
      function(d) {
        $('#place-autocomplete').remove();
        ele.after(d);
      });
  };


/*
  $('#get-started-button').click(function() {
    $('#hide-wrapper').show();
    $('#sticky-bar').show();
    $('#intro-box').hide();
    return false;
  });


  function toggle_visibility(id) {
     var e = document.getElementById(id);
     if(e.style.display == 'block')
        e.style.display = 'none';
     else
        e.style.display = 'block';
  }
*/
  
  
  addMarker = function(lat, lng) {
    var marker = po.geoJson()
        .features([
            {geometry: {type:'Point', coordinates:[parseFloat(lng), parseFloat(lat)]}}
        ])
        .on('load', po.stylist().attr('fill', 'red'));
    map.add(marker);
    
  }
</script>
</body>
</html>