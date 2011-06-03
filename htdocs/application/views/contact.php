<?
$header_args = array(
    'title' => 'Contact Us | Shoutbound',
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
  	<li><a href="<?=site_url('/press')?>">Press</a></li>
  	<li class="selected"><a href="<?=site_url('/contact')?>">Contact</a></li>						
  </ul>
  <!--NAV END-->

  <!--ABOUT CONTENT START-->
  <div id="about-container">
    <div id="about-header"><h1>We&#39;d love to hear from you&#33;</h1></div>
    <? if(!isset($user)):?>
      <div class="about-signup-button-container">
        <a href="<?=site_url('signup/index')?>" id="sign-up">Sign up</a>
      </div>
    <? endif;?>
    <div class="about-item">
      <div class="about-item-header">E-mail is best.</div>
      <div class="about-item-content">You can e-mail us at <a href="mailto:hello@shoutbound.com?Subject=Hello!">hello@shoutbound.com</a>. We respond to every message we get. Have a question?  Got a great idea for a feature?  Feedback?  We&#8217d love to hear from you.</div>
      <div style="clear:both"></div>
    </div>
      
    <div class="about-item">
      <div class="about-item-header">Stay in the loop.</div>
      <div class="about-item-content">ou can read our <a href="http://blog.shoutbound.com" target="_blank">blog</a>, follow us on <a href="http://twitter.com/shoutbound" target="_blank">Twitter</a>, join us on <a href="http://www.facebook.com/pages/Shoutbound/150065021716235" target="_blank">Facebook</a>.</div>
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