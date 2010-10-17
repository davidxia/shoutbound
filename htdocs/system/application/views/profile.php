<!DOCTYPE html> 
<html> 
<head> 
    
<meta name="viewport" content="initial-scale=1.0, user-scalable=yes" /> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 

<!-- CSS -->
<?=$this->load->view('core_header')?>    


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
      

          <ul>
          <?php foreach($trip_ids as $trip_id):?>

          <li><a href="trip/details/<?=$trip_id?>">Go to trip <?=$trip_id?></a></li>

          <?php endforeach;?>
          </ul>

      
  </div>
    
   









</body> 
</html>