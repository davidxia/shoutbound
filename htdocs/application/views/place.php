<?php
$header_args = array(
    'title' => 'Place | Shoutbound',
    'css_paths'=>array(
      'css/place.css'
    ),
    'js_paths'=>array(
        'js/place/map.js',
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var placeId = <?=$place->id?>;
  map.lat = <?=$place->lat?>;
  map.lng = <?=$place->lng?>;
</script>
  
</head>

<body>

  <div id="sticky-footer-wrapper">
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

    <div id="top-bar"><!--TOP BAR-->
      <div id="place-info">
        <div id="place-name"><?=$place->name?> <span style="font-size:16px;"><?=$place->admin2?>, <?=$place->admin1?></span></div>
        <div id="place-description">New York is the most populous city in the United States and the center of the New York metropolitan area, which is one of the most populous metropolitan areas in the world. New York City exerts a significant impact upon global commerce, finance, media, culture, art, fashion, research, technology, education, and entertainment.<span id="wikipedia-url" class="subtext"> <a href="#">Source: Wikipedia</a></span></div>
        <!--DAVID - WE SHOULD PULL THE FIRST 500 CHARACTERS FROM WIKIPEDIA AND DUMP IT IN PLACE-DESCRIPTION.  NEED TO GET RID OF ALL INTERNAL URLS AND FOOTNOTES, JUST PLAIN TEXT.  ALSO - NEED TO STOP AT THE LAST "." BEFORE 500 CHARACTERS IS REACHED SO WE DON'T HAVE AN ENTRY STOP MID-SENTENCE-->
      </div>
      </div><!--TOP BAR END-->
      
      <div id="follow-and-stats-container"><!--FOLLOW BUTTON + STATS-->
              
        <div id="stats-container">
          <ul class="stats-list">
            <li><a href="#posts" class="num-posts"><?=$place->num_posts?><span class="stat-label">Posts</span></a></li>
            <li class="border-left"><a href="#trips" class="num-trips"><?=$place->num_trips?><span class="stat-label">Trips</span></a></li>
            <li class="border-left"><a href="#followers" class="num-followers"><?=$place->num_followers?><span class="stat-label">Followers</span></a></li>
          </ul>        
        </div>
        
        
        <div id="follow-button">
        <? if ( !$user OR !$user->is_following):?>
          <a href="#" id="follow">Follow</a>
        <? elseif ($user AND $user->is_following):?>
          <a href="#" id="unfollow">Unfollow</a>
        <? endif;?>
        </div>        
        
      </div><!-- FOLLOW BUTTON + STATS END-->  
    
    <div style="clear:both"></div>  

    <!-- LEFT COLUMN -->
    <div id="col-left">    
      
      <!--LEFT COLUMN CONTENT-->      
      <div id="left-content-container">
      
        <ul id="main-tabs">
          <li><a href="#posts">Posts</a></li>
          <li><a href="#trips">Trips</a></li>
          <li><a href="#followers">Followers</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
          <div id="activity-tab" class="main-tab-content main-tab-default">

          </div>          
        </div><!--TAB CONTAINER END-->
      </div><!--LEFT COLUMN CONTENT END-->
    </div><!--LEFT COLUMN END-->
    
    
    <!-- RIGHT COLUMN -->
    <div id="col-right">      
      
      <!-- GALLERY AND MAP-->
      <ul id="right-tabs">
        <li><a href="#gallery">Gallery</a></li>
        <li><a href="#map">Map</a></li>
      </ul>
      
      <div class="right-tab-container img-container">
        <div id="gallery-tab" class="right-tab-content main-tab-default">
          <img src="http://upload.wikimedia.org/wikipedia/commons/d/d3/Lincoln_Center_Twilight.jpg" width="330" height="330"/>
        </div>
      </div>
      <div id="map-shell" class="right-tab-container">
        <div id="map-canvas" style="height:330px;"></div>
      </div>
      
    </div><!-- RIGHT COLUMN ENDS -->
    
  </div><!-- WRAPPER ENDS -->
  </div><!-- CONTENT ENDS -->
  </div>
  <? $this->load->view('footer')?>
</body>
</head>