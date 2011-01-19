<!-- HEADER -->
<?
$header_args = array(
    'js_paths'=>array(
        'js/trip/trip.js',
        'js/trip/list.js',
        'js/trip/yelp.js',
        'js/trip/wall.js',
        'js/trip/share.js',
    ),
    'css_paths'=>array(
        'css/trip.css',
    )
);

$this->load->view('core_header', $header_args);

?>

<script>
    Constants.Trip = {};
    Constants.Trip['id'] = "<?=$trip_data['id']?>";
</script>

<?=$this->load->view('core_header_end')?>



<body>
  
    <?
        $banner_args = array('user'=>$user);
        echo($this->load->view('core_banner',$banner_args));
    ?>

  <div id="div_to_popup"></div>
  
  <div id="nn-body">


      <div id="map-shell">
          <div id="map-toolbar">
              
              <div class="nn-fb-img left"><img src="http://graph.facebook.com/<?=$trip_data['fid']?>/picture?type=square" /></div>
                <div class="nn-fb-text left">
                    <span class="trip-name"><h3><?=$trip_data['name']?></h3></span>
                    by <?=$trip_data['user_name']?>
                    
                    
                    <? if ($user['uid'] == $trip_user['uid']){ ?>
                    
                    <br/>
                    <a href="javascript: Share.showShareDialog();"> Share this trip </a>
                    
                    <? } ?>
       
                    
                </div>
              
          </div>
          
          <div id="map-canvas"></div>
      </div>
      <div id="console">
		<div id="invited-friends">
			<?=$this->load->view('trip_friends', $invited_uids)?>
		</div>
		
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