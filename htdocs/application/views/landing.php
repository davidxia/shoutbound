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
</script>
</body>
</html>