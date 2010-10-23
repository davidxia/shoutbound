<!-- HEADER -->
<?
$header_args = array(
    'js_paths'=>array(
        'js/trip/trip.js',
        'js/trip/list.js',
        'js/trip/yelp.js',
        'js/trip/wall.js',
    ),
    'css_paths'=>array('css/trip.css')
);

$this->load->view('core_header', $header_args);

?>

<script>
    Constants.Trip = {};
    Constants.Trip['id'] = "<?=$trip_data['id']?>";
</script>

<?=$this->load->view('core_header_end')?>



<body>
  
  <div id="nn-head">
    
    <div id="nn-logo"><img src="<?=static_url('images/noqnok-logo.jpg')?>"/></div>
    
    
    <div class="nn-fb-banner">
    <? if($user): ?>
    <div class="nn-fb-img right"><img src="http://graph.facebook.com/<?=$user['fid']?>/picture?type=square" /></div>
      <div class="nn-fb-text right">Welcome, <?=$user['name']?><br/>
      <a href="<?=site_url('user/logout')?>" >Logout</a>
 
      
    </div>
      

      
      
      
      
    <? else: ?>
      You are not logged in!
    <? endif; ?>
    </div>
    
    <div class="clear-both"></div>
    
  </div>
  
  <div id="nn-body">
      <div id="map-shell">
          <div id="map-toolbar">
              
              <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?=$trip_data['fid']?>/picture?type=square" /></div>
                <div class="nn-fb-text left">
                    <span class="trip-name"><h3><?=$trip_data['name']?></h3></span>
                    by <?=$trip_data['user_name']?>
                </div>
              
          </div>
          
          <div id="map-canvas"></div>
      </div>
      <div id="console">
        <div id="list">
            
            <?=$this->load->view('trip_list', $list_data, true)?>
            
        </div>
        <div id="wall">
            
            <?=$this->load->view('trip_wall', $wall_data, true)?>
            
        </div>
      </div>
      
        <div id="foot">

        </div>
      
      
  </div>
    
   









</body> 
</html>