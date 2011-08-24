<?
$header_args = array(
    'title' => 'About | Shoutbound',
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
  	<li class="selected"><a href="<?=site_url('/about')?>">About</a></li>
  	<li><a href="<?=site_url('/about/story')?>">Story</a></li>
  	<li><a href="<?=site_url('/about/team')?>">Team</a></li>
  	<li><a href="<?=site_url('/about/values')?>">Values</a></li>
  	<li><a href="http://blog.shoutbound.com" target="_blank">Blog</a></li>
  	<li><a href="<?=site_url('/press')?>">Press</a></li>
  	<li><a href="<?=site_url('/contact')?>">Contact</a></li>						
  </ul>
  <!--NAV END-->

  <!--ABOUT CONTENT START-->
  <div id="about-container">
    <div id="about-header"><h1>The best way to discover and share<br/>your next travel adventure.</h1></div>
    <? if(!isset($user)):?>
      <div class="about-signup-button-container">
        <a href="<?=site_url('signup/index')?>" id="sign-up">Sign up</a>
      </div>
    <? endif;?>
    <div class="about-item">
      <div class="about-item-header">For you.</div>
      <div class="about-item-content">  Use Shoutbound to learn more about the places you&#39;re dying to go, the people who interest you, and the trips they take.  When it&#39;s time to plan a trip of your own, ask your friends and family for recommendations or to join you.  Shoutbound organizes their responses so you don&#39;t have to.  Shoutbound also makes it easy to share your travel experiences and help others plan their trips based on your advice.</div>
      <div class="about-item-img-container">
        <img src="<?=site_url('static/images/compass-icon.jpg')?>" alt="Shoutbound is committed to adventure"/>           
      </div>            
      <div style="clear:both"></div>
    </div>
      
    <div class="about-item">
      <div class="about-item-header">For travel bloggers, journalists, and content producers.</div>
      <div class="about-item-content">Shoutbound is a dedicated travel content syndication platform on steroids.  You can use Shoutbound to drive traffic to your website, get new readers, more comments, and increase the longevity of your content. Post links to your blog, article or content on Shoutbound. In addition to being shared with your followers, your posts are shared with people who follow the destinations mentioned in your post.</div>
      <div class="about-item-img-container">
        <img src="<?=site_url('static/images/loudspeaker.png')?>" alt="Travel content syndication" width="115" height="115"/>           
      </div>            
      <div style="clear:both"></div>    
    </div>
    
    <div class="about-item">
      <div class="about-item-header">For travel and tourism professionals.</div>
      <div class="about-item-content">We are building a community of people who are passionate about travel.  Shoutbound appeals to both active and aspirational travelers alike.  Not everyone gets to travel all the time, but everyone has a travel dream.  If you&#39;re as excited as we are about this, we&#39;d love to hear from you with any ideas you may have&#33; Drop us a line at <a href="mailto:hello@shoutbound.com">hello&#64;shoutbound.com</a>.</div>
      <div class="about-item-img-container">
        <img src="<?=site_url('static/images/handshake_icon.png')?>" alt="Travel and tourism collaboration"/>      
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