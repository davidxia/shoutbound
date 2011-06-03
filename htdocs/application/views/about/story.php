<?
$header_args = array(
    'title' => 'Our Story | Shoutbound',
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
  	<li class="selected"><a href="<?=site_url('/about/story')?>">Story</a></li>
  	<li><a href="<?=site_url('/about/team')?>">Team</a></li>
  	<li><a href="<?=site_url('/about/values')?>">Values</a></li>
  	<li><a href="http://blog.shoutbound.com" target="_blank">Blog</a></li>
  	<li><a href="<?=site_url('/press')?>">Press</a></li>
  	<li><a href="<?=site_url('/contact')?>">Contact</a></li>						
  </ul>
  <!--NAV END-->

  <!--ABOUT CONTENT START-->
  <div id="about-container">
    <div id="about-header"><h1>We created Shoutbound to<br/>solve a problem.</h1></div>
    <? if(!isset($user)):?>
      <div class="about-signup-button-container">
        <a href="<?=site_url('signup/index')?>" id="sign-up">Sign up</a>
      </div>
    <? endif;?>
    <div class="about-item">
      <div class="about-item-header">This is our story.</div>
      <div class="about-item-content">  Shoutbound was founded in 2011 by two New Yorkers who love to travel. With our friends and family scattered all over the world, we found it hard to assemble a group for travel or get good advice from friends and family.<br/><br/>Adventures were getting lost in mass e-mails, scattered posts, random comments and haphazard conversations. We were spending so much time in front of a computer researching, organizing, and planning, that cooking up our next adventure almost didn’t seem fun anymore.<br/><br/>What we needed was one place to discover, organize and share all the relevant interactions for each of our travel plans and dreams, and make that information for our friends and family to use when they needed it too. And so we created Shoutbound.</div>
      <div class="about-item-img-container">
        <img src="<?=site_url('static/images/rubiks_cube.jpeg')?>" alt="Things to bring on a travel journey"/>      
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