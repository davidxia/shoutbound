<?
$header_args = array(
    'title' => 'Team | Shoutbound',
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
  	<li class="selected"><a href="<?=site_url('/about/team')?>">Team</a></li>
  	<li><a href="<?=site_url('/about/values')?>">Values</a></li>
  	<li><a href="http://blog.shoutbound.com" target="_blank">Blog</a></li>
  	<li><a href="<?=site_url('/press')?>">Press</a></li>
  	<li><a href="<?=site_url('/contact')?>">Contact</a></li>						
  </ul>
  <!--NAV END-->

  <!--ABOUT CONTENT START-->
  <div id="about-container">
    <div id="about-header"><h1>Meet team Shoutbound.</h1></div>
    <? if(!isset($user)):?>
      <div class="about-signup-button-container">
        <a href="<?=site_url('signup/index')?>" id="sign-up">Sign up</a>
      </div>
    <? endif;?>
    <div class="about-item">
      <div class="about-item-header">James Richards, Co-founder</div>
      <div class="about-item-content">James grew up in Jakarta, Indonesia, where he developed an enduring love of tropical weather.  He now lives in New York, and spends each winter in hibernation and denial.  James has lived most of his life in countries other than those of his passports, and needs a tourist visa whenever he visits &#8220home&#8221 in Jakarta.  His favorite travel experience was stumbling into an <i>Idul Fitri</i> festival in Mataram, Lombok and dodging hand-launched fireworks, parade floats and motorcycles all night long. He received his J.D. from Columbia Law School at age 20, and is their youngest graduate on record.</div>
      <div class="about-item-img-container">
        <img src="<?=site_url('static/images/james_portrait.jpg')?>" alt="James Richards"/>      
      </div>            
      <div style="clear:both"></div>
    </div>
      
    <div class="about-item">
      <div class="about-item-header">David Xia, Co-founder</div>
      <div class="about-item-content">David wishes he could make a living as a modern day Sherlock Holmes - minus the cocaine habit and tacky deerstalker hat.  One of David's most memorable travel experiences was hiking through the Adirondacks during an extremely cold week one spring.  From his blog: &#8220Almost all our Nalgene water bottles froze overnight...so we hiked with our bottles inside our jackets to thaw them for water along the way. I got thirsty and impatient so just ate icicles off of trees as I hiked. Anthony and Seth warned me about getting diarrhea this way. I was fine.&#8221  David graduated with a B.A. in mathematics from Columbia University, <em>summa cum laude.</em></div>
      <div class="about-item-img-container">
        <img src="<?=site_url('static/images/david_portrait.jpg')?>" alt="David Xia"/>           
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