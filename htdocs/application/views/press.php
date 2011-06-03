<?
$header_args = array(
    'title' => 'Press | Shoutbound',
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
  	<li><a href="<?=site_url('/about/values')?>">Values</a></li>
  	<li><a href="http://blog.shoutbound.com" target="_blank">Blog</a></li>
  	<li class="selected"><a href="<?=site_url('/press')?>">Press</a></li>
  	<li><a href="<?=site_url('/contact')?>">Contact</a></li>						
  </ul>
  <!--NAV END-->



  <!--ABOUT CONTENT START-->
  <div id="about-container">
    <div id="about-header"><h1>Nice to meet you : )</h1></div>
    <? if(!isset($user)):?>
      <div class="about-signup-button-container">
        <a href="<?=site_url('signup/index')?>" id="sign-up">Sign up</a>
      </div>
    <? endif;?>
    <div class="about-item">
      <div class="about-item-header">We&#39;d love to hear from you.</div>
      <div class="about-item-content">Shoutbound is currently in private alpha. If you have any questions or would like to know more about what we&#39;re doing, drop James a line at <a href="mailto:james@shoutbound.com">james@shoutbound.com</a>.</div>
    </div>
    <div style="clear:both"></div>
    <div class="about-item">
      <div class="about-item-header">Press kit.</div>
      <div class="about-item-content"><a href="">Click here to download our press kit</a>, which contains our logo, information about our company and founders, and other helpful materials.</div>
    </div>
    <div style="clear:both"></div>    

  </div> 
  <!--ABOUT CONTENT END-->

  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICK FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>
</body>
</html>