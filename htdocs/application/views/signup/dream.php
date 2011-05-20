<?
$header_args = array(
    'title' => 'Dream | Shoutbound',
    'css_paths' => array(
        'css/dream.css',
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
</script>
</head>
	
<body style="overflow-y: hidden; overflow-x:hidden;">

  <!--CONTENT-->
  <div class="onboarding-main"> 
    
    <!--TOP-->
    <div id="onboarding-top">
      <div class="onboarding-header activeheader">1. Dream</div>
      <div class="onboarding-header">2. Follow</div>
      <div class="onboarding-header">3. Profile</div>    
    </div>
    
    <!--LEFT-->
    <div id="onboarding-left">
      <div class="onboarding-subtitle">What are your dream travel destinations?</div>
      <form id="bucket-list" action="<?=site_url('signup/save_bucket_list')?>" method="post">
      <fieldset>
        <div id="place" style="position:relative;">
          <a id="add-place" href="" style="position:absolute;left:-20px;top:15px;">[+]</a><a id="subtract-place" href="" style="position:absolute;left:-20px;top:30px;">[-]</a>
          <span class="label-and-errors">
            <label for="place_name0"></label>
            <span class="error-message" style="float:right;height:19px;"><span style="color:white">a</span></span>
          </span>
          <input type="text" id="place_name" class="place-input" name="place_name" autocomplete=off/>
          <input type="hidden" id="place_id" class="place_ids" name="place_id"/>
        </div>
      </fieldset>
      </form>
    </div>
    
    <!--MAP-->
    <div id="map-shell">
      <div id="map-canvas">
        <img src="<?=site_url('static/images/map_placeholder.png')?>" width="490" height="390"/>
      </div>
    </div>
           
    <div style="clear:both"></div>
    
  </div><!--CONTENT END-->

  <!--STICKY-BAR-->
  <div id="sticky-bar">  
    <div id="progress-buttons-container">
      <a href="#" class="next-button">Next</a> 
    </div>        
  </div>

<script type="text/javascript">
  $('.place-input').focus();
  // dynamic form plugin for multiple places
  $('#place').dynamicForm('#add-place', '#subtract-place', {
    limit: 10,
    afterClone: function(clone) {
      clone.find('input').val('');
    }
  });


  // jquery form validation plugin
  $('#bucket-list').validate({
    errorPlacement: function(error, element) {
      error.appendTo( element.siblings('.label-and-errors').children('.error-message') );
    }
  });


  // allows user to use up/down arrows to select from autosuggest list
  $('.place-input').keyup(function(e) {
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
            name = a.text(),
            id = a.attr('id').match(/^place-(\d+)$/)[1];
        ele.val(name);
        ele.siblings('.place_ids').val(id);
      }
  
      //set cursor position
      if (keyCode === arrow.up) {
        return false;
      }

      return;
    }
  });


  $('.place-input').bind('keydown keypress', function(e) {
    var keyCode = e.keyCode || e.which,
      arrow = {up: 38, enter: 13};
    
    if (keyCode == arrow.up || keyCode == arrow.enter) {
      e.preventDefault();
    }
    if (keyCode == arrow.enter) {
      var dates = $(this).parent().next();
      $('#place-autocomplete').remove();
      $('#add-place').click();
    }    
  });


  $(function() {
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
  
  $('.next-button').click(function() {
    if ($('#bucket-list').valid()) {
      var ids = $('.place_ids').map(function() {return $(this).val();}).get();
      $('#bucket-list').submit();
    }
    return false;
  });
</script>
</body>
</html>