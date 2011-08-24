<?
$header_args = array(
    'title' => 'Our Values | Shoutbound',
    'css_paths'=> array(
        'css/home.css',
        'css/about.css',
    ),
    'js_paths'=> array(
    )
);
$this->load->view('core_header', $header_args);
?>

<body>
  <div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>

  <!--NAV START-->
  <ul id="navbar">
  	<li><a href="<?=site_url('/about')?>">About</a></li>
  	<li><a href="<?=site_url('/about/story')?>">Story</a></li>
  	<li><a href="<?=site_url('/about/team')?>">Team</a></li>
  	<li class="selected"><a href="<?=site_url('/about/values')?>">Values</a></li>
  	<li><a href="http://blog.shoutbound.com" target="_blank">Blog</a></li>
  	<li><a href="<?=site_url('/press')?>">Press</a></li>
  	<li><a href="<?=site_url('/contact')?>">Contact</a></li>						
  </ul>
  <!--NAV END-->

  <!--ABOUT CONTENT START-->
  <div id="about-container">
    <div id="about-header"><h1>These are our four core values.</h1></div>
    <? if(!isset($user)):?>
      <div class="about-signup-button-container">
        <a href="<?=site_url('signup/index')?>" id="sign-up">Sign up</a>
      </div>
    <? endif;?>
    <div class="about-item">
      <div class="about-item-header">Adventure</div>
      <div class="about-item-content">We&#8217re adventurers at heart, and we created Shoutbound to help people turn their travel dreams into real-life adventures.  Whether you dream of climbing the Seven Summits, backpacking through South America, or discovering the best pizza in New York City, we&#8217re committed to helping you do that.</div>
      <div class="about-item-img-container">
        <img src="<?=site_url('static/images/smallstockphoto.jpg')?>" alt="Things to bring on a travel journey" width="138" height="114"/>      
      </div>            
      <div style="clear:both"></div>
    </div>
      
    <div class="about-item">
      <div class="about-item-header">Environment</div>
      <div class="about-item-content">We believe in sustainability and environmental stewardship, and we take active steps to reduce our own carbon footprint<!-- , and we offset the balance -->. <!-- Shoutbound is a certified carbon neutral company by the Bonneville Environmental Foundation, an independent, non-profit organization. --></div>
      <div class="about-item-img-container">
        <img src="<?=site_url('static/images/environment.jpeg')?>" alt="Shoutbound is environmentally friendly"/>  
      </div>          
      <div style="clear:both"></div>    
    </div>

    <div class="about-item">
      <div class="about-item-header">Community</div>
      <div class="about-item-content">We aim to be active and helpful participants in the global travel community.  Have a question for us&#63;  Got a great idea for a feature&#63;  <a href="<?=site_url('/contact')?>">Getting in touch is easy</a>, and we promptly respond to every message we get.  You can also read our <a href="http://blog.shoutbound.com" target="_blank">blog</a>, follow us on <a href="http://twitter.com/shoutbound">Twitter</a>, or join us on <a href="http://www.facebook.com/pages/Shoutbound/150065021716235">Facebook</a>.</div>
      <div class="about-item-img-container">
        <img src="<?=site_url('static/images/community-icon.jpeg')?>" alt="Shoutbound is committed to the travel community"/>  
      </div>            
      <div style="clear:both"></div>    
    </div>

    <div class="about-item">
      <div class="about-item-header">Transparency</div>
      <div class="about-item-content">We disclose the source of any information or recommendation made by us.  We do so openly, honestly, and always.</div>
        <img style="margin-left:15px" src="<?=site_url('static/images/transparency-icon.jpg')?>" alt="Shoutbound is transparent"/>  
      </div>            
      <div style="clear:both"></div>    
    </div>

  </div> 
  <!--ABOUT CONTENT END-->

  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICK FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>
</body>
</html>