<?

// somephp here

?>

<!DOCTYPE html> 
<html> 
<head> 
    
<meta name="viewport" content="initial-scale=1.0, user-scalable=yes" /> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 

<!-- CSS -->
<?=$this->load->view('core_header')?>    
<link rel="stylesheet" type="text/css" href='<?=static_url('css/trip.css');?>'/>



<script type="text/javascript">


function addComment(foo){
    alert(foo);
}


</script>

<script>
    Constants.Trip = {};
    Constants.Trip['id'] = "<?=$trip_data['id']?>";
</script>

<script type="text/javascript" src="<?=static_url('js/trip.js');?>"></script> 


</head> 
<body>
  <div id="nn-head">
    
    <div id="nn-logo"><h1>noqnok.</h1></div>
    
    <div id="nn-fb-banner">
    <? if($user): ?>
    <div class="nn-fb-img"><img src="http://graph.facebook.com/<?=$user['fid']?>/picture?type=square" /></div>
      <div class="nn-fb-text">Welcome, <?=$user['name']?><br/>
      <a href="<?=site_url('user/logout')?>" >Logout</a></div>
      
      
      
      
    <? else: ?>
      You are not logged in!
    <? endif; ?>
    </div>
    
    <div class="clear-both"></div>
    
  </div>
  
  <div id="nn-body">
      <div id="map-shell">
          <div id="map-toolbar">
              <?=$trip_data['name']?>
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