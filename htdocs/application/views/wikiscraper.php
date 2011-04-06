<?
$header_args = array(
    'title' => 'Sign Up | Shoutbound',
    'css_paths' => array(
    ),
    'js_paths' => array(
    )
);

$this->load->view('core_header', $header_args);
?>
</head>
	
<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

    <form action="">
      <fieldset>
        <label for="query">Search for a place</label>
        <input type="text" id="query" name="query"/>
      </fieldset>
      <button type="submit" id="query-submit" class="blue-button" name="query-submit">Search</button>
    </form>
    
    <div id="loading-div"><img src="<?=site_url('images/ajax-loader.gif')?>" width="32" height="32"/></div>
    
    <div id="name" class="info"></div>
    <div id="abstract" class="info"></div>
    <div id="lat" class="info"></div>
    <div id="lng" class="info"></div>
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  
  <? $this->load->view('footer')?>
  
</body>

<script type="text/javascript">
function dbpediaQuery() {
  if ($('#query').val() != '') {
    $('.info').html('');
    
    var postData = {
      query: $('#query').val()
    };
    
    $.ajax({
      type: 'POST',
      url: '<?=site_url('wikiscraper/ajax_dbpedia_query')?>',
      data: postData,
      success: function(r) {
        var r = $.parseJSON(r);
        if (r.results.bindings.length != 0) {
          console.log(r.results);
          $('#name').html(r.results.bindings[0].label.value);
          $('#abstract').html(r.results.bindings[0].abstract.value);
          $('#lat').html(r.results.bindings[0].lat.value);
          $('#lng').html(r.results.bindings[0].long.value);
        } else {
          $('#name').html('sorry, we couldn\'t find any info on that');
        }
      }
    });
  }
  return false;
}

$('#loading-div')
  .hide()  // hide it initially
  .ajaxStart(function() {
    $(this).show();
  })
  .ajaxStop(function() {
    $(this).hide();
  })
;

$(document).ready(function() {
  $('#query-submit').click(dbpediaQuery);
});
</script>
</html>
