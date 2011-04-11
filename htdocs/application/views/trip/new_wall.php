<?php
$header_args = array(
    'title' => 'New Wall | Shoutbound',
    'css_paths'=>array(
        'css/trip-page.css',
    ),
    'js_paths'=>array(
        'js/jquery/popup.js',
        'js/jquery/validate.min.js',
        'js/jquery/timeago.js',
    )
);

$this->load->view('core_header', $header_args);
?>  
</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>  
    <div id="div-to-popup" style="background-color:white; display:none;"></div>

    USER NAME: <?=$user->name?>
    
    <br/><br/>
    
    TRIP NAME: <?=$trip->name?>
    
    <br/><br/>
    
    DESTINATIONS:
    <br/>
    <? foreach($destinations as $destination):?>
      <?=$destination->name?>
      <br/>
    <? endforeach;?>
    
    <br/>
    
    <!-- WALL CONTENT -->
    <div id="wall-content">
      WALLITEMS:
      <? foreach ($wallitems as $wallitem):?>
        <!-- WALLITEM -->
        <div class="wallitem" id="wallitem-<?=$wallitem->id?>">
          AUTHOR: <?=$wallitem->user_name?>
          CONTENT: <?=$wallitem->content?>
          CREATED: <abbr class="timeago" title="<?=$wallitem->created?>"><?=$wallitem->created?></abbr>
          LIKE
          REPLY
          <br/>
          <? foreach ($wallitem->replies as $reply):?>
            <!-- WALLITEM REPLY -->
            <div class="reply" id="wallitem-<?=$wallitem->id?>">
              --------->AUTHOR: <?=$reply->user_name?>
              CONTENT: <?=$reply->content?>
              CREATED: <abbr class="timeago" title="<?=$reply->created?>"><?=$reply->created?></abbr>
              LIKE
            </div><!-- WALLITEM REPLY ENDS -->
          <? endforeach;?>
        </div><!-- WALLITEM ENDS -->
      <? endforeach;?>
    </div><!-- WALL CONTENT ENDS -->
    
    
    <!-- ITEM INPUT CONTAINER -->
    <div id="wallitem-input-container;">
      <label for="wallitem-input"><h2>Add Message:</h2></label>
      <textarea id="wallitem-input"></textarea>
      <div id="wallitem-post-button"><a href="#">Add</a></div>
    </div><!-- ITEM INPUT CONTAINER ENDS -->
    
    <input type="text" id="place-autosuggest"/>
    <div id="autosuggestions">places: </div>

  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  <? $this->load->view('footer')?>


<script type="text/javascript">
  // convert unix timestamps to time ago
  $('abbr.timeago').timeago();
  
  
  // create namespace for geocoder
  var sbgeocoder = {};
  
  // autosuggest place from database
  $('#place-autosuggest').keyup(function(e) {
    var keyCode = e.keyCode || e.which;
    // ignore arrow keys
    if (keyCode!==37 && keyCode!==38 && keyCode!==39 && keyCode!==40) {
      delay(sbgeocoder.geocodeQuery, 300);
    }
  });

  // delay geocoder api for 1 second of keyboard inactivity
  delay = (function() {
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    };
  })();
  

  sbgeocoder.geocodeQuery = function() {
    var query = $('#place-autosuggest').val().trim();

    if (query.length > 1) {
      var postData = {
        query: query
      };
      
      $.ajax({
        type: 'POST',
        url: '<?=site_url('places/ajax_autosuggest')?>',
        data: postData,
        success: function(r) {
          var r = $.parseJSON(r);
          $('#autosuggestions').empty();
          for (var i=0; i<r.places.length; i++) {
            $('#autosuggestions').append('<div>'+r.places[i]+'</div>');
          }
        }
      });
    } else {
    	$('#place-autosuggest').html('').css('border', '0');
    }
  };


  $('#wallitem-post-button').click(function() {
    if ($('#wallitem-input').val().length != 0) {
      $.ajax({
        type: 'POST',
        url: '<?=site_url('users/ajax_get_logged_in_status')?>',
        success: function(r) {
          var r = $.parseJSON(r);
          if (r.loggedin) {
            postWallitem();
          } else {
            showLoginSignupDialog();
          }
        }
      });
    }
    return false;
  });


  function showLoginSignupDialog() {
    $.ajax({
      url: '<?=site_url('users/login_signup')?>',
      success: function(r) {
        var r = $.parseJSON(r);
        $('#div-to-popup').empty().append(r.data).bPopup({follow:false, opacity:0});
      }
    });
  }


  function loginSignupSuccess() {
    $('#div-to-popup').empty();
    postWallitem();
  }

  
  function postWallitem() {
    var postData = {
      tripId: 2,
      content: $('#wallitem-input').val()
    };
    
    $.ajax({
      type: 'POST',
      url: '<?=site_url('wallitems/ajax_save')?>',
      data: postData,
      success: function(r) {
        var r = $.parseJSON(r);
        displayWallitem(r);
        $('abbr.timeago').timeago();
        $('#wallitem-input').val('');
      }
    });  
  }


  function displayWallitem(r) {
    var html = [];
    html[0] = '<li id="wallitem-'+r.id+'">';
    html[1] = '<a href="<?=site_url('profile')?>/'+r.userId+'" class="wallitem-author">';
    html[2] = r.userName;
    html[3] = '</a>';
    html[4] = ' <div class="remove-wallitem"></div>';
    html[5] = '<span class="wallitem-content">'+r.content+'</span>';
    html[6] = '<br/>';
    html[7] = '<abbr class="timeago" title="'+r.created+'">'+r.created+'</abbr>';
    html[8] = '</li>';
    html = html.join('');
    
    $('#wall-content').append(html);
  }
</script>

</body>
</head>