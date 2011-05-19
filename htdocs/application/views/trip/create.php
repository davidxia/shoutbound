<?
$header_args = array(
    'title' => 'Shoutbound',
    'css_paths'=>array(
        'css/excite-bike/jquery-ui-1.8.11.custom.css',
        'css/createtrip.css',
    ),
    'js_paths'=>array(
        'js/user/loginSignup.js',
        'js/jquery/validate.min.js',
        'js/jquery/jquery-ui-1.8.11.custom.min.js',
        'js/jquery/popup.js',
        'js/jquery/jquery-dynamic-form.js'
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
</script>

</head>

<body>

<div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>
		  
  <!-- TRIP CREATION FORM -->
  <form id="trip-creation-form" action="confirm_create" method="post">
    
    <!-- PLACE DATES FIELD -->
    <fieldset>
      <div>Destinations</div>
      <div id="dates-header">Dates (optional)</div>     
      <div id="place_dates">
      
        <a id="add-place" href="">[+]</a><a id="subtract-place" href="">[-]</a>
        
        <div class="field place">
          <span class="label-and-errors">
            <label for="address0"></label>
            <span class="error-message" style="float:right;"></span>
          </span>
          <input type="text" id="place_name" class="place-input" name="address" autocomplete=off
			     <? if ($place):?>value="<?=$place?>"<? endif;?>
          />
          <input type="hidden" id="place_id" class="required place_ids" name="place_id"
  			    <? if ($place_id):?>value="<?=$place_id?>"<? endif;?>
          />
        </div>
        
        <div class="field dates" style="visibility:hidden;">
          <span class="label-and-errors">
            <span class="error-message"></span>
            <div class="clear"></div>
          </span>
          <label for="startdate">from</label> <input id="startdate" class="startdate" name="startdate" type="text" size="10"/> <label for="enddate">to</label> <input id="enddate" class="enddate" name="enddate" type="text" size="10" />
        </div>
        
      </div>
    </fieldset><!-- PLACE DATES FIELD ENDS -->
    
    <!-- SUMMARY FIELD -->
    <fieldset id="summary-field">
      <div class="field trip_name">
        <span class="label-and-errors">
          <label for="trip_name">Trip name</label>
          <span class="error-message"></span>
          <div class="clear"></div>
        </span>
        <input id="trip_name" name="trip_name" class="required" type="text"/>
      </div>
       <div class="field">
        <span class="label-and-errors">
          <label for="description">Trip description</label>
          <span class="error-message"></span>
          <div class="clear"></div>
        </span>
        <textarea id="description" name="description"></textarea>
      </div>
    </fieldset><!-- SUMMARY  FIELD ENDS -->


    <div style="margin-top:10px;">
      <button id="create-submit" class="blue-button" type="submit">Create</button>
    </div>
  </form><!-- TRIP CREATION FORM ENDS -->
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->

</div><!--CLOSE STICKY FOOTER WRAPPER-->
<? $this->load->view('footer')?>
</body>
</html>

<script type="text/javascript">  
  $(function() {
    $('#place_name').focus();
  
    // dates for 1st place appear if it's filled in
    if ($('#place_name').val() != '') {
      $('#dates-header').css('visibility', 'visible');
      $('.dates').css('visibility', 'visible');
    }
  
  
    // dynamic form plugin for multiple places
    $('#place_dates').dynamicForm('#add-place', '#subtract-place', {
      limit: 5,
      afterClone: function(clone) {
        clone.find('input').val('');
        clone.find('.dates').css('visibility', 'hidden');
        // TODO: why doesn't this work?
        clone.find('.place-input').focus();
      }
    });
    
    // jquery form validation plugin
    $('#trip-creation-form').validate({
      rules: {
        startdate: {
          date: true
        },
        enddate: {
          date: true
        }
      },
      messages: {
        trip_name: 'Give your trip a cool name.'
      },
      errorPlacement: function(error, element) {
        error.appendTo( element.siblings('.label-and-errors').children('.error-message') );
      }
    });
    
    
    // clicking create button checks if form is valid
    // if user is logged in, form is submitted
    // if user isn't logged in, login/signup dialogue pops up
    $('#create-submit').click(function() {
      if ($('#trip-creation-form').valid()) {
        var loggedin = loginSignup.getStatus();
        if (loggedin) {
          $('#trip-creation-form').submit();
        } else {
          loginSignup.showDialog('create trip');
        }
      }
      return false;
    });
    
    
    // datepicker jquery plugin
    $('.startdate').live('focus', function() {
      $(this).datepicker();
    });
    $('.enddate').live('focus', function() {
      $(this).datepicker();
    });
    //$('#deadline').datepicker(); 
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
        ele.val($('.selected').children('a').text());
        ele.siblings('.place_ids').val($('.selected').children('a').attr('id'));
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
      $('#dates-header').css('visibility', 'visible');
      $('#place-autocomplete').remove();
      dates.css('visibility', 'visible');
      dates.children('.startdate').focus();
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
      $(this).parent().siblings('.place-input').val($(this).children('a').text());
      $(this).parent().siblings('.place_ids').val($(this).children('a').attr('id'));
      $(this).parent().parent().siblings('.dates').css('visibility', 'visible');
      $('#place-autocomplete').remove();
      $('#dates-header').css('visibility', 'visible');
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
</script>