<?php
$header_args = array(
    'title' => 'New Wall | Shoutbound',
    'css_paths'=>array(
        'css/trip-page.css',
    ),
    'js_paths'=>array(
        'js/jquery/timeago.js',
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url()?>";
</script>
  
</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>  
    
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
    
    <div id="wall-content">
      WALLITEMS:
      <br/>
      <? foreach ($wallitems as $wallitem):?>
        CONTENT: <?=$wallitem->content?>
        <br/>
        <? foreach ($wallitem->replies as $reply):?>
          --------->CONTENT: <?=$reply->content?>
          <br/>
        <? endforeach;?>
      <? endforeach;?>
    </div>
    
    <!-- ITEM INPUT CONTAINER -->
    <div id="wallitem-input-container;">
      <label for="wallitem-input"><h2>Add Message:</h2></label>
      <textarea id="wallitem-input"></textarea>
      <div id="wallitem-post-button"><a href="#">Add</a></div>
    </div><!-- ITEM INPUT CONTAINER ENDS -->

  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  <? $this->load->view('footer')?>


<script type="text/javascript">
  $('#wallitem-post-button').click(function() {
    // distinguish between message and suggestion
    if ($('#wallitem-input').val().length != 0) {
      $.ajax({
        type: 'POST',
        url: '<?=site_url('users/ajax_get_logged_in_status')?>',
        success: function(r) {
          var r = $.parseJSON(r);
          if (r.loggedin) {
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
            
          } else {
            alert('please login to post on the wall');
          }
        }
      });
    }
    return false;
  });


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