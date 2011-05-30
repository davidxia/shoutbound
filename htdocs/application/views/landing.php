<?
$header_args = array(
    'title' => 'Have an Adventure | Shoutbound',
    'css_paths'=>array(
      'css/landing.css',
    ),
    'js_paths'=>array(
      'js/jquery/jqFancyTransitions.1.8.min.js',
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

  <div id="landing-page-gallery">
    <div id="slideshowHolder">
      <img src="http://i.imgur.com/vpuuY.jpg" width="490" height="375"/>
      <img src="https://lh4.googleusercontent.com/_lgMz7QRk66k/TI40jh7fCfI/AAAAAAAAAh8/qk-rneImY4A/s800/3765705795_f124a87d70.jpg" width="490" height="375"/>
      <img src="http://i.imgur.com/ttCWR.jpg" width="490" height="375"/>
      <img src="http://i.imgur.com/l9L1Y.jpg" width="490" height="375"/>
    </div>
  </div>

  <div id="landing-page-left">
    <div id="landing-page-title">Discover your next travel adventure.</div>    
    <div id="sign-up-button-container">
      <a href="<?=site_url('signup/index')?>" id="sign-up">Let's go!</a>
    </div>
  </div>

  <div style="clear:both"></div>
  
  <div id="landing-page-bottom"><!--BOTTOM-->
  
    <!-- 1st Bottom Item-->
    <div class="landing-page-bottom-item">
      <div class="bottom-item-title">Find relevant travel content<br/>from people you trust.</div>
      <div class="bottom-item-img-container"></div>
      <div class="bottom-item-copy">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</div>  
    </div>
    
    <!-- 2nd Bottom Item-->
    <div class="landing-page-bottom-item">
      <div class="bottom-item-title">Collaborate with friends and family to plan your next trip.</div>
      <div class="bottom-item-img-container"></div>
      <div class="bottom-item-copy">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</div>  
    </div>
    
    <!-- 3rd Bottom Item-->    
    <div class="landing-page-bottom-item">
      <div class="bottom-item-title">Share your travel dreams<br/>and experiences.</div>
      <div class="bottom-item-img-container"></div>
      <div class="bottom-item-copy">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</div>        
    </div>
    
    <!-- Last Bottom Item-->    
    <div class="landing-page-bottom-item last">
      <div class="bottom-item-title">Drive traffic to your travel blog<br/>or related publication.</div>
      <div class="bottom-item-img-container">
        <img alt="Wordpress, Tumblr, Blogger" src="<?=site_url('static/images/blogging-services.jpg')?>"/>
      </div>           
      <div class="bottom-item-copy">Use Shoutbound to distribute your travel content and increase traffic to your travel blog or website.</div>  
    </div> 
    
    <div style="clear:both"></div>
  </div><!--BOTTOM END-->


  </div><!-- WRAPPER ENDS -->
  </div><!-- CONTENT ENDS -->
  </div><!--STICKY FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>

		<!--BAR-->
<!--
		<div style="position:relative; line-height:45px; height:45px; width:400px; margin-top:20px; margin-bottom:20px;">
		  <form id="place_input-form" action="trips/create" method="post" style="position:relative; height:45px;">
		    <label for="place_input" style="position:absolute; font-size:20px; color:#007EAD; z-index:1; background-color:white; height:45px; padding-left:12px; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px;"><span>Where do you want to go?</span></label>
			  <input type="text" id="place_input" name="place_input" autocomplete="off" style="position:absolute; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; height:41px; width:313px; margin-right:70px; padding-left:10px; font-size:20px; z-index:2; background:transparent; border:1px solid #8F8F8F;"/>
			  <input type="hidden" id="place_id" name="place_id"/>
			  <button id="lets-go" type="submit">Let&rsquo;s go!</button>
		  </form>
  		  
		</div>
--><!--BAR ENDS-->
	
	<!--RIGHT-->
<!--   	<img src="<?=site_url('static/images/stockphoto.jpg')?>" width="470" height="407"/> -->
<!--RIGHT ENDS-->
  

<script>
  $('#slideshowHolder').jqFancyTransitions({ width: 490, height: 375, effect:'wave', delay:3500, navigation: false, links: false });
  

  $.fn.labelFader = function() {
    var f = function() {
      var $this = $(this);
      if ($this.val()) {
        $this.siblings('label').children('span').hide();
      } else {
        $this.siblings('label').children('span').fadeIn('fast');
      }
    };
    this.focus(f);
    this.blur(f);
    this.keyup(f);
    this.change(f);
    this.each(f);
    return this;
  };

  $(function() {
    $('#place_input').focus();
    $('#place_input').labelFader();
    
    // bind onkeyup event to location-search-box
    $('#place_input').keyup(function(e) {
      var keyCode = e.keyCode || e.which;
      var q = $.trim($(this).val());
      // ignore arrow keys
      if (keyCode!==37 && keyCode!==38 && keyCode!==39 && keyCode!==40 && q.length>2) {
        var f = function () {geocoder(q);};
        delay(f, 200);
      }
    });
    
    
    $('#place-autocomplete > li').live('click', function() {
      var a = $(this).children('a'),
          name = a.text(),
          id = a.attr('id').match(/^place-(\d+)$/)[1];
      $('#place_input').val(name);
      $('#place_id').val(id);
      $('#place-autocomplete').remove();
      $('#place_input-form').submit();
      return false;
    });
    
    
    $('#login-submit').click(function() {
      var postData = {
        email: $('#email').val(),
        password: $('#password').val()
      };
      
      $.post('<?=site_url('login/ajax_email_login')?>', postData,
        function(d) {
          var r = $.parseJSON(d);
          if (r.success) {
            window.location = '<?=site_url()?>';
          } else {
            var text = 'Wrong email or password.';
            $('#login-error').html(text);
          }
        });
      return false;
    });
  });

  
  // allows user to use up/down arrows to select from autosuggest list
  $('#place_input').keyup(function(e) {
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
        $('#place_input').val(name);
        $('#place_id').val(id);
      }
  
      if (keyCode === arrow.up) {
        return false;
      }

      return;
    }
  });
  
  
  $('#place_input').bind('keydown keypress', function(e) {
    var keyCode = e.keyCode || e.which,
      arrow = {up: 38};
    if (keyCode == arrow.up) {
      e.preventDefault();
    }
  });
  
  
  // remove selected formatting on mouseover
  $('#place-autocomplete').mouseover(function() {
    $(this).children().removeClass('selected');
  });
  

  // delay geocoder for x ms of keyboard inactivity
  delay = (function() {
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    };
  })();


  geocoder = function(q) {      
    $.post(baseUrl+'places/ajax_autocomplete', {query:q},
      function(d) {
        $('#place-autocomplete').remove();
        $('#place_input-form').after(d);
      });
  };
</script>
</body>
</html>