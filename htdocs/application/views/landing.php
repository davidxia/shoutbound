<?
$header_args = array(
    'title' => 'Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>

<style type="text/css"> 
#lets-go {
  cursor: pointer;
  display:block;
  height:45px;
  line-height:30px;
  text-align:center;
  font-size:18px;
  text-decoration:none;
	color: white;
	border: solid 1px #0076a3;
	background: #0095cd;
	background: -webkit-gradient(linear, left top, left bottom, from(#44749D), to(##44749D));
	background: -moz-linear-gradient(top,  #44749D,  #44749D);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#44749D', endColorstr='#navy');
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  position: absolute;
  right: 0;
  z-index: 3;
  margin: 0;
}
#lets-go:hover {
	background: #007ead;
	background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
	background: -moz-linear-gradient(top,  #0095cc,  #00678e);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0095cc', endColorstr='#00678e');
}
#lets-go:active {
	color: #80bed6;
	background: -webkit-gradient(linear, left top, left bottom, from(#0078a5), to(#00adee));
	background: -moz-linear-gradient(top,  #0078a5,  #00adee);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0078a5', endColorstr='#00adee');
}
#place-autocomplete .selected, #place-autocomplete li:hover {
  font-weight:bold;
  background-color: #E0E0FF;
}
</style>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
</script>
</head>

<body>
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>
  <!--LEFT-->
	<div style="width:450px; float:left; padding:20px; margin-top:45px;">
    <h2 style="font-size:52px; line-height:58px; font-weight:bold;">Collaborative travel planning.</h2>

		<!--BAR-->
		<div style="position:relative; line-height:45px; height:45px; width:400px; margin-top:20px; margin-bottom:20px;">
		  <form id="place_input-form" action="trips/create" method="post" style="position:relative; height:45px;">
		    <label for="place_input" style="position:absolute; font-size:20px; color:#007EAD; z-index:1; background-color:white; height:45px; padding-left:12px; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px;"><span>Where do you want to go?</span></label>
			  <input type="text" id="place_input" name="place_input" autocomplete="off" style="position:absolute; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; height:41px; width:313px; margin-right:70px; padding-left:10px; font-size:20px; z-index:2; background:transparent; border:1px solid #8F8F8F;"/>
			  <input type="hidden" id="place_id" name="place_id"/>
			  <button id="lets-go" type="submit">Let&rsquo;s go!</button>
		  </form>
  		  
		</div><!--BAR ENDS-->

		<h3 style="font-size:24px; color:gray; font-weight:normal;">Use Shoutbound to organize group travel plans and get travel advice from friends and family.</h3>
	
	</div><!--LEFT ENDS-->
	
	<!--RIGHT-->
	<div>
  	<img src="<?=site_url('static/images/stockphoto.jpg')?>" width="470" height="407"/>
  </div><!--RIGHT ENDS-->
  
</div><!-- WRAPPER ENDS -->
</div><!-- CONTENT ENDS -->
	  	  	 
<!--BOTTOM-->  		  		 		
<div id="bottom" style="background-color:#EBE7E0; padding:30px 0; border-top:1px solid #BDB8AD; border-bottom:1px solid #BDB8AD;">

	<div id="panel" style="height:170px; padding:30px 0px 30px 0px; width:914px; margin:auto; background-color:white; -moz-box-shadow: 2px 2px 2px 2px gray; -webkit-box-shadow: 2px 2px 2px 2px gray; box-shadow: 2px 2px 2px 2px gray; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:1px solid #C8C8C8; text-align:center;">
	
		<div style="float:left; margin-left:35px; padding-right:29px; width:240px;"><h2>Create a trip</h2><br/><p>Coming to see New York? Dreaming of exploring Tibet? Create a trip for all your travel plans and dreams!</p>
		</div>
	
		<div style="float:left; padding-left:30px; padding-right:29px; border-right:1px solid #C8C8C8; border-left:1px solid #C8C8C8; width:240px;"><h2>Build your trip</h2><br/><p>Invite friends and family to join you on your trips or give you travel advice. Shoutbound organizes and records their responses all in one place.</p>
		</div>
		
		<div style="float:left; margin-left:30px; padding-right:35px; width:240px;"><h2>Go!</h2><br/><p>Use Shoutbound to remember, discover, and experience all the great places your friends and family recommended for you!</p>
		</div>
		
	</div>	
</div><!-- BOTTOM ENDS -->

<? $this->load->view('footer')?>


<script>
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

  $(document).ready(function() {
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
      $('#place_input').val($(this).children('a').text());
      $('#place_id').val($(this).children('a').attr('id'));
      $('#place-autocomplete').remove();
      $('#place_input-form').submit();
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
        $('#place_input').val($('.selected').children('a').text());
        $('#place_id').val($('.selected').children('a').attr('id'));
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