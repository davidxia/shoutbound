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
  <!-->
  <div id="instructions">
      <h3>Welcome to the noqnok beta! </h3>
      <p>
          You’re looking at a trip to New York being planned by your friend, Rishi Taparia.  Here’s how to start using noqnok:
      </p>
          <ul>
              <li> Post a comment: To post on Rishi’s wall, simply type your post in the text box and click “post”.</li>
              <li> Search the map: Rishi’s map is searchable and integrated with Yelp.  For example, if you type “Sushi” into the search bar and hit “Search”, noqnok will
                   return Yelp hits for “Sushi” within area covered by the map. </li>
              <li> Make a suggestion: To make a suggestion for Rishi, first search for what you want to suggest and then click on the Yelp result that appears in the map.
                   Then click “suggest”. For example, to suggest Katz’s Deli, pan the map to the Lower East Side and search for “Katz”. 
                   Click on the pin corresponding to Katz’s and then click “Suggest”.  </li>
              <li> Refresh the page to see updates.</li>
          </ul>
      <p>
      noqnok is in closed beta.  At the moment, we only support in-map search, so if you want to broaden your search area, zoom the map out.
      Currently, only items or places that are on Yelp can be searched for or suggested.
      </p>
      <p>
      Let us know what you think!  Send questions, comments or feedback to feedback@noqnok.com
      </p>
      <h3>
      We’re working hard to add features – watch this space!
      </h3>
    
  </div>
  -->
  
  <div id="nn-head">
    
    <div id="nn-logo"><img src="<?=static_url('images/noqnok-logo.jpg')?>"/></div>
    
    
    <div class="nn-fb-banner">
    <? if($user): ?>
    <div class="nn-fb-img right"><img src="http://graph.facebook.com/<?=$user['fid']?>/picture?type=square" /></div>
      <div class="nn-fb-text right">Welcome, <?=$user['name']?><br/>
      <a href="<?=site_url('user/logout')?>" >Logout</a>
      <br/><a href="javascript: showInstructions();">Instructions</a>    
      
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