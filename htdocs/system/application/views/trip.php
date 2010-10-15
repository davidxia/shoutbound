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

    $(document).ready(function(){
        
       $("#submit-suggestion").click(function(){
          
           var d = {foo: 'wowsa'};
           
           $.ajax({
               type: "POST",
               url: "trip/do_ajax_suggestion",
               data: d,
               success: addComment
           });
           
           return false;
       });
        
    });

function addComment(foo){
    alert(foo);
}


</script>


<script type="text/javascript" src="<?=static_url('js/trip.js');?>"></script> 


</head> 
<body>
  <div id="nn-head">
    
    <h1>noqnok.</h1> 
    
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
        <? if($user): ?>
          Welcome <?=$user['name']?>
          <img src="http://graph.facebook.com/<?=$user['fid']?>/picture" />
          <br/>
          <a href="<?=site_url('user/logout')?>" >Logout</a>
        <? else: ?>
          You are not logged in!
        <? endif; ?>
      </div>
  </div>
    
   









</body> 
</html>
