<?
$header_args = array(
    'title' => 'Sign Up | Shoutbound',
    'css_paths' => array(
    ),
    'js_paths' => array(
        'js/jquery/jquery.expander.js',
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
    $('.thumbnail').remove();
    
    var postData = {
      query: $('#query').val()
    };
    
    $.ajax({
      type: 'POST',
      url: '<?=site_url('places/ajax_dbpedia_query')?>',
      data: postData,
      success: function(r) {
        var r = $.parseJSON(r);
        //console.log(r);
        if (r) {
          $('#name').html(r.label.value);
          var abstract = r.abstract.value;
          // add ellipses if abstract doesn't end with period
          if ( ! abstract.match(/\.$/)) {
            abstract += '...';
          }
          $('#abstract').html(abstract);
          textShorten($('#abstract'));
          $('#lat').html(r.lat.value);
          $('#lng').html(r.long.value);
          //var img = new Image();
          //img.src = r.thumbnail.value;
          $('#lng').after('<img src="'+r.thumbnail.value+'" class="thumbnail"/>');
        } else {
          $('#name').html('sorry, we couldn\'t find any info on that');
        }
      }
    });
  }
  return false;
}

$('#loading-div')
  .hide()
  .ajaxStart(function() {
    $(this).show();
  })
  .ajaxStop(function() {
    $(this).hide();
  })
;

function textShorten(o) {
  o.expander({
    slicePoint: 300
  });
}

$(function() {
  $('#query-submit').click(dbpediaQuery);
});
</script>
</html>