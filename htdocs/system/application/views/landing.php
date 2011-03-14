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
  padding: 0 20px;
  cursor: pointer;
  display:block;
  height:61px;
  line-height:30px;
  text-align:center;
  font-weight:bold;
  font-size:22px;
  text-decoration:none;
	color: white;
	border: solid 1px #0076a3;
	background: #0095cd;
	background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
	background: -moz-linear-gradient(top,  #00adee,  #0078a5);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#00adee', endColorstr='#0078a5');
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
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
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0078a5', endColorstr='#00adee');
}
</style> 

</head>

<body style="background-color:#1B272C;">

  <?=$this->load->view('header')?>

	<div class="wrapper" style="background-color:white;">
	
  	<!-- CONTENT -->		
  	<div class="content" style="position:relative; margin:0 auto; width:960px;">
  		<div style="text-align:center; padding-top:50px; margin-bottom:30px;">
  		  <img src="<?=site_url('images/stockphoto.jpg')?>" width="520" height="350"/>
  		</div>
  		
  		<ul>
  		  <li style="float:left; width:280px; margin:0 20px;">
  		    <h2 style="font-size:28px; margin-bottom:15px;">Create</h2>
  		    <p>Create a trip to wherever you want to go. Heading to New York to see the Big Apple? Dreaming of exploring Tibet? Planning a honeymoon in Bali? Create a trip on Shoutbound for all your future travel plans and dreams.</p>
  		  </li>
  		  <li style="float:left; width:280px; margin:0 20px;">
  		    <h2 style="font-size:28px; margin-bottom:15px;">Receive</h2>
  		    <p>Want to know if anyone's up for joining you in Italy this summer? Looking for authentic dumplings in Hong Kong? Invite your friends and family to join you on your trips or give you travel advice. Shoutbound organizes and records their responses, making it easy to organize group travel and get recommendations from the people you trust.</p>
  		  </li>
  		  <li style="float:left; width:280px; margin:0 20px;">
  		    <h2 style="font-size:28px; margin-bottom:15px;">Go</h2>
  		    <p>On your trip, use Shoutbound to remember, discover, and experience all the great places your friends and family recommended for you.</p>
  		  </li>
  		  <li style="clear:both;"></li>
  		</ul>
  		
  	</div><!-- CONTENT ENDS -->
  	
  	<div style="background:#1b272c; position:relative; top:-380px; left:0;">
      <div style="margin:0 auto; width:700px; padding:15px; line-height:60px; height:60px;">
  		  <form action="trips/create" method="post" style="position:relative;">
    		    <label for="destination" style="position:absolute; font-size:22px; font-weight:bold; color:#87CEEB; z-index:1; background-color:white; width:558px; height:61px; padding:0 100px 0 40px;"><span>Where do you want to go?</span></label>
    			  <input type="text" id="destination" name="destination" autocomplete="off" style="position:absolute; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; height:59px; width:558px; padding:0 100px 0 40px; font-size:22px; font-weight: bold; color:#000080; z-index:2; background:transparent;"/>
    			  <button id="lets-go" type="submit">Let's go</button>
  		  </form>
      </div>
  	</div>


	</div><!-- WRAPPER ENDS -->

  <?=$this->load->view('footer')?>

<script>
  $.fn.labelFader = function() {
    var f = function() {
      var $this = $(this);
      if ($this.val()) {
        $this.siblings("label").children('span').hide();
      } else {
        $this.siblings("label").children('span').fadeIn("fast");
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
    $('#destination').focus();

    $('#destination').labelFader();
  });
</script>

</body>
</html>