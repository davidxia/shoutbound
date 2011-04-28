<?php
$header_args = array(
    'title' => 'Place | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
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
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

    <div id="top-bar"><!--TOP BAR-->
      <div id="place-pic-container" class="img-container">
        <a href="#" id="place-pic"><img src="http://upload.wikimedia.org/wikipedia/commons/1/10/Zion_angels_landing_view.jpg" width="250" height="250"/></a>
      </div>
      <div id="place-info">
        <div id="place-name">Zion National Park</div>
        <div id="place-description">Zion National Park is located in the Southwestern United States, near Springdale, Utah. A prominent feature of the 229 square miles (590 km2) park is Zion Canyon, which is 15 miles (24 km) long and up to half a mile (800 m) deep, cut through the reddish and tan-colored Navajo Sandstone by the North Fork of the Virgin River. The lowest elevation is 3,666 ft (1,117 m) at Coalpits Wash and the highest elevation is 8,726 ft (2,660 m) at Horse Ranch Mountain. Located at the junction of the Colorado Plateau, Great Basin, and Mojave Desert regions, the park's unique geography and variety of life zones allow for unusual plant and animal diversity. Numerous plant species as well as 289 species of birds, 75 mammals (including 19 species of bat), and 32 reptiles inhabit the park's four life zones: desert, riparian, woodland, and coniferous forest. Zion National Park includes mountains, canyons, buttes, mesas, monoliths, rivers, slot canyons, and natural arches.</div>
      </div>
               
      </div><!--TOP BAR END-->
      
      <div id="follow-and-stats-container"><!--FOLLOW BUTTON + STATS-->
              
        <div id="stats-container">
          <ul class="stats-list">
            <li><a href="#trail" class="trip-count">94<span class="stat-label">Trips</span></a></li>
            <li class="border-left"><a href="#posts" class="post-count">893<span class="stat-label">Posts</span></a></li>
            <li class="border-left"><a href="#followers" class="followers-count">500<span class="stat-label">Followers</span></a></li>
          </ul>        
        </div>
        
        
        <div id="follow-button">
              <a href="#" id="follow">Follow</a>

              <a href="#" id="unfollow">Unfollow</a>

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
      
      <!-- MAP -->
      <div id="map-shell">
          <div id="map-canvas"></div>
        </div>
      </div><!--MAP ENDS-->
      
    </div><!-- RIGHT COLUMN ENDS -->
    
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  
  </div>
  <? $this->load->view('footer')?>
</body>
</head>