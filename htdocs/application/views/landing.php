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
      <a href="<?=site_url('signup/index')?>" id="sign-up">Sign up!</a>
    </div>
  </div>

  <div style="clear:both"></div>
  
  <div id="landing-page-bottom"><!--BOTTOM-->
  
    <!-- 1st Bottom Item-->
    <div class="landing-page-bottom-item">
      <div class="bottom-item-title">Discover relevant travel<br/>content from people you trust.</div>
      <div class="bottom-item-img-container"><img src="<?=site_url('static/images/CompassIcon.jpg')?>" height="75" width="75"/></div>
      <div class="bottom-item-copy"><!-- Use Shoutbound to learn more about the places you're dying to go, the people who interest you, and their trips.  --><a href="<?=site_url('/about')?>">Learn more</a>.</div>  
    </div>
    
    <!-- 2nd Bottom Item-->
    <div class="landing-page-bottom-item">
      <div class="bottom-item-title">Collaborate with friends and family to plan your next trip.</div>
      <div class="bottom-item-img-container"><img src="<?=site_url('static/images/collaborate-icon.png')?>"/>
</div>
      <div class="bottom-item-copy"><!-- Ask your friends and family for travel recommendations. Shoutbound organizes their responses for you.  --><a href="<?=site_url('/about')?>">Learn more</a>.</div>  
    </div>
    
    <!-- 3rd Bottom Item-->    
    <div class="landing-page-bottom-item">
      <div class="bottom-item-title">Share your travel dreams<br/>and experiences.</div>
      <div class="bottom-item-img-container"><img src="<?=site_url('static/images/broadcast_icon.png')?>"?></div>
      <div class="bottom-item-copy"><!-- Shoutbound makes it easy to share your travel experiences and help others plan their trips based on your advice.  --><a href="<?=site_url('/about')?>">Learn more</a>.</div>        
    </div>
    
    <!-- Last Bottom Item-->    
    <div class="landing-page-bottom-item last">
      <div class="bottom-item-title">Drive traffic to your travel blog<br/>or related publication. </div>
      <div class="bottom-item-img-container">
        <img src="<?=site_url('static/images/loudspeaker.png')?>" height="75" width="75"/>
      </div>           
      <div class="bottom-item-copy"><!-- Use Shoutbound to distribute your travel content and increase traffic to your travel blog, website, or publication.  --><a href="<?=site_url('/about')?>">Learn more</a>.</div>  
    </div> 
    
    <div style="clear:both"></div>
  </div><!--BOTTOM END-->


  </div><!-- WRAPPER ENDS -->
  </div><!-- CONTENT ENDS -->
  </div><!--STICKY FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>
<script>
  $('#slideshowHolder').jqFancyTransitions({ width: 490, height: 375, effect:'zipper', delay:3500, navigation: false, links: false });
  

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
</script>
</body>
</html>